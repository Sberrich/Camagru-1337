<?php require APPROOT .'/views/inc/header.php'; ?>


<!-- The buttons to control the stream -->
<div class="button-group">
<a href="<?php echo URLROOT; ?>/pages/index" class="btn btn-outline-light"><i class="fa fa-backward"></i> Back</a><br>
  <button id="btn-start" type="button" class="btn btn-danger">Start Streaming</button>
  <button id="capture" type="button" class="btn btn-secondary">Capture Image</button>
  <button id="up" type="button" class="btn btn-success">Save Image</button>
  <button class="btn btn-info" id="clear" disabled>Clear</button>
</div>
<!-- Video Element & Canvas -->

    <br>
    <div class="jumbotron text-center">
    <h2>Add Post</h2>
        <div class="row" class="img-fluid">
                <div class="col-md-9">
                    <div id="imagefilter" class="img-fluid">
                        <img id="img_filter" class="img-fluid"  width="150" height="150" style="display: none; position: absolute;">
                        <video id="video" width="400" height="300" ></video>
                    </div>
                </div>
        <!-- Filters Block -->
        <div class="col-md-3">   
        <div class="container" data-spy="scroll"  style="overflow-x: auto; border:2px groove black; width: 200px; height: 300px; float: left; display: block;">     
            <div class="col" >
                <?php $filters = '../public/imgs/filter/';
                    foreach(glob($filters."*") as $file) : ?>    
                    <?php echo '<img class="card-img-top" src="'.$file.'" id="'.$file.'" style="width: 100px; height: 100px;" >'; ?>
                    <input type="radio" value="<?php echo $file; ?>" name="stickers"> stickers
                <?php endforeach; ?>
              </div>
        </div>
        </div>
           
        </div>
        <!-- take pic div -->
        <div class="row">
      
         <div class="container">
        <div class="row">
             <div class="col-md-6">  
         <canvas id="canvas" width="500" height="400" class="img-fluid">
                 </canvas> </div>
        <div class="col-md-6"> 
          <div class="container">
        <div data-spy="scroll"  style="overflow-x: auto; border:1px groove black; width: 500px; height: 400px;" id="scrol" class="img-fluid">
            <div class="col" >
                <?php 
                    foreach($data['posts'] as $post): ?>    
                    <div><?php echo '<img class="card-img-top img-fluid" src="'.$post->imgurl.'" style="width: 400px; height: 300px;" >'; ?></div><br>
                <?php endforeach; ?>
              </div>
        </div>
            </div></div></div><br>
            <div class="row" style="margin-left: 50px;">
         <form action="<?php echo URLROOT;?>/posts/image" method="POST">
        </form>
                </div>
            
            </div>
      </div>
     </div>
<?php require APPROOT .'/views/inc/footer.php'; ?>