<?php
session_start();
// config files //
include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

$pageName = 'Index';

include "templates/core/header.php";

if (!isLoggedIn()) {
  $_SESSION["userPermission"] = "";
  $_SESSION["userEmail"] = "";
}
// form validation //
if (isset($_POST["submit-btn"])) { // when submit button is clicked
  $queryName = filterInput($_POST["queryName"]);
  $queryEmail = filterInput($_POST["queryEmail"]);
  $queryMessage = filterInput($_POST["queryMessage"]);

  if (isBlankField($queryName || $queryEmail || $queryMessage)) {
    jsAlert("Please fill up all fields.");
  } else { //check if name is valid
    if (!isValidName($queryName)) {
      jsAlert("Please enter a name.");
    } else { // check if email is valid
      if (!isValidEmail($queryEmail)) {
        jsAlert("Please enter a valid email.");
      } else {
        jsAlert("Your message has been sent!");
        jsRedirect(SITE_ROOT . "index.php");
      }
    }
  }
}

$curSeshQuery = DB::query("SELECT * FROM User WHERE UserEmail=%s", $_SESSION["userEmail"]);
$curStudentSesh = DB::count();
foreach ($curSeshQuery as $getQueryResult) {
  $curSeshName = $getQueryResult["UserName"];
  $curSeshEmail = $getQueryResult["UserEmail"];
  $curSeshPhone = $getQueryResult["UserPhone"];
  $curSeshIG = $getQueryResult["UserIG"];
  $curSeshBio = $getQueryResult["UserBio"];
  $curSeshBal = $getQueryResult["UserPackageBal"];
  $curSeshPerm = $getQueryResult["UserPermission"];
  $curSeshID = $getQueryResult["UserID"];
}

?>

<body>
  <?php

  ?>
  <div id="root">
    <div id="nav" class="nav-container d-flex">
      <div class="nav-content d-flex">

        <?php if ($_SESSION["userPermission"] == 1 || $_SESSION["userPermission"] == 2) {
          include "templates/core/usernav.php";
        } elseif ($_SESSION["userPermission"] == 3) {
          include "templates/core/adminNav.php";
        } else {
          include "templates/core/navbar.php";
        } ?>

      </div>
      <div class="nav-shadow"></div>
    </div>

    <main>
      <div class="container">
        <!-- Gallery Start -->
        <section class="scroll-section" id="gallery">
          <h2 class="small-title">Announcements</h2>
          <div class="row">
            <div class="col-12">
              <div class="glide" id="glideGallery">
                <!-- Large Images Start -->
                <div class="glide glide-large shadow rounded mb-4">
                  <div class="glide__track mb-0" data-glide-el="track">
                    <ul class="glide__slides gallery-glide-custom mb-0">
                      <li class="glide__slide p-0">
                        <a href="library/img/product/carousel1.jpg">
                          <img alt="detail" src="library/img/product/carousel1.jpg" class="responsive border-0 rounded img-fluid sh-50 w-100" />
                        </a>
                      </li>
                      <li class="glide__slide p-0">
                        <a href="library/img/product/carousel2.jpg">
                          <img alt="detail" src="library/img/product/carousel2.jpg" class="responsive border-0 rounded img-fluid sh-50 w-100" />
                        </a>
                      </li>
                      <li class="glide__slide p-0">
                        <a href="library/img/product/carousel3.jpg">
                          <img alt="detail" src="library/img/product/carousel3.jpg" class="responsive border-0 rounded img-fluid sh-50 w-100" />
                        </a>
                      </li>
                      <li class="glide__slide p-0">
                        <a href="library/img/product/carousel4.jpg">
                          <img alt="detail" src="library/img/product/carousel4.jpg" class="responsive border-0 rounded img-fluid sh-50 w-100" />
                        </a>
                      </li>
                      <li class="glide__slide p-0">
                        <a href="library/img/product/carousel5.jpg">
                          <img alt="detail" src="library/img/product/carousel5.jpg" class="responsive border-0 rounded img-fluid sh-50 w-100" />
                        </a>
                      </li>
                      <li class="glide__slide p-0">
                        <a href="library/img/product/carousel6.jpg">
                          <img alt="detail" src="library/img/product/carousel6.jpg" class="responsive border-0 rounded img-fluid sh-50 w-100" />
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- Large Images End -->
                <!-- Thumbs Start -->
                <div class="glide glide-thumb mb-3">
                  <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                      <li class="glide__slide p-0">
                        <img alt="thumb" src="library/img/product/small/carousel1.jpg" class="responsive rounded-md img-fluid shadow" />
                      </li>
                      <li class="glide__slide p-0">
                        <img alt="thumb" src="library/img/product/small/carousel2.jpg" class="responsive rounded-md img-fluid shadow" />
                      </li>
                      <li class="glide__slide p-0">
                        <img alt="thumb" src="library/img/product/small/carousel3.jpg" class="responsive rounded-md img-fluid shadow" />
                      </li>
                      <li class="glide__slide p-0">
                        <img alt="thumb" src="library/img/product/small/carousel4.jpg" class="responsive rounded-md img-fluid shadow" />
                      </li>
                      <li class="glide__slide p-0">
                        <img alt="thumb" src="library/img/product/small/carousel5.jpg" class="responsive rounded-md img-fluid shadow" />
                      </li>
                      <li class="glide__slide p-0">
                        <img alt="thumb" src="library/img/product/small/carousel6.jpg" class="responsive rounded-md img-fluid shadow" />
                      </li>
                    </ul>
                  </div>
                  <div class="glide__arrows" data-glide-el="controls">
                    <button class="btn btn-icon btn-icon-only btn-foreground-alternate shadow left-arrow" data-glide-dir="<">
                      <i data-acorn-icon="chevron-left"></i>
                    </button>
                    <button class="btn btn-icon btn-icon-only btn-foreground-alternate shadow right-arrow" data-glide-dir=">">
                      <i data-acorn-icon="chevron-right"></i>
                    </button>
                  </div>
                </div>
                <!-- Thumbs End -->
              </div>
            </div>
          </div>
        </section>
        <!-- Gallery End -->

        <!-- Banners Start -->
        <h2 class="small-title">Shortcuts</h2>
        <div class="row">
          <div class="col-12 col-md-4 mb-5">
            <div class="card w-100 sh-18 sh-md-22 hover-img-scale-up">
              <img src="library/img/product/classesThumbnail.jpg" class="card-img h-100 scale" alt="card image" />
              <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                <div class="d-flex flex-column h-100 justify-content-between align-items-start">
                  <div class="cta-3 text-black">
                    Classes we
                    <br />
                    Offer
                  </div>
                  <a href="<?php SITE_ROOT ?>classes.php" class="btn btn-icon btn-icon-start btn-primary stretched-link">
                    <i data-acorn-icon="chevron-right"></i>
                    <span>View</span>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-4 mb-5">
            <div class="card w-100 sh-18 sh-md-22 hover-img-scale-up">
              <img src="library/img/product/InThumb.jpg" class="card-img h-100 scale" alt="card image" />
              <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                <div class="d-flex flex-column h-100 justify-content-between align-items-start">
                  <div class="cta-3 text-white">
                    Our Instructors
                    <br />
                  </div>
                  <a href="<?php SITE_ROOT ?>instructors.php" class="btn btn-icon btn-icon-start btn-primary stretched-link">
                    <i data-acorn-icon="chevron-right"></i>
                    <span>View</span>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-4 mb-5">
            <div class="card w-100 sh-18 sh-md-22 hover-img-scale-up">
              <img src="library/img/product/carousel5.jpg" class="card-img h-100 scale" alt="card image" />
              <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                <div class="d-flex flex-column h-100 justify-content-between align-items-start">
                  <div class="cta-3 text-white">
                    Buy a Package
                    <br />
                  </div>
                  <a href="<?php SITE_ROOT ?>userPurchase.php" class="btn btn-icon btn-icon-start btn-primary stretched-link">
                    <i data-acorn-icon="chevron-right"></i>
                    <span>View</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Banners End -->

        <div class="row gy-5">
          <!-- Help Start -->
          <div class="col-12 col-xl-4">
            <h2 class="small-title">Contact Us</h2>
            <div class="card h-100-card">
              <div class="card-body small">
                <p class="mb-2 cta-3 text-primary">Call/Text us: <span class="text-muted mb-4">+65 90123455</span></p>
                <p class="mb-2 cta-3 text-primary">Email us: <span class="text-muted mb-4">info@classbooking.com</span></p>
                <div class="mb-2 cta-3 text-primary">Locate us:</div>
                <p class="text-muted mb-4">144 Robinson Road, #05-02 S(123456)</p>

                <!-- Enquiry form -->
                <div class="mb-2 cta-3 text-primary small">Need more help?
                  <p class="text-muted mb-4 small">Write to us and we'll back to you asap!</p>
                  <form method="POST" class="small">
                    <div class="mb-2 small">
                      <label class="form-label">Name</label>
                      <input type="text" class="form-control" name="queryName" />
                    </div>
                    <div class="mb-2 small">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control" name="queryEmail" />
                    </div>
                    <div class="mb-2 small">
                      <label class="form-label">Message</label>
                      <textarea placeholder="Type here" class="form-control" name="queryMessage" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" name="submit">Submit</button>
                  </form>
                  <!-- Enquiry form end -->

                </div>

              </div>
            </div>
          </div>
          <!-- Help End -->

          <!-- Video Guide Start -->
          <div class="col-12 col-xl-8">
            <h2 class="small-title">Video Guide</h2>
            <div class="card h-100-card sh-md-45 bg-transparent">
              <div class="iframe-container">
                <iframe width="854" height="480" src="https://www.youtube.com/embed/37HL5ZhvrlM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
              </div>

            </div>
          </div>
          <!-- Video Guide End -->
        </div>
      </div>
    </main>
    <!-- Layout Footer Start -->
    <?php include "templates/core/footer.php"; ?>
    <!-- Layout Footer End -->
  </div>

  <!-- Theme Settings Modal Start -->
  <?php include "templates/core/thememodel.php"; ?>
  <!-- Theme Settings Modal End -->

  <!-- Niches Modal Start -->
  <?php include "templates/core/niches.php"; ?>
  <!-- Niches Modal End -->

  <!-- Theme Settings & Niches Buttons Start -->
  <?php include "templates/core/themebuttons.php"; ?>
  <!-- Theme Settings & Niches Buttons End -->

  <!-- Search Modal Start -->
  <?php include "templates/core/searchmodal.php"; ?>
  <!-- Search Modal End -->
  <?php include "templates/core/globalScripts.php"; ?>
</body>

</html>