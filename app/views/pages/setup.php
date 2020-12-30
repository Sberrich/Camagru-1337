<?php include(APPROOT.'/views/inc/header.php') ?>
<div class="container">
        <div>
            <div class="container text-center">
            <?php flash("setup_success");?>
                    <h1 class="display-2 text-warning" > Setup Execute Successfully </h1>
                    <img src="../public/imgs/svg/setup.svg" class="img-fluid mb-3 d-none m-auto d-md-block" id="svg"/>
                    <a href="<?php echo URLROOT; ?>/posts/index" class="btn btn-light"><i class="fa fa-backward"></i> Back Home</a><br>
            </div>
        </div>
</div>
<?php include(APPROOT.'/views/inc/footer.php') ?>