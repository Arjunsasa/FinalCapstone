<?php
session_start();

include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

$pageName = 'Admin Dashboard';

include "templates/core/header.php";

if (!isLoggedIn()) {
  jsRedirect(SITE_ROOT . "index.php");
}

if (!isAdmin()){
  jsRedirect(SITE_ROOT . "index.php");
}
?>

<body>
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
            <!-- Classes Title and Top Buttons Start -->
            <div class="page-title-container">
              <div class="row">
                <!-- Title Start -->
                <div class="col-12 col-md-7">
                  <span class="mb-0 pb-0 display-4" id="title">Classes | </span> <span class="small-title">Current Classes</span>
                </div>
                <!-- Title End -->
              </div>
            </div>
            <!-- Title and Top Buttons End -->

            <!-- Content Start -->
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
                        <th class="col">Class Info</th>
                        <th class="col">Status</th>
                        <th class="col">Edit | Disable</th>

                      </thead>
                      <tbody>
                        <!-- query classes info -->
                        <?php
                        $allClassQuery = DB::query("SELECT * FROM Classes INNER JOIN User on Classes.UserID=User.UserID");
                        foreach ($allClassQuery as $allClassResult) {
                          $allClassName = $allClassResult["ClassName"];
                          $allDateTime = $allClassResult["ClassDateTime"];
                          $allInstructorName = $allClassResult["UserName"];
                          $allClassInfo = $allClassResult["ClassInfo"];
                          $allClassStatus = $allClassResult["ClassStatus"];
                          $allClassID = $allClassResult["ClassID"];
                        ?>

                          <!-- populate class information -->

                          <tr id="lesson<?php echo $allClassID; ?>">
                            <td class="col"><?php echo $allClassName; ?></td>
                            <td class="col"><?php echo $allDateTime; ?></td>
                            <td class="col"><?php echo $allInstructorName; ?></td>
                            <td class="col-4"><?php echo $allClassInfo; ?></td>
                            <td class="col"><?php if ($allClassStatus == 0) {
                                              echo 'Unavailable';
                                            } else {
                                              echo 'Available';
                                            } ?></td>
                            <td class="col">
                              <?php echo str_repeat('&nbsp;', 2) ?>
                              <a href="<?php SITE_ROOT ?>adminClassEdit.php?classID=<?php echo $allClassID; ?>"><i data-acorn-icon="edit-square" class="icon" data-acorn-size="18"></i></a>
                              <?php echo str_repeat('&nbsp;', 7) ?>
                              <!-- delete classe code can go here - From Shina -->
                              <a onclick="deleteDataC(<?php echo $allClassID; ?>);" href="#"><i data-acorn-icon="eye-off" class="icon" data-acorn-size="18"></i></a>
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
              <!-- Packages Title Start -->
              <div class="col-12 col-md-7 mb-4">
                <span class="mb-0 pb-0 display-4" id="title">Packages | </span>
                <spam class="small-title">Active Packages</spam>
              </div>
              <!-- Packages Title End -->
            </div>
            <section class="scroll-section " id="hoverableRows">
              <div class="card mb-5">
                <div class="card-body">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th class="col">Package</th>
                        <th class="col">No. of Credits</th>
                        <th class="col">Price</th>
                        <th class="col">Status</th>
                        <th class="col">Edit | Disable </th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Query Packages info -->
                      <?php
                      $allPackagesQuery = DB::query("SELECT * FROM Packages");
                      foreach ($allPackagesQuery as $allPackageResult) {
                        $allPackageName = $allPackageResult["PackageName"];
                        $allPackageType = $allPackageResult["PackageType"];
                        $allPackagePrice = $allPackageResult["PackagePrice"];
                        $allPackageStatus = $allPackageResult["PackageStatus"];
                        $allPackageID = $allPackageResult["PackageID"];
                      ?>

                        <!-- Populate Packages Information -->

                        <tr id="package<?php echo $allPackageID; ?>">
                          <td class="row"><?php echo $allPackageName; ?></td>
                          <td class="col"><?php echo $allPackageType; ?></td>
                          <td class="col"><?php echo $allPackagePrice; ?></td>
                          <td class="col"><?php if ($allPackageStatus != 0) {
                                            echo 'Available';
                                          } else {
                                            echo 'Unavailable';
                                          } ?></td>
                          <td class="col">
                            <?php echo str_repeat('&nbsp;', 2) ?>
                            <a href="<?php SITE_ROOT ?>adminPackageEdit.php?packageID=<?php echo $allPackageID; ?>"><i data-acorn-icon="edit-square" class="icon" data-acorn-size="18"></i></a>
                            <?php echo str_repeat('&nbsp;', 7) ?>
                            <!-- delete classe code can go here - From Shina -->
                            <a onclick="deleteDataP(<?php echo $allPackageID; ?>);" href="#"><i data-acorn-icon="eye-off" class="icon" data-acorn-size="18"></i></a>
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

            <!-- Packages Table End -->
          </div>
        </div>

        <div class="row">
          <!-- Instructors Title Start -->
          <div class="col-12 col-md-7 mb-4">
            <span class="mb-0 pb-0 display-4" id="title">Instructors | </span> <span class="small-title">Teaching Faculty</span>
          </div>
          <!-- Packages Title End -->
        </div>
        <section class="scroll-section " id="hoverableRows">
          <div class="card mb-5">
            <div class="card-body">
              <table class="table table-hover">
                <thead>

                  <th class="col">Name</th>
                  <th class="col">Email</th>
                  <th class="col">Phone</th>
                  <th class="col">IG Handle</th>
                  <th class="col-3">Bio</th>
                  <th class="col">Status</th>
                  <th class="col">Edit | Disable</th>
                </thead>
                <tbody>
                  <!-- Query Packages info -->
                  <?php
                  $allInstructorQuery = DB::query("SELECT * FROM User WHERE UserPermission=2");
                  foreach ($allInstructorQuery as $allInstructorResult) {
                    $allInstructoreName = $allInstructorResult["UserName"];
                    $allInstructorEmail = $allInstructorResult["UserEmail"];
                    $allInstructorPhone = $allInstructorResult["UserPhone"];
                    $allInstructorIG = $allInstructorResult["UserIG"];
                    $allInstructorBio = $allInstructorResult["UserBio"];
                    $allInstructorStatus = $allInstructorResult["UserStatus"];
                    $allInstructorID = $allInstructorResult["UserID"];
                  ?>

                    <!-- Populate Packages Information -->

                    <tr id="instructor<?php echo $allInstructorID; ?>">
                      <td class="col"><?php echo $allInstructoreName; ?></td>
                      <td class="col"><?php echo $allInstructorEmail; ?></td>
                      <td class="col-1"><?php echo $allInstructorPhone; ?></td>
                      <td class="col"><?php echo $allInstructorIG; ?></td>
                      <td class="col-3"><?php echo $allInstructorBio; ?></td>
                      <td class="col"><?php if ($allInstructorStatus != 0) {
                                        echo 'Available';
                                      } else {
                                        echo 'Unavailable';
                                      } ?></td>
                      <td class="col">
                        <?php echo str_repeat('&nbsp;', 2) ?>
                        <a href="<?php SITE_ROOT ?>adminEditProfile.php?userID=<?php echo $allInstructorID; ?>"><i data-acorn-icon="edit-square" class="icon" data-acorn-size="18"></i></a>
                        <?php echo str_repeat('&nbsp;', 7) ?>
                        <!-- delete classe code can go here - From Shina -->
                        <a onclick="deleteDataI(<?php echo $allInstructorID; ?>);" href="#"><i data-acorn-icon="eye-off" class="icon" data-acorn-size="18"></i></a>
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

        <!-- Packages Table End -->
      </div>

      <div class="row">
        <!-- Instructors Title Start -->
        <div class="col-12 col-md-7 mb-4">
          <span class="mb-0 pb-0 display-4" id="title">Members | </span> <span class="small-title">Active Members</span>
        </div>
        <!-- Packages Title End -->
      </div>
      <section class="scroll-section " id="basic">
        <div class="card mb-5">
          <div class="card-body">
            <table class="table">
              <thead>

                <th class="col">Name</th>
                <th class="col">Email</th>
                <th class="col">Phone</th>
                <th class="col">IG Handle</th>
                <th class="col">Bio</th>
                <th class="col">Status</th>
                <th class="col">Edit | Disable </th>

              </thead>
              <tbody>
                <!-- Query Packages info -->
                <?php
                $allMembersQuery = DB::query("SELECT * FROM User WHERE UserPermission=1");
                foreach ($allMembersQuery as $allMembersResult) {
                  $allMembersName = $allMembersResult["UserName"];
                  $allMembersEmail = $allMembersResult["UserEmail"];
                  $allMembersPhone = $allMembersResult["UserPhone"];
                  $allMembersIG = $allMembersResult["UserIG"];
                  $allMembersBio = $allMembersResult["UserBio"];
                  $allMembersStatus = $allMembersResult["UserStatus"];
                  $allMembersID = $allMembersResult["UserID"];
                ?>

                  <!-- Populate Packages Information -->

                  <tr id="member<?php echo $allMembersID; ?>">
                    <td class="row"><?php echo $allMembersName; ?></td>
                    <td class="col"><?php echo $allMembersEmail; ?></td>
                    <td class="col"><?php echo $allMembersPhone; ?></td>
                    <td class="col"><?php echo $allMembersIG; ?></td>
                    <td class="col"><?php echo $allMembersBio; ?></td>
                    <td class="col"><?php if ($allMembersStatus != 0) {
                                      echo 'Available';
                                    } else {
                                      echo 'Unavailable';
                                    } ?></td>
                    <td class="col">
                      <?php echo str_repeat('&nbsp;', 2) ?>
                      <a href="<?php SITE_ROOT ?>adminEditProfile.php?userID=<?php echo $allMembersID; ?>"><i data-acorn-icon="edit-square" class="icon" data-acorn-size="18"></i></a>
                      <?php echo str_repeat('&nbsp;', 7) ?>
                      <!-- delete classe code can go here - From Shina -->
                      <a onclick="deleteDataM(<?php echo $allMembersID; ?>);" href="#"><i data-acorn-icon="eye-off" class="icon" data-acorn-size="18"></i></a>
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

      <!-- Packages Table End -->
  </div>
  </div>
  </main>

  <?php include "templates/core/footer.php"; ?>

  </div>
  <!-- start here -->
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
  <!-- end here -->
  <?php include "templates/core/globalScripts.php"; ?>
  <?php include "templates/core/adminAjax.php"; ?>
</body>

</html>