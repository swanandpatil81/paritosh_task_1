<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TestController extends Controller{

	public function get_user_data($user_id){

		$result = DB::select('call get_user_data(?)' , array($user_id));
		echo json_encode($result);
	}
    
  public function get_user_data_post(Request $request){

  	$result = DB::select('call get_user_data(?)' , array($user_id));
	  echo json_encode($result);
  }

  public function pdf_test(){

  	/*$content = "";

  	$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($content);
		return $pdf->download('test.pdf');*/
  }
}