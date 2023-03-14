<?php
// config files //

session_start();

include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

$pageName = 'Register';

include "templates/core/header.php";

if (!isLoggedIn()) {
  $_SESSION["userPermission"] = "";
  $_SESSION["userEmail"] = "";
}
?>

<body>
  <?php
  $newName = $newEmail = $newPass = $confirmP = $newPhone = $newTerms = "";


  if (isset($_POST["register"])) {
    $newName = filterInput($_POST["signUpName"]); //filter the input and grab the name from the input field
    $newEmail = filterInput($_POST["signUpEmail"]);
    $newPass = filterInput($_POST["signUpPassword"]);
    $confirmP = filterInput($_POST["confirmPassword"]);
    $newPhone = filterInput($_POST["signUpPhone"]);
    $newTerms = filterInput($_POST["signUpCheck"]);

    if ($newName != "" && $newEmail != "" && $newPass != "" && $confirmP != "" && $newPhone != "" && $newTerms != "") {
      if (isValidEmail($newEmail)) {
        if (isValidPhone($newPhone)) {
          if (isValidName($newName)) {
            if ($newPass == $confirmP) {
              DB::startTransaction();
              DB::insert('User', [
                'UserName' => $newName,
                'UserEmail' => $newEmail,
                'UserPass' => password_hash($newPass, PASSWORD_DEFAULT),
                'UserPhone' => $newPhone
              ]);
              $success = DB::affectedRows();
              if ($success) {
                function_redirect('login.php');
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
    <!-- main content -->
    <main>
      <div class="container">
        <!-- Form Start -->
        <div class="row">
          <div class="col">
            <div class="d-flex justify-content-center">
              <div class="page-title-container">
                <h1 class="mb-0 mt-2 pb-0 display-4">Register As New user</h1>
              </div>
            </div>
          </div>
          <div>
            <div class="d-flex justify-content-center">
              <section class="col-6 scroll-section" id="signUp">
                <h2 class="small-title">Sign Up</h2>
                <form class="card mb-5 tooltip-end-top" id="signUpForm" method="POST" novalidate>
                  <div class="card-body">
                    <p class="text-alternate mb-4">Edit your profile here</p>
                    <div class="mb-3 filled form-group tooltip-end-top">
                      <i data-acorn-icon="user"></i>
                      <input class="form-control" placeholder="Name" name="signUpName" value="<?php echo $newName; ?>" />
                    </div>
                    <div class="mb-3 filled form-group tooltip-end-top">
                      <i data-acorn-icon="email"></i>
                      <input class="form-control" type="email" placeholder="Email" name="signUpEmail" value="<?php echo $newEmail; ?>" />
                    </div>
                    <div class="mb-3 filled form-group tooltip-end-top">
                      <i data-acorn-icon="lock-off"></i>
                      <input class="form-control" type="password" placeholder="Password" name="signUpPassword" />
                    </div>
                    <div class="mb-3 filled form-group tooltip-end-top">
                      <i data-acorn-icon="lock-off"></i>
                      <input class="form-control" type="password" placeholder="Confirm Password" name="confirmPassword" />
                    </div>
                    <div class="mb-3 filled form-group tooltip-end-top">
                      <i data-acorn-icon="mobile"></i>
                      <input class="form-control" placeholder="Phone Number" name="signUpPhone" value="<?php echo $newPhone; ?>" />
                    </div>
                    <div class="mb-0 position-relative tooltip-label-end form-group">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="customCheck1" name="signUpCheck" value="accepted" />
                        <label class="form-check-label" for="customCheck1">
                          I have read and accept the
                          <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">
                            terms and conditions</a>.
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer border-0 pt-0 d-flex align-items-center">
                    <button class="btn btn-icon btn-icon-end btn-primary" type="submit" name="register">
                      <span>Sign Up</span>
                      <i data-acorn-icon="chevron-right"></i>
                    </button>
                  </div>
                </form>
              </section>
            </div>

            <!-- Terms and Conditions Modal Start -->
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
            <!-- Terms and Conditions Modal End -->

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