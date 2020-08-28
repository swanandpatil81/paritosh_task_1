<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paginator;

class IndexController extends Controller{
    
	public function emp_details($page_no = null , $q_search = null , $txt_search = null){

		$param['TARGET_PAGENAME'] = "/Employee-Details";
		$param['PAGE_NUMBER'] = $page_no;
		$param['Q_SEARCH'] = urldecode($q_search);
		$param['TXT_SEARCH'] = urldecode($txt_search);
		$param['DATA_LIMIT'] = 10;

		if(isset($param['PAGE_NUMBER']) and !empty($param['PAGE_NUMBER'])){
			$start = (($param['PAGE_NUMBER'] - 1) * $param['DATA_LIMIT']) + 1; //first item to display on this page
			$end = $start + ($param['DATA_LIMIT'] - 1);
			$limit_start = ($param['PAGE_NUMBER'] - 1) * $param['DATA_LIMIT'];
		}
		else{
			$start = 1;
			$end = $start + ($param['DATA_LIMIT'] - 1);
			$limit_start = 0;
		}

		if(($param['Q_SEARCH'] =='') and ($param['TXT_SEARCH'] =='')){
			$param['query'] = "call get_user_details($start,$end)";
			$param['count_query'] = "call count_user_details()";
		}
		if(($param['Q_SEARCH'] =='q_search') and ($param['TXT_SEARCH'] !='')){
			$param['query'] = "call search_user_details('$txt_search',$limit_start,$param[DATA_LIMIT])";
			$param['count_query'] = "call count_search_user_details('$txt_search')";
		}

		$paginator = new Paginator($param);

		$pagination = $paginator -> PaginationLinks($param);
		$data = $paginator -> get_data($param);
		$TotalData = $paginator -> TotalData_LastPage($param);
		return view("emp_details",['pagination'=>$pagination,'data'=>$data,'targetPage'=>$param['TARGET_PAGENAME'],'q_search'=>$q_search,'txt_search'=>$txt_search,'TotalData'=>$TotalData['TotalData_text'],'lastpage'=> $TotalData['lastpage']]);
	}

}