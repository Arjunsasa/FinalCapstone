<?php
session_start();
// config files //
include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

$pageName = 'Login';

include "templates/core/header.php";
?>

<body>
  <?php
  $loginEmail = $loginPassword = "";

  if (isset($_POST["login"])) {
    $loginEmail = filterInput($_POST["email"]);
    $loginPassword = filterInput($_POST["password"]);

    if ($loginEmail == "" || $loginPassword == "") { // check if email and password are filled
      function_alert("Please fill up your email address and password.");
    } else {
      if (!isValidEmail($loginEmail)) {
        function_alert("Please enter a valid email address");
      } else {
        $getUserQuery = DB::query("SELECT * FROM User WHERE UserEmail=%s", $loginEmail);
        $userExist = DB::count(); // if user exist. BOTH Email & Password exist.
        foreach ($getUserQuery as $getUserResult) {
          $getDBUserName = $getUserResult["UserName"];
          $getDBUserPassword = $getUserResult["UserPass"];
          $getDBUserPermission = $getUserResult["UserPermission"];
          $getDBUserStatus = $getUserResult["UserStatus"];
          $getDBUserEmail = $getUserResult["UserEmail"];
          $getDBUserID = $getUserResult["UserID"];
          $getDBUserPackageBal = $getUserResult["UserPackageBal"];
        }

        if ($userExist) {
          if (password_verify($loginPassword, $getDBUserPassword)) {
            loginSession($getDBUserName, $loginEmail, $getDBUserPermission, $getDBUserID);
            if ($getDBUserPermission == 1) {
              jsRedirect(SITE_ROOT . "profileUser.php");
            } elseif ($getDBUserPermission == 2) {
              jsRedirect(SITE_ROOT . "profileInstructor.php");
            } else {
              jsRedirect(SITE_ROOT . "admin.php");
            }
          } else {
            function_alert("incorrect login. Please try again.");
          }
        } else {
          function_alert("incorrect login. Please try again.");
        }
      }
    }
  }
  ?>
  <div id="root">
    <div id="nav" class="nav-container d-flex">
      <div class="nav-content d-flex">

        <?php include "templates/core/navbar.php" ?>

      </div>
      <div class="nav-shadow"></div>
    </div>
    <!-- main content -->
    <main>
      <div class="container">
        <!-- Form Start -->
        <div class="d-flex justify-content-center">
          <div class="col-12 col-lg-auto h-100 pb-4 px-4 pt-0 p-lg-0">
            <div class="sw-lg-70 min-h-100 bg-foreground d-flex justify-content-center align-items-center shadow-deep py-5 full-page-content-right-border">
              <div class="sw-lg-50 px-5">
                <div class="mb-5">
                  <h2 class="cta-1 mb-0 text-primary">Welcome,</h2>
                  <h2 class="cta-1 text-primary">let's get started!</h2>
                </div>

                <div class="mb-3">
                  <p class="h6">Please use your credentials to login.</p>
                </div>

                <div>
                  <form id="loginForm" class="tooltip-end-bottom" method="POST" novalidate>
                    <div class="mb-4 filled form-group tooltip-end-top">
                      <i data-acorn-icon="email"></i>
                      <input class="form-control" placeholder="Email" name="email" />
                    </div>

                    <div class="mb-5 filled form-group tooltip-end-top">
                      <i data-acorn-icon="lock-off"></i>
                      <input class="form-control pe-7" name="password" type="password" placeholder="Password" />
                    </div>

                    <div class="text-center">
                      <button type="submit" name="login" class="btn btn-lg btn-primary">Login</button>
                    </div>
                    <br>
                    <p>Not yet a memeber? <a href="register.php">Register Here</a></p>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Form End -->
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