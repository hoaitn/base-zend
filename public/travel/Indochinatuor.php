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
									<h2 class="title"><a>Classic Tours</a></h2>
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
										<div class="tour_items">
											<div class="tour_items_images">
												<a href="#"><img src="upload/img17.gif" alt=""/></a>
											</div>
											<div class="tour_items_content">
												<h2 class="tour_items_title"><a href="#">Vietnam essential draw 09 days 08 nights</a></h2>
												<div class="tour_items_sub">
													<b>Rates:</b> <span> $538 - $ 889 </span>    |   <b>Duration:</b>	 9 days/ 8 nights
												</div>
												<div class="tour_items_intro">Excellent to visit the major landmarks of Vietnam within a very limited time, easy to connect with surrounding highlights of the Southeast Asian countries</div>
											</div>
                                            <a href="#" class="tour_items_detail">More Detail</a>
											<div class="clear"></div>
										</div><!--End .tour_items-->
										<div class="tour_items">
											<div class="tour_items_images">
												<a href="#"><img src="upload/img17.gif" alt=""/></a>
											</div>
											<div class="tour_items_content">
												<h2 class="tour_items_title"><a href="#">Vietnam essential draw 09 days 08 nights</a></h2>
												<div class="tour_items_sub">
													<b>Rates:</b> <span> $538 - $ 889 </span>    |   <b>Duration:</b>	 9 days/ 8 nights
												</div>
												<div class="tour_items_intro">Excellent to visit the major landmarks of Vietnam within a very limited time, easy to connect with surrounding highlights of the Southeast Asian countries</div>
                                                <a href="#" class="tour_items_detail">More Detail</a>
											</div>
											<div class="clear"></div>
										</div><!--End .tour_items-->
										<div class="tour_items">
											<div class="tour_items_images">
												<a href="#"><img src="upload/img17.gif" alt=""/></a>
											</div>
											<div class="tour_items_content">
												<h2 class="tour_items_title"><a href="#">Vietnam essential draw 09 days 08 nights</a></h2>
												<div class="tour_items_sub">
													<b>Rates:</b> <span> $538 - $ 889 </span>    |   <b>Duration:</b>	 9 days/ 8 nights
												</div>
												<div class="tour_items_intro">Excellent to visit the major landmarks of Vietnam within a very limited time, easy to connect with surrounding highlights of the Southeast Asian countries</div>
                                                <a href="#" class="tour_items_detail">More Detail</a>
											</div>
											<div class="clear"></div>
										</div><!--End .tour_items--><div class="tour_items">
											<div class="tour_items_images">
												<a href="#"><img src="upload/img17.gif" alt=""/></a>
											</div>
											<div class="tour_items_content">
												<h2 class="tour_items_title"><a href="#">Vietnam essential draw 09 days 08 nights</a></h2>
												<div class="tour_items_sub">
													<b>Rates:</b> <span> $538 - $ 889 </span>    |   <b>Duration:</b>	 9 days/ 8 nights
												</div>
												<div class="tour_items_intro">Excellent to visit the major landmarks of Vietnam within a very limited time, easy to connect with surrounding highlights of the Southeast Asian countries</div>
                                                <a href="#" class="tour_items_detail">More Detail</a>
											</div>
											<div class="clear"></div>
										</div><!--End .tour_items-->
										<div class="tour_items">
											<div class="tour_items_images">
												<a href="#"><img src="upload/img17.gif" alt=""/></a>
											</div>
											<div class="tour_items_content">
												<h2 class="tour_items_title"><a href="#">Vietnam essential draw 09 days 08 nights</a></h2>
												<div class="tour_items_sub">
													<b>Rates:</b> <span> $538 - $ 889 </span>    |   <b>Duration:</b>	 9 days/ 8 nights
												</div>
												<div class="tour_items_intro">Excellent to visit the major landmarks of Vietnam within a very limited time, easy to connect with surrounding highlights of the Southeast Asian countries</div>
                                                <a href="#" class="tour_items_detail">More Detail</a>
											</div>
											<div class="clear"></div>
										</div><!--End .tour_items-->
										<div class="tour_items">
											<div class="tour_items_images">
												<a href="#"><img src="upload/img17.gif" alt=""/></a>
											</div>
											<div class="tour_items_content">
												<h2 class="tour_items_title"><a href="#">Vietnam essential draw 09 days 08 nights</a></h2>
												<div class="tour_items_sub">
													<b>Rates:</b> <span> $538 - $ 889 </span>    |   <b>Duration:</b>	 9 days/ 8 nights
												</div>
												<div class="tour_items_intro">Excellent to visit the major landmarks of Vietnam within a very limited time, easy to connect with surrounding highlights of the Southeast Asian countries</div>
                                                <a href="#" class="tour_items_detail">More Detail</a>
											</div>
											<div class="clear"></div>
										</div><!--End .tour_items-->
										<div class="tour_items">
											<div class="tour_items_images">
												<a href="#"><img src="upload/img17.gif" alt=""/></a>
											</div>
											<div class="tour_items_content">
												<h2 class="tour_items_title"><a href="#">Vietnam essential draw 09 days 08 nights</a></h2>
												<div class="tour_items_sub">
													<b>Rates:</b> <span> $538 - $ 889 </span>    |   <b>Duration:</b>	 9 days/ 8 nights
												</div>
												<div class="tour_items_intro">Excellent to visit the major landmarks of Vietnam within a very limited time, easy to connect with surrounding highlights of the Southeast Asian countries</div>
                                                <a href="#" class="tour_items_detail">More Detail</a>
											</div>
											<div class="clear"></div>
										</div><!--End .tour_items-->
										<div class="tour_items">
											<div class="tour_items_images">
												<a href="#"><img src="upload/img17.gif" alt=""/></a>
											</div>
											<div class="tour_items_content">
												<h2 class="tour_items_title"><a href="#">Vietnam essential draw 09 days 08 nights</a></h2>
												<div class="tour_items_sub">
													<b>Rates:</b> <span> $538 - $ 889 </span>    |   <b>Duration:</b>	 9 days/ 8 nights
												</div>
												<div class="tour_items_intro">Excellent to visit the major landmarks of Vietnam within a very limited time, easy to connect with surrounding highlights of the Southeast Asian countries </div>
                                                <a href="#" class="tour_items_detail">More Detail</a>
											</div>
											<div class="clear"></div>
										</div><!--End .tour_items-->
										<div class="tour_items">
											<div class="tour_items_images">
												<a href="#"><img src="upload/img17.gif" alt=""/></a>
											</div>
											<div class="tour_items_content">
												<h2 class="tour_items_title"><a href="#">Vietnam essential draw 09 days 08 nights</a></h2>
												<div class="tour_items_sub">
													<b>Rates:</b> <span> $538 - $ 889 </span>    |   <b>Duration:</b>	 9 days/ 8 nights
												</div>
												<div class="tour_items_intro">Excellent to visit the major landmarks of Vietnam within a very limited time, easy to connect with surrounding highlights of the Southeast Asian countries</div>
                                                <a href="#" class="tour_items_detail">More Detail</a>
											</div>
											<div class="clear"></div>
										</div><!--End .tour_items-->
										<div class="pagination">
											<ul>
												<li><a href="#" class="pagination_first">First</a></li>
												<li><a href="#" class="pagination_prev">Previous</a></li>
												<li><a href="#" class="pagination_active">1</a></li>
												<li><a href="#">2</a></li>
												<li><a href="#">3</a></li>
												<li><a href="#">4</a></li>
												<li><a href="#" class="pagination_next">next</a></li>
												<li><a href="#" class="pagination_last">Last</a></li>
											</ul>
										</div>
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
									<a>Search tour</a>
									<img src="images/icon/icon8.png" alt="" class="title_stour" />
								</h2>
								<form action="" method="post" id="search">
									<select>
										<option value="0"> -------------------  Indochina Tours  ------------------- </option>
									</select>
									<br />
									<input type="text" value="" class="txt"/>
									<input type="submit" value="Search" class="button"/>
									<div class="clear"></div>
								</form>
							</div><!--End .innerBlock-->
						</div><!--End .block_mid-->
						<div class="block_bot"></div>
						<div class="clear"></div>
					</div><!--End .block-->
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
                    <div class="block">
						<div class="block_top"></div>
						<div class="block_mid">
							<div class="innerBlock">
								<h2 class="block_title">
									<a>Most View</a>
									<img src="images/icon/icon7.png" alt="" class="title_view" />
								</h2>
								<ul>
                                	<li><a href="#">Tour sapa 2 days/ 1 night check Tour sapa 2 days/ 1 night check</a></li>
                                    <li><a href="#">Tour sapa 2 days/ 1 night check</a></li>
                                    <li><a href="#">Tour sapa 2 days/ 1 night check</a></li>
                                    <li><a href="#">Tour sapa 2 days/ 1 night check</a></li>
                                    <li><a href="#">Tour sapa 2 days/ 1 night check</a></li>
                                </ul>
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
