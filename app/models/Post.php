<?php
class Post{
	private $db;

	public function __construct(){
		$this->db = new Database;
	}

	public function  save($data)
	{
		$this->db->query('INSERT INTO posts (user_id, path, created_at) VALUES (:user_id, :path, NOW())');
		$this->db->bind(':user_id', $data['user_id']);
		$this->db->bind(':path', $data['path']);
		if($this->db->execute())
			return true;
		else
			return false;
	}
	public function getPosts($depart, $postsPerPage){
        $this->db->query('SELECT *,
        posts.posts_id as postsId,
        users.id as usersId
        FROM posts
        INNER JOIN users
        ON posts.user_id = users.id
        ORDER BY posts.created_at DESC LIMIT '.$depart.','.$postsPerPage.'');
        $result = $this->db->resultSet();
        return ($result);
    }

    public function like_nbr($data)
 {
   $this->db->query('UPDATE posts SET like_nbr = :like_nbr WHERE posts_id = :post_id');
   $this->db->bind(':like_nbr', $data['like_nbr']);
   $this->db->bind(':post_id', $data['post_id']);
   if($this->db->execute()){
     return true;
   }else {
     return false;
   }
 }
 public function getcomments()
  {
    $this->db->query('SELECT *,
                      comments.id as commentId,
                      users.id as userId
                     FROM `comments`
                     INNER JOIN users
                     ON comments.user_id = users.id');

    $result = $this->db->resultSet();
    return ($result);
  }

 public function addcomment($data)
 {
   $this->db->query('INSERT INTO comments (user_id,  post_id, content) VALUES (:user_id,:post_id, :content )');
        $this->db->bind(':user_id',$data['user_id']);
        $this->db->bind(':post_id',$data['post_id']);
        $this->db->bind(':content',$data['content']);

        if($this->db->execute())
        {
            return true;
        }else
        {
            return false;
        } 
 }

    public function count_posts(){
        $this->db->query('SELECT count(*) FROM posts');
        $c = $this->db->fetchColumn();
        if($c)
            return $c;
        else
            return false;
    }
    public function addLike($data)
    {
        $this->db->query('INSERT INTO likes (like_user_id, like_post_id) VALUES (:user_id, :post_id)');
        $this->db->bind(':user_id',$data['user_id']);
        $this->db->bind(':post_id',$data['post_id']);

        if($this->db->execute())
        {
            return true;
        }else
        {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function getUserById($id){
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();
    
    //check row
        if($row)
            return $row; 
        else
            return false;

    }
    public function getUserByPostId($id)
    {
        $this->db->query('SELECT * FROM posts WHERE posts_id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();
    
    //check row
        if($row)
            return $row->user_id; 
        else
            return false;
    }

    public function deleteLike($data)
    {
        $this->db->query('DELETE FROM likes WHERE like_user_id = :user_id AND like_post_id = :post_id');
        $this->db->bind(':user_id',$data['user_id']);
        $this->db->bind(':post_id',$data['post_id']);

        if($this->db->execute())
        {
            return true;
        }else
        {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getPost($user_id){
        $this->db->query('SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC');
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->resultSet();
        return ($result);
    }
    public function getlikes(){
        $this->db->query('SELECT * FROM likes');
        $result = $this->db->resultSet();
        return ($result);
    }
    public function deletePost($postId, $user_id){
        $this->db->query('DELETE FROM posts WHERE posts_id = :posts_id AND user_id = :user_id');
        $this->db->bind(':posts_id', $postId);
        $this->db->bind(':user_id', $user_id);
        if($this->db->execute())
            return true;
        else
            return false;
    }
    public function isLiked($data)
    {
        $this->db->query('SELECT * FROM posts WHERE posts_id = :posts_id');
        $this->db->bind(':posts_id',$data['postId']);
        $row = $this->db->single();
    
    //check row
        if($this->db->rowCount() > 0){
            return $row->liked;
        } else {
            return false;
        }
    }
    public function like($data, $nbr)
    {
        $this->db->query('UPDATE posts SET liked=:liked  WHERE posts_id = :posts_id');
        $this->db->bind(':posts_id',$data['postId']);
        $this->db->bind(':liked',$nbr);
        if($this->db->execute()){
                return true;
            }else {
                return false;
        }

    }
}