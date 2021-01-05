<?php require APPROOT.'/views/inc/header.php'; ?>
<div class="container">
    <div class="row flex-lg-nowrap">
      <div class="col">
        <div class="row">
          <div class="col mb-3">
            <div class="card">
              <?php flash("edit_success");?>
              <div class="card-body">
                <div class="e-profile">
                  <div class="row">
                      <div class="col-12 col-sm-auto mb-3">
                        <div class="mx-auto" style="width: 140px;">
                          <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                            <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">
                            <img src="../public/imgs/svg/avatar.svg" alt="" class="img-fluid mb-3 d-none m-auto d-md-block" id="svg">
                            </span>
                          </div>
                        </div>
                    </div>
                    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                      <div class="text-center text-sm-left mb-2 mb-sm-0">
                        <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo $_SESSION['username']?></h4>
                        <p class="mb-0">@<?php echo $_SESSION['username']?>.s</p>
                        <div class="text-muted"><small><?php echo$_SESSION['created_at']?></small></div>
                        <div class="mt-2">
                            <a href="<?php echo URLROOT;?>/posts/camera" class="btn btn-primary"><span><i class="fa fa-fw fa-camera"></i>Back To Studio</span></a>
                        </div>
                      </div>
                      <div class="text-center text-sm-right">
                        <span class="badge badge-secondary">User</span>
                        <div class="text-muted"><small><?php echo$_SESSION['created_at']?></small></div>
                      </div>
                    </div>
                  </div>
                  <ul class="nav nav-tabs">
                    <li class="nav-item"><a href="" class="active nav-link">Settings</a></li>
                  </ul>
                  <div class="tab-content pt-3">
                    <div class="tab-pane active">
                      <form class="form" action="<?php echo URLROOT; ?>/users/modify" method="post">
                      <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <label>Username</label>
                                        <div class="input-group-prepend d-flex flex-column mb-3 <?php echo (!empty($data['edit_username_err']))? 'is-invalid' : ''; ?>">
                                            <div class="d-flex flex-row input-holder">
                                              <span class="icon input-group-text bg-white px-4 border-md border-right-0">
                                                  <i class="fa fa-user text-muted"></i>
                                              </span>
                                              <input type="text"  placeholder="<?php echo $_SESSION['username'];?>" name="edit_username" class="input form-control bg-white border-md border-left-0 pl-3" value="<?php echo $data['edit_username']; ?>">
                                          </div>
                                          <span class="invalid-feedback"><?php echo $data['edit_username_err']; ?></span>
                                        </div>   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Email</label>
                                          <!-- Email Address -->
                                            <div class="input-group-prepend d-flex flex-column mb-3  <?php echo (!empty($data['edit_email_err']))? 'is-invalid' : ''; ?>">
                                              <div class="d-flex flex-row input-holder">
                                              <span class="input-group-text bg-white px-4 border-md border-right-0">
                                              <i class="fa fa-envelope text-muted"></i>
                                          </span>
                                          <input type="email"  placeholder="<?php echo $_SESSION['email'];?>" name="edit_email" class="form-control bg-white border-left-0 border-md" 
                                          value="<?php echo $data['edit_email']; ?>">
                                      </div>
                                      <span class="invalid-feedback"><?php echo $data['edit_email_err']; ?></span>
                                    </div>                            
                                  </div>
                                </div>
                                
                              </div>
                            </div>
                          <div class="row">
                                <div class="col-12 col-sm-6 mb-3">
                                    <div class="mb-2"><b>Change Password</b></div>
                                        <div class="row">
                                              <div class="col">
                                              <!-- Password -->
                                                  <div class="input-group-prepend d-flex flex-column mb-3  <?php echo (!empty($data['edit_password_err']))? 'is-invalid' : ''; ?>">
                                                    <div class="d-flex flex-row input-holder">
                                                          <span class="input-group-text bg-white px-4 border-md border-right-0">
                                                              <i class="fa fa-lock text-muted"></i>
                                                          </span>
                                                          <input type="password"  name="edit_password" placeholder="Enter your password" class="form-control bg-white border-left-0 border-md" value="<?php echo $data['edit_password']; ?>">
                                                    </div>
                                                      <span class="invalid-feedback"><?php echo $data['edit_password_err']; ?></span>
                                                  </div>
                                              </div>
                                        </div>
                                    <div class="row">
                                          <div class="col">
                                      <!-- New Password -->
                                                <div class="input-group-prepend d-flex flex-column mb-3  <?php echo (!empty($data['edit_new_password_err']))? 'is-invalid' : ''; ?>">
                                                    <div class="d-flex flex-row input-holder">
                                                          <span class="input-group-text bg-white px-4 border-md border-right-0">
                                                              <i class="fa fa-lock text-muted"></i>
                                                          </span>
                                                          <input type="password"  name="edit_new_password" placeholder="New Password" class="form-control bg-white border-left-0 border-md" value="<?php echo $data['edit_new_password']; ?>">
                                                    </div>
                                                      <span class="invalid-feedback"><?php echo $data['edit_new_password_err']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="row">
                                            <div class="col">
                                          <!-- Confirm Password -->
                                                    <div class="input-group-prepend d-flex flex-column mb-3  <?php echo (!empty($data['new_confirm_password_err']))? 'is-invalid' : ''; ?>">
                                                          <div class="d-flex flex-row input-holder">
                                                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                                                    <i class="fa fa-lock text-muted"></i>
                                                                </span>
                                                                <input type="password"  name="new_confirm_password" placeholder=" Confirm New Password" class="form-control bg-white border-left-0 border-md" value="<?php echo $data['new_confirm_password']; ?>">
                                                          </div>
                                                            <span class="invalid-feedback"><?php echo $data['new_confirm_password_err']; ?></span>
                                                    </div>
                                              </div>
                                    </div>
                                  </div>
    
                                  <div class="col-12 col-sm-5 offset-sm-1 mb-3">
                                      <div class="mb-2"><b>Keeping in Touch</b></div>
                                      <div class="row">
                                            <div class="col">
                                              <label>Email Notifications</label>
                                              <div class="custom-controls-stacked px-2">
                                                <div class="row justify-content-center">
                                                    <div>
                                                      <?php if($_SESSION['notification'] == 1) {?>
                                                                <input type="checkbox" name="checkbox_send_notif" checked><i class="fa fa-envelope-o fa-fw"></i>
                                                                  <label class="form-check-label" for="materialIndeterminate2">Receive notifications by email</label>
                                                              <?php }else {?>
                                                              <input type="checkbox" name="checkbox_send_notif" unchecked><i class="fa fa-envelope-o fa-fw"></i>
                                                              <label for="notifications-news">Newsletter</label>
                                                              <?php }?>
                                                      </div>
                                                  </div>
                                                </div>
                                              </div>
                                          </div>
                                    </div>
                                  </div>
                          <!-- Submit Modify -->
                          <div class="row">
                            <div class="col d-flex justify-content-end">
                            <div class="mt-2">
                                <button class="btn btn-primary" type="submit" value="modify">
                                  <i class="fa fa-fw fa-edit"></i>
                                  <span>Save Changes</span>
                                </button>
                            </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<?php require APPROOT.'/views/inc/footer.php'; ?>