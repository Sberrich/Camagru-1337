<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">

<div class="pagination justify-content-center">

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
    <div class="row justify-content-center">
        <div class="col-md-6">
          <?php if(is_array($data['posts']))
            {
          foreach($data['posts'] as $post):?>
          <div class="card">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="mr-4">
                  </div>
                  <div class="ml-2">
                    <div class="h5 m-0"><?php echo $post->username;?></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="text-muted h7 mb-2">
                <i class="fa fa-clock"></i><?php echo ' ' . $post->imgedate;?></div>
                <img src="<?php echo $post->imgurl;?>" class="img img-fluid" width="500" height="500" >
            </div>
              <div class="card-footer">
                <!-- like    -->
                  <?php
                    $liked = false;
                    if(is_array($data['likes']))
                    {
                          foreach ($data['likes'] as $like) 
                          {
                                if ($like->userid == $_SESSION['id'] && $like->imgid == $post->imgid)
                                {
                                    $liked = true; ?>
                                     <div class="row ">
                    <div class="col-md-4">
                        <i class="fa fa-heart"  data-imgid="<?php echo $post->imgid; ?>" data-userid="<?php echo $_SESSION['id'];?>" name="liket"></i>
                    </div>
                    <div class="col-md-4">
                        <p class="card-text" data-imgid="<?php echo $post->imgid; ?>"><?php echo $post->likes; ?></p>
                    </div>
                    </div>
                      <?php
                                }
                          }
                    }
                if ($liked === false) 
                {?><div class="row">
                  <div class="col-md-4">
                      <i class="fa fa-heart-o"  data-imgid="<?php echo $post->imgid; ?>" data-userid="<?php echo $_SESSION['id'];?>" name="liket"></i>
                  </div>
                  <div class="col-md-4">
                      <p class="card-text" data-imgid="<?php echo $post->imgid; ?>"><?php echo $post->likes; ?></p>
                  </div>
              </div>
                <?php }
                ?>          
                  <!-- comment    -->
              <a class="card-link"><i class="fa fa-comment"></i> Comments</a>
                  <div class="cardbox-comments mt-2">            
                  <input class="form-control" type="text" placeholder="Your comments" data-imgid="<?php echo $post->imgid; ?>" name="cmntvalue"/>

                            <button type="button" class="btn btn-outline-primary"  data-imgid="<?php echo $post->imgid; ?>"  data-userid="<?php echo $_SESSION['id'];?>" name="cmntbtn">Add</button>

                              <br>
                            </div>
                          
                  <?php
                    if(is_array($data['comments']))
                      {
                        foreach($data['comments'] as $comment)
                          {
                            if($comment->imgid == $post->imgid)
                            {
                              ?>
                                <hr class="mb-1 mt-4">
                              <ul class="media-list">
                                <li class="media">                    
                                  <div class="media-body">
                                        <strong class="text-dark"><?php echo $comment->username;?></strong>
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
          <br>
        <?php endforeach ;}?>
        </div>
      </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>





































