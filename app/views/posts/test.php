<div class="container take-pic">
        <h2 class="text-center text-muted">Welcome To Camagru Studio</h2>
        <a href="<?php echo URLROOT; ?>/pages/index" class="btn btn-outline-info"><i class="fa fa-backward"></i> Back</a><br>
         <button id="btn-start" type="button" class="btn btn-outline-success">Start Streaming</button>
         <button id="btn-stop" type="button" class="btn btn-outline-danger">Stop Streaming</button>
        <div class="d-flex flex-column">
            <div class="row" id="imageHolder">
                <div class="col-md-9 camera">
                    <div class="d-flex flex-column">
                        <div id="imagefilter">
                            <img id="img_filter" class="img-fluid">
                            <video id="video" width="400" height="300" ></video>
                        </div>
                        <div class="actions">
                            <button class="btn btn-outline-info" id="capture" role="button"><i class="fa fa-camera" aria-hidden="true"></i></button>
                            <input type="file" name="upFile" id="upFile" accept=".png,.gif,.jpg,.jpeg">
                        </div>
                    </div>
                </div>
                <div class="col-md-9 preview">  
                    <canvas id="canvas" width="400" height="300"></canvas>
                    <canvas id="canvas2" width="400" height="300"></canvas>   
                </div>

                <!-- Filters Block -->
                <div class="col-md-3">   
                    <div data-spy="scroll"  style="overflow-x: auto; border:2px groove black; width: 200px; height: 300px; float: left; display: block;">     
                        <div class="d-flex flex-column" >
                            <?php 
                                foreach(glob('../public/imgs/filter/'."*") as $file) : ?>    
                                <div class="sticker">
                                    <?php echo '<img class="card-img-top" src="'.$file.'" id="'.$file.'" style="width: 100px; height: 100px;" >'; ?>
                                    <input type="radio" value="<?php echo $file; ?>" name="stickers">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- take pic div -->
            <div class="row">
                <div class="flex-md-equal w-100 my-md-3 pl-md-3"> 
                    <div class="flex-md-equal w-100 m-3 py-md-3">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="container">
                                        <div data-spy="scroll"  style="overflow-x: auto; border:1px groove black; width: 500px; height: 400px;" id="scrol" class="img-fluid">
                                            <div class="col" >
                                                <?php foreach($data['posts'] as $post): ?>    
                                                    <div><?php echo '<img class="card-img-top img-fluid" src="'.$post->imgurl.'" style="width: 400px; height: 300px;" >'; ?></div><br>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br> 
                            <div class="row" id="finishActions">
                                <form action="<?php echo URLROOT;?>/posts/image" method="POST">
                                    <button class="btn btn-outline-primary btn-lg" id="save" role="button" ><i class="fa fa-picture-o" aria-hidden="true"></i></button>
                                    <button class="btn btn-outline-danger btn-lg" id="clear" role="button" ><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>







    <?php
    class Posts extends Controller{
        public function __construct()
        {
            $this->postModel = $this->model('Post');
            $this->userModel = $this->model('User');
        }
        // Save Image 
        public function storeimg()
        {
            if(isset($_SESSION['id']))
            { 
                 if(isset($_POST['image64']) && isset($_POST['imagesticker']))
                 {
                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                        $upload_dir = "../public/imgs/";
                        $img = $_POST['image64'];
                        $img = str_replace('data:image/png;base64,', '', $img);
                        $img = str_replace(' ', '+', $img);
                        $data = base64_decode($img);
                        $file = $upload_dir . mktime().'.png';
                        file_put_contents($file, $data);
                        chmod($file, 0777);
                        //str_replace(URLROOT, '..',
                        $sourceImage =  $_POST['imagesticker'];
                        list($srcWidth, $srcHeight) = getimagesize($sourceImage);
                        $src = imagecreatefrompng($sourceImage);
                        $dest = imagecreatefrompng($file);
                        imagecopyresized($dest, $src, 0, 0, 0, 0, 200, 200, $srcWidth, $srcHeight);
                        imagepng($dest, $file, 9);
                        move_uploaded_file($dest, $file);
                    
                        $data = ['userid' => $_SESSION['id'],
                                 'imgurl' => $file          
                            ];
                            if($this->postModel->save($data)){
                            }else
                              return false;
                    }
            }else{
                redirect('pages/index');
            }
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
        public function image(){
           if(isset($_SESSION['id']))
           {
            $posts = $this->postModel->getImagesbyUsr($_SESSION['id']);
            $data = ['posts' => $posts];
                $this->view('posts/image', $data);
           }else
           {
                $this->view('pages/index');
           }
            
        }
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




























<div class="container">
    <div class="jumbotron jumbotron-fluid text-center">
        <h1 class="text-center display-4">Camagru</h1>
        <img src="../public/imgs/svg/index.svg" alt="" class="img-fluid mb-3 d-none m-auto d-md-block">
         <p class="lead"></p>
        <?php if(isset($_SESSION['username'])): ?>
            <a class="btn btn-outline-success btn-lg" href="<?php echo URLROOT;?>/posts/image" role="button">Add Photo</a>
            <?php else : ?>
            <a class="btn btn-outline-info" href="<?php echo URLROOT;?>/users/register" role="button">Register Now</a>
            <a class="btn btn-outline-dark" href="<?php echo URLROOT;?>/users/login" role="button">Log in!</a>
        <?php endif;?>
    </div>
    <div class="album py-5 bg-light">
         <div class="container">
                <div class="row justify-content-start">
                 <?php foreach($data['posts'] as $post)   : ?>
        <div class="col-md-4">    
            <div class="card mb-4 box-shadow">
            <?php echo '<img class="card-img-top" src="'.$post->imgurl.'" alt="Card image cap">'; ?>
            <div class="card-body">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-md-4"><p class="card-text"><?php echo $post->username; ?></p></div>
                        <div class="col-md-4"  ><p class="card-text" style="width: 200px" id="imgedate"><?php echo $post->imgedate; ?></p></div>
                    </div>
                
                <div class="d-flex ">
                <div class="row ">
                    <?php   
                        $liked = false;
                    foreach($data['likes'] as $like){
                            if($like->userid == $_SESSION['id'] && $like->imgid == $post->imgid){
                                $liked = true;
                            ?>
                        <div class="row ">
                        <div class="col-md-4">
                            <i class="fa fa-heart"  data-imgid="<?php echo $post->imgid; ?>" data-userid="<?php echo $_SESSION['id'];?>" name="liket"></i>
                        </div>
                        <div class="col-md-4">
                            <p class="card-text" data-imgid="<?php echo $post->imgid; ?>"><?php echo $post->likes; ?></p>
                        </div>
                        </div>
                    <?php }
                    }
                    if ($liked === false){ ?>
                        <div class="row">
                            <div class="col-md-4">
                                <i class="fa fa-heart-o"  data-imgid="<?php echo $post->imgid; ?>" data-userid="<?php echo $_SESSION['id'];?>" name="liket"></i>
                            </div>
                            <div class="col-md-4">
                                <p class="card-text" data-imgid="<?php echo $post->imgid; ?>"><?php echo $post->likes; ?></p>
                            </div>
                        </div>
                
                    <?php }

                    ?>
                    </div>
                    
                    </div>
                    
                </div>
                <div class="row justify-content-start">
                        <div class="container pb-cmnt-container">
                    <div class="actionBox" >
                        <?php if(isset($_SESSION['id'])) : ?>
                                <form class="form-inline" role="form">
                            <?php else : ?>
                                <form class="form-inline" role="form" hidden>
                            <?php endif; ?>
                                    <div class="row">
                                        <input class="form-control" type="text" placeholder="Your comments" data-imgid="<?php echo $post->imgid; ?>" name="cmntvalue"/>
                                        <button type="button" class="btn btn-outline-primary"  data-imgid="<?php echo $post->imgid; ?>"  data-userid="<?php echo $_SESSION['id'];?>" name="cmntbtn">Add</button>
                                    </div>
                                    </form>
                                    <ul class="commentList" id="commentList">
                                        <?php foreach($data['comments'] as $comment){
                                        if($comment->imgid == $post->imgid){ 
                                            ?>
                                        <li>
                                            <div class="commentText">
                                                <span class="date sub-text"><?php echo $comment->username;?></span><p data-id="<?php echo $post->imgid; ?>"><?php echo htmlspecialchars($comment->comment);?></p><span class="date sub-text">on <?php echo $comment->cmntdate;?></span>

                                            </div>
                                        </li>
                                        <?php } } ?>
                                    </ul>
                                
                            </div></div>
                </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        </div>
        </div>
        <div >
            <nav aria-label="Page navigation example">
            <ul class="pagination flex-wrap justify-content-center">
                <li class="page-item"><a class="page-link" href="http://192.168.99.101:8088/Camagru/Posts/index?page=<?php if($_GET['page'] > 1)
                echo $_GET['page'] - 1;
                else{
                    echo $_GET['page'];}?>">Previous</a></li>
                <?php for($i = 1; $i <= $data['nbrPages']; $i++) { ?>
                <li class="page-item "><a class="page-link" href="http://192.168.99.101:8088/Camagru/Posts/index?page=<?php echo $i;?>"><?php echo $i;?></a></li>
                <?php }?>
                <li class="page-item"><a class="page-link" href="http://192.168.99.101:8088/Camagru/Posts/index?page=<?php if($_GET['page'] < $data['nbrPages']){echo $_GET['page'] + 1;}
                else{
                    echo $_GET['page'];}?>">Next</a></li>
            </ul>
        </nav>
        </div>
    </div>
</div>
</main>