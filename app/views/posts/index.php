<?php require APPROOT .'/views/inc/header.php';?>
<div class="container">
<div class="jumbotron text-center">
<img src="../public/imgs/svg/camagru.svg" alt="" class="img-fluid mb-3 d-none m-auto d-md-block">

  <p class="lead"></p>
      <?php if(isset($_SESSION['username'])): ?>
      <a class="btn btn-outline-success btn-lg" href="<?php echo URLROOT;?>/posts/camera" role="button">Add Photo</a>
      <?php else : ?>
      <a class="btn btn-outline-info" href="<?php echo URLROOT;?>/users/register" role="button">Register Now</a>
      <a class="btn btn-outline-dark" href="<?php echo URLROOT;?>/users/login" role="button">Log in!</a>
    <?php endif;?>
</div>

<div class="album py-5 bg-light">
  <div class="container  pb-cmnt-container">
      
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
            <li class="page-item"><a class="page-link" href="http://192.168.99.100:8088/Camagru/Posts/index?page=<?php if($_GET['page'] > 1)
            echo $_GET['page'] - 1;
            else{
                echo $_GET['page'];}?>">Previous</a></li>
            <?php for($i = 1; $i <= $data['nbrPages']; $i++) { ?>
            <li class="page-item "><a class="page-link" href="http://192.168.99.100:8088/Camagru/Posts/index?page=<?php echo $i;?>"><?php echo $i;?></a></li>
            <?php }?>
            <li class="page-item"><a class="page-link" href="http://192.168.99.100:8088/Camagru/Posts/index?page=<?php if($_GET['page'] < $data['nbrPages']){echo $_GET['page'] + 1;}
            else{
                echo $_GET['page'];}?>">Next</a></li>
          </ul>
    </nav>
    </div>
</div>
</main>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>
