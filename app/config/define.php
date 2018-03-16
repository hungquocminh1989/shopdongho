<?php 
define('SMARTY_CACHE_LIFETIME', 300);//Seconds
define('SMARTY_LEFT_DELIMITER', '{%');
define('SMARTY_RIGHT_DELIMITER', '%}');
define('SYSTEM_DEFAULT_TIMEZONE', 'Asia/Tokyo');
define('SYSTEM_PUBLIC_DIR', str_replace("\\", '/', getcwd()));
define('SYSTEM_VIEW_JS', str_replace("\\", '/', getcwd()).'/app/views/js');
define('SYSTEM_JS_ENCRYTION', FALSE);
define('SYSTEM_PASSCODE', 'bb8b067fa8aab806dc17e3087c8e3eab');
define('SYSTEM_ROOT_DIR', SYSTEM_PUBLIC_DIR);
define('SYSTEM_PUBLIC_UPLOAD', SYSTEM_ROOT_DIR.'/public/upload');
define('SYSTEM_CURRENCY', ' đ');
define('SYSTEM_PHONE', '0902660153');
define('SYSTEM_PRODUCT_INFO_DEFAULT', 'Nhãn hiệu : Armani
Xuất xứ : Nhật Bản
Kiểu máy : Quartz
Chất liệu vỏ : Thép không gỉ
Chất liệu kính : Kính Cứng
Độ chịu nước : Chống nước sinh hoạt
Chức năng khác : Lịch ngày');
define('SYSTEM_TMP_DIR', str_replace("\\", '/', getcwd().'/tmp'));
