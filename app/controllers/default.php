<?php
    class Posts extends Controller{
        public function __construct(){
             $this->postModel = $this->model('Post');
             $this->userModel = $this->model('User');
        }

        public function SaveImage(){
          if(isset($_SESSION['user_id']))
            {
            if(isset($_POST['imgData']) && isset($_POST['filtrsticker'])){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $upload_dir = "../public/img/";
                $img = $_POST['imgData'];
                $filter = $_POST['filtrsticker'];
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $file = $upload_dir . mktime().'.png';
                file_put_contents($file, $data);
                $sourceImage = $filter;
                $destImage = $file;
                list($srcWidth, $srcHeight) = getimagesize($sourceImage);
                $src = imagecreatefrompng($sourceImage);
                $dest = imagecreatefrompng($destImage);
                imagecopyresized($dest, $src, 0, 0, 0, 0, 150, 150, $srcWidth, $srcHeight);
                imagepng($dest, $file, 9);
                move_uploaded_file($dest, $file);
                
                $data = [
                    'user_id'  => $_SESSION['user_id'],
                    'path' => $file,
                ];
                  if($this->postModel->save($data)){
                  }else
                    return false;
            }
            }else
            {
              redirect('pages/index');
            }
        }

        public function webcam(){
            if(isset($_SESSION['user_id']))
            {
             $posts = $this->postModel->getImagesbyUsr($_SESSION['user_id']);
             $data = ['posts' => $posts];
                 $this->view('posts/webcam', $data);
            }else
            {
              redirect('pages/index');
            }
             
         }

        public function deletePost(){
            if(isset($_SESSION['user_id']))
            {
              //On vérifie que tous les jetons sont là
              if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])){
                if ($_SESSION['token'] == $_POST['token']){

                  $data = $this->postModel->getImagesbyUsr($_SESSION['user_id']);
                  if(isset($_POST['submit1'])){
                      $postId = $_POST['submit1'];
                      if($this->postModel->deletePost($postId, $_SESSION['user_id']))
                      {
                          redirect('posts/webcam');
                      }
                      else
                          die('ERROR');
                  }
                  $this->view('posts/webcam',$data);
                }else
                  redirect('pages/error');
              }else{                 
                  // Les token ne correspondent pas
                  redirect('pages/error');
              }
          }else
          {
            redirect('pages/index');
          }
        }

        public function profilePic()
        {
          if(isset($_SESSION['user_id']))
          {
            //On vérifie que tous les jetons sont là
            if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])){
              if ($_SESSION['token'] == $_POST['token']){
                if(isset($_POST['submit2']))
                {
                    $path = $_POST['submit2'];
                    if($this->userModel->profilePic($path, $_SESSION['user_id']))
                    {
                        redirect('posts/home');
                    }
                    else
                      die('ERROR');
                }
              }else
              redirect('pages/error');
            }else{ 
              // Les token ne correspondent pas
              redirect('pages/error');
            }
            }else
            {
              redirect('pages/index');
            }
        }


             //////////home////////////////
        public function home(){
        
            $postsPerPage = 5;
            $totalPosts = $this->postModel->count_posts();
            $totalPages = ceil($totalPosts/$postsPerPage);
        
            if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $totalPages){
        
              $_GET['page'] = intval($_GET['page']);
              $currentPage = $_GET['page'];    
            }else
              $currentPage = 1;
        
            $depart = ($currentPage - 1) * $postsPerPage;
            
              $posts = $this->postModel->get_posts($depart, $postsPerPage);
              $likes = $this->postModel->getlikes();
              $comments = $this->postModel->getcomments();
              $data =[
                'comments'=> $comments,
                'likes' => $likes,
                'posts' => $posts,
                'totalPages' => $totalPages,
                'currentPage' => $currentPage,
                'depart' => $depart,
              ];
              $this->view('posts/home',$data);
            }

          public function comment(){
            if(isset($_SESSION['user_id']))
            {
              if(isset($_POST['c_post_id']) && isset($_POST['c_user_id']) && isset($_POST['comment']) && !empty($_POST['comment']))
              {
                  $data = [
                      'posts_id'=> $_POST['c_post_id'],
                      'user_id' => $_POST['c_user_id'],
                      'comment' => $_POST['comment'],
                  ];
                  $com = $this->userModel->get_commenter($data['user_id']);
                  $uid = $this->postModel->getUserByPostId($data['posts_id']);
                  $d = $this->userModel->get_dest($uid->user_id);
                  if($this->postModel->addComment($data) && $d->notif == 1)
                  {
                    $destinataire = $d->email;
                    $sujet = "Your post has been commented" ;
                    $message = '
                    <p>Hi,
                        <br /><br />
                        @'.$com->username.', commented your post .
                    </p>
                    <p>
                        <br />--------------------------------------------------------
                        <br />This is an automatic mail , please do not reply.
                    </p> ';
              
                    $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
            
                    mail($destinataire, $sujet, $message, $headers); 
                      
                  }
              }
            }else
            {
              redirect('pages/index');
            }
          }
        
        public function Like(){
          if(isset($_SESSION['user_id']))
          {
            if(isset($_POST['post_id']) && isset($_POST['user_id']) && isset($_POST['c']) && isset($_POST['like_nbr']))
            {
                $data = [
                    'posts_id'=> $_POST['post_id'],
                    'user_id' => $_POST['user_id'],
                    'c' => $_POST['c'],
                    'like_nbr' => $_POST['like_nbr']
                ];
                 $this->postModel->like_nbr($data);
                if($data['c'] == 'fa fa-heart')
                {
                  
                  if($this->postModel->deleteLike($data))
                  {
    
                  }
                  else
                  {
                    die('something went wrong');
                  }
                }
                else if($data['c'] == 'fa fa-heart-o')
                {
                  
                  if($this->postModel->addLike($data))
                  {
                  }
                  else
                  {
                    die('something went wrong');
                  }
                }
                   
            }
          }else
          {
            redirect('pages/index');
          }
        }         
    }



    <?php require APPROOT . '/views/inc/header.php'; ?>

<!-- The buttons to control the stream -->
<div class="button-group">
  <button id="btn-start" type="button" class="btn btn-danger">Start Streaming</button>
  <button id="btn-capture" type="button" class="btn btn-secondary">Capture Image</button>
  <button id="btn-save" type="button" class="btn btn-success">Save Image</button>
  <button class="btn btn-info" id="clear" disabled>Clear</button>
</div>

<!-- Video Element & Canvas -->

  <div class="container row">
  
    <div class="col">
      <div class="play-area-sub">
        <h3 style="text-align: center;">The Stream</h3>
        <div>
          <img id="imgfilter" class="img-fluid" width="150" height="150" style="display: none; position: absolute;">
          <video  id="stream"  width="400" height="300"></video>
          <br>
					<div class="form-check form-check-inline">
		  				<input class="form-check-input" type="radio" name="filter" id="Donut" value="../public/img/Donut.png">
		  				<img src="../public/img/Donut.png" width="64" height="64">
					</div>
					<div class="form-check form-check-inline">
		  				<input class="form-check-input" type="radio" name="filter" id="Star" value="../public/img/Star.png">
		  				<img src="../public/img/Star.png" width="64" height="64">
					</div>
					<div class="form-check form-check-inline">
		  				<input class="form-check-input" type="radio" name="filter" id="Happy" value="../public/img/Happy.png">
		  				<img src="../public/img/Happy.png" width="64" height="64">
          </div>
          <br><br>
          <input id="file" type="file"  name="file" class="btn btn-info" accept="image/jpg, image/jpeg, image/png"></input><br>
        </div>
      </div>
    </div>
   
      <div class="col">
        <h3 style="text-align: center;">The Capture</h3>
        <div  width="400" height="300">
          <canvas class="img-fluid" id="canvas" width="400" height="300"></canvas>
          <canvas  id="canvas2" width="400" height="300"></canvas>
        </div>
      </div>

    </div>

    <div class="col">
			<div class="card border-0 text-white">
				<div>
          <div class="card bg-info">
            <div class="card-title"><h3 style="text-align: center;">Photos</h3></div>
          </div>
		            <hr class="bg-white mt-2 mb-5">
		    	<div style="width:100%;height: 800px; overflow-y:auto; overflow-x:hidden;">
			        <div class="row text-center">
                  <?php if(is_array($data['posts'])){
                          foreach($data['posts'] as $posts):
                          ?>
			                    <a class="m-3 pr-5 pt-1 pl-5 pb-5">
                            <img class="img-fluid img-thumbnail" src="<?php echo $posts->path;?>" height="100%" width="100%">
                            <form action="<?php echo  URLROOT;?>/posts/deletePost" method="POST">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                              <button type="submit" name="submit1" class="btn btn-danger w-100 fa fa-trash-o fa-fw"  value="<?php echo $posts->id;?>"> Delete</button>
                            </form>
                            <form action="<?php echo  URLROOT;?>/posts/profilePic" method="POST">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                              <button type="submit" name="submit2" class="btn btn-info  w-100 fa fa-user-circle-o fa-fw" value="<?php echo $posts->path;?>"> set as profile picture</button>
                            </form>
			                    </a><br>			            
			            <?php endforeach;}?>
			        </div>
					</div>
				</div>
			</div>
		</div>

  </div>

<script src="<?php echo URLROOT;?>/public/js/webcam.js"></script>
<?php require APPROOT . '/views/inc/footer.php'; ?>

/////home
<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <!-- paginnation -->
    <nav aria-label="Page navigation example justify-content-center">
        <ul class="pagination justify-content-center">
            <?php 

            if(($data['currentPage']-1) > 0)
                echo '<li class="page-item"><a class="page-link" href="http://localhost/Camagru/posts/home?page='.($data['currentPage']-1).'">Previous</a></li>';
            else
                echo '<li class="page-item"><a class="page-link">Previous</a></li>';

            for($i =1; $i <= $data['totalPages']; $i++){
                if($i == $data['currentPage'])
                    echo '<li class="page-item"><a class="page-link">'.$i.'</a></li>';
                else
                    echo '<li class="page-item"><a class="page-link" href="http://localhost/Camagru/posts/home?page='.$i.'">'.$i.'</a></li>';
            }
            if(($data['currentPage']+1) <= $data['totalPages'])
                echo '<li class="page-item"><a class="page-link" href="http://localhost/Camagru/posts/home?page='.($data['currentPage']+1).'">Next</a></li>';
            else
                echo '<li class="page-item"><a class="page-link">Next</a></li>';

            ?>
        </ul>
    </nav>

    <div class="row justify-content-center">
        <div class="col-m-6">
            <?php if(is_array($data['posts'])){
                foreach ($data['posts'] as $post) :?>
                <div class="shadow mb-5">
                    <div class="card">
                            <!-- header -->
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-2">
                                        
                                            <img class="rounded-circle" width="50" height="50" src="<?php echo $post->profile_photo;?>" alt="">
                                        </div>
                                        <div >
                                            <div class="h5">@<?php echo $post->username;?></div>
                                            <div class="text-muted"><?php echo $post->firstname; echo " "; echo$post->lastname;?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- body -->
                            <div class="card-body">
                                <div class="text-muted mb-2"> <i class="fa fa-clock-o"></i><?php echo $post->createin;?></div>
                            
                                <img src="<?php echo $post->path1; ?>" class="img img-fluid" width="495" height="400">
                            </div>
                            <!-- footer -->
                            <div class="card-footer">
                                <!-- like -->
                                <?php if(is_array($data['likes'])){
                                    $liked = false;    
                                    foreach ($data['likes'] as $like) {
                                    
                                        if ($like->user_id == $_SESSION['user_id'] && $like->posts_id == $post->postId) {
                                            $liked = true; ?>
                                            <i class = "fa fa-heart"
                                            data-post_id="<?php echo $post->postId; ?>" 
                                            data-user_id="<?php echo $_SESSION['user_id']; ?>" 
                                            data-like_nbr="<?php echo $post->like_nbr;?>" 
                                            onclick="like(event)"
                                            id="l_<?php echo $post->postId;?>"
                                            name="li_<?php echo $post->postId;?>">    
                                            </i>
                                            <?php
                                        }
                                    }
                                    if ($liked === false) {?>
                                        <i class = "fa fa-heart-o"  
                                        data-post_id="<?php echo $post->postId;?>" 
                                        data-like_nbr="<?php echo $post->like_nbr;?>" 
                                        data-user_id="<?php echo $_SESSION['user_id'];?>" 
                                        onclick="like(event)" id="l_<?php echo $post->postId;?>"
                                        name="li_<?php echo $post->postId;?>"> 
                                        </i>
                                    <?php }
                                }?>
                                <a id="li_nb_<?php echo $post->postId;?>" class="card-link text-muted">
                                <?php if ($post->like_nbr == 0){echo "";} else echo $post->like_nbr;?></a>
                                <!-- comments -->
                                <a class="card-link"><i class="fa fa-comment"></i> Comments</a>   
                                <div class=" mt-2" >
                                    <textarea  class="form-control mb-2" placeholder="write a comment..." style="resize:none"></textarea>
                                    <button data-c-user_id="<?php echo $_SESSION['user_id'];?>"
                                    data-c-post_id="<?php echo $post->postId;?>" class="btn btn-info w-25 pull-right" name="cmnt">Add</button>
                                    <br>    
                                </div>
                                <?php
                                    if(is_array($data['comments']))
                                    {
                                    foreach($data['comments'] as $comment)
                                    {
                                        if($comment->posts_id == $post->postId)
                                        {
                                        ?>
                                            <hr class="mb-1 mt-4">
                                            <ul class="media-list">
                                                <li class="media">                    
                                                    <div class="media-body">
                                                        <p><?php echo htmlspecialchars($comment->comment);?></p>
                                                    </div>
                                                </li>
                                            </ul>
                                        <?php
                                        }
                                    }
                                }?>         
                        </div>
                    </div>       
                </div>
              <br>
            <?php endforeach; }?>
        </div>
    </div> 
</div>

<script src="<?php echo URLROOT;?>/public/js/home.js"></script>
<?php require APPROOT . '/views/inc/footer.php'; ?>





//model
<?php

class Post{
    private $db;

	public function __construct(){
		$this->db = new Database;
	}
	
	public function save($data){
       
		$this->db->query('INSERT INTO posts (user_id, path, created_at) VALUES(:user_id, :path, NOW())');
		$this->db->bind(':user_id', $data['user_id']);
		$this->db->bind(':path', $data['path']);

		if($this->db->execute()){
			return true;
		}else {
			return false;
		}
	}
	
	public function getImagesbyUsr($user_id){
		$this->db->query('SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC');
		$this->db->bind(':user_id', $user_id);
		$result = $this->db->resultSet();
		if($result)
			return ($result);
		else
			return false;
	}

	public function deletePost($postId, $user_id){
		$this->db->query('DELETE FROM posts WHERE id = :post_id AND user_id = :user_id');
		$this->db->bind(':post_id', $postId);
		$this->db->bind(':user_id', $user_id);
		if($this->db->execute())
			return true;
		else
			return false;
   }


   			///////////////home//////////////////
   public function get_posts($depart, $postsPerPage){
	$this->db->query('SELECT *, posts.path as path1, posts.id as postId, users.id as userId, posts.created_at as createin, like_nbr as like_nb
					FROM `posts`
					INNER JOIN users 
					ON posts.user_id = users.id
					ORDER BY posts.created_at DESC LIMIT '.$depart.','.$postsPerPage.'');

	$r = $this->db->resultSet();
	if($r)
		return $r;
	else
		return false;
	}

	public function getcomments()
  {
    $this->db->query('SELECT * FROM `comments` INNER JOIN users ON comments.user_id = users.id');
    $result = $this->db->resultSet();
    if($result)
      return ($result);
    else
      return false;
  }

  public function addComment($data)
  {
      $this->db->query('INSERT INTO comments (user_id, posts_id, comment) VALUES (:user_id, :posts_id, :comment)');
        $this->db->bind(':user_id',$data['user_id']);
        $this->db->bind(':posts_id',$data['posts_id']);
        $this->db->bind(':comment',$data['comment']);

        if($this->db->execute())
        {
            return true;
        }else
            return false;
  }

  public function addLike($data)
    {
        $this->db->query('INSERT INTO likes (user_id, posts_id) VALUES (:user_id, :posts_id)');
        $this->db->bind(':user_id',$data['user_id']);
        $this->db->bind(':posts_id',$data['posts_id']);

        if($this->db->execute())
        {
            return true;
        }else
            return false;
    }
    public function deleteLike($data)
    {
        $this->db->query('DELETE FROM likes WHERE user_id = :user_id AND posts_id = :posts_id');
        $this->db->bind(':user_id',$data['user_id']);
        $this->db->bind(':posts_id',$data['posts_id']);

        if($this->db->execute())
        {
            return true;
        }else
            return false;
    }

  public function like_nbr($data)
  {
    $this->db->query('UPDATE posts SET like_nbr = :like_nbr WHERE id = :posts_id');

    $this->db->bind(':like_nbr', $data['like_nbr']);
    $this->db->bind(':posts_id', $data['posts_id']);

    if($this->db->execute()){
      return true;
    }else {
      return false;
    }
  }

  public function getlikes(){
	$this->db->query('SELECT * FROM likes');
	$result = $this->db->resultSet();
	return ($result);
}
  public function count_posts(){
    $this->db->query('SELECT count(*) FROM posts');

    $c = $this->db->ftchColumn();
    if($c)
      return $c;
    else
      return false;
  }

  public function getUserByPostId($postId){
    $this->db->query('SELECT * FROM posts WHERE id = :posts_id');
    $this->db->bind(':posts_id',$postId);

    $result = $this->db->single();
    if($result)
      return ($result);
    else
      return false;
  } 

}
?>
?>