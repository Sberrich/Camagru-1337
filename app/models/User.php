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
        public function getemail($email)
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
            $this->db->query("UPDATE user SET `password`= :password WHERE token= :token");
            $this->db->bind(':password', $pass);
            $this->db->bind(':token', $token);
            if($this->db->execute())
            {
                $this->db->query('UPDATE user SET token = null WHERE token = :token');
                $this->db->bind(':token', $token);
                if($this->db->execute()) return true;
                return true;
            }
            else
                return false;
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
        // Find user by id
        public function findUserById(){
          $this->db->query('SELECT * FROM user WHERE id = :id');
          $this->db->bind(':id', $_SESSION['id']);
  
          $row = $this->db->single();
      
          return $row; 
      }

         // Edit user
        public function modify($data){
          $row = $this->findUserById();
          var_dump($this->findUserById());
          if($row)
          {
            $hashed_password = $row->password;
            
            if(password_verify($data['edit_password'] ,$hashed_password)){
                $_SESSION['notification'] = $data['checkbox_send_notif'];
                echo"ready";
                var_dump($_SESSION['notification']);
                if($this->update($data))
                    return true;
                else 
                    return false;
              }
              else
                  return false;
          }
      }

      // Update
      public function update($data)
      {
          $this->db->query('SELECT * FROM user WHERE id = :id');
          $this->db->bind(':id', $data['id']);
          echo "1";
          $row = $this->db->single();
          $mail = $data['edit_email'] != "" ? $data['edit_email'] : $row->email;
          $pass = $data['edit_new_password'] != "" ? hash('whirlpool',$data['edit_new_password']) : $row->password;
          $username = $data['edit_username'] != "" ? $data['edit_username'] : $row->username;
          echo"ready";
          
          $data['edit_password'] = $pass;
          $_SESSION['username'] = $username;
          $_SESSION['email'] = $mail;
          $_SESSION['password'] = $pass;
          $this->db->query('UPDATE `user` SET 
          `username`=:edit_username,`email`=:edit_email,`password`=:edit_new_password, `notif`= :n WHERE id = :id');
          $this->db->bind(':edit_username', $username);
          $this->db->bind(':edit_email', $mail);
          $this->db->bind(':edit_new_password', $pass);
          $this->db->bind(':n', $data['checkbox_send_notif']);
          $this->db->bind(':id', $data['id']);
          echo "hi";
          if($this->db->execute()){
            echo "ok";
            return true;
          }else {
            
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
       
       
}
?>