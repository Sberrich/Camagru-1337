<?php require APPROOT .'/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card card-body mt-5 register">
                <img src="../public/imgs/viewsvg/login.svg" alt="" class="img-fluid mb-3 d-none m-auto d-md-block">
                <h2 class="text-center">Login</h2>
                <p class="font-italic text-center text-muted mb-0">Please fill in your informations to Login!</p>
                <form action="<?php echo URLROOT;?>/users/login" method="POST">
                    <!-- Username -->
                    <div class="input-group-prepend d-flex flex-column mb-3 <?php echo (!empty($data['username_err']))? 'is-invalid' : ''; ?>">
                        <div class="d-flex flex-row input-holder">
                                <span class="icon input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-user text-muted"></i>
                                </span>
                                <input type="text"  placeholder="First Name" name="username" class="input form-control bg-white border-md border-left-0 pl-3" value="<?php echo $data['username']; ?>">
                        </div>
                        <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
                    </div>
                    <!-- Password -->
                    <div class="input-group-prepend d-flex flex-column mb-3  <?php echo (!empty($data['password_err']))? 'is-invalid' : ''; ?>">
                            <div class="d-flex flex-row input-holder">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                                <input type="password"  name="password" placeholder="Password" class="form-control bg-white border-left-0 border-md" value="<?php echo $data['password']; ?>">
                            </div>

                             <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                        </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Login" class="btn btn-primary btn-block py-2">
                        </div>
                        <div class="col">
                            <div class="row"><a href="<?php echo URLROOT;?>/users/register" class="btn btn-light btn-block"> No account? Register</a></div>
                            <div class="row"><a href="<?php echo URLROOT;?>/users/fgpass" class="btn btn-light btn-block"> Forgotten Password? Recover</a></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require APPROOT .'/views/inc/footer.php'; ?>