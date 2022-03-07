<?php 
///khi tự tạo một file route mới để chạy được ta vào file app\providers\routeserviceProvider.php để cài đặt cho nó hoạt động


Route::group(['prefix'=>'/attendence'],function(){
	
       Route::get('/index','App\Http\Controllers\Attendence\AttendenceController@index')->name('attendence_index');

       Route::get('/view','App\Http\Controllers\Attendence\AttendenceController@view')->name('attendence_view');

        Route::post('/post','App\Http\Controllers\Attendence\AttendenceController@post')->name('attendence_post');

});