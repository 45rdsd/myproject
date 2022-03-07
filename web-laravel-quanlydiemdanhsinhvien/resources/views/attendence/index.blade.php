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
				<h2 class="text-center">Lịch Dạy Hiện Có - Điểm Danh</h2>
			</div>
			<div class="panel-body">

<table class="table table-bordered">
<thead>

    <th>STT</th>
    <th>Lớp học </th>
    <th>Giáo viên</th>
    <th>Môn học</th>
    <th>Điểm danh </th>
    <th>Thống kê</th>



</thead>
<tbody>
@foreach ($lichdayToday as  $item)
    <tr>
	<td>{{$index++}}</td>
	<td>{{$item->class_name}}</td>
	<td>{{$item->teacher_name}}</td>
	<td>{{$item->subject_name}}</td>
	<td><button class="btn btn-warning" onclick="window.open('{{route('attendence_view')}}?id={{$item->id}}','_seft')">Điểm Danh
	</button></td>


	<!--$value->id sẽ là id của data $lichdayToday được hiển thị ở trên -->
	<td><button class="btn btn-success">Thống Kê</button></td>
</tr>
@endforeach

</tbody>

</table>

			</div>
		</div>
	</div>


</body>
</html>