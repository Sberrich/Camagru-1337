<?php
class Users extends Controller{

    }

    public function edit()
    {
        if($this->userModel->findUserById()){
            if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $_SESSION['user_id'],
                'actif' => 1,
                'checkbox_notif' => $_POST['notif'],
                'notif' => 0,
                'edit_username' => trim($_POST['edit_username']),
                'edit_lastname' => trim($_POST['edit_lastname']), 
                'edit_firstname' => trim($_POST['edit_firstname']), 
                'edit_email' => trim($_POST['edit_email']),
                'edit_new_password' => $_POST['edit_new_password'],
                'edit_password' => $_POST['edit_password'],
                'checkbox_username' => $_POST['checkbox_username'],
                'checkbox_lastname' => $_POST['checkbox_lastname'],
                'checkbox_firstname' => $_POST['checkbox_firstname'],
                'checkbox_email' => $_POST['checkbox_email'],
                'checkbox_new_password' => $_POST['checkbox_new_password'],
                'edit_username_err' => '',
                'edit_lastname_err' => '',
                'edit_firstname_err' => '',
                'edit_email_err' => '',
                'edit_new_password_err' => '',
                'edit_password_err' => '',

            ];

            if(isset($data['checkbox_username']))
            {
                if(empty($data['edit_username']))
                    $data['edit_username_err'] = 'Enter username';
                else if($this->userModel->findUserByUsername($data['edit_username']))
                    $data['edit_username_err'] = 'Username is already taken';
            }else
                $data['edit_username'] = $_SESSION['user_username'];

            if(isset($data['checkbox_lastname']))
            {
                if(empty($data['edit_lastname']))
                    $data['edit_lastname_err'] = 'Enter lastname';
            } else
                    $data['edit_lastname'] = $_SESSION['user_lastname'];

            if(isset($data['checkbox_firstname']))
            {
                if(empty($data['edit_firstname']))
                $data['edit_firstname_err'] = 'Enter firstname';
            } else
                $data['edit_firstname'] = $_SESSION['user_firstname'];
        
            if(isset($data['checkbox_email']))
            {
                if(empty($data['edit_email']))
                $data['edit_email_err'] = 'Enter email';
                else if($this->userModel->findUserByEmail($data['edit_email'])){
                    $data['edit_email_err'] = 'Email is already taken';
                }else if (!filter_var($data['edit_email'], FILTER_VALIDATE_EMAIL)) {
                $data['edit_email_err'] = 'Email is not valid';
                }else {
                    flash('edit_danger', 'in the next login you will activate your account','alert alert-danger');
                    $data['actif'] = 0;
                }
            } else
                $data['edit_email'] = $_SESSION['user_email'];




            if(isset($data['checkbox_new_password']))
            {
                if(empty($data['edit_new_password']))
                     $data['edit_new_password_err'] = 'Enter new password';
                else if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,12}$/', $data['edit_new_password'])) {
                $data['edit_new_password_err'] = 'the password does not meet the requirements!';
            }
            } else
                $data['edit_new_password'] = $data['edit_password'];

            if(empty($data['edit_password']))
                $data['edit_password_err'] = 'Enter current password';

            if(empty($data['edit_firstname_err']) && empty($data['edit_lastname_err']) && empty($data['edit_username_err']) && empty($data['edit_email_err']) && empty($data['edit_new_password_err']) && empty($data['edit_password_err']))
            {
                if(isset($data['checkbox_notif']))
                {
                    $data['notif'] = 1;
                }else
                   $data['notif'] = 0;
                
                

                if($this->userModel->edit($data)){
                    if(isset($data['checkbox_email']))
                    {
                        $cle = md5(microtime(TRUE)*100000);
                    $this->userModel->update_cle($data['edit_email'], $cle);
                        activate_sent_email($data['edit_email'], $cle);
                    }

                }
                else
                    $data['edit_password_err'] = 'Password Incorrect';
               
                
            }
            else if(isloggedIn())
            {
                $this->view('users/edit', $data);
            }else
                redirect('users/login');

                

        }
            if(isloggedIn())
            {
                $this->view('users/edit', $data);
            }else
                redirect('users/login');
        }else
            logout();
        

        
        
    }
    
    public function verification(){
        if(isset($_GET['email']) && isset($_GET['cle']))
        {
            $email = $_GET['email'];
            $cle = $_GET['cle'];

            if($this->userModel->findUserByCle($cle, $email))
            {
                $da = $this->userModel->findUserByEmail($email);
                if($this->userModel->update_actif($da->id, 1))
                    {
                        
                        flash('login_success', 'You account is verified','alert alert-success');
                        redirect('users/login');

                    }
            
            }else
                die('token is not found');
        }
        else
            redirect('posts/home');
   
        
    }

    public function forgot_password(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'username' => $_POST['username'],
                'username_err' => '',
            ];
            if(empty($data['username']))
                $data['username_err'] = 'please enter username';
            else{ 
                $row = $this->userModel->getUserByUsername($data['username']);
                if($row)
                {
                    if($row->actif == 1)
                    {
                        if(forget_sent_email($row))
                        {
                            flash('forgot_success', 'Reset link is sent to your email', 'alert alert-success');
                        }else{
                            flash('forgot_success', 'Error sending email, please retry', 'alert alert-danger');
                            
                        }

                    } else{
                        flash('verification_danger', 'You account is not verified','alert alert-danger');
                        redirect('users/verification');
                        
                    }
                } else
                    $data['username_err'] = 'username is not exist';
        }
            
        }
        if(!isloggedIn())
        {
            $this->view('users/forgot_password', $data);
        }
        else
        {
            redirect('posts/home');
        }                   
            
        


    }

    public function recover(){
        if(isset($_GET['email']) && isset($_GET['cle']))
        {
            $email = $_GET['email'];
            $cle = $_GET['cle'];
            if($this->userModel->findUserByCle($cle, $email))
            {
                if($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    $data = [
                        'email' => trim($_GET['email']),
                        'cle' => trim($_GET['cle']),
                        'reset_password' => trim($_POST['reset_password']),
                        'reset_confirm_password' => trim($_POST['reset_confirm_password']),
                        'reset_password_err' => '',
                        'reset_confirm_password_err' => '',
                    ];
                    if(empty($data['reset_password'])){
                        $data['reset_password_err'] = 'Please enter password';
                    }else if (strlen($data['reset_password']) < 6) {
                        $data['reset_password_err'] = 'Password must be at least 6 characters';
                    }

                    //Confirm pass
                    if(empty($data['reset_confirm_password'])){
                        $data['reset_confirm_password_err'] = 'Please confirm password';
                    }else{
                        if ($data['reset_password'] != $data['reset_confirm_password'] ){
                        $data['reset_confirm_password_err'] = 'Passwords does not match';
                        }
                    }
                    if(empty($data['reset_confirm_password_err']) && (empty($data['reset_password_err'])))
                    {
                        $data['reset_password'] = password_hash($data['reset_password'], PASSWORD_DEFAULT);
                        if($this->userModel->update_password($data['email'], $data['reset_password']))
                        {
                            
                            flash('login_success', 'Your password is modified', 'alert alert-success');
                            redirect('users/login');
                            $cle = md5(microtime(TRUE)*100000);
                            if($this->userModel->update_cle($email, $cle))
                            {

                            }
                            else
                                die('token ra ghalat');
                        }else
                            die('rode lbale');
                    }
                }
            

                $this->view('users/recover', $data);
               
             
            } else
                die('chi haja mkhawra');
        } else 
                redirect('posts/home');


            
   
    }


   
}