<?php include(APPROOT.'/views/inc/header.php') ?>
<div class="container">
        <div>
            <div class="container text-center">
                    <?php flash("404");?>
                    <h1 class="display-2 text-warning" > 
                    <b class="lead">404 .oops!, you found it.
                     You found our 404 page....</b></h1>
                    <img src="../public/imgs/svg/notf.svg" class="img-fluid mb-3 d-none m-auto d-md-block"/>
                    <a href="<?php echo URLROOT; ?>/posts/index" class="btn btn-light"><i class="fa fa-backward"></i> Back Home</a><br>
            </div>
        </div>
</div>
<?php include(APPROOT.'/views/inc/footer.php') ?>