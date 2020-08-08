<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use DB;
use Excel;
class ImportExcelController extends Controller
{
	public function getListItem(){
		$tblcust = User::all();
		return view('listItem', compact('tblcust'));
	}
    public function importExport()
	{
        
		return view('Import');
	}
	public function downloadExcel($type)
	{
		$data = User::get()->toArray();
		return Excel::create('ListUser', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
	} 
	public function importExcel()
	{
        
		if(Input::hasFile('import_file')){
            $path = Input::file('import_file')->getRealPath();
            
			$data = Excel::load($path, function($reader) {
			})->get();
			// dd($data);
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {
					$insert[] = ['orgId' => $value->orgId, 'householdName' => $value->householdName, 'personal_id' => $value->personal_id, 'name_prefix' => $value->name_prefix, 'given_name' => $value->given_name, 'first_name' => $value->first_name, 'email' => $value->first_name, 'password' => $value->first_name];
				}
				// dd($insert);
				if(!empty($insert)){
					DB::table('users')->insert($insert);
					return redirect('settings/mycontact');
				}
			}
		}
		return back();
	}
	public function DeleteAll(){
		DB::table('users')->delete();
		return redirect('listItem');
	}
}
