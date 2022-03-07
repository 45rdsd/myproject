<!DOCTYPE html>
<html>
<head>
	<title>Điểm danh hôm nay</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Điểm Danh-Today</h2>
			</div>
			<div class="panel-body">

<table class="table table-bordered">
<thead>

    <th>STT</th>
    <th>Lớp học </th>
    <th>Rollno</th>
    <th>Học sinh </th>
    <th>Vắng mặt </th>
    <th>Đi Học</th>
    <th>Ghi chú</th>

</thead>
<tbody>

@if ( $studentList != null )

@foreach ($studentList as $item)
   <tr>
	<td>{{$index++}}</td>
	<td>{{$lichday->class_name}}</td>
	<td>{{$item->rollno}}</td>
	<td>{{$item->fullname}}</td>




	<td>
		  <input type="radio" name="{{ $item->rollno }}" value="0" class="form-control">
	</td>


	<td>
		<input type="radio" name="{{ $item->rollno }}" value="1"  class="form-control"  checked="true">
	</td>

	<th>
		<input type="text"   name="note_{{ $item->rollno }}" class="form-control"  >


	</th>
</tr>
@endforeach
	@endif

@if ($edit != null && count($edit) > 0)
@foreach ($edit as $item)
   <tr>
	<td>{{$index++}}</td>
	<td>{{ $lichday->class_name }}</td>
	<td>{{ $item->rollno }}</td>
	<td>{{ $item->fullname }}</td>

	<td>
		  <input type="radio" name="{{ $item->rollno }}" value="0"
		   class="form-control" {{ ($item->status == 0)?'checked' : ''
		}}>
	</td>

	<td>
		<input type="radio" name="{{ $item->rollno }}" value="1" 
		 class="form-control" {{ ($item->status == 1)?'checked':'' }}
		 >
	</td>

	<th>
		<input type="text"   name="note_{{ $item->rollno }}" class="
		form-control"  value="{{ $item->note }}">
</th>
</tr>
@endforeach
@endif




          </tbody>

      </table>
      <button class="btn btn-warning" onclick="submitData()">Save</button>
			</div>
		</div>
	  </div>

<!-- dùng ajax-jQuery-js để đẩy dữ liệu từ form điểm danh  vào database và dùng để lấy dữ liệu đã note lấy vào database -js -->

<script type="text/javascript">
	function submitData(){

//data json : đưa dữ liệu lên thành chuỗi datajson
//array =>object {'rollno',trạng thái 'status','note'}
//id_lichday


	statusList=jQuery ( 'input[type=radio]:checked' )
	 console.log(statusList)
	 data = []

	for ( i = 0 ; i < statusList.length; i++)  {

		     std = {
			'rollno': jQuery ( statusList[i] ).attr('name'),
			'status': jQuery ( statusList[i] ).val(),
			'note': jQuery( ' [name=note_' + jQuery( statusList[i] ).attr('name')+']') . val()
		         }
		         data.push(std)

	     }

	console.log(data)


$.post ('{{ route('attendence_post') }}' ,{
'_token': "{{ csrf_token() }}",
'id_lichday': {{ $lichday->id }},
'data' : JSON.stringify(data)


},function(dt) {
	location.reload()
})






	}



</script>
</body>
</html>