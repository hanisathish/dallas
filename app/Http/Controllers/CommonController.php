<?php

namespace App\Http\Controllers;

use App\Models\BonusPointTask;
use App\Models\CoinsWinLimit;
use Illuminate\Http\Request;
use Auth;
use Config;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;
use App\Models\SpinWheelImages;
use App\Models\DailyQuotes;

class CommonController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        
        $this->userSessionData = Session::get('userSessionData');
        $this->todays_date = Config::get('constants.TODAYSDATE');
        
        $this->common_file_upload_path = Config::get('constants.FILE_UPLOAD_PATH');
    }

    public function index() {
        
    }

    /**
     * @Function name : getCommonCoins
     * @Purpose : getCommonCoins
     * @Added by : Sathish
     * @Added Date : Jun 12, 2019
     */
    public function getCommonCoins(Request $request) {
        
        //Coins gained
        $whereCWLArray = array('cwlType'=>$request->segment(3));
        $crudCoinsWinLimitGain = CoinsWinLimit::crudCoinsWinLimitGain($whereCWLArray,null,null,'1', null)->get();
        if($crudCoinsWinLimitGain->count()>0){
            return response()->json(['result_code'=>1, 'coins' => $crudCoinsWinLimitGain[0]->coinsgainned]);
        }else{
            return response()->json(['result_code'=>2, 'coins' => 0]);
        }
        
        //return view('posts.index', compact('posts'));
    }
    
    /**
     * @Function name : getActionTypes
     * @Purpose : getActionTypes
     * @Added by : Sathish
     * @Added Date : Jun 28, 2019
     */
    public function getActionTypes(Request $request) {
        
        $actionTypes=array( "bonus_point_task","daily_quotes","roll_a_dice","spin_wheel","watch_video","show_ads","scratch_and_win","refer_friend","daily_check_in","quiz");
        return response()->json(['result_code'=>1, 'action_types' => $actionTypes]);
    }
 
    /**
     * @Function name : getSpinWheelCoins
     * @Purpose : getSpinWheelCoins
     * @Added by : Sathish
     * @Added Date : Jun 28, 2019
     */
    public function getSpinWheelCoins(Request $request) {

        $whereCWLArray = array('cwlType'=>'spin_wheel');
        $crudCoinsWin = CoinsWinLimit::crudCoinsWin($whereCWLArray,null,null,null,null,'1',null)->get();
        if($crudCoinsWin->count()>0){
            $whereSWIArray=array();
            $selectFromSpinWheelImages = SpinWheelImages::selectFromSpinWheelImages($whereSWIArray, null,null)->get();
            $selectFromSpinWheelImagesArray=array_column($selectFromSpinWheelImages->toArray(),'imageName');
            $spinWheelIconsArray=explode(",", ($this->common_file_upload_path['SPIN_WHEEL_ICONS']."\\".implode(",".$this->common_file_upload_path['SPIN_WHEEL_ICONS']."\\", $selectFromSpinWheelImagesArray)));
            
            $cwlFromCoin = $crudCoinsWin->toArray()[0]['cwlFromCoin'];
            return response()->json(['result_code'=>1, 'coins' => array($cwlFromCoin*1,$cwlFromCoin*2,$cwlFromCoin*3,$cwlFromCoin*4,$cwlFromCoin*5,$cwlFromCoin*6,$cwlFromCoin*7,$cwlFromCoin*8),'spin_wheel_icons'=>$spinWheelIconsArray]);
        }else{
            return response()->json(['result_code'=>2, 'coins' => 0]);
        }
    }
    
    /**
     * @Function name : getCommonActionDetails
     * @Purpose : getCommonActionDetails
     * @Added by : Sathish
     * @Added Date : Jul 02, 2019
     */
    public function getCommonActionDetails(Request $request) {

        $action_type = $request->action_type;
        //Coins gained
        $whereCWLArray = array('cwlType'=>$action_type);
        $crudCoinsWinLimitGain = CoinsWinLimit::crudCoinsWinLimitGain($whereCWLArray,null,null,'1', null)->get();
        
        if($action_type == 'daily_quotes'){
            $whereArray = array('dqPublishDate'=>$this->todays_date);
            $caDetails = DailyQuotes::selectFromDailyQuotes($whereArray, null, 5)->get();
            $commonArray = $caDetails->toArray();
            $commonCount = $caDetails->count();
        }
        if($action_type == "bonus_point_task"){
            $whereArray = array('bptPublishDate'=>$this->todays_date);
            $caDetails = BonusPointTask::selectFromBonusPointTask($whereArray, null, 5)->get();
            $commonArray = $caDetails->toArray();
            $commonCount = $caDetails->count();
        }
        if($action_type == "spin_wheel"){
            $whereSWIArray=array();
            $selectFromSpinWheelImages = SpinWheelImages::selectFromSpinWheelImages($whereSWIArray, null,null)->get();
            $selectFromSpinWheelImagesArray=array_column($selectFromSpinWheelImages->toArray(),'imageName');
            $spinWheelIconsArray=explode(",", ($this->common_file_upload_path['SPIN_WHEEL_ICONS']."\\".implode(",".$this->common_file_upload_path['SPIN_WHEEL_ICONS']."\\", $selectFromSpinWheelImagesArray)));
            
            $whereCWLArray = array('cwlType'=>$action_type);
            $crudCoinsWin = CoinsWinLimit::crudCoinsWin($whereCWLArray,null,null,null,null,'1',null)->get();
        
            $cwlFromCoin = $crudCoinsWin->toArray()[0]['cwlFromCoin'];
            $commonArray = array("images"=>$spinWheelIconsArray,'coins_in_spin_wheels'=>array($cwlFromCoin*1,$cwlFromCoin*2,$cwlFromCoin*3,$cwlFromCoin*4,$cwlFromCoin*5,$cwlFromCoin*6,$cwlFromCoin*7,$cwlFromCoin*8));
            $commonCount = count($spinWheelIconsArray);
        }
        
        if($action_type == "scratch_and_win"){
            
            $commonArray = array();
            $commonCount = 1;
        }
        //dd($caDetails->toArray());
        
        
        if($commonCount>0){
            return response()->json(['result_code'=>1, 'action' => $action_type,'hist_remaining'=>0,'coins_earned'=>$crudCoinsWinLimitGain[0]->coinsgainned,'misc'=>$commonArray]);
        }else{
            return response()->json(['result_code'=>2, 'message' => "Sorry No data"]);
        }
    }
}
