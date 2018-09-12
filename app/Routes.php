<?php
/**
* 
* Cùng 1 Url có thể cho chạy nhiều route
* Thời gian check các route ko match rất nhanh
* Chạy qua route tiếp theo -> return TRUE
* Dừng tại route hiện tại -> return FAlSE
* 
*/

//Register Controller Request
$controller = new CommonController();
$indexController = new IndexController();
$categoryControler = new CategoryController();
$productControler = new ProductController();
$pageControler = new PageController();
$headerControler = new HeaderController();
$htmlControler = new HtmlController();
$systemBackup = new SystemBackupController();

//Common
Flight::route('/main', array($controller, 'action_main'));
Flight::route('/admin', array($controller, 'action_admin'));
Flight::route('/admin/login', array($controller, 'action_login'));
Flight::route('/main/define/add', array($controller, 'action_add_define'));
Flight::route('/main/image/upload', array($controller, 'action_image_upload'));
Flight::route('/javascript-obfuscator', array($controller, 'action_obfuscator'));//API

//Drag sort table
Flight::route('/main/category/dragsort', array($categoryControler, 'action_dragsort'));
Flight::route('/main/html/dragsort', array($htmlControler, 'action_dragsort'));
Flight::route('/main/product/dragsort', array($productControler, 'action_dragsort'));
Flight::route('/main/header/dragsort', array($headerControler, 'action_dragsort'));
Flight::route('/main/page/dragsort', array($pageControler, 'action_dragsort'));
Flight::route('/main/pagesection/dragsort', array($pageControler, 'action_dragsort'));

//Category
Flight::route('/main/category/edit', array($categoryControler, 'action_editcategory'));
Flight::route('/main/category/update', array($categoryControler, 'action_updatecategory'));
Flight::route('/main/category/delete', array($categoryControler, 'action_deletecategory'));

//Product
Flight::route('/main/product/edit', array($productControler, 'action_editproduct'));
Flight::route('/main/product/update', array($productControler, 'action_updateproduct'));
Flight::route('/main/product/delete', array($productControler, 'action_deleteproduct'));

//Page
Flight::route('/main/section/add', array($pageControler, 'action_add_section'));
Flight::route('/main/page/checkexistpagetype', array($pageControler, 'action_checkexistpagetype'));
Flight::route('/main/page/update', array($pageControler, 'action_update_page'));
Flight::route('/main/page/delete', array($pageControler, 'action_delete_page'));
Flight::route('/main/page/edit', array($pageControler, 'action_edit_page'));

//Header
Flight::route('/main/header/update', array($headerControler, 'action_update_header'));
Flight::route('/main/header/edit', array($headerControler, 'action_edit_header'));
Flight::route('/main/header/delete', array($headerControler, 'action_delete_header'));

//HTML From
Flight::route('/main/html/update', array($htmlControler, 'action_update_html'));
Flight::route('/main/html/edit', array($htmlControler, 'action_edit_html'));
Flight::route('/main/html/delete', array($htmlControler, 'action_delete_html'));

//Backup Database Request
Flight::route('/main/systembackup/createbackup', array($systemBackup, 'action_backupsite'));
Flight::route('/main/systembackup/deletebackup', array($systemBackup, 'action_deletebackup'));
Flight::route('/cleansite', array($controller, 'action_cleansite'));


// Sample
/*$membership = new MembershipController();
Flight::route('GET /login', array($membership, 'login'));
Flight::route('POST /login', array($membership, 'loginAttempt'));
Flight::route('/logout', array($membership, 'logout'));
Flight::route('/profile/@name', array($membership, 'profile'));
Flight::route('GET /profile/@name/edit', array($membership, 'profileEdit'));
Flight::route('POST /profile/@name/edit', array($membership, 'profileEditAttempt'));
Flight::route('GET /sign-up', array($membership, 'register'));
Flight::route('POST /sign-up', array($membership, 'registerAttempt'));*/

//Register Crontabs Request
$cron = new CommonCrontab();
Flight::route('/cron', array($cron, 'cron'));

//Index & Detail
Flight::route('/(@page_link)(/@id/@product_link)', array($indexController, 'action_index'));

// Route mặc định khi không match toàn bộ
Flight::route('/*', array($controller, 'index'));