<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Config;
use Response;

use App\Models\Insights;
use DB;
use DataTables;
use Auth;
class InsightsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->browserTitle = Config::get('constants.BROWSERTITLE');
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
        $this->common_file_download_path = Config::get('constants.FILE_DOWNLOAD_PATH');
	    $this->userSessionData = Session::get('userSessionData');
		$this->authUserId = $this->userSessionData['umId'];
		
    }
     

    public function insightIndex()
    {
        $data['title'] = $this->browserTitle . " - Insights List";
        return view('insights.index', $data);
    }
	
	
	public function getInsightList()
    {
        $result = array();  
		
        $insights = Insights::selectInsightDetail(null, null, null, null, null, null)->get();

        $i = 1;
        foreach ($insights as $insight) {
			
            $row = array();
			$btn = "";
			
            $row[] = $insight->id;
			$row[] = $insight->typename;
            $row[] = $insight->name;

            if($insight->type==1) 
			{
               $r = json_decode(unserialize($insight->source));
			   $url = $r->download_path."/".$r->uploaded_file_name;
			   $btn.='<a download href="'.$url.'" class="btn btn-outline-primary btn-sm" target="_blank">Download</a>';
			} 
			else 
			{
                $btn.='<a href="'.$insight->source.'" class="btn btn-outline-primary btn-sm" target="_blank">Go to Link</a>';
            }

            //showConfirm
            $button_html = '<a onclick="edit_insight(' . $insight->id . ')"  data-toggle="tooltip"   href="#"  data-original-title="Edit"><i class="fa fa-edit"></i></a>
                            <a onclick="insight_data_delete(' . $insight->id . ')"   href="#"><i class="fa fa-trash"></i></a>';
			
            $row[] = $btn;
            $row[] = $button_html;
            $result[] = $row;
        }

        //return Datatables::of($result)->rawColumns([6])->make(true);
        return Datatables::of($result)->escapeColumns(['id'])->make(true);
    }
	
	
    public function getInsightById(Request $request)
    {
        $getInsightById = Insights::find($request->get('insightID'));
        return $getInsightById;
    }
	
	
	
	public function storeOrUpdateInsight(Request $request)
    {
		
		$file = "";
        if (isset($request->file) && $request->file != "") {
			
            $file = $this->insightsFileUpload($request->file);
        }
		else{
			
			
		}
		
        $insightFormData = $request->except('hidden_insightID','file');
        $insightFormData['createdBy'] = $this->authUserId;

        unset($insightFormData['hidden_insightID'], $insightFormData['_token']);
		
		
		if ($file == "") {
			
			$insightId = $request->get('hidden_insightID');
		    $source = DB::table('insights')->where('id', $insightId)->value('source');
			$insightFormData['source'] = $source;
            
        } else	{
            $insightFormData['source'] = $file;
        }
		
        if ($request->get('hidden_insightID') > 0) {
            unset($insightFormData['createdBy']);
            $insightFormData['updatedBy'] = $this->authUserId;
            $whereArray = array('id' => $request->get('hidden_insightID'));
            $updateDetails = Insights::updateInsights($insightFormData, $whereArray);
            return "updated";
        } else {
            $insertDetails = Insights::create($insightFormData);
            if ($insertDetails->id > 0) {
                return "inserted";
            } else {
                return 0;
            }
        }
    }
	
	public function deleteInsightById(Request $request)
    {

        $whereArray = array('id' => $request->get('eventattedanceId'));
        $updateAHDeletedStatus = array('deleted_at' => now(), 'deletedBy' => $this->authUserId);
        Insights::crudInsights($whereArray, null, null, null, null, $updateAHDeletedStatus, null, null);
    }
	
	
	
    /**  Insights **/

    public function addInsights(Request $request){

        $data['title'] = $this->browserTitle . " - ";
        $data['groupId'] = $request->groupId;
        return view('insights.add_insights', $data);
    }
	
	
	public function store(Request $request){
		
        $insertData = $request->all();
		
		//dd($insertData);

 		
        $resourceId = $request->resourceId;

        //validation rules

        $file = "";
        if (isset($request->file) && $request->file != "") {
            $file = $this->insightsFileUpload($request->file,$request->group_id);
        }
		
        $insertData = $request->except(['_token', 'resourceId',"file","source",'url_name','url_description','url_visibility']);
		
        $insertDataURL = $request->except(['_token']);
		
        //print_r($insertData);
        //$insertData['name'] = $request->url_name;
        //$insertData['description'] =  $request->url_description;		
        //$insertData['visibility'] = $request->url_visibility;
		
        if($request->type==2){
            $insertDataURL['name'] = $request->url_name;
			$insertDataURL['description'] =  $request->url_description;		
            $insertDataURL['visibility'] = $request->url_visibility;		
            $file = $request->source;
            
        }
		
        if ($file == "") {
            //$insertData->except(['item_photo']);
        } else {
            $insertData['source'] = $file;
        }

        if ($resourceId > 0) { 
		    //update
            $insertData['updatedBy'] = Auth::id();

            Insights::where("id", $resourceId)->update($insertData);
			
        } else { //insert
            $insertData['createdBy'] = Auth::id();
            //$insertData['orgId'] = Auth::user()->orgId;

            Insights::create($insertData);
        }

         //return response()->json(['success' => '1',"message" => '<div class="alert alert-success"><strong>Saved!</strong></div>']);
		
		return redirect('insights/manage/');
    }
	
	
	public function insightList(Request $request) {

        $result = array();
                                        
        $insights = Insights::select("insights.id",'insights.name',"insights.type","insights.source","insights.description","insights.visibility","insights.updated_at as upddate",DB::raw("(CASE insights.type WHEN '1' THEN 'File' ELSE 'URL' END) AS typename"))->get();
        
        //$insights = insight::getinsightList();
        //dd($insights); 
        
        //$insights = insight::where('orgId', $this->orgId)->select("id", "type", "amount")->orderBy("id", "desc")->get();
                    
        $i = 1;
        foreach ($insights as $insight) {
            
            $row = [ $insight->typename, $insight->name, $insight->description, $insight->upddate];

			/*if($insight->type==1) 
			{
				 $r = json_decode(unserialize($insight->source));
				 $url = $r->download_path."/".$r->uploaded_file_name;

				$row[]='<a download href="'.$url.'" class="btn btn-outline-primary btn-sm" target="_blank">Download</a>';
			}
			else 
			{
				$row[] = '<a href="'.$insight->source.'" class="btn btn-outline-primary btn-sm" target="_blank">Go to Link</a>';
			}*/
			
			$editLink = url("/insights/edit/". $insight->id);            
			$row[] = "<a href='".$editLink ."'>  <i class='fa fa-pencil-square-o'></i></a>";
			
            //$row[] = '<a onclick="editInsights('.$insight->id.') class="edit btn btn-primary btn-sm float-right"><i class="fa fa-edit"></i></a>';
			
            $result[] = $row;
            $i += 1;
        }

        return Datatables::of($result)->rawColumns([4])->make(true);


        /*$groupId = $request->groupId;
        $members  = Insights::insightList($groupId,$request->search['value']);
        return DataTables::of($members)
                        ->addColumn('action', function($row) {

                            $btn ="";

                            if($row->type==1) {
                                $r = json_decode(unserialize($row->source));

                                $url =$r->download_path."/".$r->uploaded_file_name;
                                //$r->uploaded_file_name;

                                $btn.='<a download href="'.$url.'" class="btn btn-outline-primary btn-sm" target="_blank">Download</a>';
                            }
                            else {
                                $btn.='<a href="'.$row->source.'" class="btn btn-outline-primary btn-sm" target="_blank">Go to Link</a>';
                            }

                            $btn.= '<a onclick="editInsights(' . $row->id . ')"  class="edit btn btn-primary btn-sm float-right"><i class="fa fa-edit"></i></a>';



                            return $btn;
                        })

                        ->addColumn('type', function($row) {
                            return ($row->type==1)?'<i title="file" class="fa fa-file" aria-hidden="true"></i>':'<i title="link" class="fa fa-link" aria-hidden="true"></i>';
                        })

                        ->addColumn('updated_at', function($row) {
                            return date('d-M-Y',strtotime($row->updated_at));
                        })

                        ->addColumn('visibility', function($row) {
                            return ($row->visibility==1)?'Leaders/Admins':'All';
                        })
                        ->rawColumns(['action',"type"])
                        ->make(true);*/
    }
	
	
	
	public function editInsights($eventId, Request $request){
		
        $data['title'] = $this->browserTitle . " - ";
        $data['groupId'] = $request->groupId;
        $data['resource'] = Insights::find($eventId);


        if($data['resource'] != null){
            //echo $data['resource']->source; exit();
            if($data['resource']->type==1){
                $r = json_decode(unserialize($data['resource']->source));
                $data['resource']->source = $r->uploaded_file_name;
            }
            else {

            }
        }

        return view('insights.edit_insights', $data);
    }
	

	
	private function insightsFileUpload($file) {

        $extension = $file->getClientOriginalExtension();

        $imageName = basename($file->getClientOriginalName(), ("." . $extension));

        $imageName .= "_" . time() . '.' . $extension;
		
        $destinationPath = $this->common_file_upload_path['INSIGHTS_UPLOAD_PATH'];

        $downloadPath = $this->common_file_download_path['INSIGHTS_DOWNLOAD_PATH'] . '/';

        $file->move(
                $destinationPath, $imageName
        );

        $upload_data = array('uploaded_path' => $destinationPath, 'download_path' => $downloadPath, 'uploaded_file_name' => $imageName, 'original_filename' => $imageName, 'upload_file_extension' => $extension, 'file_size' => 0);
        $jsonformat = serialize(json_encode($upload_data));

        return $jsonformat;
    }
	
	
}
