<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
          <?php 
            if(is_array($data['posts']))
            {
              foreach($data['posts'] as $post):?>
                  <div class="card">
                    <div class="card-header">
                            <div class="h4"><small class="text-muted"><?php echo $post->username;?></small></div>
                    </div>
                    <div class="card-body">
                      <div class="text-muted h6">
                        <i class="fa fa-clock"></i><?php echo $post->imgedate;?></div>
                        <img src="<?php echo $post->imgurl;?>" class="img img-fluid" width="500" height="500" >
                    </div>
                      <div class="card-footer">
                        <!-- like    -->
                          <?php
                            $liked = false;
                            if(is_array($data['like']))
                            {
                                  foreach ($data['like'] as $lik) 
                                  {
                                        if ($lik->userid == $_SESSION['id'] && $lik->imgid == $post->imgid)
                                        {
                                            $liked = true; ?>
                                              <i  onclick="like(event)"
                                                  class = "fas fa-heart"
                                                  post_id="<?php echo $post->imgid; ?>"
                                                  user_id="<?php echo $_SESSION['id']; ?>"
                                                  like_nbr="<?php echo $post->likes;?>"
                                                  id="im<?php echo $post->imgid; ?>">  
                                              </i>
                              <?php
                                        }
                                  }
                            }
                        if ($liked === false) 
                        {?>
                            <i  onclick="like(event)"
                                                  class = "fas fa-heart"
                                                  post_id="<?php echo $post->imgid; ?>"
                                                  user_id="<?php echo $_SESSION['id']; ?>"
                                                  like_nbr="<?php echo $post->likes;?>"
                                                  id="im<?php echo $post->imgid; ?>">  
                                              </i>
                        <?php }
                        ?>
                        <a id="im_nb_<?php echo $post->imgid; ?>" class="h4 text-muted"><?php echo $post->likes ;?></a>
                  
                          <!-- comment    -->
                      <a class="card-link"><i class="fa fa-comment"></i> Comments</a>
                          <div class="cardbox-comments mt-2">            
                          <textarea name="comment_<?php echo $post->imgid ;?>"
                                    class="form-control w-100 mb-2" placeholder="Describe Post here..."
                                    rows="1" >
                                    </textarea>
                          <button onclick="comment(event)"
                                  data-c-user_id="<?php echo $_SESSION['id']; ?>"
                                  data-c-post_id="<?php echo $post->imgid ;?>"
                                  class="btn btn-secondary pull-right">Add
                          </button>
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
                                              <p><?php echo htmlspecialchars($comment->content);?></p> 
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

<div class="pagination justify-content-center">

<nav aria-label="Page navigation example">
    <ul class="pagination flex-wrap justify-content-center">
      <li class="page-item"><a class="page-link" href="http://192.168.99.102:8088/Camagru/Posts/index?page=<?php if($_GET['page'] > 1)
      echo $_GET['page'] - 1;
      else{
          echo $_GET['page'];}?>">Previous</a></li>
      <?php for($i = 1; $i <= $data['nbrPages']; $i++) { ?>
      <li class="page-item "><a class="page-link" href="http://192.168.99.102:8088/Camagru/Posts/index?page=<?php echo $i;?>"><?php echo $i;?></a></li>
      <?php }?>
      <li class="page-item"><a class="page-link" href="http://192.168.99.102:8088/Camagru/Posts/index?page=<?php if($_GET['page'] < $data['nbrPages']){echo $_GET['page'] + 1;}
      else{
          echo $_GET['page'];}?>">Next</a></li>
    </ul>
  </nav>
</div>
      </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>





































