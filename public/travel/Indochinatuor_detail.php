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
	
	$(document).ready(function(){
		$('#carousel').jcarousel({
			vertical: true,
			scroll: 1,
			auto: 0,
			wrap: 'last',
			initCallback: mycarousel_initCallback
		});
		//Default Action
		$(".tab_content").hide(); //Hide all content
		$("ul.tabs li:first").addClass("active").show(); //Activate first tab
		$(".tab_content:first").show(); //Show first tab content
		
		//On Click Event
		$("ul.tabs li").click(function() {
			$("ul.tabs li").removeClass("active"); //Remove any "active" class
			
			$(".tab_content").hide(); //Hide all tab content
			var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
			$(activeTab).fadeIn(); //Fade in the active contentd
			return false;
		});
		//Front page Carousel - Initial Setup
		$('div#slideshow-carousel a img').css({'opacity': '1'});
		$('div#slideshow-carousel a img:first').css({'opacity': '1.0'});
		$('div#slideshow-carousel li a:first').append('<span class="arrow"></span>')
		
		//Combine jCarousel with Image Display
		$('div#slideshow-carousel li a').hover(
			function () {
					
				if (!$(this).has('span').length) {
					$('div#slideshow-carousel li a img').stop(true, true).css({'opacity': '1'});
					$(this).stop(true, true).children('img').css({'opacity': '1'});
				}		
			},
			function () {
					
				$('div#slideshow-carousel li a img').stop(true, true).css({'opacity': '1'});
				$('div#slideshow-carousel li a').each(function () {
		
					if ($(this).has('span').length) $(this).children('img').css({'opacity': '1'});
		
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
										<div class="tour_detail">
                                        	<h2 class="tour_detail_title">Enjoy a private tour focusing on Indochina to explore the world heritage of Halong Bay, the wonder of Angkor Ruins and the hidden jewel of Luang Prabang. </h2>
											<div class="tour_detail_left">
												<p><b>Reference :</b> </p>
												<p><span>- Duration :</span>16 Days</p>
												<p><span>- Depart From :</span> Vientiane</p>
												<div class="tour_detail_price"><span>Prince: </span>$ 2.450 </div>
												<div class="tour_detail_book"><a href="#">Book now</a></div>
											</div>
											<div class="tour_detail_right">
												<div id="slide_detail">
													<div id="slideshow-main">
														<ul>
															<li class="p1 active">
																<a href="#">
																	<img src="upload/img18.gif" width="278" height="162" alt=""/>
																	<span class="opacity"></span>
																	
																</a>
															</li>
															<li class="p2">
																<a href="#">
																	<img src="upload/2_big.gif" width="278" height="162" alt=""/>
																	<span class="opacity"></span>
																	
																</a>
															</li>
															<li class="p3">
																<a href="#">
																	<img src="upload/3_big.gif" width="278" height="162" alt=""/>
																	<span class="opacity"></span>
																	
																</a>
															</li>
															<li class="p4">
																<a href="#">
																	<img src="upload/4_big.gif" width="278" height="162" alt=""/>
																	<span class="opacity"></span>
																	
																</a>
															</li>
															<li class="p5">
																<a href="#">
																	<img src="upload/5_big.gif" width="278" height="162" alt=""/>
																	<span class="opacity"></span>
																	
																</a>
															</li>
															<li class="p6">
																<a href="#">
																	<img src="upload/6_big.gif" width="278" height="162" alt=""/>
																	<span class="opacity"></span>
																	
																</a>
															</li>
															<li class="p7">
																<a href="#">
																	<img src="upload/7_big.gif" width="278" height="162" alt=""/>
																	<span class="opacity"></span>
																	
																</a>
															</li>
														</ul>										
													</div>
															
													<div id="slideshow-carousel">				
														  <ul id="carousel" class="jcarousel jcarousel-skin-tango">
															<li><a href="#" rel="p1"><img src="upload/img19.gif" width="60" height="50" alt="#"/></a></li>
															<li><a href="#" rel="p2"><img src="upload/img20.gif" width="60" height="50" alt="#"/></a></li>
															<li><a href="#" rel="p3"><img src="upload/img21.gif" width="60" height="50" alt="#"/></a></li>
															<li><a href="#" rel="p1"><img src="upload/img19.gif" width="60" height="50" alt="#"/></a></li>
															<li><a href="#" rel="p2"><img src="upload/img20.gif" width="60" height="50" alt="#"/></a></li>
															<li><a href="#" rel="p3"><img src="upload/img21.gif" width="60" height="50" alt="#"/></a></li>
                                                            <li><a href="#" rel="p2"><img src="upload/img20.gif" width="60" height="50" alt="#"/></a></li>
														  </ul>
													</div>
													<div class="button-carousel"></div>
													<div class="clear"></div>
													
												</div><!--End .slide_detail-->
											</div><!--End .tour_detail_right-->	
										</div><!--End .tour_detail-->
                                        <div class="clear"></div>
                                        <ul class="tabs tab_detail">
												<li><a href="#tab1" class="first">Destination</a></li>
												<li><a href="#tab2">Itinerary</a></li>
												<li><a href="#tab3" class="last_bg">Price</a></li>
											</ul>
											<div class="tab_container">
												<div id="tab1" class="tab_content">
													<p class="tab_intro">Enjoy a private tour focusing on Indochina to explore the world heritage of Halong Bay, the wonder of Angkor Ruins and the hidden jewel of Luang Prabang. Come with us to meet the people, experience the culture and savour the cuisine.</p>
													<div class="tab_items">
														<h2>Day 1 - Vientiane</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="tab_items">
														<h2>Day 2 - Vientiane - Luang Prabang</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="tab_items">
														<h2>Day 3 - Luang Prabang - Hanoi</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="tab_items">
														<h2>Day 4 - Hanoi - Halong Bay</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="tab_items">
														<h2>Day 5 - Halong Bay - Hanoi</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="next_page">
														<a href="#">Next pages</a>
													</div>
												</div>
												<div id="tab2" class="tab_content">
													<p class="tab_intro">Enjoy a private tour focusing on Indochina to explore the world heritage of Halong Bay, the wonder of Angkor Ruins and the hidden jewel of Luang Prabang. Come with us to meet the people, experience the culture and savour the cuisine.</p>
													<div class="tab_items">
														<h2>Day 1 - Vientiane</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="tab_items">
														<h2>Day 2 - Vientiane - Luang Prabang</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="tab_items">
														<h2>Day 3 - Luang Prabang - Hanoi</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="tab_items">
														<h2>Day 4 - Hanoi - Halong Bay</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="tab_items">
														<h2>Day 5 - Halong Bay - Hanoi</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="next_page">
														<a href="#">Next pages</a>
													</div>
												</div>
												<div id="tab3" class="tab_content">
													<p class="tab_intro">Enjoy a private tour focusing on Indochina to explore the world heritage of Halong Bay, the wonder of Angkor Ruins and the hidden jewel of Luang Prabang. Come with us to meet the people, experience the culture and savour the cuisine.</p>
													<div class="tab_items">
														<h2>Day 1 - Vientiane</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="tab_items">
														<h2>Day 2 - Vientiane - Luang Prabang</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="tab_items">
														<h2>Day 3 - Luang Prabang - Hanoi</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="tab_items">
														<h2>Day 4 - Hanoi - Halong Bay</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="tab_items">
														<h2>Day 5 - Halong Bay - Hanoi</h2>
														<p>Arrive in Vientiane. Our guide and car pick you up and transfer to hotel for check in. In the afternoon, visit some ancient monuments in the capital: the central market (Talad Sao), Wat Sisaket monastery, Imperial Wat Phra Keo temple and That Luang. Have dinner and overnight in Vientiane.</p>
													</div>
													<div class="next_page">
														<a href="#">Next pages</a>
													</div>
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
