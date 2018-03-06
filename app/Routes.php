<?php

//Register Controller Request
$controller = Flight::CommonController();
Flight::route('/(index)', array($controller, 'index'));
Flight::route('/detail/@id/@product_link', array($controller, 'detail'));
Flight::route('/main', array($controller, 'main'));
Flight::route('/admin', array($controller, 'adminlogin'));
Flight::route('/admin/login', array($controller, 'login'));

//Category
Flight::route('/main/category/add', array($controller, 'addcategory'));
Flight::route('/main/category/update', array($controller, 'updatecategory'));
Flight::route('/main/category/delete', array($controller, 'deletecategory'));

//Product
Flight::route('/main/product/add', array($controller, 'addproduct'));
Flight::route('/main/product/update', array($controller, 'updateproduct'));
Flight::route('/main/product/delete', array($controller, 'deleteproduct'));

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