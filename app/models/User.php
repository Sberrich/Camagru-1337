<?php
    class User{
        private $db;
        
        public function __construct()
        {
            $this->db = new Database;
        }
        //register Model
        public function register($data)
        {
          $this->db->query('INSERT INTO user (username, email, password, token) VALUES(:username, :email, :password, :token)');
          $this->db->bind(':username', $data['username']);
          $this->db->bind(':email', $data['email']);
          $this->db->bind(':password', $data['password']);
          $this->db->bind(':token', $data['token']);
          if($this->db->execute()){
            return true;
           } else {
            return false;
           }
        }
        // Login Model
        public function login($username, $password)
        {
            $this->db->query('SELECT * FROM user WHERE username = :username');
            $this->db->bind(':username', $username);
            
            $row = $this->db->single();
            
            $hashed_password = $row->password;
            $hash = hash('whirlpool', $password);
            if($hash == $hashed_password){
              return $row;
            } else {
              return false;
            }
        }
        //Find User By username
        public function findUserByUsername($username)
        {
          $this->db->query('SELECT * FROM user WHERE username = :username');
          $this->db->bind(':username', $username);
          $row = $this->db->single();
          if($this->db->rowCount() > 0){
              return true;
          }else{
            return false;
          }
        }
        //Find User By id
        public function findUserById()
        {
          $this->db->query('SELECT * FROM user WHERE id = :id');
          $this->db->bind(':id', $_SESSION['id']);
          $row = $this->db->single();
          if($this->db->rowCount() > 0){
              return true;
          }else{
            return false;
          }
        }
        //Get User by Token
        public function getUserByToken($token)
        {
            $this->db->query('SELECT * FROM user WHERE token = :token');
            $this->db->bind(':token', $token);
            $row = $this->db->single();
            return $row;
        }
        //Update And Expire Token
        public function updateTokenbyemail($data)
        {
            $this->db->query('UPDATE user SET token = :token WHERE email = :email');
            $this->db->bind(':token', $data['token']);
            $this->db->bind(':email', $data['email']);
            if($this->db->execute())
                return true;
            else
                return false;
        }
        //FindUserByEmail
        public function getemailbyuser($email)
        {
            $this->db->query('SELECT * FROM user WHERE email = :email');
            $this->db->bind(':email', $email);
            $row = $this->db->single();
            if($this->db->rowCount() > 0){
                return true;
            }else{
              return false;
            }
        }
        //Get User By Email
        public function getUserByEmail($email)
        {
            $this->db->query('SELECT * FROM user WHERE email = :email');
            $this->db->bind(':email', $email);
            $row = $this->db->single();
            return $row;
        }
        //Change PassWord
        public function changepass($data)
        {
            
            $pass = $data['password'];
            $token = $data['token'];
            $this->db->query("UPDATE user SET `password`=:`password` WHERE token= :token");
            $this->db->bind(':password', $pass);
            $this->db->bind(':token', $token);
            if($this->db->execute())
            {
                $this->db->query('UPDATE user SET token = null WHERE token= :token');
                $this->db->bind(':token', $token);
                if($this->db->execute()) return true;
                return true;
            }
            else
                return false;
        }
        //Check The User Confimation
        public function checkuserconfirmed($username)
        {
            $this->db->query('SELECT * FROM user WHERE username = :username');
            $this->db->bind(':username', $username);
            $row = $this->db->single();
            $chek = $row->confirmed;
            if($chek == 1){
                return true;
            }else{
              return false;
            }
        }
        //Check The User Confimation
        public function checkemailconfirmed($email)
        {
            $this->db->query('SELECT * FROM user WHERE email = :email');
            $this->db->bind(':email', $email);
            $row = $this->db->single();
            $chek = $row->confirmed;
            if($chek == 1){
                return true;
            }else{
              return false;
            }
        }
        //Forgot PassWord
        public function forgottenpass($data)
        {
                $this->db->query('UPDATE user SET username = :username WHERE token = :token');
                $this->db->bind(':username', $data['username']);
                $this->db->bind(':token', $data['token']);

                  if($this->db->execute()){
                    return true;
                  } else {
                    return false;
                  }
        }
        //Confirm
        public function confirm($data)
        {
            $token = $data['token'];
           
            $this->db->query('UPDATE user SET confirmed = 1 WHERE token= :token');
            $this->db->bind(':token', $token);
            if($this->db->execute())
            {
              
              $this->db->query('UPDATE user SET token = NULL WHERE token= :token');
              $this->db->bind(':token', $token);
              if($this->db->execute()) return true;
              
                return true;
            }
            else{
                return false;
            }
        }
        //Update Profile 
        public function modify($data)
        {
          
           $this->db->query('SELECT * FROM user WHERE id = :id1');
           $this->db->bind(':id1', $data['id']);
           $row = $this->db->single();
           $mail = $data['email'] != "" ? $data['email'] : $row->email;
           $pass = $data['password'] != "" ? $data['password'] : $row->password;
           $user = $data['username'] != "" ? $data['username'] : $row->username;
           $_SESSION['username'] = $user;
           $this->db->query('UPDATE  `user` SET `username` = :uname1 , email = :email1 , `password` = :password1, `notification` = :notif  WHERE id = :id1');
           $this->db->bind(':uname1', $user);
           $this->db->bind(':email1', $mail);
           $this->db->bind(':password1', $pass);
           $this->db->bind(':id1', $data['id']);
            $this->db->bind(':notif', $data['notif']);
           // Execute
           if ($this->db->execute()) {
               return true;
           } else {
               return false;
           }
        }
        //Flash Method
        public function flash($key,$value)
        {
          if (isset($_SESSION['flash']))
               echo $_SESSION['flash'];
           unset($_SESSION['flash']);
        }
        //Get Comment
        public function get_commenter($userid)
        {
          $this->db->query('SELECT * FROM user WHERE userid = :userid');
          $this->db->bind(':userid',$userid);
          $result = $this->db->single();
          if($result)
            return ($result);
              else
          return false;
        } 
       
}
?>