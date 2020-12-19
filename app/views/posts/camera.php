<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
	<div class="row " >
		
			
		<div class="col-8">
			<div class="card">
			<?php flash('posts');?>
					<div class="card-header">
						<h2 style="text-align: center;">Camera</h2>
					</div>
					
				
					<div class="card-body">
						
					<div  style='position: relative;'>
						<img  src ='' id = 'imgf' style='position: absolute;top: 10px;left: 10px;display: none; width: 30%; height: 30%;'>
						<video class="img-fluid border border-dark" id="video" height="480" width="640"></video>
					</div>
					<br>
						<button class="btn btn-dark btn-block " id="snap" disabled>
							Take Picture</button>
							<br>
						<div style='position: relative;'>
							<img src ='' id = 'canvasf' style='position: absolute;top: 10px;left: 10px;display: none; width: 30%; height: 30%;'>
						<canvas class="img-fluid border border-dark" id="canvas" height="480" width="640"></canvas>
						</div>	
						



					<div class="row">
						<div class="col">
							<img src="../public/imgs/Emoji/1.png" alt="Emoji" height="40px" width="40px">
							<input type="radio" id="1" name="filter" value = '../public/imgs/Emoji/1.png'>
						</div>
						<div class="col">
							<img src="../public/imgs/Emoji/2.png" alt="Emoji" height="40px" width="40px">
							<input type="radio" id="2" name="filter" value = '../public/imgs/Emoji/2.png'>
						</div>
						<div class="col">
							<img src="../public/imgs/Emoji/3.png" alt="Emoji" height="40px" width="40px">
							<input type="radio" id="3" name="filter" value = '../public/imgs/Emoji/3.png'>
						</div>
						<div class="col">
							<img src="../public/imgs/Emoji/4.png" alt="Emoji" height="40px" width="40px">
							<input type="radio" id="4" name="filter" value = '../public/imgs/Emoji/4.png'>
						</div>
						
						
						
					</div>	
					
					</div>

					<div class="card-footer">

						
							
						
							<div class="input-group">

  								
  								<div class="custom-file">
   									<input type="file"  id="file" class="custom-file-input" accept=".png, .gif, .jpg, .jpeg">
    								<label class="custom-file-label">Choise image</label>
  								</div>
  								
							</div>
							<br>
  							<button class="btn btn-dark btn-block" id="save" >Save</button>
							<button class="btn btn-dark btn-block" id="clear" >Clear Canvas</button>
						


					</div>
				</div>
				</div>
				
				<br>
				
					<div class="card col-4">
						<div style="width:100%;height: 1250px; overflow-y:auto; overflow-x:hidden;">
					<div class="card-header">
						<h2 style="text-align: center;">Photos</h2>
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
<script src="<?php echo URLROOT;?>/js/snap.js"></script>
<?php require APPROOT . '/views/inc/footer.php'; ?>	

				