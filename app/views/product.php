<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<link rel="stylesheet" href="public/assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="public/assets/bootstrap/css/bootstrap-grid.min.css">
<link rel="stylesheet" href="public/assets/bootstrap/css/bootstrap-reboot.min.css">
<script src="public/assets/web/assets/jquery/jquery.min.js"></script>
<script src="public/assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
  <h2>Vertical (basic) form</h2>
  <form action="/action_page.php">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
    </div>
    <div class="checkbox">
      <label><input type="checkbox" name="remember"> Remember me</label>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

</body>
</html>
