<?php

session_start();

// config files //
include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

$pageName = 'Admin | Edit Member Details';

include "templates/core/header.php";

if (!isset($_GET["userID"]) || $_GET["userID"] == "") {
  jsRedirect(SITE_ROOT . "admin.php");
} else {
  $getUserQuery = DB::query("SELECT * FROM User WHERE UserID=%i", $_GET["userID"]);
  foreach ($getUserQuery as $getUserResult) {
    $userDBID = $getUserResult["UserID"];
    $userDBName = $getUserResult["UserName"];
    $userDBEmail = $getUserResult["UserEmail"];
    $userDBPhone = $getUserResult["UserPhone"];
    $userDBIG = $getUserResult["UserIG"];
    $userDBBio = $getUserResult["UserBio"];
    $userDBPackageBal = $getUserResult["UserPackageBal"];
    $userDBStatus = $getUserResult["UserStatus"];
    $userDBPermission = $getUserResult["UserPermission"];
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
  $editName = $editEmail = $editPass = $editConfirmP = $editPhone = $editIG = $editBio = "";



  if (isset($_POST["editProfile"])) {
    $editName = filterInput($_POST["editName"]); //filter the input and grab the name from the input field
    $editEmail = filterInput($_POST["editEmail"]);
    $editPass = filterInput($_POST["editPassword"]);
    $editConfirmP = filterInput($_POST["editConfirmPassword"]);
    $editPhone = filterInput($_POST["editPhone"]);
    $editIG = filterInput($_POST["editIG"]);
    $editBio = filterInput($_POST["editBio"]);

    if ($editName != "" && $editEmail != "" && $editPhone != "") {
      if (isValidEmail($editEmail)) {
        if (isValidPhone($editPhone)) {
          if (isValidName($editName)) {
            if ($editPass == $editConfirmP) {
              if ($editPass == "") { // Do not change password
                DB::update('User', [
                  'UserName' => $editName,
                  'UserEmail' => $editEmail,
                  'UserPhone' => $editPhone,
                  'UserIG' => $editIG,
                  'UserBio' => $editBio,
                ], "UserID=%i", $userDBID);
              } else { // Change Password
                DB::update('User', [
                  'UserName' => $editName,
                  'UserEmail' => $editEmail,
                  'UserPass' => password_hash($editPass, PASSWORD_DEFAULT),
                  'UserPhone' => $editPhone,
                  'UserIG' => $editIG,
                  'UserBio' => $editBio,
                ], "UserID=%i", $userDBID);
              }

              $success = DB::affectedRows();
              if ($success) {
                function_alert("Update Success");
                DB::commit();
              } else {
                function_alert("Insert Fail");
                DB::rollback();
              }
            } else {
              function_alert("Passwords do not match");
            }
          } else {
            function_alert("please enter valid name");
          }
        } else {
          function_alert("invalid phone number");
        }
      } else {
        function_alert("Please enter valid Email");
      }
    } else {
      function_alert("Please fill up required fields");
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

    <main>
      <div class="container">
        <div class="row">
          <div class="col">
            <!-- Title Start -->
            <div class="d-flex justify-content-center">
              <section class="scroll-section" id="title">
                <div class="page-title-container">
                  <h1 class="mb-0 pb-0 display-4">Edit Your Profile</h1>
                </div>
              </section>
            </div>
            <!-- Title End -->

            <!-- Content Start -->
            <div>
              <!-- Sign Up Start -->
              <div class="d-flex justify-content-center">
                <section class="col-6 scroll-section" id="signUp">
                  <h2 class="small-title">Profile</h2>
                  <form class="card mb-9 tooltip-end-top" id="signUpForm" method="POST" novalidate>
                    <div class="card-body">
                      <p class="text-alternate mb-4">Make the changes you wish to your profile.</p>
                      <div class="mb-4 filled">
                        <i data-acorn-icon="user"></i>
                        <input class="form-control" placeholder="Name" name="editName" value="<?php echo $userDBName; ?>" />
                      </div>
                      <div class="mb-4 filled">
                        <i data-acorn-icon="email"></i>
                        <input class="form-control" type="email" placeholder="Email" name="editEmail" value="<?php echo $userDBEmail; ?>" />
                      </div>
                      <div class="mb-4 filled">
                        <i data-acorn-icon="lock-off"></i>
                        <input class="form-control" type="password" placeholder="Password" name="editPassword" />
                      </div>
                      <div class="mb-4 filled">
                        <i data-acorn-icon="lock-off"></i>
                        <input class="form-control" type="password" placeholder="Confirm Password" name="editConfirmPassword" />
                      </div>
                      <div class="mb-4 filled">
                        <i data-acorn-icon="mobile"></i>
                        <input class="form-control" placeholder="Phone Number" name="editPhone" value="<?php echo $userDBPhone; ?>" />
                      </div>
                      <div class="mb-4 filled">
                        <i data-acorn-icon="instagram"></i>
                        <input class="form-control" placeholder="Instagram" name="editIG" value="<?php echo $userDBIG; ?>" />
                      </div>
                      <div class="mb-4 filled">
                        <i data-acorn-icon="content"></i>
                        <textarea class="form-control" placeholder="A short description of yourself" name="editBio" rows="3"><?php echo $editBio; ?></textarea>
                      </div>
                      <div class="mb-4 filled">
                        <i data-acorn-icon="wallet"></i>
                        <input class="form-control" type="text" placeholder="Current balance credit for class bookings" name="editBalance" value="<?php echo $userDBPackageBal; ?>" readonly />
                      </div>
                    </div>
                    <div class="card-footer border-0 pt-0 d-flex justify-content-between align-items-center">
                      <div>
                        <button class="btn btn-icon btn-icon-end btn-primary" name="editProfile" type="submit">
                          <span>Save Changes</span>
                          <i data-acorn-icon="chevron-right"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </section>
              </div>
              <!-- Sign Up End -->
              <!-- Content End -->
            </div>

            <!-- Tersm and Conditions Modal Start -->
            <div class="modal fade scroll-out" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-md modal-dialog-scrollable short modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="scroll-track-visible">
                      <p>
                        Liquorice caramels apple pie chupa chups bonbon. Jelly-o candy apple pie sugar plum icing chocolate cake lollipop jujubes bear claw.
                        Pastry sweet roll carrot cake cake macaroon gingerbread cookie. Lemon drops brownie candy cookie candy pie sweet roll biscuit marzipan.
                        Chocolate bar candy canes macaroon liquorice danish biscuit biscuit. Tiramisu toffee brownie sweet roll sesame snaps halvah. Icing
                        carrot cake cupcake gummi bears danish. Sesame snaps muffin macaroon tiramisu ice cream jelly-o pudding marzipan tootsie roll. Muffin
                        candy icing tootsie roll wafer powder danish cheesecake macaroon. Sweet marshmallow oat cake marshmallow ice cream carrot cake. Bonbon
                        powder carrot cake marzipan jelly beans pie cotton candy cotton candy. Gummies donut caramels chocolate bar. Powder soufflé brownie
                        jelly beans gingerbread candy.
                      </p>
                      <p>
                        Apple pie gummies marshmallow wafer. Cookie macaroon croissant tart topping jelly pie sesame snaps jelly. Chocolate tootsie roll
                        marshmallow tootsie roll gummi bears jelly beans lollipop macaroon gummi bears. Ice cream gingerbread tart cheesecake. Brownie jelly
                        beans cookie liquorice candy bear claw powder muffin sweet roll. Carrot cake gingerbread pudding chocolate cake cake chocolate bar
                        sesame snaps wafer. Pie jelly beans tart donut chupa chups caramels sesame snaps wafer gummies. Cake marshmallow cupcake donut.
                        Marshmallow cookie gummies chocolate cake dragée topping cheesecake halvah carrot cake. Cupcake bear claw carrot cake candy canes bonbon
                        croissant biscuit liquorice fruitcake. Jelly liquorice gummies. Biscuit croissant croissant liquorice. Gummi bears pie powder fruitcake
                        caramels brownie danish pastry pudding. Caramels sugar plum cookie cotton candy tootsie roll jelly pudding.
                      </p>
                      <p>
                        Tiramisu brownie tart chupa chups icing chupa chups. Gummi bears fruitcake carrot cake chocolate bonbon. Sesame snaps brownie gummi
                        bears tootsie roll caramels dragée. Powder cake gummies jelly beans toffee carrot cake bonbon powder muffin. Marshmallow jelly beans
                        cake donut cotton candy chocolate bar biscuit macaroon marzipan. Cake cupcake gummies. Gingerbread bonbon wafer. Pastry sweet cookie
                        danish lollipop sweet toffee topping bear claw. Apple pie dessert cake dessert. Tiramisu pie sugar plum gingerbread cupcake brownie
                        candy canes gummies jelly. Bonbon chocolate cake lollipop lollipop jelly beans apple pie halvah sweet roll. Macaroon jujubes powder
                        cheesecake sesame snaps fruitcake marzipan muffin.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Tersm and Conditions Modal End -->
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

  <?php include "templates/core/globalscripts.php"; ?>
</body>

</html>