<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiemdanhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diemdanh', function (Blueprint $table) {
            $table->increments('id');//id tự tăng
            $table->unsignedInteger('id_lichday');///TAO cột tương đương với cột id của bảng lịch dạy
            $table->foreign('id_lichday')->references('id')->on('lichday');///tạo khóa ngoài đến bảng lịch dạy
            $table->string('rollno',16);
            $table->foreign('rollno')->references('rollno')->on('sinhvien');///tạo khóa ngoài den bang sinh viên


            $table->tinyInteger('status');/// bằng 0 thì vằng còn =1 thì đi học
            $table->string('note',200);
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
        Schema::dropIfExists('diemdanh');
    }
}


//thiết kế bẳng diem danh trong database gồm cột id tự tăng tạo cột tương tương lịch dạy và cột khóa ngoài đến bảng liên quan