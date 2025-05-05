<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title><?= $company->name ?> </title>
	<?php require_once("includes/links.php") ?>
</head>

<body>
	<div class="page-wrapper">
		<?php require_once("includes/header.php") ?>

		<!--Main Slider-->
		<section class="main-slider">
			<div class="rev_slider_wrapper fullwidthbanner-container" id="rev_slider_one_wrapper" data-source="gallery">
				<div class="rev_slider fullwidthabanner" id="rev_slider_one" data-version="5.4.1">
					<ul>
						<!-- Slide 1 -->
						<li data-index="rs-1" data-transition="zoomout">
							<!-- MAIN IMAGE -->
							<img src="images/main-slider/1.jpg" alt="" class="rev-slidebg" />

							<div class="tp-caption tp-shape tp-shapewrapper tp-resizeme ipad-hidden rs-parallaxlevel-1" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingtop="[0,0,0,0]" data-responsive_offset="on" data-type="shape" data-height="auto" data-whitespace="nowrap" data-width="none" data-hoffset="['110','110','110','110']" data-voffset="['110','90','90','90']" data-x="['right','right','right','right']" data-y="['bottom','bottom','bottom','bottom']" data-frames='[{"from":"x:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":1000,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'>
								<i class="float-icon flaticon-cargo-boat"></i>
							</div>

							<div class="tp-caption tp-resizeme rs-parallaxlevel-1 ipad-hidden" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingtop="[0,0,0,0]" data-responsive_offset="on" data-type="shape" data-height="none" data-whitespace="nowrap" data-width="none" data-hoffset="['0','0','0','0']" data-voffset="['110','90','90','90']" data-x="['right','right','right','right']" data-y="['bottom','bottom','bottom','bottom']" data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":1500,"ease":"Power3.easeInOut"},{"delay":"wait","speed":3000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'>
								<i class="float-icon flaticon-airplane-2"></i>
							</div>

							<div class="tp-caption tp-resizeme rs-parallaxlevel-3" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingtop="[0,0,0,0]" data-responsive_offset="on" data-type="shape" data-height="none" data-whitespace="nowrap" data-width="none" data-hoffset="['-10','-10','-10','100']" data-voffset="['-170','-170','-120','-100']" data-x="['center','center','center','center']" data-y="['middle','middle','middle','middle']" data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":2000,"ease":"Power3.easeInOut"},{"delay":"wait","speed":3000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'>
								<figure><img src="images/main-slider/plane-icon.png" alt="" /></figure>
							</div>

							<div class="tp-caption" data-paddingbottom="[0,0,0,0]" data-paddingleft="[15,15,15,15]" data-paddingright="[0,0,0,0]" data-paddingtop="[0,0,0,0]" data-responsive_offset="on" data-type="text" data-height="none" data-width="['750','750','750','650']" data-whitespace="normal" data-hoffset="['0','0','0','0']" data-voffset="['-195','-160','-160','-140']" data-x="['left','left','left','left']" data-y="['middle','middle','middle','middle']" data-textalign="['top','top','top','top']" data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
								<span class="title"><?= $company->name ?> Logistics & Transport</span>
							</div>

							<div class="tp-caption" data-paddingbottom="[0,0,0,0]" data-paddingleft="[15,15,15,15]" data-paddingright="[15,15,15,15]" data-paddingtop="[0,0,0,0]" data-responsive_offset="on" data-type="text" data-height="none" data-width="['750','750','750','650']" data-whitespace="normal" data-hoffset="['0','0','0','0']" data-voffset="['-70','-40','-40','-30']" data-x="['left','left','left','left']" data-y="['middle','middle','middle','middle']" data-textalign="['top','top','top','top']" data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
								<h2>Logistics & Cargo <br />For Business</h2>
							</div>

							<div class="tp-caption" data-paddingbottom="[0,0,0,0]" data-paddingleft="[15,15,15,15]" data-paddingright="[15,15,15,15]" data-paddingtop="[0,0,0,0]" data-responsive_offset="on" data-type="text" data-height="none" data-width="['700','750','700','450']" data-whitespace="normal" data-hoffset="['0','0','0','0']" data-voffset="['100','120','120','120']" data-x="['left','left','left','left']" data-y="['middle','middle','middle','middle']" data-textalign="['top','top','top','top']" data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
								<a href="#tracking" class="theme-btn btn-style-one hvr-light"><span class="btn-title">Track your Package</span></a>
							</div>
						</li>

						<!-- Slide 1 -->
						<li data-index="rs-2" data-transition="zoomout">
							<!-- MAIN IMAGE -->
							<img src="images/main-slider/2.jpg" alt="" class="rev-slidebg" />

							<div class="tp-caption tp-shape tp-shapewrapper tp-resizeme ipad-hidden rs-parallaxlevel-1" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingtop="[0,0,0,0]" data-responsive_offset="on" data-type="shape" data-height="auto" data-whitespace="nowrap" data-width="none" data-hoffset="['110','110','110','110']" data-voffset="['110','90','90','90']" data-x="['right','right','right','right']" data-y="['bottom','bottom','bottom','bottom']" data-frames='[{"from":"x:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":1000,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'>
								<i class="float-icon flaticon-cargo-boat"></i>
							</div>

							<div class="tp-caption tp-resizeme rs-parallaxlevel-1 ipad-hidden" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingtop="[0,0,0,0]" data-responsive_offset="on" data-type="shape" data-height="none" data-whitespace="nowrap" data-width="none" data-hoffset="['0','0','0','0']" data-voffset="['110','90','90','90']" data-x="['right','right','right','right']" data-y="['bottom','bottom','bottom','bottom']" data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":1500,"ease":"Power3.easeInOut"},{"delay":"wait","speed":3000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'>
								<i class="float-icon flaticon-airplane-2"></i>
							</div>

							<div class="tp-caption tp-resizeme rs-parallaxlevel-3" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingtop="[0,0,0,0]" data-responsive_offset="on" data-type="shape" data-height="none" data-whitespace="nowrap" data-width="none" data-hoffset="['-10','-10','-10','100']" data-voffset="['-170','-170','-120','-100']" data-x="['center','center','center','center']" data-y="['middle','middle','middle','middle']" data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":2000,"ease":"Power3.easeInOut"},{"delay":"wait","speed":3000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'>
								<figure><img src="images/main-slider/plane-icon.png" alt="" /></figure>
							</div>

							<div class="tp-caption" data-paddingbottom="[0,0,0,0]" data-paddingleft="[15,15,15,15]" data-paddingright="[0,0,0,0]" data-paddingtop="[0,0,0,0]" data-responsive_offset="on" data-type="text" data-height="none" data-width="['750','750','750','650']" data-whitespace="normal" data-hoffset="['0','0','0','0']" data-voffset="['-195','-160','-160','-140']" data-x="['left','left','left','left']" data-y="['middle','middle','middle','middle']" data-textalign="['top','top','top','top']" data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
								<span class="title"><?= $company->name ?> Logistics & Transport</span>
							</div>

							<div class="tp-caption" data-paddingbottom="[0,0,0,0]" data-paddingleft="[15,15,15,15]" data-paddingright="[15,15,15,15]" data-paddingtop="[0,0,0,0]" data-responsive_offset="on" data-type="text" data-height="none" data-width="['750','750','750','650']" data-whitespace="normal" data-hoffset="['0','0','0','0']" data-voffset="['-70','-40','-40','-30']" data-x="['left','left','left','left']" data-y="['middle','middle','middle','middle']" data-textalign="['top','top','top','top']" data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
								<h2>Logistics & Cargo <br />For Business</h2>
							</div>

							<div class="tp-caption" data-paddingbottom="[0,0,0,0]" data-paddingleft="[15,15,15,15]" data-paddingright="[15,15,15,15]" data-paddingtop="[0,0,0,0]" data-responsive_offset="on" data-type="text" data-height="none" data-width="['700','750','700','450']" data-whitespace="normal" data-hoffset="['0','0','0','0']" data-voffset="['100','120','120','120']" data-x="['left','left','left','left']" data-y="['middle','middle','middle','middle']" data-textalign="['top','top','top','top']" data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'>
								<a href="#tracking" class="theme-btn btn-style-one hvr-light"><span class="btn-title">Track your Package</span></a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</section>
		<!-- End Main Slider-->

		<!-- Features Section -->
		<section class="features-section">
			<div class="auto-container">
				<div class="row">
					<!-- Feature Block -->
					<div class="feature-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box">
							<div class="icon-box">
								<i class="icon flaticon-logistics-delivery-6"></i>
								<span class="count">01</span>
							</div>
							<div class="content-box">
								<h4 class="title">
									<a href="page-about.html">Cost<br />
										optimization</a>
								</h4>
								<div class="text">Ensure delivery through a robust performance management and communication.</div>
							</div>
						</div>
					</div>

					<!-- Feature Block -->
					<div class="feature-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box">
							<div class="icon-box">
								<i class="icon flaticon-fast-delivery-1"></i>
								<span class="count">02</span>
							</div>
							<div class="content-box">
								<h4 class="title">
									<a href="page-about.html">Reduced<br />
										transit timing</a>
								</h4>
								<div class="text">We deliver very fast and offer same-day delivery at a pocket-friendly price.</div>
							</div>
						</div>
					</div>

					<!-- Feature Block -->
					<div class="feature-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box">
							<div class="icon-box">
								<i class="icon flaticon-container-2"></i>
								<span class="count">03</span>
							</div>
							<div class="content-box">
								<h4 class="title"><a href="page-about.html">Warehouse Packaging</a></h4>
								<div class="text">Appropriate container to pack the products and labeling packages with the relevant invoice.</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Features Section-->

		<!-- About Section -->
		<section id="about" class="about-section pt-0">
			<div class="anim-icons">
				<div class="float-image wow fadeInRight"><img src="images/resource/float-img-1.png" alt="" /></div>
				<span class="icon icon-dots-1 bounce-x"></span>
				<span class="icon icon-dotted-map zoom-one"></span>
			</div>

			<div class="auto-container">
				<div class="row">
					<div class="content-column col-lg-6 col-md-12 col-sm-12 order-2">
						<div class="inner-column">
							<div class="sec-title">
								<span class="sub-title">Transportation Company</span>
								<h2>We provide full range of transportation services</h2>
								<div class="text">
									<?= $company->name ?> has a global network with distribution centres around the world to meet the warehousing and distribution requirements of various industries. The following locations demonstrate the storage capabilities of <?= $company->name ?> both domestically and internationally.
								</div>
							</div>

							<div class="content-box">
								<div class="about-block">
									<i class="icon flaticon-worldwide-shipping"></i>
									<h4 class="title">Worldwide services</h4>
									<p class="text">Our Logistics division will begin the supply chain journey by importing inventory from your suppliers to our international 3PL warehouses. </p>
								</div>

								<div class="about-block">
									<i class="icon flaticon-3d-cube"></i>
									<h4 class="title">Local services</h4>
									<p class="text">We have a global network with distribution centres around the world to meet the warehousing and distribution requirements of various industries.</p>
								</div>
							</div>

							<div class="btm-box">
								<a href="#contact" class="theme-btn btn-style-one"><span class="btn-title">Contact Us</span></a>
							</div>
						</div>
					</div>

					<!-- Image Column -->
					<div class="image-column col-lg-6 col-md-12 col-sm-12">
						<div class="inner-column">
							<figure class="image-1"><img src="images/resource/about-1.jpg" alt="" /></figure>
							<figure class="image-2"><img src="images/resource/about-2.jpg" alt="" /></figure>
							<div class="experience">
								<strong><i class="icon flaticon-global"></i> 40<br />
									Years</strong>
								Working Exprience
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--Emd About Section -->

		<!-- Services Section -->
		<section id="services" class="services-section">
			<div class="bg-image" style="background-image: url(images/background/1.jpg)"></div>
			<div class="anim-icons">
				<span class="icon icon-wave-line"></span>
			</div>

			<div class="auto-container">
				<div class="sec-title text-center">
					<span class="sub-title">SPECIALISATION</span>
					<h2>Specialist in logistics services</h2>
				</div>

				<div class="row">
					<!-- Service Block -->
					<div class="service-block col-xl-3 col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image">
									<a href="#"><img src="images/resource/service-1.jpg" alt="" /></a>
								</figure>
							</div>
							<div class="content-box">
								<i class="icon flaticon-airplane-2"></i>
								<span class="sub-title">01 Service</span>
								<h4 class="title"><a href="#">Air freight</a></h4>
								<div class="text">Air freight parcel delivery is the transfer and shipment of goods via an air carrier, which may be charter or commercial. Such shipments travel out of commercial and passenger aviation gateways to anywhere planes can fly and land.</div>
							</div>
						</div>
					</div>

					<!-- Service Block -->
					<div class="service-block col-xl-3 col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="300ms">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image">
									<a href="#"><img src="images/resource/service-2.jpg" alt="" /></a>
								</figure>
							</div>
							<div class="content-box">
								<i class="icon flaticon-cargo-boat"></i>
								<span class="sub-title">02 Service</span>
								<h4 class="title"><a href="#">Sea freight</a></h4>
								<div class="text">Sea freight is a method of transporting large quantities of products via cargo ships. Goods are packed into containers and these containers are loaded onto a vessel, where they will be sailed to their destination country.</div>
							</div>
						</div>
					</div>

					<!-- Service Block -->
					<div class="service-block col-xl-3 col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="600ms">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image">
									<a href="#"><img src="images/resource/service-3.jpg" alt="" /></a>
								</figure>
							</div>
							<div class="content-box">
								<i class="icon flaticon-delivery-truck-3"></i>
								<span class="sub-title">03 Service</span>
								<h4 class="title"><a href="#">Road service</a></h4>
								<div class="text">Automatically manage deliveries with your own drivers and 3rd party delivery services like DoorDash Drive, Uber and others. Live-tracking on Google Maps makes it easy for everyone, your will receive a real-time tracking</div>
							</div>
						</div>
					</div>

					<!-- Service Block -->
					<div class="service-block col-xl-3 col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="900ms">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image">
									<a href="#"><img src="images/resource/service-4.jpg" alt="" /></a>
								</figure>
							</div>
							<div class="content-box">
								<i class="icon flaticon-delivery-box-4"></i>
								<span class="sub-title">04 Service</span>
								<h4 class="title"><a href="#">Warehousing & Distribution</a></h4>
								<div class="text"><?= $company->name ?>’s philosophy is to provide a warehousing and distribution service that meets expectations of quality in productivity, costs, and service. We are well versed in consolidating stock within their global network facilities. </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Services Section-->

		<!-- Tracking Section -->
		<section id="tracking" class="tracking-section pull-down">
			<div class="auto-container">
				<div class="outer-box">
					<div class="arrow-box wow fadeInRight">
						<img src="images/icons/arrow-2.png" alt="" class="icon" />
						<span class="title">Results in <br />few seconds</span>
					</div>
					<div class="tracking-form">
						<h4 class="title">Track your <br />Waybill</h4>
						<!-- Tracking Form -->
						<form method="post" onsubmit="getreceipt(event, this);">
							<div class="row">
								<div class="form-group col-lg-4 col-md-12 col-sm-12">
									<span class="icon lnr-icon-user"></span>
									<input required type="text" name="field_name" placeholder="Your Tracking Number" />
								</div>
								<!-- Form Group -->
								<div class="form-group col-lg-4 col-md-12 col-sm-12">
								</div>
								<!-- Form Group -->
								<div class="form-group col-lg-4 col-md-12 col-sm-12 text-end">
									<button type="submit" class="theme-btn btn-style-one"><span class="btn-title">Track Order</span></button>
								</div>
							</div>
						</form>
						<!-- End Tracking Form -->
					</div>
				</div>
			</div>
		</section>
		<!-- End Tracking Section -->

		<!-- Call To Action Two -->
		<section class="call-to-action" style="background-image: url(images/background/2.jpg)">
			<div class="auto-container">
				<div class="outer-box">
					<a href="" class="play-now lightbox-image"><i class="icon fa fa-play"></i><span class="ripple"></span></a>
					<div class="sec-title light mb-0">
						<div class="sub-title">Get in touch with us anytime</div>
						<h1>Looking for the best <br />logistics transport service?</h1>
						<a href="#contact" class="theme-btn btn-style-one hvr-light"><span class="btn-title">Send Message</span></a>
					</div>
				</div>
			</div>
		</section>
		<!--End Call To Action Two -->

		<!-- Work Section -->
		<section class="work-section">
			<div class="anim-icons">
				<span class="icon icon-dotted-map-2 zoom-one"></span>
				<span class="icon icon-plane-1 bounce-y"></span>
			</div>

			<div class="auto-container">
				<div class="sec-title text-center">
					<span class="sub-title">How It Work</span>
					<h2>3 easy step to task</h2>
				</div>

				<div class="row">
					<!-- Work Block -->
					<div class="work-block col-lg-4 col-md-6 col-sm-12 wow fadeInRight">
						<div class="inner-box">
							<div class="icon-box">
								<span class="count">01</span>
								<i class="icon flaticon-delivery-box-4"></i>
							</div>
							<h4 class="title">Pay your service <br />charges</h4>
						</div>
					</div>

					<!-- Work Block -->
					<div class="work-block col-lg-4 col-md-6 col-sm-12 wow fadeInRight" data-wow-delay="300ms">
						<div class="inner-box">
							<div class="icon-box">
								<span class="count">02</span>
								<i class="icon flaticon-stock-1"></i>
							</div>
							<h4 class="title">Enter your <br />& product detail</h4>
						</div>
					</div>

					<!-- Work Block -->
					<div class="work-block col-lg-4 col-md-6 col-sm-12 wow fadeInRight" data-wow-delay="600ms">
						<div class="inner-box">
							<div class="icon-box">
								<span class="count">03</span>
								<i class="icon flaticon-delivery-box-3"></i>
							</div>
							<h4 class="title">Commence tracking for <br />your goods</h4>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Work Section -->

		<!-- Fun Fact Section -->
		<section class="fun-fact-section p-0">
			<div class="auto-container">
				<div class="outer-box">
					<div class="bg-image" style="background-image: url(images/background/3.jpg)"></div>

					<div class="row">
						<!-- Content Column -->
						<div class="content-column col-lg-7 col-md-12 col-sm-12 order-2">
							<div class="inner-column">
								<div class="sec-title light">
									<span class="sub-title">We Deliver on time</span>
									<h2>Total Coverage & Flexibility in Exports & Imports</h2>
									<div class="text"><?= $company->name ?> Global Logistics and Warehousing are the world's trusted provider of international supply chain solutions.</div>
								</div>

								<div class="fact-counter">
									<div class="row">
										<!--Column-->
										<div class="counter-column col-lg-4 col-md-6 col-sm-12">
											<div class="inner">
												<div class="count-box"><span class="count-text" data-speed="3000" data-stop="7869">0</span></div>
												<h4 class="counter-title">Deliveries <br />Completed</h4>
												<i class="icon flaticon-delivery-8"></i>
											</div>
										</div>

										<!--Column-->
										<div class="counter-column col-lg-4 col-md-6 col-sm-12">
											<div class="inner">
												<div class="count-box"><span class="count-text" data-speed="3000" data-stop="1683">0</span></div>
												<h4 class="counter-title">Satisfied <br />Customers</h4>
												<i class="icon flaticon-team"></i>
											</div>
										</div>

										<!--Column-->
										<div class="counter-column col-lg-4 col-md-6 col-sm-12">
											<div class="inner">
												<div class="count-box"><span class="count-text" data-speed="3000" data-stop="6975">0</span></div>
												<h4 class="counter-title">
													Delivered<br />
													on Time
												</h4>
												<i class="icon flaticon-delivery-box-3"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="image-column col-lg-5 col-md-12 col-sm-12">
							<div class="inner-column">
								<figure class="image"><img src="images/resource/image-1.png" alt="" /></figure>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Fun Fact Section -->

		<!-- Project Section -->
		<section id="projects" class="project-section pb-0">
			<div class="large-container">
				<div class="sec-title text-center">
					<span class="sub-title">LATEST PROJECTS</span>
					<h2>Works across the world</h2>
				</div>

				<!-- Prject Carousel -->
				<div class="project-carousel owl-carousel owl-theme">
					<!-- Project Block -->
					<div class="project-block">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image">
									<a href="images/resource/project-1.jpg" class="lightbox-image"><img src="images/resource/project-1.jpg" alt="" /></a>
								</figure>
								<a href="#" class="icon"><i class="fa fa-plus"></i></a>
							</div>
							<div class="content-box">
								<span class="sub-title">Logistics</span>
								<h4 class="title"><a href="#">Special transport</a></h4>
							</div>
						</div>
					</div>

					<!-- Project Block -->
					<div class="project-block">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image">
									<a href="images/resource/project-2.jpg" class="lightbox-image"><img src="images/resource/project-2.jpg" alt="" /></a>
								</figure>
								<a href="#" class="icon"><i class="fa fa-plus"></i></a>
							</div>
							<div class="content-box">
								<span class="sub-title">Cargo</span>
								<h4 class="title"><a href="#">Special transport</a></h4>
							</div>
						</div>
					</div>

					<!-- Project Block -->
					<div class="project-block">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image">
									<a href="images/resource/project-3.jpg" class="lightbox-image"><img src="images/resource/project-3.jpg" alt="" /></a>
								</figure>
								<a href="#" class="icon"><i class="fa fa-plus"></i></a>
							</div>
							<div class="content-box">
								<span class="sub-title">Logistics</span>
								<h4 class="title"><a href="#">Special transport</a></h4>
							</div>
						</div>
					</div>

					<!-- Project Block -->
					<div class="project-block">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image">
									<a href="images/resource/project-4.jpg" class="lightbox-image"><img src="images/resource/project-4.jpg" alt="" /></a>
								</figure>
								<a href="#" class="icon"><i class="fa fa-plus"></i></a>
							</div>
							<div class="content-box">
								<span class="sub-title">Logistics</span>
								<h4 class="title"><a href="#">Special transport</a></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--End Project Section -->

		<!-- Why Choose Us -->
		<section id="contact" class="why-choose-us pull-up pb-0">
			<div class="bg-image" style="background-image: url(images/background/4.jpg)"></div>
			<div class="anim-icons">
				<div class="float-image"><img src="images/resource/delivery-boy.png" alt="" /></div>
			</div>

			<div class="auto-container">
				<div class="row">
					<!-- Content Column -->
					<div class="content-column col-lg-6 col-md-12 col-sm-12">
						<div class="inner-column">
							<div class="sec-title light">
								<span class="sub-title">Why Choose Us</span>
								<h2>We create opportunity to reach potential</h2>
							</div>

							<!-- Feature Block -->
							<div class="feature-block-two">
								<div class="inner-box">
									<i class="icon flaticon-delivery-box-4"></i>
									<h4 class="title">Global Network</h4>
									<p class="text"><?= $company->name ?> have partnered with strategic service providers around the globe who are committed to innovative, cost-effective solutions for our customers.</p>
								</div>
							</div>

							<!-- Feature Block -->
							<div class="feature-block-two">
								<div class="inner-box">
									<i class="icon flaticon-international-shipping-3"></i>
									<h4 class="title">Secure 3PL Warehousing</h4>
									<p class="text">Our global network of 3PL warehouses is equipped to consolidate, store, and distribute goods to consumers efficiently and effectively regardless of their location.</p>
								</div>
							</div>
						</div>
					</div>

					<!-- form Column -->
					<div class="form-column col-lg-6 col-md-12 col-sm-12">
						<div class="inner-column">
							<!-- Contact Form -->
							<div class="contact-form wow fadeInLeft">
								<!--Contact Form-->
								<form method="post" id="contact-form">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 form-group">
											<label>Your Name:</label>
											<input type="text" name="full_name" placeholder="" required />
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12 form-group">
											<label>Your Email:</label>
											<input type="email" name="email" placeholder="" required />
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12 form-group">
											<label>Phone No:</label>
											<input type="text" name="phone" placeholder="" required />
										</div>

										<div class="col-lg-12 col-md-12 col-sm-12 form-group">
											<label>Estimated Weight (kg):</label>
											<div class="range-slider-one">
												<input type="text" required class="range-amount" name="weight" readonly />
												<div class="distance-range-slider"></div>
											</div>
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12 form-group">
											<label>Freight type:</label>
											<select class="custom-select" required name="cargo_type">
												<?php foreach ($cargo  as $key => $value) { ?>
													<option value="<?= $value ?>"><?= $value ?></option>
												<?php } ?>

											</select>
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12 form-group">
											<label>Delivery type:</label>
											<select required class="custom-select" name="delivery_type">
												<option value="">Select</option>
												<option value="My Door">Door to Door</option>
												<option value="Your Warehouse">Warehouse Collection</option>
											</select>
										</div>

										<div class="col-lg-12 col-md-12 col-sm-12 form-group">
											<button class="theme-btn btn-style-two hvr-light submit" type="submit" name="submit-form"><span class="btn-title">Submit Request</span></button>
										</div>
									</div>
								</form>
							</div>
							<!--End Contact Form -->
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Why Choose Us -->

		<!-- About Section Two -->
		<section class="about-section-two">
			<div class="auto-container">
				<div class="row">
					<div class="content-column col-lg-6 col-md-12 col-sm-12 order-2">
						<div class="inner-column">
							<div class="sec-title">
								<span class="sub-title">Get to know us</span>
								<h2>Dedicated Team of Professionals</h2>
								<h4>Our highly skilled and experienced team have been contributing to the company’s inspiring growth over 40 years ago.</h4>
								<div class="text">As a global citizen, we are committed to our people, environment, and the communities in which we operate, and instil processes and values that reflect a commitment to sustainability.</div>
							</div>

							<div class="row">
								<!-- Feature Block -->
								<div class="feature-block-three col-lg-4 col-md-4 col-sm-12">
									<div class="inner">
										<i class="icon flaticon-delivery-courier"></i>
										<h4 class="title">Cost Optimisation</h4>
									</div>
								</div>

								<!-- Feature Block -->
								<div class="feature-block-three col-lg-4 col-md-4 col-sm-12">
									<div class="inner">
										<i class="icon flaticon-delivery-insurance-3"></i>
										<h4 class="title">Reduced <br />Transit Time</h4>
									</div>
								</div>

								<!-- Feature Block -->
								<div class="feature-block-three col-lg-4 col-md-4 col-sm-12">
									<div class="inner">
										<i class="icon flaticon-delivery-box-3"></i>
										<h4 class="title">Delivery <br />on Time</h4>
									</div>
								</div>
							</div>

							<div class="founder-info">
								<div class="thumb"><img src="images/resource/ceo.jpg" alt="" /></div>
								<h5 class="name">Brittary Herman</h5>
								<span class="designation">CEO & Founder of Company</span>
							</div>
						</div>
					</div>

					<!-- Image Column -->
					<div class="image-column col-lg-6 col-md-12 col-sm-12">
						<div class="inner-column">
							<figure class="image-1 wow fadeInUp"><img src="images/resource/about-3.jpg" alt="" /></figure>
							<figure class="image-2 wow fadeInRight">
								<img src="images/resource/about-4.jpg" alt="" />
								<div class="icon-box"><i class="icon flaticon-delivery-box-4"></i></div>
							</figure>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--Emd About Section Two -->

		<!-- Testimonial Section -->
		<section class="testimonial-section pt-0">
			<div class="anim-icons">
				<span class="icon icon-bg-dots"></span>
				<span class="icon icon-plane-2 bounce-y"></span>
			</div>

			<div class="auto-container">
				<div class="sec-title text-center">
					<span class="sub-title">Client’s Testimonials</span>
					<h2>Here are some clients <br />feedbacks</h2>
				</div>

				<div class="outer-box">
					<!-- Testimonial Carousel -->
					<div class="testimonial-carousel owl-carousel owl-theme">
						<!-- Testimonial Block -->
						<div class="testimonial-block">
							<div class="inner-box">
								<div class="content-box">
									<div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-alt"></i></div>
									<div class="text">“Would definitely recommend <?= $company->name ?> and will definitely be using them again and subsequently.</div>
								</div>
								<div class="thumb"><img src="images/resource/testi-thumb-1.jpg" alt="" /></div>
								<h4 class="name">Jhon D. William</h4>
							</div>
						</div>

						<!-- Testimonial Block -->
						<div class="testimonial-block">
							<div class="inner-box">
								<div class="content-box">
									<div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-alt"></i></div>
									<div class="text">“<?= $company->name ?> has really helped our business. Definitely worth the investment. Thank you!</div>
								</div>
								<div class="thumb"><img src="images/resource/testi-thumb-2.jpg" alt="" /></div>
								<h4 class="name">Aleesha Brown</h4>
							</div>
						</div>

						<!-- Testimonial Block -->
						<div class="testimonial-block">
							<div class="inner-box">
								<div class="content-box">
									<div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-alt"></i></div>
									<div class="text">“I highly recommend <?= $company->name ?>. It has been so important for us as we continue to grow our company.</div>
								</div>
								<div class="thumb"><img src="images/resource/testi-thumb-3.jpg" alt="" /></div>
								<h4 class="name">Mike Hardon</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Testimonial Section -->

		<!-- Offer Section -->
		<section class="offer-section">
			<div class="auto-container">
				<div class="row">
					<!-- Content Column -->
					<div class="content-column col-lg-5 col-md-12">
						<div class="inner-column">
							<div class="sec-title light">
								<span class="sub-title">Special Logistics</span>
								<h2>Best services for businesses</h2>
								<div class="text"><?= $company->name ?> has been delivering first-class supply chain solutions for over 40 years..</div>
							</div>
							<ul class="list-style-two">
								<li><i class="fa fa-plane"></i> Urgent transport solutions</li>
								<li><i class="fa fa-plane"></i> Top quality services with reasonable price</li>
								<li><i class="fa fa-plane"></i> Reliable & experienced staffs</li>
							</ul>
						</div>
					</div>

					<!-- Content Column -->
					<div class="image-column col-lg-7 col-md-12 col-sm-12">
						<div class="inner-column">
							<div class="image-box">
								<figure class="image"><img src="images/resource/offer-img-1.jpg" alt="" /></figure>
								<figure class="image"><img src="images/resource/offer-img-2.jpg" alt="" /></figure>
								<div class="fact-counter-one bounce-y">
									<h4 class="counter-title">Trusted by</h4>
									<div class="count-box"><span class="count-text" data-speed="3000" data-stop="4890">0</span></div>
								</div>
								<div class="caption-box wow fadeIn">
									<div class="inner">
										<i class="icon flaticon-logistics-3"></i>
										<h4 class="title">Moving your <br />products across borders</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Offer Section -->

		<!-- Clients Section   -->
		<section class="clients-section">
			<div class="anim-icon">
				<span class="icon dotted-line-1"></span>
				<span class="icon dotted-line-2"></span>
			</div>

			<div class="auto-container">
				<!-- Sponsors Outer -->
				<div class="sponsors-outer">
					<!--clients carousel-->
					<ul class="clients-carousel owl-carousel owl-theme">
						<li class="slide-item">
							<a href="#"><img src="images/clients/1.jpg" alt="" /></a>
						</li>
						<li class="slide-item">
							<a href="#"><img src="images/clients/2.jpg" alt="" /></a>
						</li>
						<li class="slide-item">
							<a href="#"><img src="images/clients/3.jpg" alt="" /></a>
						</li>
						<li class="slide-item">
							<a href="#"><img src="images/clients/4.jpg" alt="" /></a>
						</li>
						<li class="slide-item">
							<a href="#"><img src="images/clients/5.jpg" alt="" /></a>
						</li>
					</ul>
				</div>
			</div>
		</section>
		<!--End Clients Section -->

		<!-- Main Footer -->
		<?php require_once("includes/footer.php") ?>
		<!--End Main Footer -->
	</div>
	<!-- End Page Wrapper -->
	<?php require_once("includes/scripts.php") ?>
	<script src="<?= $uri->backend ?>js/controllers.js"></script>
	<!--  -->
	<script>
		function getreceipt(e, y) {
			e.preventDefault();
			const data = $(y).serializeArray();
			const value = data.map(x => x.value).pop();

			$("#search-inner").load(`${site.domain}invoice?tracking_number=${value}#Waybill`, function(response) {
				$(".main-header").addClass("moblie-search-active");
				$(".close-search").click(() => $(".main-header").removeClass("moblie-search-active"))
			});
		}

		$(document).ready(function() {
			$("#contact-form").submitForm({
				validation: "normal",
				process_url: `${site.process}custom/send-message`,
			})
		})
	</script>
</body>

</html>