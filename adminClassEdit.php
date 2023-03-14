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

if (!isAdmin()){
  jsRedirect(SITE_ROOT . "index.php");
}
?>

<body>
  <?php
  $editClassName = $editClassInfo = $editClassDateTime = $editClassInstructor = $editClassStatus = "";

  if (!isset($_GET["classID"]) || $_GET["classID"] == "") {
    jsRedirect(SITE_ROOT . "admin.php");
  } else {
    $getClassQuery = DB::query("SELECT * FROM Classes WHERE ClassID=%i", $_GET["classID"]);
    foreach ($getClassQuery as $getClassResult) {
      $classDBName = $getClassResult["ClassName"];
      $classDBInfo = $getClassResult["ClassInfo"];
      $classDBDateTime = $getClassResult["ClassDateTime"];
      $classDBStatus = $getClassResult["ClassStatus"];
      $classDBUserID = $getClassResult["UserID"];
    }
    $allUserQuery = DB::query("SELECT UserName, UserPermission, UserID FROM User WHERE UserID=%s", $classDBUserID);
    foreach ($allUserQuery as $allUserResult) {
      $allUserPermission = $allUserResult["UserPermission"];
      $allUserName = $allUserResult["UserName"];
      $allUserID = $allUserResult["UserID"];
    }
  }

  if (isset($_POST["editClass"])) {
    $allEditUserQuery = DB::query("SELECT UserName, UserPermission, UserID FROM User WHERE UserName=%s", $_POST["classInstructor"]);
    foreach ($allEditUserQuery as $allEditUserResult) {
      $allEditUserPermission = $allEditUserResult["UserPermission"];
      $allEditUserName = $allEditUserResult["UserName"];
      $allEditUserID = $allEditUserResult["UserID"];
    }

    $editClassName = filterInput($_POST["className"]); //filter the input and grab the name from the input field
    $editClassInfo = filterInput($_POST["classInfo"]);
    $editClassDateTime = filterInput($_POST["classDateTime"]);
    $editClassInstructor = filterInput($allEditUserName);
    $editClassStatus = filterInput($_POST["updateStatus"]);

    if ($editClassName != "" && $editClassInfo != "" && $editClassDateTime != "" && $editClassInstructor != "" && $editClassStatus != "") {
      if (isValidTitle($editClassName)) {
        if ($allEditUserPermission == 2) {
          if (isValidStatus($editClassName)) {
            DB::startTransaction();
            DB::update('Classes', [
              'ClassName' => $editClassName,
              'ClassInfo' => $editClassInfo,
              'ClassDateTime' => $editClassDateTime,
              'UserID' => $allEditUserID,
              'ClassStatus' => $editClassStatus
            ], "ClassID=%i", $_GET["classID"]);
            $success = DB::affectedRows();
            if ($success) {
              function_alert("Class Changes Made Successfully");
              DB::commit();
            } else {
              function_alert("Insert Fail");
              DB::rollback();
            }
          } else {
            function_alert("please select valid status");
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
                        <h2 class="cta-1 text-primary">Edit Class</h2>
                      </div>
                      <div>
                        <form id="registerForm" class="tooltip-end-bottom" method="POST" novalidate>
                          <div class="mb-3 filled form-group tooltip-end-top">
                            <input class="form-control" placeholder="Name your Class e.g: Hip Hop" name="className" value="<?php echo $classDBName; ?>" />
                          </div>
                          <div class="mb-3 filled form-group tooltip-end-top">
                            <input class="form-control" placeholder="Short description of class" name="classInfo" value="<?php echo $classDBInfo; ?>" />
                          </div>
                          <div class="mb-3 filled form-group tooltip-end-top">
                            <input class="form-control" type="datetime-local" placeholder="Date and time of class" name="classDateTime" value="<?php echo $classDBDateTime; ?>" />
                          </div>
                          <div class="mb-3 filled form-group tooltip-end-top">
                            <input class="form-control" placeholder="Class instructor" name="classInstructor" value="<?php echo $allUserName; ?>" />
                          </div>
                          <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="updateStatus" id="gridRadios1" value="1" checked />
                            <label class="form-check-label" for="gridRadios1">Available</label>
                          </div>
                          <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="updateStatus" id="gridRadios2" value="0" />
                            <label class="form-check-label" for="gridRadios2">Unavailable</label>
                          </div>
                          <button type="submit" name="editClass" class="btn btn-lg btn-primary">Edit Class</button>
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