<?php
    class Posts extends Controller{
        public function __construct()
        {
            parent::__construct();
            $this->postModel = $this->model('Post');
            $this->userModel = $this->model('User');
        }
        public function index(){
            if (!isset($_GET['page']))
            {
                $_GET['page'] = 0;

            }
            $posts = $this->pagination();
            $likes = $this->postModel->getlikes();
            $comments = $this->postModel->getComments();
            $data = [
                'title'=>'Camagru ',
                'posts' => $posts['post'],
                'nbrPages' => $posts['nbrPages'],
                'likes' => $likes,
                'comments' => $comments
            ];
            
            $this->view('posts/index', $data);
            
        }
        //Save Images
        public function SaveImage()
        {
              if(isset($_POST['image']) && isset($_POST['sticker']))
              {
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
                          
                      }else
                        return false;
              }
            else
            {
              redirect('pages/index');
            }
        }
        // pagination
        public function pagination()
        {
            if(!is_numeric($_GET['page']))
                $_GET['page'] = 1;
            if($_GET['page'] == 0)
                $nbStart = 0;
            else
            {
                if($_GET['page'])
                    $nmbr = $_GET['page'];
               
                $nbStart = ($nmbr * 5) - 5;
            }
           
            $allposts = $this->postModel->getImage();
            $nbrposts = count($allposts);
            $nbrpages =  ceil($nbrposts / 5);
             $pics = ['post' =>  $this->postModel->imgpaginat($nbStart, 5),
                        'nbrPages' => $nbrpages
                        ];
                    
    
                return $pics;
           
        }
       
        //camera
        public function camera(){
           if(isset($_SESSION['id']))
           {
            $posts = $this->postModel->getImagesbyUsr($_SESSION['id']);
            $data = ['posts' => $posts];
                $this->view('posts/camera', $data);
           }else
           {
                $this->view('pages/index');
           }
            
        }
        
 
        // add like
        public function addlikes()
        {
            if(isset($_POST['imgid']) && isset($_POST['userid']))
            {
                
                $userid = $_POST['userid'];
                $imgid = $_POST['imgid'];
                $data = ['imgid' => $imgid,
                        'userid' => $userid
                        ];
              
               if($this->postModel->addLikes($data) == true)
                   echo "liked";
               
            }
                  
        }
        
        public function dellikes()
        {
            if(isset($_POST['imgid']) && isset($_POST['userid']))
            {
                $userid = $_POST['userid'];
                $imgid = $_POST['imgid'];
                 $data = ['imgid' => $imgid,
                        'userid' => $userid
                        ];
                if($this->postModel->dellikes($data) == true)
                   echo "unliked";
            }
        }
        
        public function addComments()
        {
            if(isset($_POST['imgid']) && isset($_POST['userid']) && isset($_POST['comment']) && !empty($_POST['comment']))
                {   
                    $usr = $this->postModel->user_by_email($_POST['imgid']);
                    $to  = $usr->email;
                    $notif = $usr->notification ;
                    $subject = "Notification A New Comment On Your Photo";
                    $message='Hello ,your friend '.$_SESSION['username'].' add a new comment on your photo';
                    $headers = 'From: no-reply@camagru.com' . "\r\n" .
                                'Reply-To: no-reply@camagru.com' . "\r\n" .
                                'X-Mailer: PHP/' . phpversion();
                    if(!isset($_SESSION['id'])){
                        redirect("users/login");
                    }
                    $data = ['imgid' => $_POST['imgid'],
                        'userid' => $_POST['userid'],
                         'comment' => $_POST['comment']
                        ];

                    if($usr->notification == 1){
                        mail($to, $subject, $message , $headers); 
                    }
                   if($this->postModel->addComments($data))
                   {
                        return true;
                       
                   }
                
            }
        }
        
        public function delComments()
        {
            if(isset($_POST['imgid']))
            {
                $imgid = $_POST['imgid'];
                if($this->postModel->delComment($imgid))
                {
                    return true;
                }
                else{
                    return false;
                }
            }
        }
        
        public function delImage()
        {
             if(isset($_POST['imgid']))    
            {  
                 $imgid = $_POST['imgid'];
              if($this->postModel->delImage($imgid, $_SESSION['id']))
                {   
                    $this->postModel->getImagesbyUsr($_SESSION['id']);
                }
                
            } 
        }
        
}

        
    
?>