<footer class="main-footer">
  <div class="bg-image" style="background-image: url(images/background/5.jpg)"></div>
  <div class="anim-icons">
    <span class="icon icon-plane-3 bounce-x"></span>
  </div>

  <!-- Contact info -->
  <div class="contacts-outer">
    <div class="auto-container">
      <div class="row">
        <!-- Contact Info Block -->
        <div class="contact-info-block col-lg-4 col-md-6 col-sm-12 wow fadeInRight">
          <div class="inner-box">
            <div class="icon-box"><i class="icon flaticon-international-shipping-2"></i></div>
            <h4 class="title">Address</h4>
            <div class="text"><?= $company->address ?></div>
          </div>
        </div>

        <!-- Contact Info Block -->
        <div class="contact-info-block col-lg-4 col-md-6 col-sm-12 wow fadeInRight" data-wow-delay="300ms">
          <div class="inner-box">
            <div class="icon-box"><i class="icon flaticon-stock-1"></i></div>
            <h4 class="title">Contact</h4>
            <div class="text">
              <a href="mailto:<?= $company->email ?>"><?= $company->email ?></a>
              <a href="tel:<?= $company->phone ?>"><?= $company->phone ?></a>
            </div>
          </div>
        </div>

        <!-- Contact Info Block -->
        <div class="contact-info-block col-lg-4 col-md-6 col-sm-12 wow fadeInRight" data-wow-delay="600ms">
          <div class="inner-box">
            <div class="icon-box"><i class="icon flaticon-24-hours-2"></i></div>
            <h4 class="title">Timing</h4>
            <div class="text">Mon - Sat: 8 am - 5 pm, Sunday: CLOSED</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Contact info -->

  <!--Widgets Section-->
  <div class="widgets-section">
    <div class="auto-container">
      <div class="row">
        <!--Footer Column-->
        <div class="footer-column col-xl-5 col-lg-12 col-md-6 col-sm-12">
          <div class="footer-widget about-widget">
            <div class="logo">
              <a href="index.html"><img src="images/logos-air7seas/air7seaslogo-white.png" alt="" /></a>
            </div>
            <div class="text"><?= $company->name ?> has a global network with distribution centres around the world to meet the warehousing and distribution requirements of various industries. The following locations demonstrate the storage capabilities of <?= $company->name ?> both domestically and internationally.</div>
            <a href="#contact" class="theme-btn btn-style-one hvr-light small"><span class="btn-title">Reach out to us</span></a>
          </div>
        </div>

        <!--Footer Column-->
        <div class="footer-column col-xl-3 col-lg-3 col-md-6 col-sm-12">
          <div class="footer-widget">
            <h3 class="widget-title">Service</h3>
            <ul class="user-links">
              <li><a href="#">Air Frieght</a></li>
              <li><a href="#">Sea Frieght</a></li>
              <li><a href="#">Road Dispatch</a></li>
              <li><a href="#">Warehouse Management</a></li>

            </ul>
          </div>
        </div>




      </div>
    </div>
  </div>

  <!--Footer Bottom-->
  <div class="footer-bottom">
    <div class="auto-container">
      <div class="inner-container">
        <div class="copyright-text">
          <p>&copy; Copyright 2022 by <a href="#"><?= $company->name ?></a></p>
        </div>

        <ul class="social-icon-two">
          <?php foreach ($company->branches as $key => $value) { ?>
            <li>
              <a href="<?= $value->desc ?>"><span class="fab fa-<?= strtolower($value->title) ?>"></span></a>
            </li>
          <?php  } ?>

        </ul>
      </div>
    </div>
  </div>
</footer>