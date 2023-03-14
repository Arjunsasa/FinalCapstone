<?php
session_start();

include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

$pageName = 'Instructor Dashboard';

include "templates/core/headerProfile.php";

if (!isLoggedIn()) {
  jsRedirect(SITE_ROOT . "index.php");
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
}

if (!isInstructor()){
  jsRedirect(SITE_ROOT . "index.php");
}
?>

<body class="rtl">
  <?php
  $target_dir = $target_file = $imageFileType = $fileName = "";

  if (isset($_POST["uploadInstructorPic"])) {
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
                <span class="align-middle text-muted d-inline-block lh-1 pb-2 pt-2 text-small">Home</span>
                <h1 class="mb-0 pb-0 display-4" id="title">Good morning, <?php echo $curSeshName; ?></h1>
              </div>
              <!-- Title End -->
            </div>
          </div>
          <!-- Title and Top Buttons End -->

          <div class="row">
            <div class="col-xl-4 mb-5">
              <!-- About Start -->
              <p class="small-title">Your Profile</p>
              <div class="card h-100-card">
                <div class="card-body">
                  <div class="d-flex align-items-center flex-column mb-4">
                    <div class="d-flex align-items-center flex-column">
                      <div class="sw-13 position-relative mb-3">
                        <img src="uploads/profilePic<?php echo $curSeshID; ?>.jpeg" alt="Not Found" onerror="this.src='library/img/profile/profile-1.webp';" class="img-fluid rounded-xl" alt="thumb" />
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
                  </div>
                  <div class="mb-5">
                    <p class="text-small text-muted mb-2">BIO</p>
                    <div class="col">
                      <?php echo $curSeshBio; ?>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <form class="input-group" method="POST" enctype="multipart/form-data">
                      <input type="file" name="fileToUpload" class="form-control" id="fileToUpload" aria-describedby="inputGroupFileAddon04" aria-label="Upload" />
                      <button class="btn btn-outline-secondary" type="submit" name="uploadInstructorPic" id="fileToUpload">Upload</button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- About End -->
            </div>
            <div class="col-xl-8">
              <p class="small-title">Upcoming Classes</p>
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
                          <th class="col">Namelist </th>
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
                            $allClassID = $allClassResult["ClassID"];
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
                              <td class="col">
                                <a href="<?php SITE_ROOT;?>namelist.php?classID=<?php echo $allClassID; ?>"><button class="btn btn-primary btn-sm mb-4"> View <i data-acorn-icon="cursor-pointer" class="icon" data-acorn-size="18"></i></button></a>
                              </td>
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
                <?php
                $allCardClassQuery = DB::query("SELECT * FROM Classes WHERE UserID=%i", $curSeshID);
                foreach ($allCardClassQuery as $allCardClassResult) {
                  $allCardClassName = $allCardClassResult["ClassName"];
                  $allCardClassStatus = $allCardClassResult["ClassStatus"];
                  $allCardClassID = $allCardClassResult["ClassID"];
                  $allCardClassUserID = $allCardClassResult["UserID"];
                ?>
                  <div class="col-6 col-sm-4 col-xl-3">
                    <div class="card mb-5">
                      <div class="card-body text-center align-items-center d-flex flex-column justify-content-between">
                        <p class="card-text mb-2 d-flex">Attendance</p>
                        <div class="d-flex rounded-xl bg-gradient-light sw-6 sh-6 mb-3 justify-content-center align-items-center">
                          <i data-acorn-icon="chart-2" class="text-white"></i>
                        </div>
                        <?php
                        $allCardBookingQuery = DB::query("SELECT BookingID FROM Booking WHERE ClassID=%i", $allCardClassID);
                        foreach ($allCardBookingQuery as $allCardBookingResult) {
                          $allCardBookingID = $allCardBookingResult["BookingID"];
                          $numberOfAttendees = DB::count();
                        }
                        ?>
                        <p class="card-text mb-2 d-flex">Class: <?php echo $allClassName; ?></p>
                        <p class="h4 text-center mb-0 d-flex text-primary"><?php echo $numberOfAttendees; ?></p>
                      </div>
                    </div>
                  </div>
                <?php
                }
                ?>
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