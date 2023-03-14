<?php
session_start();
// config files //
include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

$pageName = 'Admin | Create A Class';

include "templates/core/header.php";

if (!isLoggedIn()) {
  jsRedirect(SITE_ROOT . "index.php");
}

if (!isAdmin()) {
  jsRedirect(SITE_ROOT . "index.php");
}
?>

<body>
  <?php
  $newClassName = $newClassInfo = $newClassDateTime = $newClassInstructor = "";


  if (isset($_POST["createClass"])) {
    $allUserQuery = DB::query("SELECT UserName, UserPermission, UserID FROM User WHERE UserName=%s", $_POST["classInstructor"]);
    foreach ($allUserQuery as $allUserResult) {
      $allUserPermission = $allUserResult["UserPermission"];
      $allUserName = $allUserResult["UserName"];
      $allUserID = $allUserResult["UserID"];
    }

    $newClassName = filterInput($_POST["className"]); //filter the input and grab the name from the input field
    $newClassInfo = filterInput($_POST["classInfo"]);
    $newClassDateTime = filterInput($_POST["classDateTime"]);
    $newClassInstructor = filterInput($allUserName);

    if ($newClassName != "" && $newClassInfo != "" && $newClassDateTime != "" && $newClassInstructor != "") {
      if (isValidTitle($newClassName)) {
        if ($allUserPermission == 2) {
          DB::startTransaction();
          DB::insert('Classes', [
            'ClassName' => $newClassName,
            'ClassInfo' => $newClassInfo,
            'ClassDateTime' => $newClassDateTime,
            'UserID' => $allUserID,
          ]);
          $success = DB::affectedRows();
          if ($success) {
            function_alert("Class created");
            DB::commit();
          } else {
            function_alert("Insert Fail");
            DB::rollback();
          }
        } else {
          function_alert("please enter an existing instructor");
        }
      } else {
        function_alert("please enter valid Title");
      }
    } else {
      function_alert("Please fill up required fields");
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
                            <input class="form-control" placeholder="Name your Class e.g: Hip Hop" name="className" />
                          </div>
                          <div class="mb-3 filled form-group tooltip-end-top">
                            <input class="form-control" placeholder="Short description of class" name="classInfo" />
                          </div>
                          <div class="mb-3 filled form-group tooltip-end-top">
                            <input class="form-control" type="datetime-local" placeholder="Date and time of class" name="classDateTime" />
                          </div>
                          <div class="mb-3 filled form-group tooltip-end-top">
                            <input class="form-control" placeholder="Class instructor" name="classInstructor" />
                          </div>
                          <button type="submit" name="createClass" class="btn btn-lg btn-primary">Create Class</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

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