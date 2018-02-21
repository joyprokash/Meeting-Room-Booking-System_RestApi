<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\models\floor;
use App\models\Room;
use App\models\Equibments;
use App\models\Bookroom;
use Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    public function getFloor(){
        $floors = floor::all();
        return response()->json($floors);
    }

    public function getBookedRoom(){
        $data = [];
        $user_id   = auth('api')->user()->id; 
        $floor     =$_GET['floor'];
        $room      =$_GET['room'];
        $startDate = date('Y-m-d', strtotime($_GET['startDate']));
        $endDate   = date('Y-m-d', strtotime($_GET['endDate']));
        $data = DB::select("SELECT * FROM `book_room` WHERE `FLOOR_ID`='$floor' AND `ROOM_ID` = '$room' AND (`START_DATE` >='$startDate' AND `END_DATE` <= '$endDate' )");
        if(!empty($data)){
            $data = $data ;
        }else{
            $data = ['response'=>'Data Not Found'] ;
        }
        return response()->json($data);
    }

    public function bookRoom(Request $request){

        $msg = [];
        $model = new Bookroom;
        $model->START_DATE = $request->start_date;
        $model->END_DATE = $request->end_date;
        $model->START_TIME = $request->start_time;
        $model->END_TIME = $request->end_time;
        $model->FLOOR_ID = $request->floor;
        $model->ROOM_ID = $request->room;
        $model->USER_ID = auth('api')->user()->id;
		$model->SUBJECT = $request->subject;
		$model->INVITES = $request->invites;
		$model->MESSAGE = $request->message;
		$model->ADD_REQ = $request->re;
		$model->EQUIB = $request->equib;
        if($model->save()) { $msg = ['SUCCESS'=>'ROOM BOOKED SUCCESSFULLY']; } else { $msg = ['ERROR'=>'SOMTHING WRONG']; }
        return response()->json($msg);
    }

    public function getRooms(){
        $floor_id = $_GET['id'];
        $rooms = Room::Where(['floor_id'=>$floor_id])->get()->toArray();
        return response()->json($rooms);
    }

    public function getDates(){
        $reqType = $_GET['reqType'];
        $date = $_GET['date'];
        $dates = [];
        if($reqType == 'prev'){
            $date = date('Y-m-d', strtotime($date . ' -1 day'));
        }else if($reqType == 'next'){
            $date = date('Y-m-d', strtotime($date . ' +1 day'));
        }else{
            $date = date('Y-m-d', strtotime($date . ' +1 day'));
        }
        for($i=0;$i<5;$i++){
            array_push($dates,['day'=>$date]);
            $date  = date('Y-m-d', strtotime($date . ' +1 day'));
        }
        return response()->json($dates);
    }

    public function getDatesBySelect(){
        $date = $_GET['date'];
        if(!empty($date)){
            $date = date('Y-m-d', strtotime($date));
            $dates = [];
            for($i=0;$i<5;$i++){
                array_push($dates,['day'=>$date]);
                $date  = date('Y-m-d', strtotime($date . ' +1 day'));
            }
            return response()->json($dates);
        }
       
    }

    public function getEquibments(){
        $Equibments = Equibments::all();
        return response()->json($Equibments);
    }

    public function getAlluser(){
        $users = User::all()->toArray();
        //print_r($users);exit;
        $userArray = array();
        foreach($users as $value){
            $userArray[]  = ['id'=>$value['id'],'value'=>$value['name'].":".$value['email']];
        }
        return response()->json($userArray);
    }


}
