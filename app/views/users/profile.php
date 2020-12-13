<?php require APPROOT .'/views/inc/header.php';?>
<main role="main">
  <div class="jumbotron">
        <img src="../public/imgs/profile.svg" alt="" class="img-fluid mb-3 d-none m-auto d-md-block">
        <h1 class="text-center display-5">Welcome <?php echo $data['title']; ?></h1>
        <a class="btn-outline-primary btn-lg" href="<?php echo URLROOT;?>/users/modify" role="button">Edit Profile</a>
        <a class="btn-outline-success btn-lg" href="<?php echo URLROOT;?>/posts/Image" role="button">Add Photo</a>
  </div>
  <div class="album py-5 bg-light"> 
  </div>
</main>
<?php require APPROOT . '/views/inc/footer.php';?>
