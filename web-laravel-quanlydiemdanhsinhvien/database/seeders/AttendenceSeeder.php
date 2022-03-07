<?php

namespace Database\Seeders;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use DB;
class AttendenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10 ; $i++) {  ////fake dữ liệu bằng vòng lặp for cho nhanh và được nhiều 
       
        	DB::table('sinhvien')->insert([
              'rollno' =>'2018'.$i,
              'fullname'=>'ABC'.$i,
              'address'=>'Hanoi'.$i,
              'email'=>$i.'duong@gmail.com',
              'birthday'=>'2000-01-31',
              'class_name'=>'Hanoi',
              'created_at'=>date('Y-m-d H:i:s'),////tự động lấy ngày tháng năm giớ thời điểm đó
              'updated_at'=>date('Y-m-d H:i:s')



        	]);
         }



              DB::table('lichday')->insert([
              'subject_name'=>'Lập trình Larave',
              'teacher_name'=>'Đinh Đình Dương',
              'frametime'=>0,
              'starttime'=>13.5,
              'endtime'=>17.5,
            'startdate'=>'2021-11-18',
            'enddate'=>'2021-12-18',
            'class_name'=>'Hanoi',
             'note'=>'Học chiều 2,4,6',
              'created_at'=>date('Y-m-d H:i:s'),////tự động lấy ngày tháng năm giớ thời điểm đó
              'updated_at'=>date('Y-m-d H:i:s')


              ]);



              DB::table('lichday')->insert([
              'subject_name'=>'Lập trình  JAVA',
              'teacher_name'=>'Đinh Đình Dương',
              'frametime'=>0,
              'starttime'=>7,
              'endtime'=>11.5,
            'startdate'=>'2021-11-18',
            'enddate'=>'2021-12-18',
            'class_name'=>'Hanoi',
             'note'=>'Học sáng 2,4,6',
              'created_at'=>date('Y-m-d H:i:s'),
              'updated_at'=>date('Y-m-d H:i:s')


              ]);
    }
}
