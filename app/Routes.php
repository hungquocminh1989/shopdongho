<?php

//Register Controller Request
$controller = new CommonController();
$indexController = new IndexController();
$categoryControler = new CategoryController();
$productControler = new ProductController();
$pageControler = new PageController();
$headerControler = new HeaderController();

Flight::route('/(@page_link)(/@id/@product_link)', array($indexController, 'action_index'));

//Common
//Flight::route('/detail/@id/@product_link', array($controller, 'action_detail'));
Flight::route('/main', array($controller, 'action_main'));
Flight::route('/admin', array($controller, 'action_admin'));
Flight::route('/admin/login', array($controller, 'action_login'));
Flight::route('/main/define/add', array($controller, 'action_add_define'));
Flight::route('/main/image/upload', array($controller, 'action_image_upload'));
Flight::route('/javascript-obfuscator', array($controller, 'action_obfuscator'));//API

//Category
Flight::route('/main/category/add', array($categoryControler, 'action_addcategory'));
Flight::route('/main/category/edit', array($categoryControler, 'action_editcategory'));
Flight::route('/main/category/update', array($categoryControler, 'action_updatecategory'));
Flight::route('/main/category/delete', array($categoryControler, 'action_deletecategory'));

//Product
Flight::route('/main/product/add', array($productControler, 'action_addproduct'));
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



// Membership Controller
/*$membership = new MembershipController();
Flight::route('GET /login', array($membership, 'login'));
Flight::route('POST /login', array($membership, 'loginAttempt'));
Flight::route('/logout', array($membership, 'logout'));
Flight::route('/profile/@name', array($membership, 'profile'));
Flight::route('GET /profile/@name/edit', array($membership, 'profileEdit'));
Flight::route('POST /profile/@name/edit', array($membership, 'profileEditAttempt'));
Flight::route('GET /sign-up', array($membership, 'register'));
Flight::route('POST /sign-up', array($membership, 'registerAttempt'));*/

// catch everything
Flight::route('/*', array($controller, 'index'));