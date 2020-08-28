<html>
<head>
	<link rel="stylesheet" type="text/css" href="{{url('/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('/css/pagination.css')}}">
	<script type="text/javascript" src="{{url('/js/jquery_library.js')}}"></script>
	<script type="text/javascript" src="{{url('/js/bootstrap.min.js')}}"></script>
</head>
<body>

<div>
	<input type="hidden" name="q_search" id="q_search" value="{{ $q_search }}" readonly>
	<input type="button" class="btn btn-primary" id="show_all_rec" value="Show All Records">
	<span class="span_search">
	<input type="text" name="txt_search" id="txt_search" placeholder="Search" value="{{ $txt_search }}" onkeyup="search_on_enter(this.id ,'btn_search')">
		<input type="button" id="btn_search" value="Go" class="btn btn-primary">
	</span>
</div>

<table class="table table-striped table-bordered">
							
	<thead>
		<tr>
		<th align="center">User Id</th>
		<th align="center">User Name</th>
		<th align="center">First Name</th>
		<th align="center">Last Name</th>
		<th align="center">Gender</th>
		</tr>
	</thead>

	<tbody>
		@foreach($data as $val)
		<tr>
		<td align="center">{{ $val -> user_id }}</td>
		<td align="center">{{ $val -> username }}</td>
		<td align="center">{{ $val -> first_name }}</td>
		<td align="center">{{ $val -> last_name }}</td>
		<td align="center">{{ $val -> gender }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
<div class="total_no_data">
	<span class="total_data">{{ $TotalData }}</span>
	<span class="goto">
	<input type="text" name="txt_goto_page" id="txt_goto_page" placeholder="Go to Page" onkeyup="search_on_enter(this.id ,'btn_goto_page')">
	<input type="button" id="btn_goto_page" value="Go" class="btn btn-primary">
	</span>
</div>

<span class="pagi_per">
{!! $pagination !!}
</span>

</body>


<script>
$('#btn_search').on('click',function(){
var txt_search = $('#txt_search').val();

if(txt_search==''){
	alert("Please Enter value to search");
	$('#txt_search').focus();
	return false;
}
if(txt_search!=''){
	window.location = "{{ $targetPage }}/1/q_search/"+txt_search;
}
});

function search_on_enter(this_id ,btn_id){
	var input = document.getElementById(this_id);
	input.addEventListener("keyup", function(event) {
	    event.preventDefault();
	    if (event.keyCode === 13) {
	        document.getElementById(btn_id).click();
	    }
	});
}

$('#show_all_rec').on('click',function(){
	window.location.href = "{{ $targetPage }}";
});

$('#btn_goto_page').on('click',function(){
	var txt_goto_page = $('#txt_goto_page').val();
	var q_search = $('#q_search').val();
	var txt_search = $('#txt_search').val();
	var lastpage = parseInt({{ $lastpage }});
	if(txt_goto_page==''){
		alert("Please Enter Page Number");
		$('#txt_goto_page').focus();
		return false;
	}
	if(parseInt(txt_goto_page) <= lastpage){
		if((q_search =='') && (txt_search =='')){
			window.location = "{{ $targetPage }}/"+txt_goto_page;
		}
		if((q_search =='q_search') && (txt_search !='')){
			window.location = "{{ $targetPage }}/"+txt_goto_page+"/"+q_search+"/"+txt_search;
		}
	}
	if(parseInt(txt_goto_page) > lastpage){
		alert('The Page You are trying to Go To Does not Exist');
		$('#txt_goto_page').focus();
		return false;
	}
});
</script>
</html>