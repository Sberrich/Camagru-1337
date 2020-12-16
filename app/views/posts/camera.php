<?php require APPROOT .'/views/inc/header.php'; ?>
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
                                foreach(glob('../public/imgs/filters/'."*") as $file) : ?>    
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