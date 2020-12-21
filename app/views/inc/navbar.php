<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-2">
  <div class="container">
      <a class="navbar-brand" href="<?php echo URLROOT;?>/Posts/index">
          <svg width="70" height="20" viewBox="0 0 76 20" fill="none">
              <path d="M2.8333 17.6623H5.92418V2.33766H2.31816V5.45455H0V1.49012e-07H8.75748V17.6623H11.8484V20H2.8333V17.6623Z" fill="white">
              </path><path d="M21.3785 17.6623H30.6512V10.9091H22.1513V8.57143H30.6512V2.33766H21.3785V0H33.4845V20H21.3785V17.6623Z" fill="white">
              </path><path d="M42.2419 17.6623H51.5146V10.9091H43.0147V8.57143H51.5146V2.33766H42.2419V0H54.3479V20H42.2419V17.6623Z" fill="white">
              </path><path d="M72.6355 2.33766H64.9084V7.27273H62.5902V0H75.2113V20H72.6355V2.33766Z" fill="white"></path>
          </svg>
          <h6>Camagru</h6>
      </a>
      <!-- Toogle Button -->
      <button class="navbar-toggler" type="button" id="btn" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Navbar -->
      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <!-- Navbar Group one -->
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active pr-3">
              <a class="nav-link" href="<?php echo URLROOT;?>/posts/index"><i class="fas fa-index mr-1" aria-hidden="true"></i>Home</a>
            </li>
            <li class="nav-item active pr-3">
              <a class="nav-link" href="<?php echo URLROOT;?>/pages/about"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>About </a>
            </li>
          </ul>
            <!-- Navbar Group two -->
          <ul class="navbar-nav ml-auto">
            <!-- Check IF the User Have A ssesion id or not -->
              <?php if(isset($_SESSION['id'])): ?>
                <!-- User have an id -->
                <li class="nav-item active pr-3">
                    <a class="nav-link" href="<?php echo URLROOT;?>/users/profile"><i class="fas fa-user" aria-hidden="true"></i> Profile </a>
                </li>
                <!-- User have an id -->
                <li class="nav-item active pr-3">
                    <a class="nav-link" href="<?php echo URLROOT;?>/Posts/camera"><i class="fas fa-camera" aria-hidden="true"></i> Camera </a>
                </li>
                <li class="nav-item active pr-3">
                    <a class="nav-link" href="<?php echo URLROOT;?>/users/modify"><i class="fas fa-edit" aria-hidden="true"></i> EditProfile </a>
                </li>
                <li class="nav-item active pr-3">
                  <a class="nav-link" href="<?php echo URLROOT;?>/users/logout"><i class="fas fa-sign-out-alt" aria-hidden="true"></i>Logout</a>
                </li>
              <!-- User Dont have an id Session -->
              <?php else: ?>
                <li class="nav-item active pr-3">
                  <a class="nav-link" href="<?php echo URLROOT;?>/users/register">Register</a>
                </li>
                <li class="nav-item active pr-3">
                  <a class="nav-link" href="<?php echo URLROOT;?>/users/login">Login</a>
                </li>
                <!-- End Conditions -->
              <?php endif;?>
          </ul>
      </div>
  </div>
</nav>
<!-- Script To Make A Toggle Button Active -->
<script>
  // Add Event To btn 
  document.getElementById('btn').addEventListener('click', function()
  {
      // Change The Display Of Navbar from bolck to none
      if( document.getElementById('navbarsExampleDefault').style.display == "block")
        document.getElementById('navbarsExampleDefault').style.display = "none";
      else
        document.getElementById('navbarsExampleDefault').style.display = "block";
  });
</script>