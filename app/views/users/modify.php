<?php require APPROOT.'/views/inc/header.php'; ?>
<div class="container">
<a href="<?php echo URLROOT; ?>/users/profile" class="btn btn-light"><i class="fa fa-backward"></i> Back</a><br>
  <div class="row">
    <div class="col-md-8 mx-auto">
      <div class="card card-body mt-5 register">
          <img src="../public/imgs/viewsvg/edit.svg" alt="" class="img-fluid mb-3 d-none m-auto d-md-block">
          <h2 class="text-center display-5">Modify An Account</h2>
          <p>Please fill out this form to modify your compte</p>
        <form action="<?php echo URLROOT; ?>/users/modify" method="post">
          <!-- Username -->
          <div class="input-group-prepend d-flex flex-column mb-3 <?php echo (!empty($data['username_err']))? 'is-invalid' : ''; ?>">
                            <div class="d-flex flex-row input-holder">
                                <span class="icon input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-user text-muted"></i>
                                </span>
                                <input type="text"  placeholder="New User Name" name="username" class="input form-control bg-white border-md border-left-0 pl-3" value="<?php echo $data['username']; ?>">
                            </div>
                            <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
          </div>
          <!-- Email Address -->
          <div class="input-group-prepend d-flex flex-column mb-3  <?php echo (!empty($data['email_err']))? 'is-invalid' : ''; ?>">
                            <div class="d-flex flex-row input-holder">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-envelope text-muted"></i>
                                </span>
                                <input type="email"  placeholder="New Email Address" name="email" class="form-control bg-white border-left-0 border-md" 
                                value="<?php echo $data['email']; ?>">
                            </div>
                            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
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
          <!-- Password Confirmation -->
          <div class="input-group-prepend d-flex flex-column mb-3  <?php echo (!empty($data['confirm_password_err']))? 'is-invalid' : ''; ?>">
                            <div class="d-flex flex-row input-holder">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                                <input type="password"  placeholder="Confirm Password" name="confirm_password" class="form-control bg-white border-left-0 border-md" 
                                value="<?php echo $data['confirm_password']; ?>">
                            </div>
                             <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
            </div>
          <div class="col-md-6">
                        <p class="mb-2">Password requirements</p>
                        <p class="small text-muted mb-2">To create a new password, you have to meet all of the following requirements:</p>
                        <ul class="small text-muted pl-4 mb-0">
                            <li>Minimum 8 character</li>
                            <li>At least one special character</li>
                            <li>At least one number</li>
                        </ul>
                    </div>
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
          <div class="row">
            <div class="col">
              <input type="submit" value="Modify" class="btn btn-primary btn-block py-2">
            </div>
            </div>
            
        </form>
        <form method="post">
              
        </form>
      </div>
    </div>
  </div>
</div>
<?php require APPROOT.'/views/inc/footer.php'; ?>