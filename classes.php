<?php
session_start();
// config files //
include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

$pageName = 'Classes';

include "templates/core/header.php";

if (!isLoggedIn()) {
  $_SESSION["userPermission"] = "";
  $_SESSION["userEmail"] = "";
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
    <!-- main content -->
    <main>
      <!-- Gallery Start -->
      <div class="page-title-container">
        <div class="row">

          <div class="col d-inline-flex">
            <h1 class="mb-5 pb-0 display-4" id="title">Classes</h1>
          </div>

          <div class="col d-inline-flex flex-row-reverse">
            <a href="<?php SITE_ROOT ?>userBooking.php"><button class="btn btn-primary btn-sm mb-4">Book a Class <i class="bi bi-hand-index"></i></button></a>
          </div>

        </div>
      </div>
      <!-- Grid Cards Start -->

      <section class="scroll-section" id="gridCards">
        <div class="mb-5">

          <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-4 justify-content-center">
            <?php
            $allClassQuery = DB::query("SELECT * FROM Classes INNER JOIN User on Classes.UserID=User.UserID");
            foreach ($allClassQuery as $allClassResult) {
              $allClassName = $allClassResult["ClassName"];
              $allDateTime = $allClassResult["ClassDateTime"];
              $allInstructorName = $allClassResult["UserName"];
              $allClassInfo = $allClassResult["ClassInfo"];
              $allClassStatus = $allClassResult["ClassStatus"];
              $allClassID = $allClassResult["ClassID"];
            ?>

              <div class="col <?php if ($allClassStatus == 0) {
                                echo 'emptyCard';
                              } ?>">
                <div class="card h-80">
                  <img src="library/img/product/hiphop.jpg" class="card-img-top" alt="image" />
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $allClassName; ?></h5>
                    <p class="card-text">
                      <?php echo $allClassInfo; ?>
                    </p>
                    <p class="card-text">
                      <?php echo $allDateTime; ?>
                    </p>
                    <p class="card-text">
                      Taught by:
                      <?php echo $allInstructorName; ?>
                    </p>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      </section>
      <!-- Grid Cards End -->

      <!-- Gallery End -->


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