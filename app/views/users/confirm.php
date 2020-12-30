<?php require APPROOT.'/views/inc/header.php'; ?>
<div class="container text-center">
<hr class="my-4">
<div class="jumbotron">
            <?php flash("Verification_success");?>
            <h4>Your account has been Verified.</h4>
            <img src="../../public/imgs/svg/verify.gif" alt="" class="img-fluid mb-3 d-none m-auto d-md-block" id = "svg">
            <a href="<?php echo URLROOT;?>/users/login"><button type="button" class="btn btn-outline-primary btn-block py-2"><i class="fa fa-sign-in">Login</i></button></a>
            <hr class="my-4">
        </div>
</div>
<?php require APPROOT.'/views/inc/footer.php'; ?>