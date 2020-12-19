

<?php require APPROOT .'/views/inc/header.php'; ?>
<div class="container">
        <div class="jumbotron">
            <h2 class="text-center text-dark">Welcome To Camagru Studio</h2>
            <img src="../public/imgs/svg/studio.svg" class="img-fluid mb-3 d-none m-auto d-md-block"/>
        </div>
        <div class="container take-pic">
            <!-- The Stream -->
            <div class="d-flex flex-column">
                <h3 style="text-align: center;">The Stream</h3>
                <div class="row" id="imageHolder">
                            <div class="col-md-9 camera">
                                <!-- Buttons Group Start -->
                <div class="actions">
                    <a href="<?php echo URLROOT; ?>/pages/index" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
                    <button id="btn-start" type="button" class="btn btn-outline-success">Start Streaming</button>
                    <button id="btn-stop" type="button" class="btn btn-outline-danger">Stop Streaming</button>
                    <button class="btn btn-outline-info" id="capture" role="button">Take A Picture</button>
                    <input type="file" name="upFile" id="upFile"  class="btn btn-outline-success" accept=".png,.gif,.jpg,.jpeg">
                </div>
                                <div class="d-flex flex-column">
                                    <div id="imagefilter">
                                    <h3 style="text-align: center;">The Video</h3>
                                        <img id="img_filter"></img>
                                        <video id="video"></video>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 preview">  
                            <h3 style="text-align: center;">The Capture</h3>
                            
                                <canvas class="" id="canvas" width="400" height="300"></canvas>
                                <canvas  id="canvas2" width="400" height="300"></canvas>
                        
                            </div>
                            <!-- Filters Block -->
                            <div class="col-md-3">  
                                 <h3 style="text-align: center;">Filters</h3>
 
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
                     </div>
                <!-- take pic div -->
                <div class="row">
                <div class="flex-md-equal w-100 my-md-3 pl-md-3"> 
                    <div class="flex-md-equal w-100 m-3 py-md-3">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="container">
                                    <h3 style="text-align: center;">The Scroll</h3>

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
<?php require APPROOT .'/views/inc/footer.php'; ?>