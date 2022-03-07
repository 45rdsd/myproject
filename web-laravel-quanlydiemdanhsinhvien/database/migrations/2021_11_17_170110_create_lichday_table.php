<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLichdayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lichday', function (Blueprint $table) {
$table->increments('id');
$table->string('class_name',50);
$table->string('subject_name',50);///Môn học 
$table->string('teacher_name',50);///người dạy
$table->string('frametime',100);///2-4-6 lịch dạy nếu =0, nếu =1 thì dạy 3-5-7
$table->float('starttime',8,2);///13h30 bắt đầu-13.5
$table->float('endtime',8,2);//17h30 kết thúc-17.5
$table->date('startdate');
$table->date('enddate');
$table->string('note',50);///ghi chú lịch học


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lichday');
    }
}



/////thế kế bảng lichday trong database gồm tên môn học tên thầy  cô ,ngày khung giờ  dạy , giờ bắt đầu và kết thúc,ngày bắt đầu và kết thúc cùng ghi chú