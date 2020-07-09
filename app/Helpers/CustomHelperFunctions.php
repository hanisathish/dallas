<?php
namespace App\Helpers;

use DB;
use Config;
use File;
class CustomHelperFunctions {
    /**
     * Function name : serializedJsonCreation()
     * Purpose : Creating a common function for serialized Json creation
     * Added by : Sathish
     * Added Date : Jul 03rd, 2018
     */
    public static function serializedJsonCreation($field_name,$count,$request) {

        for($i=0;$i<=$count;$i++){
            $arrayKeyValues[] = array($field_name.$i => $request->get($field_name.$i));
            //$arrayUnsetValues[] = $field_name.$i;
            //unset($request->get($field_name.$i));
        }
        //unset($arrayUnsetValues);
        return serialize(json_encode($arrayKeyValues));
    }

    /**
     * Function name : getMasterData()
     * Purpose : Get the data from mastertable using key
     * Added by : Sathish
     * Added Date : Jul 04, 2018
     */

    public static function getMasterData($key,$exclude=null,$orderByField=null,$whereArray)
    {
        $result=DB::table('master_lookup_data')
                ->select('*')
                ->where($whereArray)
                ->where('mldKey',$key);
        if($exclude)
        {
            $result->where('mldValue','!=',$exclude);
        }
        if($orderByField){
            $result->orderBy($orderByField, 'asc');
        }else{
            $result->orderBy('mldValue', 'asc');
        }
        
        $query=$result->get();

        if($query->count()>0)
        {
        return $query->toArray();
        }
        else
        {
           return [];
        }


    }
  
    /**
     * @Function name : fileMove
     * @Purpose : Move the files from one folder to another
     * @Added by : Sathish
     * @Added Date : Jul 23, 2018
     */
    public static function fileMove($temp_path,$destination_path,$document_attachement_array,$file_var_name){

        if(count($document_attachement_array) > 0){
            foreach($document_attachement_array as $value)
            {
                if(file_exists($temp_path.$value->$file_var_name))
                {
                    File::move($temp_path.$value->$file_var_name,$destination_path.$value->$file_var_name);
                }
            }
        }

    }
    
    /**
     * @Function name : commonFileUploadHelper
     * @Purpose : File upload
     * @Added by : Sathish
     * @Added Date : Jul 24, 2018
     */
    public static function commonFileUploadHelper($file,$destinationPath)
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $filesize=$file->getClientSize();
        $rawName = pathinfo($originalName, PATHINFO_FILENAME);
         
        $fileName = $rawName . "_" . time() . "." . $extension;
        
        $file->move($destinationPath, $fileName);
        $upload_data = array('uploaded_path' => $destinationPath, 'uploaded_file_name' => $fileName,'original_filename'=>$originalName ,'upload_file_extension' => $extension,'file_size'=>$filesize,'upload_category'=>$upload_category);
        $jsonformat=serialize(json_encode($upload_data));
        return $jsonformat;
    }
     
    
    /**
     * @Function name : deleteFilesFromFolder
     * @Purpose : Delete selected files from folder
     * @Added by : Sathish
     * @Added Date : Aug 2, 2018
     */
    public static function deleteFilesFromFolder($files_array, $folder_path) {
        $do_not_delete = array();  
        foreach($files_array as $row){
            if($row != null){
              $unserialized_object = json_decode(unserialize($row));              
              $do_not_delete[] = $unserialized_object->uploaded_file_name;                            
            }
        }    
        $directory = $folder_path;
        if(!empty($do_not_delete)){
            foreach(glob($directory ."\*") as $filename) {
                $files_to_be_deleted = preg_replace('/^.+[\\\\\\/]/', '', $filename);
                if (!in_array($files_to_be_deleted, $do_not_delete)) {
                    unlink($filename);
                }
            }
        }
    }
     
    
    /**
     * @Function name : getKeyValuePair
     * @Purpose : Creating Key Value Pair
     * @Added by : Sathish
     * @Added Date : Aug 2, 2018
     */
    public static function getKeyValuePair($table_name,$key,$value) {        
        $model_class_name = '\App\Models\\'.$table_name;
        $result = $model_class_name::pluck($value, $key);
        return $result;
    }
                 
    /**
     * @Function name : emptyValuesUnsetFromArray
     * @Purpose : Unset the keys from an array,whose value is empty
     * @Added by : Sathish
     * @Added Date : Nov 27, 2018
     */    
    public static function emptyValuesUnsetFromArray($data) {
        foreach($data as $key => $val){
            if($val == '' || $val == null || empty($val) || $val == 'null'){
               unset($data[$key]);
            }
        }
        return $data;
    }
     
    
}
