<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Config;

use App\Models\MyContact;
use App\Models\MyContactGroup;
use App\Models\ContactGroupMap;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Excel;
use Validator;
use Redirect;

class BulkUploadController extends Controller
{

    public function __construct()
    {
        
        $this->middleware(function ($request, $next) {
            $this->userguard = Auth::guard('web')->user();

            return $next($request);
        });
    }

    /**
     * @Function name : index
     * @Purpose :  Bulk Upload listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function index(Request $request)
    {
        $data['title'] = "Bulk Upload";
        if($this->userguard->roles[0]->name == "superadmin"){
            $whereArray = null;
        }else{
            $whereArray = array('contact_group.createdBy' => $this->userguard->id);    
        }
        $data['crudMyContactGroup'] = MyContactGroup::crudMyContactGroup($whereArray,null,null,null,null,null,null,'1')->get();
        //dd($data['crudMyContactGroup']);
        return view('settings.bulkupload.index',$data);
    }

    /**
     * @Function name : bulkImportExcel
     * @Purpose :  bulkImportExcel
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function bulkImportExcel(Request $request)
    {
        $validator = Validator::make(
            [
                'file'      => Input::file('import_file'),
                'extension' => strtolower(Input::file('import_file')->getClientOriginalExtension())
            ],
            [
                'file'          => 'required',
                'extension'      => 'required|in:xlsx,xls'
            ]  
            );

        $validator1=Validator::make($request->all(),[
            //use this
                'bulk_upload_type' => 'required'
            
            ]);
        // $validator = Validator::make($request->all(), [
        //             'import_file' => 'required|mimes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        //             //'required|mimes:xlsx,xls',
        //             'bulk_upload_type' => 'required'
        // ]);
        if ($validator1->fails()) {
            // dd($validator->errors());
            return Redirect::back()->withErrors($validator1->errors());
        }
        if ($validator->fails()) {
            // dd($validator->errors());
            return Redirect::back()->withErrors($validator->errors());
        }

        
        if(Input::hasFile('import_file')){
            DB::beginTransaction();
            $path = Input::file('import_file')->getRealPath();
            
			$data = Excel::load($path, function($reader) {
                
            })->get();
            $headerRow = $data->first()->keys()->toArray();
			
			if(!empty($data) && $data->count()){
                $file = Input::file('import_file');

                $countheader = count($headerRow); 
                // dd($headerRow,$countheader);
                if($request->input('bulk_upload_type') == 'contact_bulk'){
                    if($countheader == 3  && in_array('email',$headerRow) && in_array('first_name',$headerRow) && in_array('last_name',$headerRow)){
                        foreach ($data as $key => $value) {
                            if($value->email && $value->first_name){
                                $insert[] = ['c_email' => $value->email, 'c_f_name' => $value->first_name, 'c_l_name' => $value->last_name,'orgId' => $this->userguard->orgId,'createdBy' => $this->userguard->id];
                            }                            
                        }
                        // dd($insert);
                        if(!empty($insert)){ //first()
                            $latestMyContact = MyContact::select('id')->orderBy('id', 'DESC')->get();
                            if($latestMyContact->count() > 0){
                                $latestMyContactId = $latestMyContact->first()->id;
                            }else{
                                $latestMyContactId = 1;
                            }
                            // dd($latestMyContactId);
                            MyContact::insert($insert);

                            //insert into group if group name is entered
                            if($request->input('group_id')){
                                $group_id = $request->input('group_id');
                                if($request->input('grp_name_enter')){

                                    $myContactGroupFormData = $request->except('bulk_upload_type','group_id','import_file');

                                    if($this->userguard->roles[0]->name == "superadmin"){
                                        $myContactGroupFormData['orgId'] = $this->userguard->orgId;
                                    }else{
                                        $myContactGroupFormData['orgId'] = $this->userguard->orgId;
                                    }
                                    $myContactGroupFormData['createdBy'] = $this->userguard->id;

                                    $myContactGroupFormData['group_name'] = $request->input('grp_name_enter');
                                    
                                    $insertMyContactGroupDetails = MyContactGroup::create($myContactGroupFormData);
                                    $group_id = $insertMyContactGroupDetails->id;
                                }

                                //insert into group contact map
                                $myContact = DB::table('contact_list')->select('id')->where('id', '>', $latestMyContactId)->get();

                                foreach($myContact as $myContactValue){
                                    $insertGroupToContact[] = array(
                                        'contact_list_id'=>$myContactValue->id,'contact_group_id'=>$group_id
                                    );
                                }
                                    
                                
                                $insertCGM = ContactGroupMap::insert($insertGroupToContact);

                            }
                            
                        }
                    } else {
                        // return redirect()->back()->with('flash_message_error', 'Your file having unmatched Columns to our database...');
                        return redirect()->route('bulkupload.index')->with('error','Your file having unmatched Columns to our database...');
                    }

                }
                DB::commit();
                return redirect()->route('bulkupload.index')->with('success','Data from file uploaded successfully');
				return redirect('settings/bulkupload');
			}
		}
		return back();
    } 

}