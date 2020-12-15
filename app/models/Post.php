<?php
class Post{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    //Save Image in Folder with Stickers
    public function save($data)
    {    
        $this->db->query('INSERT INTO `Img` (`userid`, `imgedate`, `imgurl`) VALUES (:userid, NOW(), :imgurl)');
        $this->db->bind(':userid', $data['userid']);
        $this->db->bind(':imgurl', $data['imgurl']);
        if($this->db->execute()){
                 return true;
            }else {
             return false;
             }
    }
    //Get Images by User
    public function getImagesbyUsr($userid)
    {
        $this->db->query('SELECT * FROM Img JOIN `user` ON `Img`.`userid` = `user`.`id`  WHERE user.id=:userid order by imgedate desc');
        $this->db->bind(':userid', $userid);
        $row = $this->db->resultSet();
       
            if($row)
                return ($row);
            else
                return false;
    }
    //Get Images for index Page
    public function getImage()
    {
         $this->db->query('SELECT * FROM Img JOIN `user` ON `Img`.`imgid` = `user`.`id` order by imgedate desc ');
        $row = $this->db->resultSet();
            if($row)
            {
                return ($row);
            }
            else
            {
               false;
            }
    }
    //Remove Posts
    public function deletePost($imgid, $userid)
    {
        $this->db->query('SELECT * FROM Img WHERE imgid = :imgid AND userid = :userid');
        $this->db->query('DELETE FROM `Img` WHERE imgid= :imgid AND userid = :userid');
        $this->db->bind(':imgid', $imgid);
        $this->db->bind(':userid', $userid);
        $row = $this->db->single();
        unlink($row->imgurl);
        $this->db->bind(':imgid', $imgid);
        $this->db->bind(':userid', $userid);
        if($this->db->execute())
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    //Get Comments
    public function getComments()
    {
        $this->db->query("SELECT * FROM comment JOIN user on comment.userid = user.id order by cmntdate desc");
        $row = $this->db->resultSet();
        if($row)
        {
            return ($row);
        }
        else
        {
           false;
        }
    } 
    // Add Comments
    public function addComment($data)
    {
        $this->db->query("INSERT INTO `comment`(`userid`, `imgid`, `comment`, `cmntdate`) VALUES(:userid, :imgid, :comment, NOW())");
        $this->db->bind(':user_id',$data['user_id']);
        $this->db->bind(':userid', $userid);
        $this->db->bind(':imgid', $imgid);
        $this->db->bind(':comment', $comment);
  
          if($this->db->execute())
          {
              return true;
          }else
              return false;
    }
    //Add likes
    public function addLikes($data)
    {
        $this->db->query('INSERT INTO `like`(`userid`, `imgid`, `like`) VALUES(:userid, :imgid, 1)');
        $this->db->bind(':userid', $userid);
        $this->db->bind(':imgid', $imgid);
        if($this->db->execute())
        {
             return true;
        }else
            return false;   
    }
    //Delete Likes
    public function dellikes($data)
    {
        $this->db->query("DELETE FROM `like` WHERE userid=:userid AND imgid=:imgid");
        $this->db->bind(':userid', $userid);
        $this->db->bind(':imgid', $imgid);
        if($this->db->execute())
        {
            return true;
          }else
              return false;
    }
    //Get Likes
    public function getlikes()
    {
        $this->db->query('SELECT * FROM `like`');
        $row = $this->db->resultSet();
        return ($row);
    }
    //like numbers for images
    public function like_count($data)
    {
        $this->db->query('UPDATE `Img` SET likes = :likes WHERE imgid = :imgid');
        $this->db->bind(':likes', $data['likes']);
        $this->db->bind(':imgid', $data['imgid']);

        if($this->db->execute()){
            return true;
         }else {
            return false;
            }
    }
    // Count postes
    public function count_posts()
    {
        $this->db->query('SELECT count(*) FROM `Img`');
    
        $total = $this->db->fetchColumn();
        if($total)
        {
            return $total;
        }
        else
        {

            return false;
        }
    } 
    //Get User By Image Id
    public function getUserByPostId($imgid)
    {
        $this->db->query('SELECT * FROM `Img` WHERE imgid = :imgid');
        $this->db->bind(':imgid',$imgid);
    
        $result = $this->db->single();
        if($result)
          return ($result);
        else
          return false;
    } 
}
?>