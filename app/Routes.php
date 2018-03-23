<?php

//Register Controller Request
$controller = new CommonController();
Flight::route('/(index)', array($controller, 'action_index'));
Flight::route('/detail/@id/@product_link', array($controller, 'action_detail'));
Flight::route('/main', array($controller, 'action_main'));
Flight::route('/admin', array($controller, 'action_admin'));
Flight::route('/admin/login', array($controller, 'action_login'));

//Category
Flight::route('/main/category/add', array($controller, 'action_addcategory'));
Flight::route('/main/category/update', array($controller, 'action_updatecategory'));
Flight::route('/main/category/delete', array($controller, 'action_deletecategory'));

//Product
Flight::route('/main/product/add', array($controller, 'action_addproduct'));
Flight::route('/main/product/update', array($controller, 'action_updateproduct'));
Flight::route('/main/product/delete', array($controller, 'action_deleteproduct'));

//Infomation
Flight::route('/main/define/add', array($controller, 'action_add_define'));

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