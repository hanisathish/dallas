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
use App\Models\Organization;
use Illuminate\Support\Facades\Session;


class LocationController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
        $this->common_file_download_path = Config::get('constants.FILE_DOWNLOAD_PATH');
        $this->userSessionData = Session::get('userSessionData');
    }

    public function index() {

        $data['title'] = $this->browserTitle . " - Location Management";

        return view('settings.location.index', $data);
    }

    public function list(Request $request){
        $locations = Location::listLocations($request->search['value']);

        return DataTables::of($locations)
                        ->addColumn('action', function($row) {
                            $btn = '<a onclick="editLocation(' . $row->id . ')"  class="edit btn btn-primary btn-sm ">Edit</a>';


                            return $btn;
                        })


                        ->rawColumns(['action','image'])
                        ->make(true);
    }

    public function addPage(Request $request){
        $data['title'] = $this->browserTitle . " - Location Management";

        return view('settings.location.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insertData = $request->all();

        $locationId = $request->locationId;

        //validation rules

        $insertData = $request->except(['locationId','_token']);

        if($locationId > 0) { //update
            $insertData['updatedBy']= Auth::id();


            Location::where("id",$locationId)->update($insertData);
        }
        else { //insert
            $insertData['createdBy']= Auth::id();
            $insertData['orgId']= Auth::user()->orgId;

            Location::create($insertData);
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

    public function editLocation(Request $request,$locationId){
        $data['title'] = $this->browserTitle . " - ";
        $location = Location::findOrFail($locationId);

        $data['location'] = $location;

        return view('settings.location.create',$data);
    }

    // Created By Santhosh 
    public function churchSettings(Request $request)
    {
        $data['title'] = $this->browserTitle . " - Church Settings Management";       
        
        $data['orgId'] =  Auth::user()->orgId;

        $orgId =  Auth::user()->orgId;
             
        $whereArray = array('organization.orgId' => $orgId);


        //$data['list_church_data'] = Organization::crudOrganization($whereArray,null,null,null,null,null,null,'1')->get();

        $data['list_church_data'] = Organization::selectFromOrganization($whereArray,null,null,null,null,null,null,'1')->get()[0];
        //dd($data['list_church_data']);
       

        return view('settings.church_settings', $data);
    }

     // Created By Santhosh 
    public function storeChurchSettings(Request $request)
    {
       
        $insertData = $request->all();

        $orgId = $request->orgId;

        $orgLogo = "";

        $whereArray = array('organization.orgId' => $orgId);

        $list_church_data = Organization::selectFromOrganization($whereArray,null,null,null,null,null,null,'1')->get()[0];


        if (isset($request->orgLogo) && $request->orgLogo != "") {

            $orgLogo = $this->resourceFileUpload($request->orgLogo);

        } else {

            $orgLogo = $list_church_data->orgLogo;
        }

        $insertData = $request->except(['_token']);

        $insertData['orgLogo'] = $orgLogo;

        Organization::where("orgId",$orgId)->update($insertData);

        Session::flash('message', 'Church Settings has been updated successfully');

        return redirect('settings/church_settings');

    }

     // Created By Santhosh  
    private function resourceFileUpload($file) {

        $extension = $file->getClientOriginalExtension();

        $imageName = basename($file->getClientOriginalName(), ("." . $extension));

        $imageName .= "_" . time() . '.' . $extension;
        
        $destinationPath = $this->common_file_upload_path['PROFILE_PIC_UPLOAD_PATH'] . DIRECTORY_SEPARATOR . Auth::user()->orgId . DIRECTORY_SEPARATOR . "org_logo" . DIRECTORY_SEPARATOR;

        $downloadPath = $this->common_file_download_path['PROFILE_PIC_DOWNLOAD_PATH'] . '/' . Auth::user()->orgId . '/' . "org_logo" . '/';

        $file->move(
                $destinationPath, $imageName
        );

        $upload_data = array('uploaded_path' => $destinationPath, 'download_path' => $downloadPath, 'uploaded_file_name' => $imageName, 'original_filename' => $imageName, 'upload_file_extension' => $extension, 'file_size' => 0);
        $jsonformat = serialize(json_encode($upload_data));

        return $jsonformat;
    }



}
