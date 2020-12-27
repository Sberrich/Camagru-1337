<?php
class Posts extends Controller{
    public function __construct(){
        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

  

    public function index(){
      

        $postsPerPage = 5;
    $totalPosts = $this->postModel->count_posts();
    $totalPages = ceil($totalPosts/$postsPerPage);
    if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $totalPages){
     $_GET['page'] = intval($_GET['page']);
     $currentPage = $_GET['page'];
   }else
     $currentPage = 1;
   $depart = ($currentPage - 1) * $postsPerPage;
     $posts = $this->postModel->getPosts($depart, $postsPerPage);
     $likes = $this->postModel->getlikes();
     $comments = $this->postModel->getcomments();

     $data =[
        'likes' => $likes,
        'comments' => $comments,
       'posts' => $posts,
       'totalPages' => $totalPages,
       'currentPage' => $currentPage,
       'depart' => $depart,
       'previousPage' => $currentPage - 1,
       'nextPage' => $currentPage + 1
     ];

     $this->view('posts/index',$data);
        
    
 }

 
    
    public function image(){
      if($this->userModel->findUserById()){

        if(isloggedIn())
        {
            $data = $this->postModel->getpost($_SESSION['user_id']);
            $this->view("posts/image",$data);
        }
        else
            redirect("users/login");
        
        } else
            logout();
        
    }
    //Save Images
    public function SaveImage()
    {
          if(isset($_POST['image']) && isset($_POST['sticker']))
          {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $upload_dir = "../public/imgs/photos/";
                $img = $_POST['image'];
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $file = $upload_dir . mktime().'.png';
                file_put_contents($file, $data);
                chmod($file, 0777);
                $sourceImage = str_replace(URLROOT, '..',  $_POST['sticker']);
                $destImage = $file;
                list($srcWidth, $srcHeight) = getimagesize($sourceImage);
                $src = imagecreatefrompng($sourceImage);
                $dest = imagecreatefrompng($destImage);
                imagecopyresized($dest, $src, 0, 0, 0, 0, 150, 150, $srcWidth, $srcHeight);
                imagepng($dest, $file, 9);
                move_uploaded_file($dest, $file);
                $data = [
                    'userid'  => $_SESSION['id'],
                    'imgurl' => $file,
                ];
                  if($this->postModel->addImage($data) == true){
                      $this->postModel->getImage();
                  }else
                    return false;
          }
        else
        {
          redirect('pages/index');
        }
    }


    public function comment()
    {
      if($this->userModel->findUserById()){

        if(isloggedIn() && isset($_POST['post_id']) && isset($_POST['user_id']) && isset($_POST['content']))
        {
            $po = $this->postModel->getUserByPostId($_POST['post_id']);
            $data = [
               'post_id'=> $_POST['post_id'],
               'user_id' => $_POST['user_id'],
               'content' => $_POST['content'],
               'user_comment' => $this->postModel->getUserById($_POST['user_id']),
               'user_post' => $this->postModel->getUserById($po)
           ];


           if($this->postModel->addcomment($data) && strlen($data['content'] <= 255))
           {
                if($data['user_post']->notif == 0)
                {
                  //send mail
                }
           }
           else
            die('!base donne');

        }
        else
          redirect('posts/index');
        
        } else
            logout();
        
    }
    public function Like(){
      if($this->userModel->findUserById()){

        if(isloggedIn() && isset($_POST['post_id']) && isset($_POST['user_id']) && isset($_POST['c']) && isset($_POST['like_nbr']))
       {
           $data = [
               'post_id'=> $_POST['post_id'],
               'user_id' => $_POST['user_id'],
               'c' => $_POST['c'],
               'like_nbr' => $_POST['like_nbr']
           ];
            $this->postModel->like_nbr($data);
           if($data['c'] == 'fas fa-heart')
           {
             if($this->postModel->deleteLike($data))
             {
                }
             else
             {
               die('wa noud');
             }
           }
           else if($data['c'] == 'far fa-heart')
           {
             if($this->postModel->addLike($data))
             {

             }
             else
             {
               die('wa noud');
             }
           }
       }
       else
          redirect('posts/index');
        
        } else
           logout();
       
   }

  
    public function deletePost()
    {
        $data = $this->postModel->getpost($_SESSION['user_id']);
        if(isset($_POST['submit']))
         {
            $postId = $_POST['postId'];

            if($this->postModel->deletePost($postId, $_SESSION['user_id']))
            {
                redirect('users/profile');
            }
            else
                die('nono');
              $this->view('users/profile',$data);
        }
        else
          redirect('posts/index');
        
    }
    


}