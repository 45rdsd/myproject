<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSinhvienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sinhvien', function (Blueprint $table) {
$table->string('rollno',16);///ma so sinh vien
$table->primary('rollno');///cho la khóa chính
$table->string('fullname',50);///họten
$table->string('email',150);
$table->string('address',250);///dia chi

$table->date('birthday');//ngaysinh
$table->string('class_name',50);

            $table->timestamps();////gồm created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sinhvien');
    }
}



///thiết kế bẳng sinhvien trong database gồm các cột thông tin của sinh viên và ghi chú