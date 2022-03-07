giải quyết bài toán điểm danh
đề bài:Tạo bảng sinh viên gồm các trường sau. Tên, Mã SV (trường khoá chính), email, địa chỉ, ngày sinh.

Tạo bảng lịch dạy gồm có trường : id tự tăng, môn học (kiểu varchar), giáo viên dạy (kiểu varchar), frametime (nhận giá trị 0 =] dạy thứ 2, 4, 6. Nhận giá trị 1 =] dạy thứ 3, 5, 7). Giờ bắt đầu (datetime), giờ kết thúc (datetime), ngày bắt đầu học, ngày kết thúc môn học (date), note : Ghi chú.

Tạo bảng điểm danh gồm các trường: id tự tăng, id lịch dạy, mã sinh viên, trạng thái (0: vắng, 1 tham gia hoặc nghỉ có phép), thời gian điểm danh, thời gian sửa, ghi chú.

Yêu cầu:

Tạo 3 bảng trên, fake dữ liệu cho 2 bảng : sinh viên, tạo lịch dạy

Viết chương trình quản lý điểm danh gồm các chức năng sau. (Chỉ cần điểm danh 1 lần cho 1 buổi học)

- Hiển thị danh sách lớp học đang diễn ra học

- Click vào lớp học : Hiển thị ra bảng cho phép điểm danh như hình sau. Nếu đã điểm danh thì cho phép cập nhật lại

- Click vào lớp học -] xem được nút thống kê =] hiển thị ra bảng tỷ lệ tham gia lớp học.



b1:phân tích database
-tạo bảng 
-fake dữ liệu
b2:viết route
-tạo 1 file route attendence.php=>dky trong project
-tạo 1 controller là  Attendence/AttendenceController
-tạo route tên là 
 +) /attendence/index => hiển thị lịch dạy trong ngày hôm nay
 +)/attendence/view=> hiển thị phần điểm danh=>sửa điểm danh