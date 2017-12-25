<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />   
        <title>Page Title</title>
        <link rel="stylesheet" href="public/css/bootstrap.css">
        <script src="public/js/jquery-1.10.2.js"></script>
        <script src="public/js/bootstrap.js"></script>
    </head>
    <body>
        <div class="container">
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">Cập Nhật Danh Mục</div>
                <div class="panel-body">
                    <form action="main/category/add" method="POST">
                        <div class="form-group row">
                            <label for="ctg1" class="col-sm-2 form-control-label">Danh Mục</label>
                            <div class="col-sm-5">
                                <input name="category_name" type="text" class="form-control" id="ctg1" placeholder="Nhập Danh Mục">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" formaction="main/category/add" class="btn btn-info">Thêm</button>
                            </div>
                        </div>
                    </form>
                    <form action="" method="POST">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Danh Mục</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php 
                            		if($listCategory != NULL && count($listCategory) > 0){
										foreach($listCategory as $key => $value){
											$index = $key+1;
											echo '
												<tr>
				                                    <th scope="row">'.$index.'</th>
				                                    <td>'.$value['category_name'].'</td>
				                                    <td><button formaction="main/category/delete" name="m_category_id" value="'.$value['m_category_id'].'" type="submit" class="btn btn-danger">Xóa</button></td>
				                                </tr>
											';
										}
										
									}
                            	?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">Cập Nhật Sản Phẩm</div>
                <div class="panel-body">
                    <form action="" enctype="multipart/form-data" method="POST">
                    	<div class="form-group row">
                            <label class="col-sm-2 form-control-label">Chọn Danh Mục</label>
                            <div class="col-sm-5">
                            	<select class="form-control" name="m_category_id">
                            	<option value=""></option>
                            	<?php 
                            		if($listCategory != NULL && count($listCategory) > 0){
										foreach($listCategory as $key => $value){
											echo '
				                                <option value="'.$value['m_category_id'].'">'.$value['category_name'].'</option>
											';
										}
										
									}
                            	?>
								</select>   
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Nhập Tên Sản Phẩm</label>
                            <div class="col-sm-5">
                                <input name="product_name" type="text" class="form-control" placeholder="Nhập Tên Sản Phẩm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Nhập Mã Sản Phẩm</label>
                            <div class="col-sm-5">
                                <input name="product_no" type="text" class="form-control" placeholder="Nhập Mã Sản Phẩm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Nhập Giá</label>
                            <div class="col-sm-5">
                                <input name="product_price" type="text" class="form-control" placeholder="Nhập Giá">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Nhập Thông Tin</label>
                            <div class="col-sm-5">
                                <input name="product_info" type="text" class="form-control" placeholder="Nhập Thông Tin">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Chọn Ảnh</label>
                            <div class="col-sm-5">
                                <input class="form-control-file" name="upload[]" type="file" multiple accept="image/*" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" formaction="main/product/add" class="btn btn-info">Thêm</button>
                            </div>
                        </div>
                    </form>
                    <form method="post">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Danh Mục</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Mã Sản Phẩm</th>
                                    <th>Giá</th>
                                    <th>Thông Tin</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php 
                            		if($listProduct != NULL && count($listProduct) > 0){
										foreach($listProduct as $key => $value){
											$index = $key+1;
											echo '
												<tr>
				                                    <th scope="row">'.$index.'</th>
				                                    <td>'.$value['category_name'].'</td>
				                                    <td>'.$value['product_name'].'</td>
				                                    <td>'.$value['product_no'].'</td>
				                                    <td>'.number_format($value['product_price']).SYSTEM_CURRENCY.'</td>
				                                    <td>'.$value['product_info'].'</td>
				                                    <td><button formaction="main/product/delete" name="m_product_id" value="'.$value['m_product_id'].'" type="submit" class="btn btn-danger">Xóa</button></td>
				                                </tr>
											';
										}
									}
                            	?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>