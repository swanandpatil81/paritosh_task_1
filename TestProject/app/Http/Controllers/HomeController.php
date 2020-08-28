<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller{
    
    public function index(){
    	return view('dashboard');
    }

    public function default_road_parameters(){

    	define('SMOOTH_ROAD' , 80);
    	define('BAD_ROAD' , 60);
    	define('WIP_ROAD' , 40);
    	define('COMPULSORY_BREAKS_AT_200KM_DISTANCE' , 200);
    	define('COMPULSORY_BREAKS_AT_200KM_TIME_MINUTES' , 15);
    	define('NORMAL_BREAKS_AT_KM_TIME_MINUTES' , 20);
    }

    public function distance_calc(Request $request){   

    	if($request->distance == '' or $request->smoothroad == '' or $request->badroad == '' or $request->workinprogress == ''){

    		echo "?distance=800&smoothroad=400&badroad=200&workinprogress=200&break=";
    		echo "<br><br>";

    		echo "distance = Required (Integer)<br>";
    		echo "smoothroad = Required (Integer)<br>";
    		echo "badroad = Required (Integer)<br>";
    		echo "workinprogress = Required (Integer)<br>";
    		echo "break = Optional (Integer)<br>";

    	}else{

	    	$this -> default_road_parameters();

	    	$total_distance = (int)$request->distance;
	    	$smooth_road_distance = $request->smoothroad;
	    	$badroad_distance = $request->badroad;
	    	$workinprogress_distance = $request->workinprogress;

	    	if(isset($request->break) and !empty($request->break)){
	    		$breaks_taken = $request->break;
	    		$breaks_time = $breaks_taken * NORMAL_BREAKS_AT_KM_TIME_MINUTES;
	    	}else{
	    		$breaks_taken = floor($total_distance / COMPULSORY_BREAKS_AT_200KM_DISTANCE);
	    		$breaks_time = $breaks_taken * COMPULSORY_BREAKS_AT_200KM_TIME_MINUTES;
	    	}

	    	echo "distance = ".$total_distance." km<br>";
	    	echo "smoothroad = ".$smooth_road_distance." km<br>";
	    	echo "badroad = ".$badroad_distance." km<br>";
	    	echo "workinprogress = ".$workinprogress_distance." km<br>";
	    	echo "break = ".$breaks_taken."<br>";

	    	$total_smooth_bad_wip = $smooth_road_distance + $badroad_distance + $workinprogress_distance;
	    	echo "Total(smooth+bad+wip) = ".$total_smooth_bad_wip." km<br>";

	    	if($total_smooth_bad_wip == $total_distance){

	    		$smooth_road_seconds = $this -> display_smooth_road_data($smooth_road_distance , SMOOTH_ROAD);
	    		$bad_road_seconds = $this -> display_bad_road_data($badroad_distance , BAD_ROAD);
	    		$wip_road_seconds = $this -> display_wip_road_data($workinprogress_distance , WIP_ROAD);
	    		$breaks_seconds = $this -> display_break_data($breaks_time);
	    		echo "breaks_time = ".$breaks_time." minutes<br>";

	    		$total_journey_seconds = $smooth_road_seconds + $bad_road_seconds + $wip_road_seconds + ($breaks_time * 60);

	    		$this -> display_total_journey_data($total_journey_seconds);
	    	}else{
	    		return "Insufficient data";
	    	}
	    }
    }

    public function display_smooth_road_data($smooth_road_distance , $SMOOTH_ROAD){

    	$smooth_road_seconds = ($smooth_road_distance / $SMOOTH_ROAD) * 60 * 60;
    	
    	echo "Smooth Road Journey Will take ".$this -> secondsToTime($smooth_road_seconds);
    	echo "<br>";

    	return $smooth_road_seconds;

    }

    public function display_bad_road_data($badroad_distance , $BAD_ROAD){

    	$bad_road_seconds = ($badroad_distance / $BAD_ROAD) * 60 * 60;
    	
    	echo "Bad Road Journey Will take ".$this -> secondsToTime($bad_road_seconds);
    	echo "<br>";

    	return $bad_road_seconds;

    }

    public function display_wip_road_data($workinprogress_distance , $WIP_ROAD){

    	$wip_road_seconds = ($workinprogress_distance / $WIP_ROAD) * 60 * 60;
    	
    	echo "WIP Road Journey Will take ".$this -> secondsToTime($wip_road_seconds);
    	echo "<br>";

    	return $wip_road_seconds;

    }

    public function display_break_data($breaks_taken){

    	$breaks_seconds = $breaks_taken * 60;
    	
    	echo "Breaks during Journey Will take ".$this -> secondsToTime($breaks_seconds);
    	echo "<br>";

    	return $breaks_seconds;

    }

    public function display_total_journey_data($total_journey_seconds){
    	
    	echo "Total Journey Will take ".$this -> secondsToTime($total_journey_seconds);
    	echo "<br>";

    }

    function secondsToTime($seconds) {
	    $dtF = new \DateTime('@0');
	    $dtT = new \DateTime("@$seconds");
	    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
	}
}
