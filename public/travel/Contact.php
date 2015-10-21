<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<link href="css/skin.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/menu.js" type="text/javascript"></script>
<script src="js/jquery.jcarousel.min.js" type="text/javascript"></script>
<script src="js/javascript.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function() {
			//Default Action
			$(".tab_content").hide(); //Hide all content
			$("ul.tabs li:first").addClass("active").show(); //Activate first tab
			$(".tab_content:first").show(); //Show first tab content
			
			//On Click Event
			$("ul.tabs li").click(function() {
				$("ul.tabs li").removeClass("active"); //Remove any "active" class
				$(this).addClass("active"); //Add "active" class to selected tab
				$(".tab_content").hide(); //Hide all tab content
				var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
				$(activeTab).fadeIn(); //Fade in the active contentd
				return false;
			});
			jQuery('#mycarousel').jcarousel();
		});
	$(document).ready(function(){
		$('#carousel').jcarousel({
			vertical: true,
			scroll: 1,
			auto: 2,
			wrap: 'last',
			initCallback: mycarousel_initCallback
		});

		//Front page Carousel - Initial Setup
		$('div#slideshow-carousel a img').css({'opacity': '0.5'});
		$('div#slideshow-carousel a img:first').css({'opacity': '1.0'});
		$('div#slideshow-carousel li a:first').append('<span class="arrow"></span>')
		
		
		//Combine jCarousel with Image Display
		$('div#slideshow-carousel li a').hover(
			function () {
					
				if (!$(this).has('span').length) {
					$('div#slideshow-carousel li a img').stop(true, true).css({'opacity': '0.5'});
					$(this).stop(true, true).children('img').css({'opacity': '1.0'});
				}		
			},
			function () {
					
				$('div#slideshow-carousel li a img').stop(true, true).css({'opacity': '0.5'});
				$('div#slideshow-carousel li a').each(function () {
		
					if ($(this).has('span').length) $(this).children('img').css({'opacity': '1.0'});
		
				});
					
			}
		).click(function () {
		
				$('span.arrow').remove();        
			$(this).append('<span class="arrow"></span>');
			$('div#slideshow-main li').removeClass('active');        
			$('div#slideshow-main li.' + $(this).attr('rel')).addClass('active');	
				
			return false;
		});
	});
</script>
</head>

<body>
	<div id="page">
		<div id="header">
			<?php include("include/header.php");?>
		</div><!--End #header-->
		
		<div id="wrapper">
			<div class="innerPage">
				
				<div class="content" id="content">
					<div class="innerContent">
						<div class="cate">
							<div class="cate_top"></div>
							<div class="cate_mid">
								<div class="innerCate">
									<h2 class="title"><a>Contact us</a></h2>
									<div class="primary">
                                    	<div class="socical">
											<span>Follow us on for the lastest detail:</span>
											<a href="#"><img src="images/icon/google.png" alt="" /></a>
											<a href="#"><img src="images/icon/fb.png" alt="" /></a>
											<a href="#"><img src="images/icon/twitter.png" alt="" /></a>
											<a href="#"><img src="images/icon/youtube.png" alt="" /></a>
											<a href="#"><img src="images/icon/icon6.png" alt="" /></a>
                                            <div class="letter">
												<span>Subcribe</span>
												<a href="#"><img src="images/icon/letter.png" alt="" /></a>
											</div>
										</div><!--End .socical-->
										<ul class="tabs">
											<li><a href="#tab1" class="first">Address</a></li>
											<li><a href="#tab2">Map</a></li>
											<li><a href="#tab3" class="last_bg">Send mail</a></li>
										</ul>
										<div class="tab_container">
											<div id="tab1" class="tab_content">
												<p><b>Address 1:</b> Số 837Giải Phóng, Quận Hoàng Mai, Hà Nội, Việt Nam</p>
												<p><b>Phone:</b> (+84).4.3668 6867 - (+84).4.6674 0228      Fax: (+84).4.36421388</p>
												<br />
												<p><b>Address 2:</b> Khách sạn Flower Garden - số 46 Nguyễn Trường Tộ, Quận Ba Đình, Hà Nội , Việt Nam</p>
												<p><b>Phonei:</b> (+84).4.22421352      Fax: (+84).4.37153288 </p>
												<br />
												<p><b>Hotline:</b> (+84) 914336766  - +(84) 947406446</p>
												<p><b>Email:</b> operator@welcomevietnamtours.com</p>
												<p><b>Website:</b> http://welcomevietnamtour.com</p>
											</div>
											<div id="tab2" class="tab_content">
												<img src="upload/img.gif" alt=""/>
											</div>
											<div id="tab3" class="tab_content">
												<form action="" method="post">
													<table>
														<tr>
															<td><span>Name</span></td>
															<td><input type="text" value="" class="txt"/></td>
														</tr>
														<tr>
															<td><span>Email</span></td>
															<td><input type="text" value="" class="txt"/></td>
														</tr>
														<tr>
															<td><span>Address</span></td>
															<td><input type="text" value="" class="txt"/></td>
														</tr>
														<tr>
															<td><span>Phone</span></td>
															<td><input type="text" value="" class="txt"/></td>
														</tr>
														<tr>
															<td><span>Message</span></td>
															<td></td>
														</tr>
														<tr>
															<td colspan="2"><textarea cols="60" rows="10"></textarea></td>
														</tr>
														<tr>
															<td colspan="2"><input type="submit" value="Send" class="button" /><input type="reset" value="Clear" class="button" /></td>
														</tr>
													</table>
												</form>
											</div>
										</div><!--End .tab_container-->
										<div class="clear"></div>
									</div><!--End .primary-->
								</div><!--End .innerCate-->
							</div><!--End .cate_mid-->
							<div class="cate_bot"></div>
						</div><!--End .cate-->
					</div><!--End .innerContent-->
				</div><!--End .content #content-->
                <div class="right" id="right">
					<div class="block">
						<div class="block_top"></div>
						<div class="block_mid">
							<div class="innerBlock">
								<h2 class="block_title">
									<a>Top Seller</a>
                                    <img src="images/icon/hot.png" alt=""/>
								</h2>
								<div class="block_featured_items">
                                	<h2 class="block_featured_title"><a href="#">Hanoi - Vietnam</a></h2>
									<div class="block_featured_images">
										<a href="#"><img src="upload/img1.gif" alt=""/></a>
									</div>
									<div class="clear"></div>
								</div><!--End .block_featured_items-->
								<div class="block_featured_items">
                                	<h2 class="block_featured_title"><a href="#">Hanoi - Vietnam</a></h2>
									<div class="block_featured_images">
										<a href="#"><img src="upload/img2.gif" alt=""/></a>
									</div>
									<div class="clear"></div>
								</div><!--End .block_featured_items-->
								<div class="block_featured_items">
                                	<h2 class="block_featured_title"><a href="#">Hanoi - Vietnam</a></h2>
									<div class="block_featured_images">
										<a href="#"><img src="upload/img3.gif" alt=""/></a>
									</div>
									<div class="clear"></div>
								</div><!--End .block_featured_items-->
								<div class="block_featured_items">
                                	<h2 class="block_featured_title"><a href="#">Hanoi - Vietnam</a></h2>
									<div class="block_featured_images">
										<a href="#"><img src="upload/img4.gif" alt=""/></a>
									</div>
									<div class="clear"></div>
								</div><!--End .block_featured_items-->
                                <div class="block_featured_items">
                                	<h2 class="block_featured_title"><a href="#">Hanoi - Vietnam</a></h2>
									<div class="block_featured_images">
										<a href="#"><img src="upload/img5.gif" alt=""/></a>
									</div>
									<div class="clear"></div>
								</div><!--End .block_featured_items-->
							</div><!--End .innerBlock-->
						</div><!--End .block_mid-->
						<div class="block_bot"></div>
						<div class="clear"></div>
					</div><!--End .block-->
				</div><!--End .right #right-->				
			</div><!--End .innerPage-->
		</div><!--End #wrapper-->
		<div class="clear"></div>
		<div class="clear"></div>
		<div id="footer">
			<div class="innerPage">
				<?php include("include/footer.php")?>
			</div><!--End .innerPage-->
		</div><!--End #footer-->
	</div><!--End #page-->
</body>
</html>
