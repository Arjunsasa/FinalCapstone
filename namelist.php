<?php
session_start();
// config files //
include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

$pageName = 'Namelist for class';

include "templates/core/header.php";

if (!isLoggedIn()) {
  jsRedirect(SITE_ROOT);
} elseif (!isInstructor()) {
  jsRedirect(SITE_ROOT);
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

if (!isInstructor()){
  jsRedirect(SITE_ROOT . "index.php");
}
?>

<body>
  <?php
  if (!isset($_GET["classID"]) || $_GET["classID"] == "") {
    jsRedirect(SITE_ROOT);
  } else {
    $allClassQuery = DB::query("SELECT * FROM Classes WHERE classID=%i", $_GET["classID"]);
    foreach ($allClassQuery as $allClassResult) {
      $allClassName = $allClassResult["ClassName"];
      $allDateTime = $allClassResult["ClassDateTime"];
      $allClassInfo = $allClassResult["ClassInfo"];
      $allClassStatus = $allClassResult["ClassStatus"];
      $allClassID = $allClassResult["ClassID"];
    }
  }
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
    <!-- main content -->
    <main>

      <!-- Gallery Start -->
      <div class="page-title-container">
        <div class="row">
          <div class="col d-inline-flex">
            <h1 class="mb-5 pb-0 display-4" id="title">Namelist for Class</h1>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- Grid Cards Start -->
        <section class="scroll-section" id="stripedRows">
          <h2 class="small-title"><?php echo $allClassName . " " . $allDateTime; ?></h2>
          <div class="card mb-5">
            <div class="card-body">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Phone No.</th>
                    <th scope="col">Email</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $allNamelistClassQuery = DB::query("SELECT * FROM Booking INNER JOIN User ON Booking.UserID=User.UserID WHERE ClassID=%i", $_GET["classID"]);
                  foreach ($allNamelistClassQuery as $allNamelistClassResult) {
                    $allNamelistUserName = $allNamelistClassResult["UserName"];
                    $allNamelistUserPhone = $allNamelistClassResult["UserPhone"];
                    $allNamelistEmail = $allNamelistClassResult["UserEmail"];
                  ?>
                    <tr>
                      <th scope="row"><?php echo $allNamelistUserName; ?></th>
                      <td><?php echo $allNamelistUserPhone; ?></td>
                      <td><?php echo $allNamelistEmail; ?></td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>
        <!-- Grid Cards End -->
      </div>
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