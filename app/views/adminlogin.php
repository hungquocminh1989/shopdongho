<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <link rel="stylesheet" href="public/css/bootstrap.css">
        <script src="public/js/jquery-1.10.2.js"></script>
        <script src="public/js/bootstrap.js"></script>
    </head>
    <body>
        <form action="" method="POST">
            <div id="loginModel" class="modal" role="dialog" data-backdrop="static">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                            <h4 class="modal-title">Quản Trị Viên</h4>
                        </div>
                        <div class="modal-body">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon" id="sizing-addon1">Nhập Mã Truy Cập</span>
                                <input class="form-control" aria-describedby="sizing-addon1" type="password" required name="passcode">
                                <button type="submit" formaction="admin/login" class="form-control btn btn-info">Đăng Nhập</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>
<script>
    $('#loginModel').modal('show');
</script>