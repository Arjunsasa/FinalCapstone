<?php
session_start();
// config files //
include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

$pageName = 'Admin | Edit Packages';

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
  $editPackageName = $editPackageType = $editPackagePrice = $editPackageStatus = "";

  if (!isset($_GET["packageID"]) || $_GET["packageID"] == "") {
    jsRedirect(SITE_ROOT . "admin.php");
  } else {
    $getPackageQuery = DB::query("SELECT * FROM Packages WHERE PackageID=%i", $_GET["packageID"]);
    foreach ($getPackageQuery as $getPackageResult) {
      $packageDBID = $getPackageResult["PackageID"];
      $packageDBName = $getPackageResult["PackageName"];
      $packageDBType = $getPackageResult["PackageType"];
      $packageDBPrice = $getPackageResult["PackagePrice"];
      $packageDBStatus = $getPackageResult["PackageStatus"];
    }
  }

  if (isset($_POST["editPackage"])) {
    $editPackageName = filterInput($_POST["packageName"]); //filter the input and grab the name from the input field
    $editPackageType = filterInput($_POST["packageType"]);
    $editPackagePrice = filterInput($_POST["packagePrice"]);
    $editPackageStatus = filterInput($_POST["packageStatus"]);

    if ($editPackageName != "" && $editPackageType != "" && $editPackagePrice != "" && $editPackageStatus != "") {
      if (isValidTitle($editPackageName)) {
        if (isValidStatus($editPackageStatus)) {
          if (isValidPrice($editPackagePrice)) {
            DB::startTransaction();
            DB::update('Packages', [
              'PackageName' => $editPackageName,
              'PackageType' => $editPackageType,
              'PackagePrice' => $editPackagePrice,
              'PackageStatus' => $editPackageStatus
            ], "PackageID=%i", $_GET["packageID"]);
            $success = DB::affectedRows();
            if ($success) {
              function_alert("Package edited");
              DB::commit();
            } else {
              function_alert("Insert Fail");
              DB::rollback();
            }
          } else {
            function_alert("please Enter a price below $1000.00");
          }
        } else {
          function_alert("please select a valid status for the package");
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
            <div>

              <body class="h-100">
                <div class="d-flex justify-content-center">
                  <div class="col-12 col-lg-auto h-100 pb-4 px-4 pt-0 p-lg-0">
                    <div class="sw-lg-70 min-h-100 bg-foreground d-flex justify-content-center align-items-center shadow-deep py-5 full-page-content-right-border">
                      <div class="sw-lg-50 px-5">
                        <div class="mb-5">
                          <h2 class="cta-1 text-primary">Edit Package</h2>
                        </div>
                        <div>
                          <form id="registerForm" method="POST" class="tooltip-end-bottom" novalidate>
                            <div class="mb-3 filled form-group tooltip-end-top">
                              <input class="form-control" placeholder="Name your Package e.g: value bundle" name="packageName" value="<?php echo $packageDBName; ?>" />
                            </div>
                            <div class="mb-3 filled form-group tooltip-end-top">
                              <input class="form-control" placeholder="No: of classes in a bundle" name="packageType" value="<?php echo $packageDBType; ?>" />
                            </div>
                            <div class="mb-3 filled form-group tooltip-end-top">
                              <input class="form-control" placeholder="Price of bundle" name="packagePrice" value="<?php echo $packageDBPrice; ?>" />
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="packageStatus" id="gridRadios1" value="1" checked />
                              <label class="form-check-label" for="gridRadios1">Keep Active</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="packageStatus" id="gridRadios2" value="0" />
                              <label class="form-check-label" for="gridRadios2">Deactivate</label>
                            </div>
                            <button type="submit" name="editPackage" class="btn btn-lg btn-primary">Save Changes</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </body>
              <!-- Content End -->
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