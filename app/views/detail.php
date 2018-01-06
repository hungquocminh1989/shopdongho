<!DOCTYPE html>
<html >
    <!--<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="generator" content="Mobirise v4.5.2, mobirise.com">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
        <link rel="shortcut icon" href="<?php echo SYSTEM_BASE_URL;?>public/assets/images/logo2.png" type="image/x-icon">
        <meta name="description" content="Site Builder Description">
        <title>Chi Tiết Sản Phẩm</title>
        <link rel="stylesheet" href="<?php echo SYSTEM_BASE_URL;?>public/assets/web/assets/mobirise-icons/mobirise-icons.css">
        <link rel="stylesheet" href="<?php echo SYSTEM_BASE_URL;?>public/assets/tether/tether.min.css">
        <link rel="stylesheet" href="<?php echo SYSTEM_BASE_URL;?>public/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo SYSTEM_BASE_URL;?>public/assets/bootstrap/css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="<?php echo SYSTEM_BASE_URL;?>public/assets/bootstrap/css/bootstrap-reboot.min.css">
        <link rel="stylesheet" href="<?php echo SYSTEM_BASE_URL;?>public/assets/animatecss/animate.min.css">
        <link rel="stylesheet" href="<?php echo SYSTEM_BASE_URL;?>public/assets/socicon/css/styles.css">
        <link rel="stylesheet" href="<?php echo SYSTEM_BASE_URL;?>public/assets/dropdown/css/style.css">
        <link rel="stylesheet" href="<?php echo SYSTEM_BASE_URL;?>public/assets/theme/css/style.css">
        <link rel="stylesheet" href="<?php echo SYSTEM_BASE_URL;?>public/assets/gallery/style.css">
        <link rel="stylesheet" href="<?php echo SYSTEM_BASE_URL;?>public/assets/mobirise/css/mbr-additional.css" type="text/css">
    </head>-->
    <?php include 'app/views/common/header.php'; ?>
    <body>
        <?php include 'app/views/common/menu.php'; ?>
        <section class="engine"><a href="https://mobirise.co/e">website building software</a></section>
        <section class="features11 cid-qEg4oq9Otr" id="features11-1c" data-rv-view="712">
            <div class="container">
                <div class="col-md-12">
                    <div class="media-container-row">
                        <div class="mbr-figure" style="width: 45%;">
                            <img src="<?php echo SYSTEM_BASE_URL;?><?php echo (isset($productInfo[0]['image_path'])) ? $productInfo[0]['image_path'] : 'ERROR';?>" alt="Mobirise" title="" media-simple="true">
                        </div>
                        <div class=" align-left aside-content">
                            <h2 class="mbr-title pt-2 mbr-fonts-style display-2">Chi tiết sản phẩm</h2>
                            <div class="mbr-section-text">
                                <p class="mbr-text mb-5 pt-3 mbr-light mbr-fonts-style display-5">
                                Mã số : <?php echo (isset($productInfo[0]['product_no'])) ? $productInfo[0]['product_no'] : 'ERROR';?>
                                <br>
                                Giá : <?php echo (isset($productInfo[0]['product_price'])) ? number_format($productInfo[0]['product_price']).SYSTEM_CURRENCY : 'ERROR';?></p>
                            </div>
                            <div class="block-content">
                                <div class="card p-3 pr-3">
                                    <div class="media">
                                        <div class=" align-self-center card-img pb-3">
                                            <span class="mbr-iconfont mbri-sites" media-simple="true"></span>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="card-title mbr-fonts-style display-7"></h4>
                                        </div>
                                    </div>
                                    <div class="card-box">
                                        <p class="block-text mbr-fonts-style display-7">
                                        	Nhãn hiệu : Armani
                                        	<br>Xuất xứ : Nhật Bản 
                                            <br>Kiểu máy : Quartz<br>Chất liệu vỏ : Thép không gỉ
                                            <br>Chất liệu kính : Kính Cứng 
                                            <br>Độ chịu nước : Chống nước sinh hoạt 
                                            <br>Chức năng khác : Lịch ngày
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mbr-gallery mbr-slider-carousel cid-qEh27XDXEa" id="gallery3-2w" data-rv-view="718">
            <div>
                <div>
                    <!-- Filter --><!-- Gallery -->
                    <div class="mbr-gallery-row">
                        <div class="mbr-gallery-layout-default">
                            <div>
                                <div>
                                    <?php
                                    $html_image = '
                                    	<div class="mbr-gallery-item mbr-gallery-item--p1" data-video-url="false" data-tags="Responsive">
	                                        <div href="#lb-gallery3-2w" data-slide-to="%2$s" data-toggle="modal"><img src="%1$s" alt=""><span class="icon-focus"></span></div>
	                                    </div>
                                    ';
                                    foreach($productInfoImage as $key => $value){
					                    $html_image_replace = sprintf($html_image,SYSTEM_BASE_URL.$value['image_path'],$key);
					                    echo $html_image_replace;
					                }
                                    ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <!-- Lightbox -->
                    <div data-app-prevent-settings="" class="mbr-slider modal fade carousel slide" tabindex="-1" data-keyboard="true" data-interval="false" id="lb-gallery3-2w">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="carousel-inner">
                                    	<?php
	                                    $html_image_1 = '
	                                    	<div class="carousel-item %2$s"><img src="%1$s" alt=""></div>
	                                    ';
	                                    foreach($productInfoImage as $key => $value){
	                                    	if($key == 0){
												$html_image_replace_1 = sprintf($html_image_1,SYSTEM_BASE_URL.$value['image_path'],'active');
											}
						                    else{
												$html_image_replace_1 = sprintf($html_image_1,SYSTEM_BASE_URL.$value['image_path'],'');
											}
						                    echo $html_image_replace_1;
						                }
	                                    ?>
                                    </div>
                                    <a class="carousel-control carousel-control-prev" role="button" data-slide="prev" href="#lb-gallery3-2w"><span class="mbri-left mbr-iconfont" aria-hidden="true"></span><span class="sr-only">Previous</span></a>
                                    <a class="carousel-control carousel-control-next" role="button" data-slide="next" href="#lb-gallery3-2w"><span class="mbri-right mbr-iconfont" aria-hidden="true"></span><span class="sr-only">Next</span></a>
                                    <a class="close" href="#" role="button" data-dismiss="modal"><span class="sr-only">Close</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mbr-section info1 cid-qEgXDnt523" id="info1-2v" data-rv-view="715">
            <div class="container">
                <div class="row justify-content-center content-row">
                    <div class="media-container-column title col-12 col-lg-7 col-md-6">
                        <h3 class="mbr-section-subtitle align-left mbr-light pb-3 mbr-fonts-style display-5">Liên hệ với chúng tôi để đặt hàng ngay trong ngày</h3>
                        <h2 class="align-left mbr-bold mbr-fonts-style display-5">Gọi điện hoặc nhắn tin fanpage</h2>
                    </div>
                    <div class="media-container-column col-12 col-lg-3 col-md-4">
                        <div class="mbr-section-btn align-right py-4"><a class="btn btn-primary display-4" href="Order.html">Đặt Mua</a></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mbr-section article content1 cid-qEJQXoU1qp" id="content2-3c" data-rv-view="733">
            <div class="container">
                <div class="media-container-row">
                    <div class="mbr-text col-12 col-md-8 mbr-fonts-style display-7">
                        <blockquote>
                            <p>Đồng hồ đeo tay là một trong những phát minh vĩ đại nhất trên thế giới. Trước đây đồng hồ đeo tay chủ yếu giúp mọi người xem thời gian. Tuy nhiên, trong vài thập kỷ trở lại đây đồng hồ đeo tay không còn là một công cụ đơn thuần để mọi người xem giờ nữa mà nó là phụ kiện thiết yếu dành cho cả nam và nữ. </p>
                            <p>Ai ai cũng muốn lựa chọn một chiếc đồng hồ đẹp giá rẻ nhất dành cho mình, nhưng làm thế nào để chọn được một chiếc đồng hồ đeo tay đẹp giá rẻ thì hãy tham khảo ngay tại Đồng Hồ Giá Rẻ nhé!</p>
                        </blockquote>
                    </div>
                </div>
            </div>
        </section>
        <!--<section class="cid-qEgxwxfYdg" id="footer1-1e" data-rv-view="736">
            <div class="container">
                <div class="media-container-row content text-white">
                    <div class="col-12 col-md-3">
                        <div class="media-wrap">
                            <a href="https://mobirise.com/">
                            <img src="<?php echo SYSTEM_BASE_URL;?>public/assets/images/logo219.png" alt="Mobirise" media-simple="true">
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 mbr-fonts-style display-7">
                        <h5 class="pb-3">Địa Chỉ</h5>
                        <p class="mbr-text">364 Bùi Hữu Nghĩa<br>Phường 2 , Quận Bình Thạnh<br>TP.HCM</p>
                    </div>
                    <div class="col-12 col-md-3 mbr-fonts-style display-7">
                        <h5 class="pb-3">Liên Hệ</h5>
                        <p class="mbr-text">Facebook:&nbsp;<br>Phone: 0902660153<br>Zalo : 0902660153</p>
                    </div>
                    <div class="col-12 col-md-3 mbr-fonts-style display-7">
                        <h5 class="pb-3">Đối Tác</h5>
                        <p class="mbr-text">Google.com<br>Facebook.com<br><a class="text-white" href="https://mobirise.com/mobirise-free-mac.zip">Z</a>alo.com</p>
                    </div>
                </div>
                <div class="footer-lower">
                    <div class="media-container-row">
                        <div class="col-sm-12">
                            <hr>
                        </div>
                    </div>
                    <div class="media-container-row mbr-white">
                        <div class="col-sm-6 copyright">
                            <p class="mbr-text mbr-fonts-style display-7">© Copyright 2017 - All Rights Reserved</p>
                        </div>
                        <div class="col-md-6">
                            <div class="social-list align-right">
                                <div class="soc-item">
                                    <a href="https://twitter.com/mobirise" target="_blank">
                                    <span class="mbr-iconfont mbr-iconfont-social socicon-facebook socicon" media-simple="true"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/web/assets/jquery/jquery.min.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/popper/popper.min.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/tether/tether.min.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/smoothscroll/smooth-scroll.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/viewportchecker/jquery.viewportchecker.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/bootstrapcarouselswipe/bootstrap-carousel-swipe.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/touchswipe/jquery.touch-swipe.min.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/vimeoplayer/jquery.mb.vimeo_player.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/dropdown/js/script.min.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/masonry/masonry.pkgd.min.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/imagesloaded/imagesloaded.pkgd.min.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/theme/js/script.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/slidervideo/script.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/gallery/player.min.js"></script>
        <script src="<?php echo SYSTEM_BASE_URL;?>public/assets/gallery/script.js"></script>
        <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i></i></a></div>
        <input name="animation" type="hidden">-->
        <?php include 'app/views/common/footer.php'; ?>
    </body>
</html>