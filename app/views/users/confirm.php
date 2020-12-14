<?php require APPROOT.'/views/inc/header.php'; ?>
    <div class="jumbotron">
    <img src="../public/imgs/viewsvg/hello.svg" alt="" class="img-fluid mb-3 d-none m-auto d-md-block"/>
        <div>
            <h4 class="lead">Your account has been created.</h4>
        </div> 
    <a href="<?php echo URLROOT;?>/users/login"><button type="button" class="btn btn-primary btn-block py-2">Log in</button></a>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>