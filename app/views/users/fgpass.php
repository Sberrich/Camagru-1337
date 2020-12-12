<?php require APPROOT .'/views/inc/header.php'; ?>
    <div class="container padding-bottom-3x mb-2 mt-5">
        <div class="row justify-content-center">
            <div class="card card-body bg-light mt-5">
                <div class="forgot">
	                <h2>Forgot your password?</h2>
	                <p>Change your password in three easy steps. This will help you to secure your password!</p>
	                <ol class="list-unstyled">
	                    <li><span class="text-primary text-medium">1. </span>Enter your email address below.</li>
	                    <li><span class="text-primary text-medium">2. </span>Our system will send you a temporary link</li>
	                    <li><span class="text-primary text-medium">3. </span>Use the link to reset your password</li>
	                </ol>
	            </div>
                <form action="<?php echo URLROOT;?>/users/fgpass" method="POST">
                    <div class="form-group">
                        <label for="email">Enter your email address <sup>*</sup></label>
                        <input type="email" name="email"  class="form-control form-control-lg <?php echo (!empty($data['email_err']))? 'is-invalid' : ''; ?>" 
                        value="<?php echo $data['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                        <small class="form-text text-muted">Enter the email address you used during the registration on Camagru.com. Then we'll email a link to this address.</small> 
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="send " class="btn btn-primary btn-block py-2">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require APPROOT .'/views/inc/footer.php'; ?>