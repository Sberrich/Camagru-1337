<?php require APPROOT .'/views/inc/header.php'; ?>
<div class="container">
    <div class="container padding-bottom-3x mb-2 mt-5">
        <div class="row justify-content-center">
            <div class="card card-body mt-5 register">
                <div class="forgot">
	                <h2 class="text-center">Forgot your password?</h2>
                    <img src="../public/imgs/svg/fgp.svg" alt="" class="img-fluid mb-3 d-none m-auto d-md-block" id="svg">
	                <p>Change your password in three easy steps. This will help you to secure your password!</p>
	                <ol class="list-unstyled">
	                    <li><span class="text-primary text-medium">1. </span>Enter your email address below.</li>
	                    <li><span class="text-primary text-medium">2. </span>Our system will send you a temporary link</li>
	                    <li><span class="text-primary text-medium">3. </span>Use the link to reset your password</li>
	                </ol>
	            </div>
                <form action="<?php echo URLROOT;?>/users/fgpass" method="POST">
                    <!-- Email Address -->
                    <div class="input-group-prepend d-flex flex-column mb-3  <?php echo (!empty($data['email_err']))? 'is-invalid' : ''; ?>">
                            <div class="d-flex flex-row input-holder">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-envelope text-muted"></i>
                                </span>
                                <input type="email"  placeholder="Email Address" name="email" class="form-control bg-white border-left-0 border-md" 
                                value="<?php echo $data['email']; ?>">
                            </div>
                            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                            <small class="form-text text-muted">Enter the email address you used during the registration on Camagru.com. Then we'll email a link to this address.</small> 
                        </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="send" class="btn btn-primary btn-block py-2">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT .'/views/inc/footer.php'; ?>