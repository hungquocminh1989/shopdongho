<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quản Lý Sản Phẩm</title>
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
                    <form action="" method="POST">
                        <div class="form-group row">
                            <label for="ctg1" class="col-sm-2 form-control-label">Danh Mục</label>
                            <div class="col-sm-5">
                                <input required name="category_name" type="text" class="form-control" id="ctg1" placeholder="Nhập Danh Mục">
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
                                              <td id="grid_category_name_'.$value['m_category_id'].'">'.$value['category_name'].'</td>
                                              <td>
                                              <button class="btn btn-info" value="'.$value['m_category_id'].'" type="button" data-toggle="modal" data-target="#editModel">Sửa</button>
                                              <button formaction="main/category/delete" name="m_category_id" value="'.$value['m_category_id'].'" type="submit" class="btn btn-danger">Xóa</button>
                                              </td>
                                          </tr>
                                    ';
                                    }
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </form>
                    <form action="" method="POST">
                        <!-- Modal Update Category-->
                        <div id="editModel" class="modal" role="dialog" data-backdrop="static">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Cập Nhật Danh Mục</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="m_category_id" value=""/>
                                        <div class="form-group row">
                                            <label for="ctg1" class="col-sm-2 form-control-label">Danh Mục</label>
                                            <div class="col-sm-5">
                                                <input required name="category_name" type="text" class="form-control" id="ctg1" placeholder="Nhập Danh Mục">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="submit" formaction="main/category/update" class="btn btn-info">Cập Nhật</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                <select required class="form-control" name="m_category_id">
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
                                <input required name="product_name" type="text" class="form-control" placeholder="Nhập Tên Sản Phẩm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Nhập Mã Sản Phẩm</label>
                            <div class="col-sm-5">
                                <input required name="product_no" type="text" class="form-control" placeholder="Nhập Mã Sản Phẩm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Nhập Giá</label>
                            <div class="col-sm-5">
                                <input required name="product_price" type="text" class="form-control" placeholder="Nhập Giá">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Nhập Thông Tin</label>
                            <div class="col-sm-5">
                                <input required name="product_info" type="text" class="form-control" placeholder="Nhập Thông Tin">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Nhập Link Hiển Thị</label>
                            <div class="col-sm-5">
                                <input required name="product_link" type="text" class="form-control" placeholder="Nhập Link Hiển Thị">
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
                                    <th>Link Hiển Thị</th>
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
                                              <td id="grid_category_name_'.$value['m_product_id'].'" >'.$value['category_name'].'</td>
                                              <input id="grid_category_id_'.$value['m_product_id'].'" type="hidden" value="'.$value['m_category_id'].'"/>
                                              <td id="grid_product_name_'.$value['m_product_id'].'" >'.$value['product_name'].'</td>
                                              <td id="grid_product_no_'.$value['m_product_id'].'" >'.$value['product_no'].'</td>
                                              <td>'.number_format($value['product_price']).SYSTEM_CURRENCY.'</td>
                                              <input id="grid_product_price_'.$value['m_product_id'].'" type="hidden" value="'.$value['product_price'].'"/>
                                              <td id="grid_product_info_'.$value['m_product_id'].'" >'.$value['product_info'].'</td>
                                              <td id="grid_product_link_'.$value['m_product_id'].'" >'.$value['product_link'].'</td>
                                              <td>
                                              <button class="btn btn-info" value="'.$value['m_product_id'].'"  type="button" data-toggle="modal" data-target="#editProductModel">Sửa</button>
                                              <button formaction="main/product/delete" name="m_product_id" value="'.$value['m_product_id'].'" type="submit" class="btn btn-danger">Xóa</button></td>
                                          </tr>
                                    ';
                                    }
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </form>
                    <form action="" enctype="multipart/form-data" method="POST">
                        <!-- Modal Update Product-->
                        <div id="editProductModel" class="modal" role="dialog" data-backdrop="static">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Cập Nhật Sản Phẩm</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="m_product_id" value=""/>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Chọn Danh Mục</label>
                                            <div class="col-sm-8">
                                                <select required class="form-control" name="m_category_id">
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
                                            <label class="col-sm-4 form-control-label">Nhập Tên Sản Phẩm</label>
                                            <div class="col-sm-8">
                                                <input required name="product_name" type="text" class="form-control" placeholder="Nhập Tên Sản Phẩm">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Nhập Mã Sản Phẩm</label>
                                            <div class="col-sm-8">
                                                <input required name="product_no" type="text" class="form-control" placeholder="Nhập Mã Sản Phẩm">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Nhập Giá</label>
                                            <div class="col-sm-8">
                                                <input required name="product_price" type="text" class="form-control" placeholder="Nhập Giá">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Nhập Thông Tin</label>
                                            <div class="col-sm-8">
                                                <input required name="product_info" type="text" class="form-control" placeholder="Nhập Thông Tin">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Nhập Link Hiển Thị</label>
                                            <div class="col-sm-8">
                                                <input required name="product_link" type="text" class="form-control" placeholder="Nhập Link Hiển Thị">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 form-control-label">Chọn Ảnh</label>
                                            <div class="col-sm-8">
                                                <input class="form-control-file" name="upload[]" type="file" multiple accept="image/*" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-4">
                                            </div>
                                            <div class="col-sm-8">
                                                <button type="submit" formaction="main/product/update" class="btn btn-info">Cập Nhật</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    $('#editModel').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      //var recipient = button.data('whatever'); // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('[name="m_category_id"]').val(button.val());
      
      var category_name = $('#grid_category_name_'+button.val()).html();
      modal.find('[name="category_name"]').val(category_name);
    });
    
    $('#editProductModel').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      //var recipient = button.data('whatever'); // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('[name="m_product_id"]').val(button.val());
      
      var category_id = $('#grid_category_id_'+button.val()).val();
      modal.find('[name="m_category_id"]').val(category_id);
      
      var product_name = $('#grid_product_name_'+button.val()).html();
      modal.find('[name="product_name"]').val(product_name);
      
      var product_no = $('#grid_product_no_'+button.val()).html();
      modal.find('[name="product_no"]').val(product_no);
      
      var product_price = $('#grid_product_price_'+button.val()).val();
      modal.find('[name="product_price"]').val(product_price);
      
      var product_info = $('#grid_product_info_'+button.val()).html();
      modal.find('[name="product_info"]').val(product_info);
      
      var product_link = $('#grid_product_link_'+button.val()).html();
      modal.find('[name="product_link"]').val(product_link);
    });
</script>