<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
        <div class="jumbotron jumbotron-flud text-center">
          <div class="container">
             <h1 class="display-3 text-info" ><?php echo $data['title']; ?></h1>
             <p class="lead"><?php echo $data['description']; ?></p>
             <img src="../public/imgs/svg/index.svg" class="img-fluid mb-3 d-none m-auto d-md-block badge"/>
             <a href="<?php echo URLROOT; ?>/users/profile" class="btn btn-light"><i class="fa fa-enjoy"></i>ENJOY IT</a><br>
         </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>