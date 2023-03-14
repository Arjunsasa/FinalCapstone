<?php
session_start();

include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

$pageName = 'Your Dashboard';

include "templates/core/headerProfile.php";

if (!isLoggedIn()) {
  jsRedirect(SITE_ROOT . "index.php");
}

$today = date("Y/m/d h:i:s A");

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

<body class="rtl">
  <?php
  $target_dir = $target_file = $imageFileType = $fileName = "";

  if (isset($_POST["uploadProfilePic"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $fileName = $target_dir . "profilePic" . $curSeshID . "." . "jpeg";

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
      if ($_FILES["fileToUpload"]["size"] < 1900000) {
        if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
          if (file_exists($target_file)) {
            unlink("uploads/$fileName");
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $fileName);
            jsRedirect(SITE_ROOT . "profileUser.php");
          } else {
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $fileName);
            jsRedirect(SITE_ROOT . "profileUser.php");
          }
        } else {
          function_alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }
      } else {
        function_alert("Sorry, your file is too large.");
      }
    } else {
      function_alert("File is not an image.");
    }
  }

  ?>
  <div id="root">
    <div id="nav" class="nav-container d-flex">
      <div class="nav-content d-flex">

        <?php include "templates/core/usernav.php"; ?>

        <!-- Mobile Buttons End -->
      </div>
      <div class="nav-shadow"></div>
    </div>
    <div>
      <main>
        <div class="container">
          <!-- Title and Top Buttons Start -->
          <div class="page-title-container">
            <div class="row">
              <!-- Title Start -->
              <div class="col-12 col-md-7">
                <h1 class="mb-0 pb-0 display-4" id="title">Good morning, <?php echo $curSeshName; ?>!</h1>
              </div>
              <!-- Title End -->
            </div>
          </div>
          <!-- Title and Top Buttons End -->

          <div class="row">
            <div class="col-xl-3 mb-5">
              <!-- About Start -->
              <p class="small-title">Your Profile</p>
              <div class="card h-100-card">
                <div class="card-body">
                  <div class="d-flex align-items-center flex-column mb-4">
                    <div class="d-flex align-items-center flex-column">
                      <div class="sw-13 position-relative mb-3">
                        <img src="uploads/profilePic<?php echo $curSeshID; ?>.jpeg" alt="library/img/profile/profile-1.webp" class="img-fluid rounded-xl" alt="thumb" />
                      </div>
                      <div class="h5 mb-0"><?php echo $curSeshName; ?></div>
                    </div>
                  </div>

                  <div class="mb-5">
                    <p class="text-Medium text-muted mb-2">Details</p>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i data-acorn-icon="phone" class="text-primary" data-acorn-size="17"></i>
                        </div>
                      </div>
                      <div class="col text-alternate"><?php echo $curSeshPhone; ?></div>
                    </div>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i data-acorn-icon="email" class="text-primary" data-acorn-size="17"></i>
                        </div>
                      </div>
                      <div class="col text-alternate"><?php echo $curSeshEmail; ?></div>
                    </div>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i data-acorn-icon="instagram" class="text-primary" data-acorn-size="17"></i>
                        </div>
                      </div>
                      <div class="col text-alternate"><?php echo $curSeshIG; ?></div>
                    </div>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i data-acorn-icon="pin" class="text-primary" data-acorn-size="17"></i>
                        </div>
                      </div>
                      <div class="col text-alternate">Package Balance: <?php echo $curSeshBal; ?></div>
                    </div>
                  </div>
                  <div class="mb-6">
                    <p class="text-small text-muted mb-2">BIO</p>
                    <div class="col">
                      <?php echo $curSeshBio; ?>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <form class="input-group" method="POST" enctype="multipart/form-data">
                      <input type="file" name="fileToUpload" class="form-control" id="fileToUpload" aria-describedby="inputGroupFileAddon04" aria-label="Upload" />
                      <button class="btn btn-outline-secondary" type="submit" name="uploadProfilePic" id="fileToUpload">Upload</button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- About End -->
            </div>
            <div class="col-xl-9">
              <p class="small-title">Current Classes</p>
              <div class="row">

                <!-- Classes Table Start -->
                <section class="scroll-section" id="basic">
                  <div class="card mb-5">
                    <div class="card-body">
                      <table class="table">
                        <thead>
                          <th class="col">Class</th>
                          <th class="col">Date | Time</th>
                          <th class="col">Instructor</th>
                          <th class="col">Status</th>
                        </thead>
                        <tbody>
                          <!-- query classes info -->
                          <?php
                          $allClassQuery = DB::query("SELECT * FROM Classes INNER JOIN User on Classes.UserID=User.UserID");
                          foreach ($allClassQuery as $allClassResult) {
                            $allClassName = $allClassResult["ClassName"];
                            $allDateTime = $allClassResult["ClassDateTime"];
                            $allInstructorName = $allClassResult["UserName"];
                            $allClassStatus = $allClassResult["ClassStatus"];

                          ?>

                            <!-- populate class information -->

                            <tr style="display:<?php
                                                if ($allClassStatus == 0) {
                                                  echo "none";
                                                }
                                                ?>;">
                              <td class="col"><?php echo $allClassName; ?></td>
                              <td class="col"><?php echo $allDateTime; ?></td>
                              <td class="col"><?php echo $allInstructorName; ?></td>
                              <td class="col"><?php if ($allClassStatus == 0) {
                                                echo 'Unavailable';
                                              } else {
                                                echo 'Available';
                                              } ?></td>
                            </tr>

                          <?php
                          }
                          ?>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </section>

                <!-- Classes Table End -->

              </div>

              <div class="row">
                <!-- Existing Html with Scrollbar Start -->
                <div class="col-xl-12 mb-5">
                  <section class="scroll-section" id="existingHtmlScrollbar">
                    <div class="row">

                      <div class="col d-inline-flex">
                        <p class="small-title">My Current Bookings</p>
                      </div>

                      <div class="col d-inline-flex flex-row-reverse">
                        <a href="<?php SITE_ROOT ?>userBooking.php"><button class="btn btn-primary btn-sm mb-4">Book a Class <i class="bi bi-hand-index"></i></button></a>
                      </div>

                    </div>
                    <div class="row">
                      <div class="card">
                        <div class="card-body mb-n2" id="existingHtmlListScrollbar">

                          <div class="scroll-out mb-2">
                            <div class="list scroll-by-count" data-count="4" data-childSelector=".row">
                              <div class="row g-0 sh-6 mb-0">

                                <div class="card-body d-flex flex-row pt-4 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">

                                  <div class="d-flex flex-column">
                                    <?php
                                    $allUserBookingQuery = DB::query("SELECT * FROM Booking INNER JOIN Classes ON Booking.ClassID=Classes.ClassID WHERE Booking.UserID=%i", $curSeshID);
                                    foreach ($allUserBookingQuery as $allUserBookingResult) {
                                      $allUserBookingClassName = $allUserBookingResult["ClassName"];
                                      $allUserBookingClassDateTime = $allUserBookingResult["ClassDateTime"];
                                      $allUserBookingClassStatus = $allUserBookingResult["ClassStatus"];
                                    ?>
                                      <!-- query DB for user bookings -->

                                      <div style="display:<?php
                                                          if ($allClassStatus == 0) {
                                                            echo "none";
                                                          }
                                                          ?>;" class="name"><i data-acorn-icon="more-vertical" class="icon sh-3" data-acorn-size="18"></i><?php echo $allUserBookingClassName . ": " . $allUserBookingClassDateTime; ?></div>
                                    <?php
                                    }
                                    ?>
                                  </div>

                                </div>

                              </div>

                            </div>
                          </div>
                        </div>
                      </div>

                    </div>

                  </section>
                </div>
                <!-- Existing Html with Scrollbar End -->

              </div>





            </div>

          </div>
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

  <?php include "templates/core/profileScripts.php"; ?>
</body>

</html>