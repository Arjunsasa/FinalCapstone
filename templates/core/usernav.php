<!-- Logo Start -->
<div class="logo position-relative">
  <a href="<?php SITE_ROOT ?>index.php">
    <!-- Logo can be added directly -->
    <!-- <img src="img/logo/logo-white.svg" alt="logo" /> -->

    <!-- Or added via css to provide different ones for different color themes -->
    <div class="img"></div>
  </a>
</div>
<!-- Logo End -->
<!-- User Menu Start -->
<div class="user-container d-flex">
  <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <img class="profile" src="uploads/profilePic<?php echo $curSeshID ?>.jpeg" alt="Not Found" onerror="this.src='lib/img/profile/profile-1.webp';" />
    <div class="name"><?php echo $_SESSION["userName"]; ?></div>
  </a>
  <div class="dropdown-menu dropdown-menu-end user-menu wide">

    <div class="row mb-1 ms-0 me-0">
      <div class="col-12 p-1 mb-3 pt-3">
        <div class="separator-light"></div>
      </div>
      <div class="col-12 pe-1 ps-1">
        <ul class="list-unstyled">
          <li>
            <a href="<?php if ($_SESSION["userPermission"] == 1) {
                        echo SITE_ROOT . "profileUser.php";
                      } else {
                        echo SITE_ROOT . "profileInstructor.php";
                      } ?>">
              <i data-acorn-icon="building" class="me-2" data-acorn-size="17"></i>
              <span class="align-middle">Dashboard</span>
            </a>
          </li>
          <li>
            <a href="<?php SITE_ROOT ?>editProfile.php?userID=<?php echo $_SESSION["userID"]; ?>">
              <i data-acorn-icon="edit-square" class="me-2" data-acorn-size="17"></i>
              <span class="align-middle">Edit Profile</span>
            </a>
          </li>
          <li>
            <a href="<?php SITE_ROOT ?>logout.php">
              <i data-acorn-icon="logout" class="me-2" data-acorn-size="17"></i>
              <span class="align-middle">Logout</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- User Menu End -->

<!-- Icons Menu Start -->
<ul class="list-unstyled list-inline text-center menu-icons">
  <li class="list-inline-item">
    <a href="#" id="colorButton">
      <i data-acorn-icon="light-on" class="light" data-acorn-size="18"></i>
      <i data-acorn-icon="light-off" class="dark" data-acorn-size="18"></i>
    </a>
  </li>

</ul>
<!-- Icons Menu End -->

<!-- Menu Start -->
<div class="menu-container flex-grow-1">
  <ul id="menu" class="menu">
    <li>
      <a href="<?php SITE_ROOT ?>index.php" data-href="Dashboards.html">
        <i data-acorn-icon="home" class="icon" data-acorn-size="18"></i>
        <span class="label">Home</span>
      </a>
    </li>
    <li>
      <a href="<?php SITE_ROOT ?>classes.php" data-href="Pages.html">
        <i data-acorn-icon="notebook-1" class="icon" data-acorn-size="18"></i>
        <span class="label">Classes</span>
      </a>
    </li>
    <li>
      <a href="<?php SITE_ROOT ?>packages.php" data-href="Blocks.html">
        <i data-acorn-icon="tag" class="icon" data-acorn-size="18"></i>
        <span class="label">Packages</span>
      </a>
    </li>
    <li class="mega">
      <a href="<?php SITE_ROOT ?>instructors.php" data-href="Interface.html">
        <i data-acorn-icon="crown" class="icon" data-acorn-size="18"></i>
        <span class="label">Instructors</span>
      </a>
    </li>
  </ul>
</div>
<!-- Menu End -->
<div class="mobile-buttons-container">
  <!-- Scrollspy Mobile Button Start -->
  <a href="#" id="scrollSpyButton" class="spy-button" data-bs-toggle="dropdown">
    <i data-acorn-icon="menu-dropdown"></i>
  </a>
  <!-- Scrollspy Mobile Button End -->
  <!-- Scrollspy Mobile Dropdown Start -->
  <div class="dropdown-menu dropdown-menu-end" id="scrollSpyDropdown"></div>
  <!-- Scrollspy Mobile Dropdown End -->
  <!-- Menu Button Start -->
  <a href="#" id="mobileMenuButton" class="menu-button">
    <i data-acorn-icon="menu"></i>
  </a>
  <!-- Menu Button End -->
</div>