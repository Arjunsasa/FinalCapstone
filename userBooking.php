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
  $newBookingDateTime = $newBookingStatus = $newBookingClassID = $newBookingClassUser = "";

  if (isset($_POST["bookClass"])) {
    $newBookingDateTime = filterInput($today); //filter the input and grab the name from the input field
    $newBookingStatus = filterInput($_POST["bookingStatus"]);
    $newBookingClassID = filterInput($_POST["chooseClass"]);
    $newBookingClassUser = filterInput($curSeshID);
    $currentBookingPackageBal = filterInput($curSeshBal);
    $newBookingPackageBal = --$currentBookingPackageBal;

    if ($newBookingDateTime != "" && $newBookingStatus != "" && $newBookingClassID != "" && $newBookingClassUser != "") {
      if ($newBookingPackageBal >= "0") {
        if ($newBookingStatus == "2") {
          DB::startTransaction();
          DB::insert('Booking', [
            'BookingDateTime' => $newBookingDateTime,
            'BookingStatus' => $newBookingStatus,
            'UserID' => $newBookingClassUser,
            'ClassID' => $newBookingClassID,
          ]);
          $success = DB::affectedRows();
          if ($success) {
            function_alert("Booking Made Successfully, page will refresh after awhile...");
            DB::commit();
            header("refresh: 2");
          } else {
            function_alert("Booking Fail");
            DB::rollback();
          }
        } elseif ($newBookingStatus == "1") {
          DB::startTransaction();
          DB::insert('Booking', [
            'BookingDateTime' => $newBookingDateTime,
            'BookingStatus' => $newBookingStatus,
            'UserID' => $newBookingClassUser,
            'ClassID' => $newBookingClassID,
          ]);
          DB::update('User', [
            'UserPackageBal' => $newBookingPackageBal,
          ], "UserID=%i", $newBookingClassUser);
          $success = DB::affectedRows();
          if ($success) {
            function_alert("Booking Made Successfully, page will refresh after awhile...");
            DB::commit();
            header("refresh: 2");
          } else {
            function_alert("Booking Fail");
            DB::rollback();
          }
        } else {
          function_alert("Please select mode of payment");
        }
      } else {
        function_alert("Insufficient package credit");
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
                          <h2 class="cta-1 text-primary">New Booking</h2>
                        </div>
                        <div>
                          <form id="userBookingForm" class="tooltip-end-bottom" method="POST" novalidate>
                            <label for="chooseClass" class="mb-2 top-label">Class</label>
                            <div class="mb-2">
                              <select name="chooseClass" class="form-select tooltip-end-top" id="chooseClass">
                                <option>Choose...</option>
                                <?php
                                $allClassQuery = DB::query("SELECT * FROM Classes");
                                foreach ($allClassQuery as $allClassResult) {
                                  $allClassName = $allClassResult["ClassName"];
                                  $allClassID = $allClassResult["ClassID"];
                                  $allDateTime = $allClassResult["ClassDateTime"];
                                  $allClassInfo = $allClassResult["ClassInfo"];
                                  $allClassStatus = $allClassResult["ClassStatus"];
                                  $allClassUserID = $allClassResult["ClassID"];
                                ?>
                                  <option value="<?php echo $allClassID; ?>"><?php echo $allClassName; ?></option>
                                <?php
                                }
                                ?>
                              </select>
                            </div>
                            <div class="form-check mb-2">
                              <input class="form-check-input" type="radio" name="bookingStatus" id="gridRadios1" value="2" checked />
                              <label class="form-check-label" for="gridRadios1">Pay $18/class</label>
                            </div>
                            <div class="form-check mb-4">
                              <input class="form-check-input" type="radio" name="bookingStatus" id="gridRadios2" value="1" />
                              <label class="form-check-label" for="gridRadios2">Use existing package </label>
                            </div>
                            <button type="submit" name="bookClass" class="btn btn-lg btn-primary">Make Booking</button>
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