<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
	<div class="row " >	
		<div class="col-8">
			<div class="card">
					<div class="card-header">
						<h2 style="text-align: center;">Welcome To Camagru Studio</h2>
						<img src="../public/imgs/svg/studio.svg" class="img-fluid mb-3 d-none m-auto d-md-block" id="svg"/>
					</div>
					<!--scoller-->
					<div class="container testimonial-group">
							<div class="row text-center">
								<div class="col-xs-4">
									<!-- Filters -->
									<img src="../public/imgs/Emoji/2.png" alt="Emoji" height="40px" width="40px" id="sv">
									<input type="radio" id="2" name="filter" value = '../public/imgs/Emoji/2.png'>
									<img src="../public/imgs/Emoji/3.png" alt="Emoji" height="40px" width="40px" id="sv">
									<input type="radio" id="3" name="filter" value = '../public/imgs/Emoji/3.png'>
									<img src="../public/imgs/Emoji/4.png" alt="Emoji" height="40px" width="40px" id="sv">
									<input type="radio" id="4" name="filter" value = '../public/imgs/Emoji/4.png'>
									<img src="../public/imgs/Emoji/5.png" alt="Emoji" height="40px" width="40px" id="sv">
									<input type="radio" id="5" name="filter" value = '../public/imgs/Emoji/5.png'>
									<img src="../public/imgs/Emoji/6.png" alt="Emoji" height="40px" width="40px" id="sv">
									<input type="radio" id="6" name="filter" value = '../public/imgs/Emoji/6.png'>
									<img src="../public/imgs/Emoji/7.png" alt="Emoji" height="40px" width="40px" id="sv"> 
									<input type="radio" id="7" name="filter" value = '../public/imgs/Emoji/7.png'>
									<img src="../public/imgs/Emoji/8.png" alt="Emoji" height="40px" width="40px" id="sv">
									<input type="radio" id="8" name="filter" value = '../public/imgs/Emoji/8.png'>
									<img src="../public/imgs/Emoji/9.png" alt="Emoji" height="40px" width="40px" id="sv">
									<input type="radio" id="9" name="filter" value = '../public/imgs/Emoji/9.png'>
									<img src="../public/imgs/Emoji/10.png" alt="Emoji" height="40px" width="40px" id="sv">
									<input type="radio" id="4" name="filter" value = '../public/imgs/Emoji/10.png'>
									<img src="../public/imgs/Emoji/11.png" alt="Emoji" height="40px" width="40px" id="sv">
									<input type="radio" id="11" name="filter" value = '../public/imgs/Emoji/11.png'>
									<img src="../public/imgs/Emoji/12.png" alt="Emoji" height="40px" width="40px" id="sv">
									<input type="radio" id="4" name="filter" value = '../public/imgs/Emoji/12.png'>
									<img src="../public/imgs/Emoji/13.png" alt="Emoji" height="40px" width="40px" id="sv">
									<input type="radio" id="13" name="filter" value = '../public/imgs/Emoji/13.png'>			
								</div>
							</div>
						<!-- finscrol -->
						</div>
						<!-- Actions Buttons -->
						<div class="btn-group">
											<a href="<?php echo URLROOT; ?>/pages/index" class="btn btn-outline-dark"><i class="fas fa-backward"  aria-hidden="true"></i> Back</a>
											<button id="btn-start" type="button" class="btn btn-outline-success"><i class="fas fa-play"  aria-hidden="true"></i></button>
											<button id="btn-close" type="button" class="btn btn-outline-danger"><i class="fas fa-close"  aria-hidden="true"></i></button>
											<button id="btn-stop" type="button" class="btn btn-outline-danger"><i class="fas fa-pause"  aria-hidden="true"></i></button>
											<button class="btn btn-outline-danger" id="clear" role="button" ><i class="fas fa-trash" aria-hidden="true"></i></button>
											<button class="btn btn-outline-dark" id="snap" disabled><i class="fas fa-camera"  aria-hidden="true"></i></button>
											<button class="btn btn-outline-primary" id="save" role="button" ><i class="fas fa-save"  aria-hidden="true"></i></button>
											<button type="button" role=button class="btn btn-outline-info" onclick="{takeAuto()}"><i class="fas fa-hourglass-start"  aria-hidden="true"></i></button>
											<input type=number id="myInterval" class="col-2 text-center btn btn-outline-dark" value="5">
									</div>
							<div class="card-body">
									<div  style='position: relative;'>
									<div id="counter" style="position: absolute;width: 100%;height: 100%;text-align: center; font-size: 10vw; color: white;"></div>
										<img  src ='' id = 'imgf' style='position: absolute;top: 10px;left: 10px;display: none; width: 30%; height: 30%;'>
										<video class="img-fluid border border-dark" id="video" height="480" width="640"></video>
									</div>
									<div style='position: relative;'>
										<img src ='' id = 'canvasf' style='position: absolute;top: 10px;left: 10px;display: none; width: 30%; height: 30%;'>
										<canvas class="img-fluid border border-dark" id="canvas" height="480" width="640"></canvas>
									</div>	
									<div class="finishActions">
									<div class="input-group">
											<div class="custom-file">
												<input type="file"  id="file" class="custom-file-input" accept=".png, .gif, .jpg, .jpeg">
												<label class="custom-file-label">UPFILE</label>
											</div>
										</div>
								</div>
							</div>		
					</div>
			</div>
			<div class="card col-4">
					<div style="width:100%;height: 1000px; overflow-y:auto; overflow-x:hidden;">
								<div class="card-header">
									<img src="../public/imgs/svg/album.svg" class="img-fluid mb-3 d-none m-auto d-md-block"/>
								</div>
								<div class="card-body auto">
									<?php foreach($data['posts'] as $post):?>
										<div class="container">
											<a  class="d-block mb-4 h-100">
												<img class="img-fluid img-thumbnail" src="<?php echo $post->imgurl;?>" >
											</a>
										</div>		
									<?php endforeach;?>
								</div>
					</div>
			</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
