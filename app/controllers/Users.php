<?php
    class Users extends Controller
    {
        // Construct
        public function __construct()
        {
            $this->userModel = $this->model('User');
            $this->postModel = $this->model('Post');
        }
        //Register Method
        public function register()
        {      
            //Check If the User is login or Not
            if(!$this->isloggedIn())
            {
                    //check for post
                if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST))
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
                    if(empty($data['username'])){
                        $data['username_err'] = 'Please enter username';
                    } elseif (strlen($data['username']) > 30) {
                        $data['username_err'] = 'Long Username';
                    }
                    else {
                     
                        if($this->userModel->findUserByUsername($data['username'])){
                            $data['username_err'] = 'Username is already taken';
                        }
                    }
                      //validate Email
                      if(empty($data['email']))
                      {
                          $data['email_err'] = 'Please Enter Your Email';
                      }
                      elseif($this->userModel->getemailbyuser($data['email']))
                      {
                          $data['email_err'] = 'Email Already Exist';
                      }else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                          $data['email_err'] = 'Email is not valid';
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
                                    <p style="text-indent: 50px;  text-align: justify;letter-spacing: 3px;">To activate your account please click <a href="' .$_SERVER['HTTP_HOST'] . '/Camagru/users/confirm/?token='. $token .'"><button color:green>Here</button></a> This is an automatic mail please do not reply</p>               
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
                    }else{
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
            else
                redirect('pages/index');      
        }
        //Login Method
        public function login()
        {    
            if(!$this->isloggedIn())
            {
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
                        }

                        //validate and check For Username
                        if($this->userModel->findUserByUsername($data['username']) == false)
                        {
                            $data['username_err'] = 'No User Found';
                            
                        }
                        //make sure Errors are Empty
                        if(empty($data['username_err']) && empty($data['password_err']))
                        {
                        // Validate And check and set Login User
                            $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                            if($loggedInUser)
                            {
                                if($loggedInUser->confirmed == '1')
                                {
                                    //create session
                                    
                                $this->createUserSession($loggedInUser);
                                    redirect('pages/index');
                                }else{
                                    flash('login_success', 'You account is not verified','alert alert-danger');
                                    redirect('users/login');
                                    } 
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
            }else
                redirect('pages/index');
         
        }
        //Confirm Acounts
        public function confirm()
        {
                $data =['token' => $_GET['token']];
                $row = $this->userModel->getUserByToken($data['token']);
                if(isset($_GET['token']) && $_GET['token'] != "")
                {
                    if($_GET['token'] == $row->token)
                    {
                        $page = ['title' => "Thank You"];
                        flash("Verification_success","Your Acount Has benn Verified ");
                        $this->view("users/confirm", $page);
                        $data = ['token' => $_GET['token']];
                        $this->userModel->confirm($data);
                    }
                    else
                    redirect('users/token');
                }
                else
                    $this->view("users/login");
                   
        }
        // Logout Method
        public function logout()
        { if(isset($_GET['token']))
            {
                    unset($_SESSION['id']);
                    unset($_SESSION['username']);
                    unset($_SESSION['email']);
                    unset($_SESSION['notification']);
                    session_destroy();
                    redirect('users/login');
            }else
            {
                redirect('posts/index');
            }
        }
        // check if user login or not
        public function isloggedIn()
        {
             if(isset($_SESSION['id']))
            {
                  return true;
            }else{
                  return false;
                }
        }
        //Forgot Password Method
        public function fgpass()
        {   
            
            //check For the Post
                    if($_SERVER['REQUEST_METHOD'] == 'POST')
                    {
                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                        $data =[
                            'email' => trim($_POST['email']),
                            'email_err' => '' 
                        ];
                        //validate Email
                        if($this->userModel->checkemailconfirmed($data['email']) == false)
                        {
                            flash("confirm_danger","Please Confirm your email At first","alert alert-danger");     
                            $data['email_err'] = 'Please Confirm your email At first';
                        }
                        if(empty($data['email'])){
                            $data['email_err'] = 'Please enter email';
                        }
                        elseif($this->userModel->getemailbyuser($data['email']) == false){
                            $data['email_err'] = 'Email Not Found';
                        }
                            if(empty($data['email_err']))
                            {
                                $row = $this->userModel->getemailbyuser($data['email']);
                                if($row->token == "")
                                {
                                    //Generate A new Token
                                    $token1 = substr(md5(openssl_random_pseudo_bytes(20)), 10);
                                    $data['token'] = $token1;
                                    $this->userModel->updateTokenbyemail($data);
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
                                } else{
                                    $this->view('users/fgpass', $data);
                        }

                    }
                    else{
                        $data =['email' => '',
                            'email_err' => ''];
                        $this->view('users/fgpass', $data);
                        }
                    

        }
        // Change Pass
        public function changepass()
        {   
            //check For the token
          
                $data =['token' => $_GET['token']];
                $row = $this->userModel->getUserByToken($data['token']);
              
                    if($_GET['token'] == $row->token)
                    {
                        $token = $_GET['token'];
                        if($_SERVER['REQUEST_METHOD'] == 'POST')
                        {
                            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                            $data  =[
                                    'password' => trim($_POST['password']),
                                    'confirm_password' => trim($_POST['confirm_password']),
                                    'token' => $token,
                                    'password_err' => '',
                                    'confirm_password_err' => ''
                                 ];
                            if(empty($data['password']))
                            {
                                $data['password_err'] = 'Please enter Password';
                            }
                            elseif(strlen($_POST['password']) < 6 || ctype_lower($_POST['password']))
                            {
                                 $data['password_err'] = 'To create password, you have to meet all of the following requirements:Mini 8 char,At least one special character,one number';
                            }
                            if(empty($data['confirm_password']))
                            {
                                $data['confirm_password_err'] = 'Please confirm Password';
                            }
                            elseif($_POST['password'] != $_POST['confirm_password'])
                            {
                                $data['confirm_password_err'] = 'Passwords not match';
                            }
                            if(empty($data['password_err']) && empty($data['confirm_password_err']))
                            {
                                $data['password'] = hash('whirlpool', $data['password']);
                        
                                if($this->userModel->changepass($data))
                                {
                                     flash('changepass_success', 'You Password Changed');
                                     redirect('users/login');
                                }
                                else
                                {
                                    die('Something went wrong');
                                }
                            }
                            else
                            {
                                  $this->view('users/changepass', $data);
                            }
                        }else
                        {
                         $data =[
                                'password' => '',
                                 'confirm_password' => '',
                                 'password_err' => '',
                                 'confirm_password_err' => ''
                                 ];
                            $this->view('users/changepass', $data);
                        }
                    }
                    else
                    {
                    redirect('users/token');
                    }
                          
        }
        //Email Send
        public function emailsend(){
            $page = ['title' => "Congratulations!"];
          
            $this->view("users/emailsend", $page);
            
            
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
                        //validate username
                        if(empty($data['username']))
                        {
                            $data['username_err'] = 'The Username Field is required.';
                        }
                        elseif(strlen($_POST['username']) < 6 || strlen($_POST['username']) > 8 )
                        {
                                    $data['username_err'] = 'To create Username, you have to meet at Mini 6 char and In max 8 char';
                        }
                        elseif(!ctype_alnum($data['username']) && !empty($data['username']))
                        {
                            $data['username_err'] = 'Please Enter Alphanumeric Username';
                        }
                        /*elseif($this->userModel->findUserByUsername($data['username']))
                        {
                            $data['username_err'] = 'Username Already Exist';
                        }*/
                        //validate Email
                        if(empty($data['email']))
                        {
                            $data['email_err'] = 'The Email Field is required.';
                        }
                       /* elseif($this->userModel->getemailbyuser($data['email']))
                        {
                            $data['email_err'] = 'Email Already Exist';
                        }*/
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
                                    $to = $data['email'];
                                    
                                    $row = $this->userModel->getemail($data['email']);
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
                               
                                }
                                if ($this->userModel->modify($data)) {
                                    
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
                        }
                if(isset($_SESSION['id']))
                    $this->view('users/modify', $data);
                else
                    $this->view('pages/index');
            
        }
        // Profile of users
        public function profile()
        {
            $posts = $this->postModel->getImagesbyUsr($_SESSION['id']);
            $data = ['title' => $_SESSION['username'],
                     'posts' => $posts  
            ];
            if(isset($_SESSION['id']))
             {       $this->view('users/profile', $data);
               }  else{


                   redirect('users/login');
               }
                logout();
        }
        // Token  
        public function token()
        {
            
            $page = ['title' => "Sorry"];

            $this->view("users/token", $page);
         
        
        }
        //Create User Session
        public function createUserSession($user)
        {
          $token = substr(md5(openssl_random_pseudo_bytes(20)), 10);
          $_SESSION['token'] = $token;

          $_SESSION['id'] = $user->id;
          $_SESSION['username'] = $user->username;
          $_SESSION['email'] = $user->email;
          $_SESSION['notification'] = $user->notification;
          redirect('pages/index');          
        }
    }
?>