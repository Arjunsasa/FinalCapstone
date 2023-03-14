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

    <div class="name"><i data-acorn-icon="office" class="icon" data-acorn-size="18"></i> Admin <?php echo $_SESSION["userName"]; ?></div>
  </a>
  <div class="dropdown-menu dropdown-menu-end user-menu wide">
    <div class="row mb-3 ms-0 me-0">
      <div class="col-12 ps-1 mb-2">
        <div class="text-primary">CREATE</div>
      </div>
      <div class="col-12 ps-1 pe-1">
        <ul class="list-unstyled">
          <li class="mb-1">
            <a href="<?php SITE_ROOT ?>adminPackageCreate.php"><i data-acorn-icon="tag" class="icon" data-acorn-size="18"></i> Package</a>
          </li>
          <li class="mb-1">
            <a href="<?php SITE_ROOT ?>adminClassCreate.php"><i data-acorn-icon="notebook-1" class="icon" data-acorn-size="18"></i> Class</a>
          </li>
          <li class="mb-1">
            <a href="<?php SITE_ROOT ?>register.php"><i data-acorn-icon="user" class="icon" data-acorn-size="18"></i> New Student/Instructor</a>
          </li>

        </ul>
      </div>
    </div>

    <div class="row mb-1 ms-0 me-0">
      <div class="col-12 p-1 mb-3 pt-3">
        <div class="separator-light"></div>
      </div>
      <div class="col-12 pe-1 ps-1">
        <ul class="list-unstyled">
          <li class="mb-2">
            <a href="<?php SITE_ROOT ?>admin.php">
              <i data-acorn-icon="office" class="icon" data-acorn-size="17"></i>
              <span class="align-middle">Admin Dashboard</span></a>
          </li>
          <li>
            <a href="<?php SITE_ROOT ?>logout.php">
              <i data-acorn-icon="logout" class="me-2" data-acorn-size="17"></i>
              <a href="<?php SITE_ROOT ?>logout.php"><span class="align-middle">Logout</span></a>
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
  <!--  -->
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
<!-- Mobile Buttons Start -->
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
<!-- Mobile Buttons End -->