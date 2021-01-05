<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
        <div class="text-center">
        <img src="../public/imgs/svg/studio.svg" class="img-fluid mb-3 d-none m-auto d-md-block"/>
            
                    <h1 class="display-2 text-warning" ><?php echo $data['title']; ?></h1>
                    <p class="lead"><?php echo $data['description']; ?></p>
           
              <a href="<?php echo URLROOT; ?>/posts/index" class="btn btn-light"><i class="fa fa-heart"></i> ENJOY IT</a><br>
        </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>