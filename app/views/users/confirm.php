<?php require APPROOT.'/views/inc/header.php'; ?>
<div class="container">
    <div class="jumbotron">
        <img src="../public/imgs/svg/hello.svg" alt="" class="img-fluid mb-3 d-none m-auto d-md-block svg"/>
            <div>
                <h4 class="lead">Your account has been created.</h4>
            </div> 
            <a href="<?php echo URLROOT;?>/users/login"><button type="button" class="btn btn-primary btn-block py-2">Login</button></a>
    </div>
</div>
<?php require APPROOT.'/views/inc/footer.php'; ?>