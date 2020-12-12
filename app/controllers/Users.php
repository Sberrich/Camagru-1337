<?php
    class Users extends Controller{
        public function __construct(){
            $this->userModel = $this->model('User');
            $this->postModel = $this->model('Post');
          
        }
        //Register Method
        public function register()
        {      
            //Check If the User is login or not
            if($this->isloggedIn())
            {
                redirect('pages/index');
            }
                //check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                // Proccess Form
                $token = substr(md5(openssl_random_pseudo_bytes(20)), 10);

                //Sanitize Post Data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //Init Data
                $data =['username' => trim($_POST['username']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'email' => trim($_POST['email']),
                    'token' => $token,
                    'username_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];
                //validate username
                    if(empty($data['username']))
                    {
                        $data['username_err'] = 'The Username Field is required.';
                    }
                    elseif(!ctype_alnum($data['username']) && !empty($data['username']))
                    {
                        $data['username_err'] = 'Please Enter Alphanumeric Username';
                    }
                    elseif($this->userModel->findUser($data['username']))
                    {
                        $data['username_err'] = 'Username Already Exist';
                    }

                 //validate Password
                    if(empty($data['password']))
                    {
                        $data['password_err'] = 'The Password Field is required.';
                    }
                    elseif(strlen($_POST['password']) < 6 || ctype_lower($_POST['password']))
                    {
                        $data['password_err'] = 'To create password, you have to meet all of the following requirements:Mini 8 char,At least one special character,one number';
                    }

                 //Confirm Password
                    if(empty($data['confirm_password']))
                    {
                        $data['confirm_password_err'] = 'Please confirm Password';
                    }
                    elseif($_POST['password'] != $_POST['confirm_password'])
                    {
                        $data['confirm_password_err'] = 'Passwords not match';
                    }

                //validate Email
                    if(empty($data['email']))
                    {
                        $data['email_err'] = 'The Email Field is required.';
                    }
                    elseif($this->userModel->findUserByEmail($data['email']))
                    {
                        $data['email_err'] = 'Email Already Exist';
                    }

                // Make sure Errors fileds are empty
                    if(empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['email_err']))
                    {
                        //Hash Password
                        $data['password'] = hash('whirlpool', $data['password']);

                        //Send Validation Mail
                        $to  = $data['email'];
                        $subject = 'Confirm Account';
                        $message = '
                        <html>
                            <meta charset="UTF-8">
                            <body style= " background-color: lightblue;">
                                <h1 style="text-align: center;text-transform: uppercase;">Welcome to Camagru</h1>
                                <p style="font-size:48px;text-align: center;">&#128512; &#128516; &#128525;&#128151;</p>
                                 <p style="text-indent: 50px;  text-align: justify;letter-spacing: 3px;">To activate your account please click <a href="http://localhost/Camagru/users/confirm/?token='. $token .'"><button color:green>Here</button></a> This is an automatic mail please do not reply</p>               
                            </body>
                         </html>                    
                        ';
                        $headers = 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                        mail($to, $subject, $message , $headers);

                        //Register User
                             if($this->userModel->register($data))
                             {
                                 flash('register_success', 'Check Your Email Please To Confirm Your Account!');
                                 redirect('users/login');
                             }
                             else
                             {
                                die('Something went wrong');
                             }
                    }else{
                        // Load view with errors
                            $this->view('users/register', $data);
                        }
                }else
                     {
                    //Init Data
                        $data =['username' => '',
                            'password' => '',
                            'email' => '',
                            'confirm_password' => '',
                            'username_err' => '',
                            'email_err' => '',
                            'password_err' => '',
                            'confirm_password_err' => ''
                        ];
                    //Load View
                    $this->view('users/register', $data);
                     }
     }
    //Login Method
        public function login()
        {    
            if($this->isloggedIn())
                redirect('pages/index');

                //Check the Post
                 if($_SERVER['REQUEST_METHOD'] == 'POST')
                 {
                        // sanitize the Post Data
                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                       //Init data
                        $data =['username' => trim($_POST['username']),
                        'password' => trim($_POST['password']),
                        'username_err' => '',
                        'password_err' => '',
                        ];

                        //validate Username
                        if(empty($data['username'])){
                            $data['username_err'] = 'Please enter Username';
                        }

                        //validate Password
                        if(empty($data['password'])){
                            $data['password_err'] = 'Please enter Password';
                        }elseif(strlen($_POST['password']) < 6|| ctype_lower($_POST['password'])) {
                        $data['password_err'] = 'To create password, you have to meet all of the following requirements:Mini 8 char,At least one special character,one number';
                        }

                        //validate and check For Username
                        if($this->userModel->findUser($data['username']) == false)
                        {
                            $data['username_err'] = 'No User Found';
                            
                        }elseif($this->userModel->checkuserconfirmed($data['username'])){
                            
                        }
                        else{
                        $data['username_err'] = 'Please Check Your Email to confirm your Account';
                            
                        }

                        //make sure Errors are Empty
                        if(empty($data['username_err']) && empty($data['password_err']))
                        {
                        // Validate And check and set Login User
                            $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                        
                             if($loggedInUser)
                            {
                                //create session
                                $this->createUserSession($loggedInUser);
                            }else{
                                $data['password_err'] = "Password incorrect";
                                $this->view('users/login', $data);
                            }
                        }else{
                            //Load view with Errors
                            $this->view('users/login', $data);
                        }

                    }else{
                        //Init Data
                        $data =['username' => '',
                            'password' => '',
                            'username_err' => '',
                            'password_err' => '',
                        
                        ];
                        //Load View
                        $this->view('users/login', $data);
                    }
                 }  
                // Logout Method
                public function logout()
                {
                    unset($_SESSION['id']);
                    unset($_SESSION['username']);
                    unset($_SESSION['email']);
                    unset($_SESSION['notification']);
                    session_destroy();
                    redirect('users/login');
                }
                // check if user login or not
                public function isloggedIn(){
                    if(isset($_SESSION['id']))
                    {
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                //Create User Session
                public function createUserSession($user)
                {
                    $_SESSION['id'] = $user->id;
                    $_SESSION['username'] = $user->username;
                    $_SESSION['email'] = $user->email;
                    $_SESSION['notification'] = $user->notification;
                    redirect('pages/index');
                }

        public function fgpass()
        {
              if($this->isloggedIn())
                redirect('pages/index');
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data =[
                    'email' => trim($_POST['email']),
                    'email_err' => '' 
                ];
                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                }
                elseif($this->userModel->findUserByEmail($data['email']) == false){
                    $data['email_err'] = 'Email Not Found';
                }
                    
                if(empty($data['email_err']))
                {
                        $row = $this->userModel->getUserByEmail($data['email']);
                        $token = $row->token;
                        $to  = $data['email'];
                        $subject = 'Recover account';
                        $message = '
                            <html>
                            <head>
                            </head>
                            <body>
                                <p>To recover your account click here <a href="http://localhost/Camagru/users/changepass/?token='. $token .'"><button 
                                type="button" class="btn btn-primary">Change Password</button></a></p>
                            </body>
                            </html>
                        ';
                        $headers = 'MIME-Version: 1.0'. "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                        $headers .= 'To: ' . $to."\r\n";
                        if(mail($to, $subject, $message , $headers))
                            redirect('users/emailsend');
                    }
                
                else{
                     $this->view('users/fgpass', $data);
                }

            }
            else{
                $data =['email' => '',
                    'email_err' => ''];
                $this->view('users/fgpass', $data);
            
                }
                
        }
        
        public function changepass()
        {
           
            if(isset($_GET['token'])){
                 $token = $_GET['token'];
             if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
                   
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data =[
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'token' => $token,
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];
                  if(empty($data['password'])){
                    $data['password_err'] = 'Please enter Password';
                }elseif(strlen($_POST['password']) < 6 || ctype_lower($_POST['password'])){
                    $data['password_err'] = 'To create password, you have to meet all of the following requirements:Mini 8 char,At least one special character,one number';
                }

                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = 'Please confirm Password';
                }elseif($_POST['password'] != $_POST['confirm_password']){
                    $data['confirm_password_err'] = 'Passwords not match';
                }
                  if(empty($data['password_err']) && empty($data['confirm_password_err'])){
                    $data['password'] = hash('whirlpool', $data['password']);
                   
                    if($this->userModel->changepass($data)){
                       
                        flash('changepass_success', 'You Password Changed');
                        redirect('users/login');
                      } else {
                        die('Something went wrong');
                      }
                }else{
                     
                    $this->view('users/changepass', $data);
                }
            }
                else{
                $data =[
                    'password' => '',
                    'confirm_password' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];
                $this->view('users/changepass', $data);
             }
            }
        }
        
        public function confirm(){
            $page = ['title' => "Congratulations!"];
            
            $this->view("users/confirm", $page);
            if(isset($_GET['token']))
            {
                $data = ['token' => $_GET['token']];
                $this->userModel->confirm($data);
            }
        }
        
         public function emailsend(){
            $page = ['title' => "Congratulations!"];
            
            $this->view("users/emailsend", $page);
        }
        
        
        public function profile()
        {
            $posts = $this->postModel->getImagesbyUsr($_SESSION['id']);
            $data = ['title' => $_SESSION['username'],
                     'posts' => $posts
                
            ];
            $this->view("users/profile", $data);
        }




  // Modify
  public function modify()
  {
      // Check for POST
      if ($_SERVER['REQUEST_METHOD'] == 'POST')
      {
         //Sanitize Post Data
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
         //init Data
        $data = [
            'id' => $_SESSION['id'],
            'username' => trim($_POST['username']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'username_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => '',
            'notif' =>  $_POST['notif']
        ]; 

        //Validate Username
            if($this->userModel->findUser($data['username'])) {
                $data['username_err'] = 'Name  is already taken';
             }elseif(!ctype_alnum($data['username']) && !empty($data['username']))
             {
                    $data['username_err'] = 'The Username Field is required.';
            }

        //validate Email
           if($this->userModel->findUserByEmail($data['email'])) {
                  $data['email_err'] = 'Email is already taken';
           }
           //valide Password And Confirm Password
            if ($data['password'] && $data['confirm_password'])
            {
                if (strlen($data['password']) < 6 || ctype_lower($_POST['password']))
                {
                    $data['password_err'] = 'To create password, you have to meet all of the following requirements:Mini 8 char,At least one special character,one number';
                } elseif (empty($data['confirm_password']))
                 {
                    $data['confirm_password_err'] = 'Please confirm password';
                 } elseif ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            //Notif Check
            if(!empty($data['notif']))
            {
                $data['notif'] = 1;
                $_SESSION['notification'] = 1;
            
            }
            else{
                $data['notif'] = 0;
                $_SESSION['notification'] = 0;
                
            }
            //Make Sure Errors Are Empty

            if (empty($data['email_err']) && empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err']))
            {                        
                if (!(empty($data['password']))) {
                    $data['password'] = hash('whirlpool', $data['password']);
             }if(empty($data['email_err']))
             {
                     $row = $this->userModel->getUserByEmail($data['email']);
                     $subject = 'Modify account';
                     $message = '
                     <html>
                     <meta charset="UTF-8">
                        <body style= " background-color: lightblue;">
                        <h1 style="text-align: center;text-transform: uppercase;">Camagru Notification</h1>
                       <h2>Your account details has been successfully updated;</h2>
                       <span style="font-size:100px;>&#129488;&#128248;</span>
                       </body>
                     </html>                    
                      ';
                      $headers = 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                      mail($to, $subject, $message , $headers);
                     if(mail($to, $subject, $message , $headers))
                         redirect('users/emailsend');
                 }
            if ($this->userModel->modify($data)) {
                flash('modify_success', 'Your account is modified');
                redirect('users/modify');
            } else {
                die('Something went wrong');
            }
        } else {
            if(isset($_SESSION['id']))
                    $this->view('users/modify', $data);
            else
                    $this->view('pages/index');
        }
    } else {
        $data = [
            'username' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'username_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => '',
        ];
        if(isset($_SESSION['id']))
            $this->view('users/modify', $data);
        else
            $this->view('pages/index');
    }
} 
    }
