<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Paginator extends Model{

	public $targetpage;
	public $page;
	public $q_search;
	public $txt_search;

public function __construct($param){

$this-> targetpage = $param['TARGET_PAGENAME']; 	//your file name (the name of this file)
$this-> page = (isset($param['PAGE_NUMBER']) and !empty($param['PAGE_NUMBER'])) ? $param['PAGE_NUMBER'] : '1';
$this-> q_search = (isset($param['Q_SEARCH']) and !empty($param['Q_SEARCH'])) ? $param['Q_SEARCH'] : '';
$this-> txt_search = (isset($param['TXT_SEARCH']) and !empty($param['TXT_SEARCH'])) ? $param['TXT_SEARCH'] : '';
$this -> limit = (isset($param['DATA_LIMIT']) and !empty($param['DATA_LIMIT'])) ? $param['DATA_LIMIT'] : '10';//how many items to show per page
}

public function PaginationLinks($param){

/* Setup vars for query. */
$adjacents = 10;							// How many adjacent pages should be shown on each side?
$limit = $this -> limit; 					//how many items to show per page
$targetpage = $this-> targetpage; 			//your file name (the name of this file)
$page =  $this-> page;   
$q_search = $this-> q_search;
$txt_search = $this-> txt_search;

if($q_search=='' and $txt_search==''){
	$optional_parameters = "";
}
if($q_search=='q_search' and $txt_search!=''){
	$optional_parameters = "$q_search/$txt_search";
}
				
$prev = $page - 1;							//previous page is page - 1
$next = $page + 1;							//next page is page + 1
$total_data = $this -> count_data($param);
$lastpage = ceil($total_data/$limit);		//lastpage is = total data / items per page, rounded up.
$lpm1 = $lastpage - 1;						//last page minus 1

$pagination = "";
$pagination .= "<div class=\"pagination\">";

//previous button
if ($page > 1) {
$pagination.= "<a href=\"$targetpage/$prev/$optional_parameters\">< previous</a>";
}
else{
$pagination.= "<span class=\"disabled\">< previous</span>";	
}

//pages	
if ($lastpage < 7 + ($adjacents * 2)){	//not enough pages to bother breaking it up	
	for ($counter = 1; $counter <= $lastpage; $counter++){
		if ($counter == $page){
			$pagination.= "<span class=\"current\">$counter</span>";
		}
		else{
			$pagination.= "<a href=\"$targetpage/$counter/$optional_parameters\">$counter</a>";					
		}
	}
}
elseif($lastpage > 5 + ($adjacents * 2)){	//enough pages to hide some

	//close to beginning; only hide later pages
	if($page < 1 + ($adjacents * 2)){
		for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
			if ($counter == $page){
				$pagination.= "<span class=\"current\">$counter</span>";
			}
			else{
				$pagination.= "<a href=\"$targetpage/$counter/$optional_parameters\">$counter</a>";					
			}
		}
		$pagination.= "...";
		$pagination.= "<a href=\"$targetpage/$lpm1/$optional_parameters\">$lpm1</a>";
		$pagination.= "<a href=\"$targetpage/$lastpage/$optional_parameters\">$lastpage</a>";		
	}
	//in middle; hide some front and some back
	elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
		$pagination.= "<a href=\"$targetpage/1/$optional_parameters\">1</a>";
		$pagination.= "<a href=\"$targetpage/2/$optional_parameters\">2</a>";
		$pagination.= "...";
		for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
			if ($counter == $page){
				$pagination.= "<span class=\"current\">$counter</span>";
			}
			else{
				$pagination.= "<a href=\"$targetpage/$counter/$optional_parameters\">$counter</a>";					
			}
		}
		$pagination.= "...";
		$pagination.= "<a href=\"$targetpage/$lpm1/$optional_parameters\">$lpm1</a>";
		$pagination.= "<a href=\"$targetpage/$lastpage/$optional_parameters\">$lastpage</a>";		
	}
	//close to end; only hide early pages
	else{
		$pagination.= "<a href=\"$targetpage/1/$optional_parameters\">1</a>";
		$pagination.= "<a href=\"$targetpage/2/$optional_parameters\">2</a>";
		$pagination.= "...";
		for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
			if ($counter == $page){
				$pagination.= "<span class=\"current\">$counter</span>";
			}
			else{
				$pagination.= "<a href=\"$targetpage/$counter/$optional_parameters\">$counter</a>";					
			}
		}
	}
}

//next button
if ($page < $counter - 1) {
	$pagination.= "<a href=\"$targetpage/$next/$optional_parameters\">next ></a>";
}
else{
	$pagination.= "<span class=\"disabled\">next ></span>";
}
$pagination.= "</div>\n";	

return $pagination;
}


public function count_data($param){
	
	$query_result = DB::select($param['count_query']);
	$total_data = $query_result[0] -> num;
	return $total_data;
}


public function get_data($param){
	
	$query_result = DB::select($param['query']);
	return $query_result;
}


public function TotalData_LastPage($param){
	$total_data = $this -> count_data($param);
	
	$lastpage = ceil($total_data / $this -> limit);

	$text = "Total Records = $total_data";

	$response['TotalData_text'] = $text;
	$response['lastpage'] = $lastpage;

	return $response;
}


}