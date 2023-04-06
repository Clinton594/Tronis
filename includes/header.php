	<!-- Preloader -->
	<div class="preloader"></div>

	<!-- Main Header-->
	<header id="home" class="main-header header-style-one">
		<div class="search-popup">
			<span class="search-back-drop"></span>
			<button class="close-search"><span class="fa fa-times"></span></button>

			<div id="search-inner" class="search-inner">

			</div>
		</div>
		<!-- Header Top -->
		<div class="header-top">
			<div class="top-left">
				<!-- Info List -->
				<ul class="list-style-one">
					<li><i class="fa fa-map-marker-alt"></i> <?= $company->address ?></li>
					<li><i class="fa fa-clock"></i> Mon - Sat: 8am - 5pm</li>
					<li><i class="fa fa-phone-volume"></i> <a href="tel:+92(8800)87890"><?= $company->phone ?></a></li>
				</ul>
			</div>

			<div class="top-right">
				<ul class="social-icon-one">
					<?php foreach ($company->branches as $key => $value) { ?>
						<li>
							<a href="<?= $value->desc ?>"><span class="fab fa-<?= strtolower($value->title) ?>"></span></a>
						</li>
					<?php  } ?>
				</ul>
			</div>
		</div>
		<!-- Header Top -->

		<!-- Header Lower -->
		<div class="header-lower">
			<!-- Main box -->
			<div class="main-box">
				<div class="logo-box">
					<div class="logo">
						<a href="<?= $uri->site ?>"><img src="<?= $company->logo_ref ?>" alt="" title="Tronis" /></a>
					</div>
				</div>

				<!--Nav Box-->
				<div class="nav-outer">
					<nav class="nav main-menu">
						<ul class="navigation">
							<li class="current"><a href="#home">Home</a></li>
							<li><a href="#about">About</a></li>
							<li><a href="#tracking">Tracking</a></li>
							<li><a href="#services">Services</a></li>
							<li><a href="#contact">Contact</a></li>
						</ul>
					</nav>
					<!-- Main Menu End-->

					<div class="outer-box">


						<a href="#contact" class="theme-btn d-block btn-style-one alternate"><span class="btn-title">Send a Message</span></a>


						<!-- Mobile Nav toggler -->
						<div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Header Lower -->

		<!-- Mobile Menu  -->
		<div class="mobile-menu">
			<div class="menu-backdrop"></div>

			<!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
			<nav class="menu-box">
				<div class="upper-box">
					<div class="nav-logo">
						<a href="index.html"><img src="<?= $company->logo_ref ?>" alt="" title="Fesho" /></a>
					</div>
					<div class="close-btn"><i class="icon fa fa-times"></i></div>
				</div>

				<ul class="navigation clearfix">
					<!--Keep This Empty / Menu will come through Javascript-->
				</ul>
				<ul class="contact-list-one">
					<li>
						<!-- Contact Info Box -->
						<div class="contact-info-box">
							<i class="icon lnr-icon-phone-handset"></i>
							<span class="title">Call Now</span>
							<a href="tel:+92880098670"><?= $company->phone ?></a>
						</div>
					</li>
					<li>
						<!-- Contact Info Box -->
						<div class="contact-info-box">
							<span class="icon lnr-icon-envelope1"></span>
							<span class="title">Send Email</span>
							<a href="mailto:<?= $company->email ?>"><?= $company->email ?></a>
						</div>
					</li>
					<li>
						<!-- Contact Info Box -->
						<div class="contact-info-box">
							<span class="icon lnr-icon-clock"></span>
							<span class="title">Send Email</span>
							Mon - Sat 8:00 - 6:30, Sunday - CLOSED
						</div>
					</li>
				</ul>

				<ul class="social-links">
					<?php foreach ($company->branches as $key => $value) { ?>
						<li>
							<a href="<?= $value->desc ?>"><span class="fab fa-<?= strtolower($value->title) ?>"></span></a>
						</li>
					<?php  } ?>
				</ul>
			</nav>
		</div>
		<!-- End Mobile Menu -->


		<!-- End Header Search -->

		<!-- Sticky Header  -->
		<div class="sticky-header">
			<div class="auto-container">
				<div class="inner-container">
					<!--Logo-->
					<div class="logo">
						<a href="<?= $uri->site ?>" title=""><img src="<?= $company->logo_ref ?>" alt="" title="" /></a>
					</div>

					<!--Right Col-->
					<div class="nav-outer">
						<!-- Main Menu -->
						<nav class="main-menu">
							<div class="navbar-collapse show collapse clearfix">
								<ul class="navigation clearfix">
									<!--Keep This Empty / Menu will come through Javascript-->
								</ul>
							</div>
						</nav>
						<!-- Main Menu End-->

						<!--Mobile Navigation Toggler-->
						<div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Sticky Menu -->
	</header>
	<!--End Main Header -->