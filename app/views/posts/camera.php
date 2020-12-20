<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
	<div class="row " >	
		<div class="col-8">
			<div class="card">
					<div class="card-header">
						<h2 style="text-align: center;">Welcome To Camagru Studio</h2>
						<img src="../public/imgs/svg/studio.svg" class="img-fluid mb-3 d-none m-auto d-md-block"/>

					</div>
					<!-- Card Body -->

			<!--scol
			 -->
			 <div class="container testimonial-group">
				<div class="row text-center">
					<div class="col-xs-4">
					
			
									<img src="../public/imgs/Emoji/1.png" alt="Emoji" height="20px" width="20px">
									<input type="radio" id="1" name="filter" value = '../public/imgs/Emoji/1.png'>
					
									<img src="../public/imgs/Emoji/2.png" alt="Emoji" height="20px" width="20px">
									<input type="radio" id="2" name="filter" value = '../public/imgs/Emoji/2.png'>
							
								
									<img src="../public/imgs/Emoji/3.png" alt="Emoji" height="40px" width="40px">
									<input type="radio" id="3" name="filter" value = '../public/imgs/Emoji/3.png'>
							
								
									<img src="../public/imgs/Emoji/4.png" alt="Emoji" height="40px" width="40px">
									<input type="radio" id="4" name="filter" value = '../public/imgs/Emoji/4.png'>
							
					</div>
					
				</div>
			</div>
			 <!-- finscrol -->
					<div class="card-body">
					<div class="actions">
                    <a href="<?php echo URLROOT; ?>/pages/index" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
                    <button id="btn-start" type="button" class="btn btn-outline-success"><i class="fas fa-play"></i></button>
					<button id="btn-close" type="button" class="btn btn-outline-danger"><i class="fas fa-close"></i></button>

					<button id="btn-stop" type="button" class="btn btn-outline-danger"><i class="fas fa-pause"></i></button>
					<button class="btn btn-outline-dark" id="snap" disabled><i class="fas fa-camera"></i></button>
					</div>
					
							Take snapshot every <input type=number id="myInterval"  value="5"> Seconds
							<input type=button value="Auto" onclick="{takeAuto()}">
					<br>
							<div  style='position: relative;'>
							<div id="counter" style="position: absolute;width: 100%;height: 100%;text-align: center; font-size: 20vw; color: white;"></div>
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
										<label class="custom-file-label">Choise image</label>
									</div>
								</div>
								<div class="actions">
										<button class="btn btn-outline-primary btn-lg" id="save" role="button" ><i class="fa fa-picture-o" aria-hidden="true"></i></button>
										<button class="btn btn-outline-danger btn-lg" id="clear" role="button" ><i class="fa fa-trash" aria-hidden="true"></i></button>
								</div>
								

							</div>
					</div>
						<div class="card-footer">
						</div>
			</div>
		</div>
			<div class="card col-4">
					<div style="width:100%;height: 1250px; overflow-y:auto; overflow-x:hidden;">
						<div class="card-header">
							<h2 style="text-align: center;">Album</h2>
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