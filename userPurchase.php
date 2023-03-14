<?php
session_start();
// config files //
include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

$pageName = 'New Booking';

include "templates/core/header.php";

if (!isLoggedIn()) {
  jsRedirect(SITE_ROOT . "login.php");
}

$curSeshQuery = DB::query("SELECT * FROM User WHERE UserEmail=%s", $_SESSION["userEmail"]);
$curStudentSesh = DB::count();
foreach ($curSeshQuery as $getQueryResult) {
  $curSeshID = $getQueryResult["UserID"];
  $curSeshName = $getQueryResult["UserName"];
  $curSeshEmail = $getQueryResult["UserEmail"];
  $curSeshPhone = $getQueryResult["UserPhone"];
  $curSeshIG = $getQueryResult["UserIG"];
  $curSeshBio = $getQueryResult["UserBio"];
  $curSeshPerm = $getQueryResult["UserPermission"];
  $curSeshBal = $getQueryResult["UserPackageBal"];
}
?>

<body>
  <?php
  $today = date("Y/m/d h:i:s A");
  $newPurchaseDateTime = $newPurchaseType = $newPurchaseUserID = $newPurchasePackageID = "";

  if (isset($_POST["makePurchase"])) {
    $newPurchaseDateTime = filterInput($today); //filter the input and grab the name from the input field
    $newPurchasePackageID = filterInput($_POST["choosePackage"]);
    $allSelectedPackageQuery = DB::query("SELECT * FROM Packages WHERE PackageID=%i", $newPurchasePackageID);
    foreach ($allSelectedPackageQuery as $allSelectedPackageResult) {
      $allPurchasePackageName = $allSelectedPackageResult["PackageName"];
      $allPurchasePackageType = $allSelectedPackageResult["PackageType"];
      $allPurchasePackagePrice = $allSelectedPackageResult["PackagePrice"];
    }
    $packageExist = DB::count();
    $newPackagePrice = filterInput($allPurchasePackagePrice);
    $newPurchaseUserID = filterInput($curSeshID);
    $currentBookingPackageBal = filterInput($curSeshBal);
    $newPurchasePackageBal = $currentBookingPackageBal + $allPurchasePackageType;

    if ($newPurchaseDateTime != "" && $newPurchasePackageID != "" && $newPackagePrice != "" && $newPurchaseUserID != "" && $currentBookingPackageBal != "" && $newPurchasePackageBal != "") {
      DB::startTransaction();
      DB::insert('Purchase', [
        'PurchaseDateTime' => $newPurchaseDateTime,
        'PaymentPrice' => $newPackagePrice,
        'UserID' => $newPurchaseUserID,
        'PackageID' => $newPurchasePackageID,
      ]);
      DB::update('User', [
        'UserPackageBal' => $newPurchasePackageBal,
      ], "UserID=%i", $newPurchaseUserID);
      $success = DB::affectedRows();
      if ($success) {
        function_alert("Purchase Made Successfully, page will refresh after awhile...");
        DB::commit();
        header("refresh: 2");
      } else {
        function_alert("Booking Fail");
        DB::rollback();
      }
    } else {
      function_alert("Please select required fields");
    }
  }
  ?>
  <div id="root">
    <div id="nav" class="nav-container d-flex">
      <div class="nav-content d-flex">

        <?php include "templates/core/usernav.php" ?>

      </div>
      <div class="nav-shadow"></div>
    </div>
    <!-- Menu End -->

    <!-- Mobile Buttons Start -->
    <div class="mobile-buttons-container">
      <!-- Scrollspy Mobile Button Start -->
      <a href="#" id="scrollSpyButton" class="spy-button" data-bs-toggle="dropdown">
        <i data-acorn-icon="menu-dropdown"></i>
      </a>
      <!-- Scrollspy Mobile Button End -->

      <!-- Scrollspy Mobile Dropdown Start -->
      <div class="dropdown-menu dropdown-menu-end" id="scrollSpyDropdown"></div>
      <!-- Scrollspy Mobile Dropdown End -->

      <!-- Menu Button Start -->
      <a href="#" id="mobileMenuButton" class="menu-button">
        <i data-acorn-icon="menu"></i>
      </a>
      <!-- Menu Button End -->
    </div>
    <!-- Mobile Buttons End -->
  </div>
  <div class="nav-shadow"></div>
  </div>

  <main>
    <div class="container">
      <div class="row">
        <div class="col">
          <!-- Content Start -->
          <div>

            <body class="h-100">
              <div class="d-flex justify-content-center">
                <div class="col-12 col-lg-auto h-100 pb-4 px-4 pt-0 p-lg-0">
                  <div class="sw-lg-70 min-h-100 bg-foreground d-flex justify-content-center align-items-center shadow-deep py-5 full-page-content-right-border">
                    <div class="sw-lg-50 px-5">
                      <div class="mb-5">
                        <h2 class="cta-1 text-primary">Package Purchase</h2>
                      </div>
                      <div>
                        <form id="userBookingForm" class="tooltip-end-bottom" method="POST" novalidate>
                          <label for="chooseClass" class="mb-2 top-label">Package Selection</label>
                          <div class="mb-5">
                            <select name="choosePackage" class="form-select tooltip-end-top" id="choosePackage">
                              <option>Choose...</option>
                              <?php
                              $allPackageQuery = DB::query("SELECT * FROM Packages WHERE PackageStatus=1");
                              foreach ($allPackageQuery as $allPackageResult) {
                                $allPackageName = $allPackageResult["PackageName"];
                                $allPackageID = $allPackageResult["PackageID"];
                                $allPackageType = $allPackageResult["PackageType"];
                                $allPackagePrice = $allPackageResult["PackagePrice"];
                              ?>
                                <option value="<?php echo $allPackageID; ?>"><?php echo $allPackageName; ?> : $<?php echo $allPackagePrice; ?>, No. of lessons in package: <?php echo $allPackageType; ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                          <button type="submit" name="makePurchase" class="btn btn-lg btn-primary">Make Purchase</button>
                        </form>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </body>
  </main>
  <!-- Content End -->
  <?php include "templates/core/footer.php"; ?>
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
  <?php include "templates/core/globalscripts.php"; ?>
</body>

</html>