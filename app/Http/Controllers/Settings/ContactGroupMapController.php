<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Config;

use DataTables; 


use App\Models\MyContactGroup;
use App\Models\MyContact;
use App\Models\ContactGroupMap;

class ContactGroupMapController extends Controller
{

    public function __construct()
    {
        $this->set_password = Config::get('constants.SET_PASSWORD');
        $this->set_btn_class = Config::get('constants.SET_BTN_CLASS');
    }

    /**
     * @Function name : index
     * @Purpose :  MyContactGroups listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function index(Request $request)
    {
        $data['title'] = "MyContactGroup";

        return view('mycontactgroup.index',$data);
    }

       

    /**
     * @Function name : create
     * @Purpose :  MyContactGroups listing
     * @Added by : Sathish    
     * @Added Date : Jul 03, 2019
     */
    public function create(Request $request)
    {
 
    } 
     
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("contact_group_map")->where('id',$id)->delete();
        
        return "success";
        return redirect()->route('mycontact.index')
        ->with('success','Contact deleted successfully');
    }

}