<?php
    class Posts extends Controller{
        public function __construct()
        {
             $this->postModel = $this->model('Post');
             $this->userModel = $this->model('User');
        }
        //Save Images
        public function SaveImage()
        {
          if(isset($_SESSION['id']))
            {
              if(isset($_POST['image']) && isset($_POST['sticker']))
              {
                      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                      $upload_dir = "../public/imgs/";
                      $img = $_POST['image64'];
                      $img = str_replace('data:image/png;base64,', '', $img);
                      $img = str_replace(' ', '+', $img);
                      $data = base64_decode($img);
                      $file = $upload_dir . time().'.png';
                      file_put_contents($file, $data);
                      chmod($file, 0777);
                      $sourceImage = str_replace(URLROOT, '..',  $_POST['sticker']);
                      list($srcWidth, $srcHeight) = getimagesize($sourceImage);
                      $src = imagecreatefrompng($sourceImage);
                      $dest = imagecreatefrompng($file);
                      imagecopyresized($dest, $src, 0, 0, 0, 0, 200, 200, $srcWidth, $srcHeight);
                      imagepng($dest, $file, 9);
                      move_uploaded_file($dest, $file);
                  
                      $dt = ['userid' => $_SESSION['id'],
                      'imgurl' => $file          
                          ];
                      if (!empty($data)) {
                              if ($this->postModel->save($dt) == true) {
                                  $this->postModel->getImage();
                          }
               }
             
            }
            }else
            {
              redirect('pages/index');
            }
        }
        //Webcam
        public function camera()
        {
            if(isset($_SESSION['id']))
            {
             $posts = $this->postModel->getImagesbyUsr($_SESSION['id']);
             $data = ['posts' => $posts];
                 $this->view('posts/camera', $data);
            }else
            {
              redirect('pages/index');
            }
             
        }
        //Delete Posts
        public function deletePost()
        {
            if(isset($_SESSION['id']))
            {
              //On vérifie que tous les jetons sont là
              if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])){
                if ($_SESSION['token'] == $_POST['token']){

                  $data = $this->postModel->getImagesbyUsr($_SESSION['id']);
                  if(isset($_POST['submit1'])){
                      $postId = $_POST['submit1'];
                      if($this->postModel->deletePost($postId, $_SESSION['id']))
                      {
                          redirect('posts/camera');
                      }
                      else
                          die('ERROR');
                  }
                  $this->view('posts/camera',$data);
                }else
                  redirect('pages/notfound');
              }else{                 
                  // Les token ne correspondent pas
                  redirect('pages/notfound');
              }
          }else
          {
            redirect('pages/index');
          }
        }
        //index
        public function index()
        {
            $postsPerPage = 5;
            $totalPosts = $this->postModel->count_posts();
            $totalPages = ceil($totalPosts/$postsPerPage);
        
            if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $totalPages)
            {
              $_GET['page'] = intval($_GET['page']);
              $currentPage = $_GET['page'];    
            }else
              $currentPage = 1;
        
              $depart = ($currentPage - 1) * $postsPerPage;
            
              $posts = $this->postModel->getImage($depart, $postsPerPage);
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
              $this->view('posts/index',$data);
        }
        //comment
        public function comment()
        {
            if(isset($_SESSION['id']))
            {
              if(isset($_POST['imgid']) && isset($_POST['userid']) && isset($_POST['comment']) && !empty($_POST['comment']))
              {
                  $data = [
                      'imgid'=> $_POST['imgid'],
                      'userid' => $_POST['userid'],
                      'comment' => $_POST['comment'],
                  ];
                  $com = $this->userModel->get_commenter($data['userid']);
                  $uid = $this->postModel->getUserByPostId($data['imgid']);
                  $d = $this->userModel->get_dest($uid->id);
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
        //Likes
        public function Like()
        {
          if(isset($_SESSION['id']))
          {
            if(isset($_POST['imgid']) && isset($_POST['userid']) && isset($_POST['comment']) && isset($_POST['likes']))
            {
                $data = [
                    'imgid'=> $_POST['imgid'],
                    'userid' => $_POST['userid'],
                    'comment' => $_POST['comment'],
                    'likes' => $_POST['likes']
                ];
                 $this->postModel->like_count($data);
                if($data['c'] == 'fa fa-heart')
                {
                  
                  if($this->postModel->delelikes($data))
                  {
    
                  }
                  else
                  {
                    die('something went wrong');
                  }
                }
                else if($data['c'] == 'fa fa-heart-o')
                {
                  
                  if($this->postModel->addLikes($data))
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
        //Profile Pic 
        public function profilePic()
        {
          if(isset($_SESSION['userid']))
          {
            //On vérifie que tous les jetons sont là
            if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])){
              if ($_SESSION['token'] == $_POST['token']){
                if(isset($_POST['submit2']))
                {
                    $path = $_POST['submit2'];
                    if($this->userModel->profilePic($path, $_SESSION['userid']))
                    {
                        redirect('posts/index');
                    }
                    else
                      die('ERROR');
                }
              }else
              redirect('pages/notfound');
            }else{ 
              // Les token ne correspondent pas
              redirect('pages/notfound');
            }
            }else
            {
              redirect('pages/index');
            }
        }
    }
?>