<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Config;
use App\Models\Rooms;
use Illuminate\Http\Response;
use DataTables;
use Auth;
use App\Models\Roles;

class RoomController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
        $this->common_file_download_path = Config::get('constants.FILE_DOWNLOAD_PATH');
    }

    public function index() {

        $data['title'] = $this->browserTitle . " - Asset Management";

        return view('asset.room', $data);
    }

    public function createRoomPage(Request $request) {
        $data['title'] = $this->browserTitle . " - Create Resource";
        $data['roles'] = Roles::selectFromRoles(['orgId'=>Auth::user()->orgId])->get();
        $data['room_group'] = \App\Models\MasterLookupData::selectFromMasterLookupData([["mldKey","=","room_group"]])->get();

        return view('asset.create_room', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $insertData = $request->all();

        $roomId = $request->roomId;

        //validation rules


        $room_image = "";
        if (isset($request->room_image) && $request->room_image != "") {
            $room_image = $this->resourceFileUpload($request->room_image);
        }

        $insertData = $request->except(['_token', 'roomId','room_image	']);

        if ($room_image == "") {
            //$insertData->except(['item_photo']);
        } else {
            $insertData['room_image'] = $room_image;
        }

        if ($roomId > 0) { //update
            $insertData['updatedBy'] = Auth::id();


            Rooms::where("id", $roomId)->update($insertData);
        } else { //insert
            $insertData['createdBy'] = Auth::id();
            $insertData['orgId'] = Auth::user()->orgId;

            Rooms::create($insertData);
        }

        return response()->json(
                        [
                            'success' => '1',
                            "message" => '<div class="alert alert-success">
                                                                 <strong>Saved!</strong>
                                                           </div>'
                        ]
        );
    }

    public function roomList(Request $request) {
        $Rooms = Rooms::listRooms($request->search['value']);

        return DataTables::of($Rooms)
                        ->addColumn('action', function($row) {
                            $btn = '<a onclick="editRoom(' . $row->id . ')"  class="edit btn btn-primary btn-sm ">Edit</a>';


                            return $btn;
                        })
                        ->addColumn('quantity', function($row) {
                            return 0;
                        })
                        ->addColumn('image', function($row) {
                            $hh_pic_image= url('/assets/uploads/organizations/avatar.png');
                            if($row->room_image != null){
                                $hh_pic_image_json = json_decode(unserialize($row->room_image));
                                $hh_pic_image = $hh_pic_image_json->download_path.$hh_pic_image_json->uploaded_file_name;
                            }
                            return "<img src='$hh_pic_image' style='max-width:25px;' />";
                        })
                        ->rawColumns(['action','image'])
                        ->make(true);
    }

    public function edit($id) {
        $data['title'] = $this->browserTitle . " - Create Room";
        $data['roles'] = Roles::selectFromRoles(['orgId'=>Auth::user()->orgId])->get();
        $data['room_group'] = \App\Models\MasterLookupData::selectFromMasterLookupData([["mldKey","=","room_group"]])->get();
        $room = Rooms::findOrFail($id);

        $data['room'] = $room;
        return view('asset.create_room', $data);
    }

    /**
     * @Function name : resourceFileUpload
     * @Purpose : upload resourceFileUpload
     * @Added by : Ananth
     * @Added Date : 1 sep 2019
     */
    private function resourceFileUpload($file) {


        $extension = $file->getClientOriginalExtension();


        $imageName = basename($file->getClientOriginalName(), ("." . $extension));

        $imageName .= "_" . time() . '.' . $extension;
        $destinationPath = $this->common_file_upload_path['PROFILE_PIC_UPLOAD_PATH'] . DIRECTORY_SEPARATOR . Auth::user()->orgId . DIRECTORY_SEPARATOR . "rooms" . DIRECTORY_SEPARATOR;


        $downloadPath = $this->common_file_download_path['PROFILE_PIC_DOWNLOAD_PATH'] . '/' . Auth::user()->orgId . '/' . "rooms" . '/';


        $file->move(
                $destinationPath, $imageName
        );



        $upload_data = array('uploaded_path' => $destinationPath, 'download_path' => $downloadPath, 'uploaded_file_name' => $imageName, 'original_filename' => $imageName, 'upload_file_extension' => $extension, 'file_size' => 0);
        $jsonformat = serialize(json_encode($upload_data));

        return $jsonformat;
    }

    public function fbwall() {

        $data['title'] = $this->browserTitle . " - Asset Management";

        return view('asset.fbwall', $data);
    }
}
