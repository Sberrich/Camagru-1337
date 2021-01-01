<?php require APPROOT.'/views/inc/header.php'; ?>
<div class="container">
  <div class="row">
    <div class="col-md-8 mx-auto">
      <div class="card card-body mt-5 register">
      <?php flash("Modify_success");?>
          <img src="../public/imgs/svg/new.svg" alt="" class="img-fluid mb-3 d-none m-auto d-md-block" id="svg">
          <h2 class="text-center display-5">Modify An Account</h2>
          <p>Please fill out this form to modify your compte</p>
          <!-- Form Modify -->
          <form action="<?php echo URLROOT; ?>/users/modify" method="post">
          <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
          <!-- Username -->
                <div class="input-group-prepend d-flex flex-column mb-3 <?php echo (!empty($data['new_username_err']))? 'is-invalid' : ''; ?>">
                                  <div class="d-flex flex-row input-holder">
                                      <span class="icon input-group-text bg-white px-4 border-md border-right-0">
                                          <i class="fa fa-user text-muted"></i>
                                      </span>
                                      <input type="text"  placeholder="<?php echo($_SESSION['username'])?>" name="new_username" class="input form-control bg-white border-md border-left-0 pl-3" value="<?php echo $data['new_username']; ?>">
                                  </div>
                                  <span class="invalid-feedback"><?php echo $data['new_username_err']; ?></span>
                </div>
                <!-- Email Address -->
                <div class="input-group-prepend d-flex flex-column mb-3  <?php echo (!empty($data['new_email_err']))? 'is-invalid' : ''; ?>">
                            <div class="d-flex flex-row input-holder">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-envelope text-muted"></i>
                                </span>
                                <input type="email"  placeholder="<?php echo($_SESSION['email'])?>" name="new_email" class="form-control bg-white border-left-0 border-md" 
                                value="<?php echo $data['new_email']; ?>">
                            </div>
                            <span class="invalid-feedback"><?php echo $data['new_email_err']; ?></span>
                        </div>
                <!-- Password -->
                <div class="input-group-prepend d-flex flex-column mb-3  <?php echo (!empty($data['new_password_err']))? 'is-invalid' : ''; ?>">
                                  <div class="d-flex flex-row input-holder">
                                      <span class="input-group-text bg-white px-4 border-md border-right-0">
                                          <i class="fa fa-lock text-muted"></i>
                                      </span>
                                      <input type="password"  name="newpassword" placeholder="New Password" class="form-control bg-white border-left-0 border-md" value="<?php echo $data['new_password']; ?>">
                                  </div>

                                  <span class="invalid-feedback"><?php echo $data['new_password_err']; ?></span>
                </div>
                <!-- Password Confirmation -->
                <div class="input-group-prepend d-flex flex-column mb-3  <?php echo (!empty($data['confirm_new_password_err']))? 'is-invalid' : ''; ?>">
                                  <div class="d-flex flex-row input-holder">
                                      <span class="input-group-text bg-white px-4 border-md border-right-0">
                                          <i class="fa fa-lock text-muted"></i>
                                      </span>
                                      <input type="password"  placeholder="Confirm New Password" name="confirm_new_password" class="form-control bg-white border-left-0 border-md" 
                                      value="<?php echo $data['confirm_new_password']; ?>">
                                  </div>
                                  <span class="invalid-feedback"><?php echo $data['confirm_new_password_err']; ?></span>
                  </div>
                   <!-- Old Password -->
                <div class="input-group-prepend d-flex flex-column mb-3  <?php echo (!empty($data['old_password_err']))? 'is-invalid' : ''; ?>">
                                  <div class="d-flex flex-row input-holder">
                                      <span class="input-group-text bg-white px-4 border-md border-right-0">
                                          <i class="fa fa-lock text-muted"></i>
                                      </span>
                                      <input type="password"  name="old_password" placeholder="Old Password" class="form-control bg-white border-left-0 border-md" value="<?php echo $data['old_password']; ?>">
                                  </div>

                                  <span class="invalid-feedback"><?php echo $data['old_password_err']; ?></span>
                </div>

                  <!-- Password Requirments -->
                <div class="col-md-6">
                              <p class="mb-2">Password requirements</p>
                              <p class="small text-muted mb-2">To create a new password, you have to meet all of the following requirements:</p>
                              <ul class="small text-muted pl-4 mb-0">
                                  <li>Minimum 8 character</li>
                                  <li>At least one special character</li>
                                  <li>At least one number</li>
                              </ul>
                </div>
                <!-- Notification -->
                <div class="row">
                <div class="col">
                  <p>Send Email Notification :</p>
                </div>
                <div class="col">
                    <?php if($_SESSION['notification'] == 1): ?>
                    <input type="checkbox" checked data-toggle="toggle" name="notif">
                    <?php else: ?>
                      <input type="checkbox" data-toggle="toggle" name="notif">
                    <?php endif;?>
                </div>
              </div> 
              <!-- Submit Modify -->
              <div class="form-group">
                    <input type="submit" value="modify" class="btn btn-outline-danger btn-block py-2">
              </div>
              
          </form>
          
      </div>
    </div>
  </div>
</div>
<?php require APPROOT.'/views/inc/footer.php'; ?>