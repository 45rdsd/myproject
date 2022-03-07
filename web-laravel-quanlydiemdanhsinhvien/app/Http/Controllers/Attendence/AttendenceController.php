<?php

namespace App\Http\Controllers\Attendence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class AttendenceController extends Controller
{





///bước 1:tìm ra những lớp học phải dạnh thời điểm hiện tại truy cập



   public function index(Request $index)/////tìm những lớp học có sẵn tại thời điểm hiện tại truy cập

 {
      ///lấy giờ hiện tại đúng để không bao giờ lệch múi giờ
$mydate = new \DateTime();
$mydate->modify('+7 hours');



      	 $currentDate = $mydate->format('Y-m-d');////hàm tự động lấy ngày tháng năm của thời điểm naỳ- thời điểm truy cập

         $frametime=0;//giá trị 0=> thứ 2.4.6 | giá trị 1=> thứ 3.5.7

         $day= $mydate->format('N'); ////1=thứ 2,2=>thứ 3...7=>chủ nhật...||Trong đó : số 1.3.5 là thứ 2.4.6 => frametime=0 
          // và số 2.4.6 là thứ 3.5.7 =>frametime = 1////hàm date tự động cập nhật số ngày cho chương trình
         // $ngay=$day+1;
         // echo "Thứ : ". $ngay.'</br>';
      



    // điều kiện if lệnh này để lấy giá trị tự động cho cột frametime là 0 và 1

     if ($day == 1 || $day==3 || $day==5){ /////hoặc
       
	     $frametime=0;
 
 }elseif ($day != 7){
           $frametime=1;
        } else {
	$frametime=-1;///nếu rơi vào ngày chủ nhật thì sẽ cho frametime về giá trị -1
       }



       $hour=$mydate->format('H');////Hàm lấy giờ ở thời điểm truy cập hiện tại ví dụ 8h30 thì $hour=8
       $minute=$mydate->format('i');///Hàm lấy số phút của giờ ở thời điểm hiện tại
       $currentTime=$hour+$minute/60;



  // die();





   // /tìm lịch dạy trong bảng 'lichday' ngày hôm nay

$lichdayToday = DB::table('lichday')
->where('startdate','<=',$currentDate)////ngày nhỏ hơn hoặc bằng
->where('enddate','>=',$currentDate)////ngày lớn hơn hoặc bằng
->where('frametime',$frametime)

->where('starttime','<=',$currentTime)
->where('endtime','>=',$currentTime)
->get();///lệnh get() để lấy dữ liệu có các đặc tính trên trong bảng 'lichday' ra
// echo $currentTime .'*'.$currentDate.'*'.$frametime;
// var_dump($lichdayToday);////không có lịch dạy sẽ không var_dump ra cái gì


 return view('attendence.index')->with(
 [
'index'=>1,
 'lichdayToday'=>$lichdayToday]);//////đưa dữ liệu của biến $lichdayToday vào biến 'lichdayToday' rồi đưa dữ liệu đến bảng file index.blade.php


 }








///bước 2: kiểm tra đã điểm danh hay chưa và thực hienj thao tác điểm danh

     public function view(Request $request)

       {


            /////tìm lịch dạy ngày hôm nay
                $lichday=DB::table('lichday')
                ->where('id',$request->id)->get();//lấy data có id bằng id của data trên hàm index đã gửi qua Request 
          if ($lichday != null && count($lichday)>0)
               {
          	$lichday= $lichday[0];////biến một mảng thành 1 object-đối tượng
               }
               else
               {
               	return redirect()->route('attendence_index');///quay vể route này
               }



//////lấy ra danh sách sinh viên điểm danh tại thời điểm hiện tại

         $mydate = new \DateTime();
         $mydate->modify('+7 hours');
        $currentDate = $mydate->format('Y-m-d ');///ngày tháng năm và giờ phút giây


////hệ thống học 1 ngày -1 buổi - 1 lần điểm danh



/////kiểm tra đã điểm danh hay chưa trong bảng 'diemdanh' bằng biến $edit

 $edit=DB::table('diemdanh')
 ->leftJoin('sinhvien','sinhvien.rollno','=','diemdanh.rollno')////lệnh lấy thêm dữ liệu của bảng liên kết là lấy thêm dữ liệu từ bảng sinh viên-> từ bảng sinvien
 ->where('diemdanh.id_lichday',$request->id)////nếu bảng điểm danh đã tồn tại id_lichday thì lấy dữ liệu có id =$request đó : chính là id của lịch dạy hôm nat
->where('diemdanh.created_at','>=',$currentDate)///dữ liệu $edit lấy ra cũng phải có đặc điểm là thười gian ắt lên trung với thời điểm hiện tại
->select('diemdanh.*','sinhvien.fullname')///lấy hết dữ liệu trong  bảng 'diemdanh' và lấy fullname của bảng  'sinhvien'
->get();

///$edit >0 -> đã điểm danh rồi-> có thể sẽ sửa lại phần điểm danh nếu cần





$studentList = null ;
if ($edit == null || count($edit)==0 )////đưa dữ liệu thành mảng 

{
	$studentList =DB::table ('sinhvien')
->where('class_name',$lichday->class_name)->get();///lấy ra danh sách sinh viên nằm trong lớp được dạy///lấy sinh viên có class_name bằng class_name của data $lichday

}

return view('attendence.view')->with([////lấy dữ liệu đổ ra view
'index'    =>1,
'lichday' => $lichday,
'studentList'  => $studentList,
'edit' => $edit


]);



       }
  

  ///Hàm 3: bắt dữ liệu từ javascrip  tác động vào form điểm danh//lấy dữ liệu từ json
        public function post(Request $request){

            $mydate = new \DateTime();
           $mydate->modify('+7 hours');
           





           

         	$id_lichday = $request->id_lichday;
         	$data  = json_decode($request->data,true);
            $currentTime = $mydate->format('Y-m-d H:i:s ');
            $currentDate = $mydate->format('Y-m-d ');

////check dữ liệu điểm danh đã tồn tại hay chưa để còn sửa hoặc làm mới

         $edit = DB::table('diemdanh')
 ->leftJoin('sinhvien','sinhvien.rollno','=','diemdanh.rollno')
 ->where('diemdanh.id_lichday',$request->id_lichday)
->where('diemdanh.created_at','>=',$currentDate)
->select('diemdanh.*','sinhvien.fullname')
->get();   
if ($edit != null && count($edit) > 0 ) {
	///update lại thông tin điểm danh
               foreach ($data as $item ) {
             DB::table('diemdanh')
                ->where('id_lichday', $request->id_lichday)
             	->where('created_at', '>=', $currentDate)
             	->where('rollno', $item['rollno'])///mảng item vị trí rollno
                   ->update([
                   'status'     => $item['status'],
                   'note'       => $item['note'],
                   'updated_at' => $currentTime

             	]);
             }

return redirect()->route('attendence_index');


}



         ///dùng vòng lặp foreach để insert dữ liệu từ data json vào database 'diemdanh'

             foreach ($data as $item ) {
             	DB::table('diemdanh')->insert([

                 'id_lichday'=>$id_lichday,
                 'rollno'=>$item['rollno'],
                 'status'=>$item['status'],
                 'note'=>$item['note'],
                 'created_at'=>$currentTime,
                 'updated_at'=>$currentTime





             	]);
             }
             return redirect()->route('attendence_index');

         }

}
