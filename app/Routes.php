<?php

//Register Controller Request
$controller = new CommonController();
$indexController = new IndexController();
Flight::route('/(index)', array($indexController, 'action_index'));
Flight::route('/detail/@id/@product_link', array($controller, 'action_detail'));
Flight::route('/main', array($controller, 'action_main'));
Flight::route('/admin', array($controller, 'action_admin'));
Flight::route('/admin/login', array($controller, 'action_login'));

//Category
Flight::route('/main/category/add', array($controller, 'action_addcategory'));
Flight::route('/main/category/edit', array($controller, 'action_editcategory'));
Flight::route('/main/category/update', array($controller, 'action_updatecategory'));
Flight::route('/main/category/delete', array($controller, 'action_deletecategory'));

//Product
Flight::route('/main/product/add', array($controller, 'action_addproduct'));
Flight::route('/main/product/edit', array($controller, 'action_editproduct'));
Flight::route('/main/product/update', array($controller, 'action_updateproduct'));
Flight::route('/main/product/delete', array($controller, 'action_deleteproduct'));

//Infomation
Flight::route('/main/define/add', array($controller, 'action_add_define'));

//Image
Flight::route('/main/image/upload', array($controller, 'action_image_upload'));

//Page
Flight::route('/main/section/add', array($controller, 'action_add_section'));
Flight::route('/main/page/update', array($controller, 'action_update_page'));
Flight::route('/main/page/delete', array($controller, 'action_delete_page'));
Flight::route('/main/page/edit', array($controller, 'action_edit_page'));
Flight::route('/'.SYSTEM_ROUTE_PAGE_REFIX.'/@page_link', array($indexController, 'action_index'));

//API
Flight::route('/javascript-obfuscator', array($controller, 'action_obfuscator'));

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