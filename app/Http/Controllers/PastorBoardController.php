<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location;
use DB;
use Config;
use Illuminate\Http\Response;
use DataTables;
use Auth;
use App\Models\Roles;
use App\Models\PastorBoard;

class PastorBoardController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
        $this->common_file_download_path = Config::get('constants.FILE_DOWNLOAD_PATH');
    }

    public function index() {

        $data['title'] = $this->browserTitle . " - Pastor Board";

        return view('pasterBoard.index', $data);
    }

    public function manage() {

        $data['title'] = $this->browserTitle . " - Pastor Board";

        return view('pasterBoard.manage', $data);
    }

    public function createPostPage(Request $request) {
        $data['title'] = $this->browserTitle . " - Create Post";
        $data['locations'] = Location::listLocations("")->get();
        $data['p_category'] = \App\Models\MasterLookupData::selectFromMasterLookupData([["mldKey","=","room_group"]])->get();
        //$data['room_group'] = \App\Models\MasterLookupData::selectFromMasterLookupData([["mldKey","=","room_group"]])->get();

        return view('pasterBoard.create_post', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $insertData = $request->all();

        $postId = $request->postId;

        //validation rules


        $image_path = "";
        if (isset($request->image_path) && $request->image_path != "") {
            $image_path = $this->resourceFileUpload($request->image_path,$request->parent_type);
        }

        $insertData = $request->except(['_token', 'postId','image_path']);

        if ($image_path == "") {
            //$insertData->except(['item_photo']);
        } else {
            $insertData['image_path'] = $image_path;
        }

        if ($postId > 0) { //update
            $insertData['updatedBy'] = Auth::id();


            PastorBoard::where("id", $postId)->update($insertData);
        } else { //insert
            $insertData['createdBy'] = Auth::id();
            $insertData['orgId'] = Auth::user()->orgId;

            PastorBoard::create($insertData);
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



    public function postList(Request $request) {


        $offset =$request->offset;
        $limit = 3;

        $posts = PastorBoard::listAllPost($request->search)
                            ->offset($offset)
                            ->limit($limit)
                            ->get();

        $count =DB::select('SELECT FOUND_ROWS() as record_count');
        $count = $count[0]->record_count;

        $html = "";
        $adHtml = "";
        //print_r(count($posts));
        if(count($posts)==0) {

            $html='<div class="col-lg-12 post-section">
            <div class="card m-b-5">
            <div class="card-header ">
            No Data
            </div></div>
            </div>';
        }
        foreach($posts as $post){
            //dump($post);
            $adHtml = "";
            $class ="bg-warning";
            if($post->parent_type==3){ //ads
                $class = "bg-success";
                $adHtml = ' <p class=" font-14"><span class="bg-primary"><i class="fa fa-inr" aria-hidden="true"></i> '.$post->cost.'</span></p>';
            }
            if($post->parent_type==2){ //news
                $class = "bg-primary";
            }


            $hh_pic_image= url('/assets/uploads/organizations/avatar.png');
            if($post->image_path != null){
                $hh_pic_image_json = json_decode(unserialize($post->image_path));
                $hh_pic_image = $hh_pic_image_json->download_path.$hh_pic_image_json->uploaded_file_name;
            }
            $html.='<div class="col-lg-12 post-section">
                             <div class="card m-b-5">
                                 <div class="card-header '.$class.'">
                                     '.$post->p_title.'
                                     <span class="float-right font-14">'.date("d-M-Y h:i",strtotime($post->created_at)).'</span>
                                 </div>
                                 <div class="card-body">

                                     <div class="media">

                                         <img class="d-flex mr-3 rounded-circle" src="'.$hh_pic_image.'" alt="Generic placeholder image" height="128">
                                         <div class="media-body">
                                             <h5 class="mt-0 font-18 mb-1">'.$post->created_user.'</h5>
                                             <p class=" font-14">'.$post->p_description.'</p>
                                            '.$adHtml.'
                                             <p class="text-muted font-14 fb-contact">
                                             <span><i class="fa fa-user" aria-hidden="true"></i> '.$post->contact_name.' </span>
                                             <span><i class="fa fa-phone" aria-hidden="true"></i> '.$post->contact_phone.' </span>
                                             <span><i class="fa fa-envelope" aria-hidden="true"></i> '.$post->contact_email.'</span></p>
                                         </div>
                                     </div>

                                 </div>
                             </div>
                         </div>';
        }

        return response()->json(
                        [
                            'success' => '1',
                            "data" => $html,
                            "count" =>$count
                        ]
        );


    }

    public function managePostList(Request $request) {
        $Rooms = PastorBoard::listPost($request->search['value']);

        return DataTables::of($Rooms)
                        ->addColumn('action', function($row) {

                            $hh_pic_image= url('/assets/uploads/organizations/avatar.png');
                            if($row->image_path != null){
                                $hh_pic_image_json = json_decode(unserialize($row->image_path));
                                $hh_pic_image = $hh_pic_image_json->download_path.$hh_pic_image_json->uploaded_file_name;
                            }

                            $html='<div class="row post-main">

                            <div class=" col-md-12 mt-0 font-18 mb-1">'.$row->p_title.'</div>
                                    <div class=" col-md-2 post-image-container">

                                      <img src="'.$hh_pic_image.'" class="post-img" style="height:100px; ">
                                    </div>

                                    <div class=" col-md-7 ">

                                      <div class="post-desc ">'.$row->p_description.'</div>
                                       <div class="post-email"> '.$row->contact_email.'</div>
                                       <div class="post-phone"> '.$row->contact_phone.'</div>


                                    </div> <div class="col-md-3">
                                                    <button class="btn" onclick="editPost('.$row->id.')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                    <button class="btn" onclick="deletePost('.$row->id.')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                             </div></div>';




                            return $html;
                        })
                        /*->addColumn('quantity', function($row) {
                            return 0;
                        })
                        ->addColumn('image', function($row) {
                            $hh_pic_image= url('/assets/uploads/organizations/avatar.png');
                            if($row->room_image != null){
                                $hh_pic_image_json = json_decode(unserialize($row->room_image));
                                $hh_pic_image = $hh_pic_image_json->download_path.$hh_pic_image_json->uploaded_file_name;
                            }
                            return "<img src='$hh_pic_image' style='max-width:25px;' />";
                        })*/
                        ->rawColumns(['action'])
                        ->make(true);
    }
    public function edit($id) {
        $data['title'] = $this->browserTitle . " - Edit Post";
        $data['p_category'] = \App\Models\MasterLookupData::selectFromMasterLookupData([["mldKey","=","room_group"]])->get();
        //$data['room_group'] = \App\Models\MasterLookupData::selectFromMasterLookupData([["mldKey","=","room_group"]])->get();
        $post = PastorBoard::findOrFail($id);

        $data['post'] = $post;
        $data['locations'] = Location::listLocations("")->get();
        return view('pasterBoard.create_post', $data);

    }

    /**
     * @Function name : resourceFileUpload
     * @Purpose : upload resourceFileUpload
     * @Added by : Ananth
     * @Added Date : 1 sep 2019
     */
    private function resourceFileUpload($file,$parent_type) {


        $extension = $file->getClientOriginalExtension();


        $imageName = basename($file->getClientOriginalName(), ("." . $extension));

        $imageName .= "_" . time() . '.' . $extension;
        $destinationPath = $this->common_file_upload_path['PROFILE_PIC_UPLOAD_PATH'] . DIRECTORY_SEPARATOR . Auth::user()->orgId . DIRECTORY_SEPARATOR . "post" . DIRECTORY_SEPARATOR. $parent_type. DIRECTORY_SEPARATOR;


        $downloadPath = $this->common_file_download_path['PROFILE_PIC_DOWNLOAD_PATH'] . '/' . Auth::user()->orgId . '/' . "post" . '/'.$parent_type.'/';


        $file->move(
                $destinationPath, $imageName
        );



        $upload_data = array('uploaded_path' => $destinationPath, 'download_path' => $downloadPath, 'uploaded_file_name' => $imageName, 'original_filename' => $imageName, 'upload_file_extension' => $extension, 'file_size' => 0);
        $jsonformat = serialize(json_encode($upload_data));

        return $jsonformat;
    }

}
