<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location;
use DB;
use Config;
use App\Models\Resources;
use App\Models\Roles;
use Illuminate\Http\Response;
use DataTables;
use Auth;

class AssetController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
        $this->common_file_download_path = Config::get('constants.FILE_DOWNLOAD_PATH');
    }

    public function index() {

        $data['title'] = $this->browserTitle . " - Asset Management";

        return view('asset.resource', $data);
    }

    public function createResourcePage(Request $request) {
        $data['title'] = $this->browserTitle . " - Create Resource";
        $data['roles'] = Roles::selectFromRoles(['orgId'=>Auth::user()->orgId])->get();
        $data['category'] = \App\Models\MasterLookupData::selectFromMasterLookupData([["mldKey","=","resource_category"]])->get();
        $data['locations'] = Location::listLocations("")->get();
        return view('asset.create_resource', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $insertData = $request->all();

        $resourcesId = $request->resourceId;

        //validation rules


        $item_photo = "";
        if (isset($request->item_photo) && $request->item_photo != "") {
            $item_photo = $this->resourceFileUpload($request->item_photo);
        }

        $insertData = $request->except(['_token', 'resourceId','item_photo']);

        if ($item_photo == "") {
            //$insertData->except(['item_photo']);
        } else {
            $insertData['item_photo'] = $item_photo;
        }

        if ($resourcesId > 0) { //update
            $insertData['updatedBy'] = Auth::id();


            Resources::where("id", $resourcesId)->update($insertData);
        } else { //insert
            $insertData['createdBy'] = Auth::id();
            $insertData['orgId'] = Auth::user()->orgId;

            Resources::create($insertData);
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

    public function resourceList(Request $request) {
        $resources = Resources::listResources($request->search['value']);

        return DataTables::of($resources)
                        ->addColumn('action', function($row) {
                            $btn = '<a onclick="editResource(' . $row->id . ')"  class="edit btn btn-primary btn-sm ">Edit</a>';


                            return $btn;
                        })

                        ->addColumn('image', function($row) {
                            $hh_pic_image= url('/assets/uploads/organizations/avatar.png');
                            if($row->item_photo != null){
                                $hh_pic_image_json = json_decode(unserialize($row->item_photo));
                                $hh_pic_image = $hh_pic_image_json->download_path.$hh_pic_image_json->uploaded_file_name;
                            }
                            return "<img src='$hh_pic_image' style='max-width:25px;' />";
                        })
                        ->rawColumns(['action','image'])
                        ->make(true);
    }

    public function edit($id) {
        $data['title'] = $this->browserTitle . " - Create Event";
        $data['category'] = \App\Models\MasterLookupData::selectFromMasterLookupData([["mldKey","=","resource_category"]])->get();
        $data['roles'] = Roles::selectFromRoles(['orgId'=>Auth::user()->orgId])->get();
        $resources = Resources::findOrFail($id);
        $data['locations'] = Location::listLocations("")->get();
        $data['resource'] = $resources;
        return view('asset.create_resource', $data);
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
        $destinationPath = $this->common_file_upload_path['PROFILE_PIC_UPLOAD_PATH'] . DIRECTORY_SEPARATOR . Auth::user()->orgId . DIRECTORY_SEPARATOR . "resource" . DIRECTORY_SEPARATOR;


        $downloadPath = $this->common_file_download_path['PROFILE_PIC_DOWNLOAD_PATH'] . '/' . Auth::user()->orgId . '/' . "resource" . '/';


        $file->move(
                $destinationPath, $imageName
        );



        $upload_data = array('uploaded_path' => $destinationPath, 'download_path' => $downloadPath, 'uploaded_file_name' => $imageName, 'original_filename' => $imageName, 'upload_file_extension' => $extension, 'file_size' => 0);
        $jsonformat = serialize(json_encode($upload_data));

        return $jsonformat;
    }

}
