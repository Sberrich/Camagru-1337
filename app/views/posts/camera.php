<?php require APPROOT .'/views/inc/header.php'; ?>
<div class="container">
<div class="jumbotron">
<h2 class="text-center text-dark">Welcome To Camagru Studio</h2>
<img src="../public/imgs/svg/studio.svg" class="img-fluid mb-3 d-none m-auto d-md-block"/>
</div>
<div class="container take-pic">
<!-- Buttons Group Start -->
<div class="actions">
    <a href="<?php echo URLROOT; ?>/pages/index" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
    <button id="btn-start" type="button" class="btn btn-outline-success">Start Streaming</button>
    <button id="btn-stop" type="button" class="btn btn-outline-danger">Stop Streaming</button>
    <button class="btn btn-outline-info" id="capture" role="button">Take A Picture</button>
    <input type="file" name="upFile" id="upFile"  class="btn btn-outline-success" accept=".png,.gif,.jpg,.jpeg">
</div>
<!-- The Stream -->
    <div class="d-flex flex-column">
        <h3 style="text-align: center;">The Stream</h3>
        <div class="row" id="imageHolder">
            <div class="col-md-9 camera">
            <div class="d-flex flex-column">
                <div id="imagefilter">
                    <img id="img_filter"></img>
                    <video id="video"></video>
                    <canvas  id="canvas" width="400" height="300"></canvas>
                </div>
            </div>
         </div>
         <div class="col">
        <h3 style="text-align: center;">The Capture</h3>
        <div  width="400" height="300">
          <canvas  id="canvas2" width="400" height="300"></canvas>
        </div>
      </div>
        <!-- Filters Block -->
        <div class="col-md-3">   
            <div data-spy="scroll"  style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden; border:2px groove black; width: 200px; height: 300px; float: left; display: block;">     
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
                            <div data-spy="scroll" id="scroll">
                                <div class="col" >
                                <?php if(is_array($data['posts'])){
                                    foreach($data['posts'] as $posts):
                                ?>
			                    <a class="m-3 pr-5 pt-1 pl-5 pb-5">
                                    <img class="img-fluid img-thumbnail" src="<?php echo $posts->imgurl;?>" height="100%" width="100%">
                                    <form action="<?php echo  URLROOT;?>/posts/deletePost" method="POST">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                                    <button type="submit" name="submit1" class="btn btn-outline-danger w-100 fa fa-trash-o fa-fw"  value="<?php echo $posts->imgid;?>"> Delete</button>
                                    </form>
                                    <form action="<?php echo  URLROOT;?>/posts/profilePic" method="POST">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                                    <button type="submit" name="submit2" class="btn btn-outlin-info  w-100 fa fa-user-circle-o fa-fw" value="<?php echo $posts->path;?>"> set as profile picture</button>
                                    </form>
                                        </a><br>			            
                                <?php endforeach;}?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br> 
                <div class="row" id="finishActions">
                     <form action="<?php echo URLROOT;?>/posts/camera" method="POST">
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
</div>

<?php require APPROOT .'/views/inc/footer.php'; ?>