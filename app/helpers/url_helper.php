<?php
    // Simple page redirect
    function redirect($page){
        echo "<script>location.replace('". URLROOT . '/' . $page."')</script>";
    }
  // check if user login or not
  function isloggedIn()
  {
       if(isset($_SESSION['id']))
      {
            return true;
      }else{
            return false;
          }
  }
  //Create User Session
  function createUserSession($user)
  {
    $token = substr(md5(openssl_random_pseudo_bytes(20)), 10);
    $_SESSION['token'] = $token;

    $_SESSION['id'] = $user->id;
    $_SESSION['username'] = $user->username;
    $_SESSION['email'] = $user->email;
    $_SESSION['notification'] = $user->notification;
    redirect('pages/index');          
  }
  // Logout Method
  function logout()
  {
              unset($_SESSION['id']);
              unset($_SESSION['username']);
              unset($_SESSION['email']);
              unset($_SESSION['notification']);
              session_destroy();
              redirect('users/login');
  }
