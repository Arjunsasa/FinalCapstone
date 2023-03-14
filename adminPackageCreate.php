<?php
session_start();
// config files //
include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

$pageName = 'Admin | Create Packages';

include "templates/core/header.php";

if (!isLoggedIn()) {
  jsRedirect(SITE_ROOT . "index.php");
}

if (!isAdmin()){
  jsRedirect(SITE_ROOT . "index.php");
}

?>

<body>
  <?php
  $newPackageName = $newPackageType = $newPackagePrice = "";

  if (isset($_POST["create"])) {
    $newPackageName = filterInput($_POST["packageName"]); //filter the input and grab the name from the input field
    $newPackageType = filterInput($_POST["packageType"]);
    $newPackagePrice = filterInput($_POST["packagePrice"]);

    if ($newPackageName != "" && $newPackageType != "" && $newPackagePrice != "") {
      if (isValidTitle($newPackageName)) {
        if (isValidPrice($newPackagePrice)) {
          DB::startTransaction();
          DB::insert('Packages', [
            'PackageName' => $newPackageName,
            'PackageType' => $newPackageType,
            'PackagePrice' => $newPackagePrice
          ]);
          $success = DB::affectedRows();
          if ($success) {
            function_alert("Package created");
            DB::commit();
          } else {
            function_alert("Insert Fail");
            DB::rollback();
          }
        } else {
          function_alert("please enter a price below $1000.00");
        }
      } else {
        function_alert("please enter valid name");
      }
    } else {
      function_alert("Please fill up required fields");
    }
  }
  ?>
  <div id="root">
    <div id="nav" class="nav-container d-flex">
      <div class="nav-content d-flex">

        <?php include "templates/core/adminNav.php"; ?>

      </div>
      <div class="nav-shadow"></div>
    </div>

    <main>
      <div class="container">
        <div class="row">
          <div class="col">
            <!-- Content Start -->

            <body class="h-100">
              <div class="d-flex justify-content-center">
                <div class="col-12 col-lg-auto h-100 pb-4 px-4 pt-0 p-lg-0">
                  <div class="sw-lg-70 min-h-100 bg-foreground d-flex justify-content-center align-items-center shadow-deep py-5 full-page-content-right-border">
                    <div class="sw-lg-50 px-5">
                      <div class="mb-5">
                        <h2 class="cta-1 text-primary">Create Package</h2>
                      </div>
                      <div>
                        <form id="registerForm" class="tooltip-end-bottom" method="POST" novalidate>
                          <div class="mb-3 filled form-group tooltip-end-top">
                            <input class="form-control" placeholder="Name your Package e.g: value bundle" name="packageName" />
                          </div>
                          <div class="mb-3 filled form-group tooltip-end-top">
                            <input class="form-control" placeholder="No: of classes in a bundle" name="packageType" />
                          </div>
                          <div class="mb-3 filled form-group tooltip-end-top">
                            <input class="form-control" placeholder="Price of bundle" name="packagePrice" />
                          </div>
                          <button type="submit" name="create" class="btn btn-lg btn-primary">Create Package</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </body>
            <!-- Content End -->
          </div>
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