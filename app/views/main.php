<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/base.dwt" codeOutsideHTMLIsLocked="false" --><head>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Page Title</title>
<link rel="stylesheet" href="public/assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="public/assets/bootstrap/css/bootstrap-grid.min.css">
<link rel="stylesheet" href="public/assets/bootstrap/css/bootstrap-reboot.min.css">
<script src="public/assets/web/assets/jquery/jquery.min.js"></script>
<script src="public/assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<form action="main/category/add"  method="POST">
  <div class="form-group">
    <label for="exampleFormControlInput1">abc</label>
    <input type="text" class="form-control" name="category_name" >
    <input type="submit" class="form-control" value="OK" >
  </div>
</form>

<form action="main/product/add" enctype="multipart/form-data"  method="POST">
  <div class="form-group">
    <label for="exampleFormControlInput1">xyz</label>
    <input type="text" class="form-control" name="product_name" >
    Select images: <input name="upload[]" type="file" multiple accept="image/*" />
    <input type="submit" class="form-control" value="OK" >
  </div>
</form>

<?php include 'common/footer.php';?>
</body>
</html>
