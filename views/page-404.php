<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Not Found </title>
	<?php require_once("includes/links.php") ?>
</head>


<body>

	<div class="page-wrapper">

		<!-- Preloader -->
		<div class="preloader"></div>

		<!-- 404 Section -->
		<section class="">
			<div class="auto-container pt-120 pb-70">
				<div class="row">
					<div class="col-xl-12">
						<div class="error-page__inner">
							<div class="error-page__title-box">
								<img src="<?= $uri->site ?>images/resource/404.jpg" alt="">
								<h3 class="error-page__sub-title">Page not found!</h3>
							</div>
							<p class="error-page__text">Sorry we can't find that page! The page you are looking <br> for
								was never existed.</p>
							<a href="<?= $uri->site ?>" class="theme-btn btn-style-one shop-now"><span class="btn-title">Back to Home</span></a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--End 404 Section -->

	</div><!-- End Page Wrapper -->


	<!-- Scroll To Top -->
	<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>

	<?php require_once("includes/scripts.php") ?>
</body>


</html>