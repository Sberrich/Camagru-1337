<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT;?>/css/profile.css">    
<div class="container">
		<div class="jumbotron">
				<h1><i class="fa fa-camera-retro" aria-hidden="true"></i> Gallery</h1>
				<p>This is your Gallery</p>
				<small>
				<span>Members only</span></small>
				<br>
				<a class="font-weight-bold text-dark" href="#">Username :<?php echo $_SESSION['username'];?></a>
				<br>
				<a class="font-weight-bold text-dark"> Email:<?php echo $_SESSION['email'];?></a>
				
		</div>	
		<h1 class="text-center text-white">Yoo! Gallery</h1>
		<hr class="mt-2 mb-5">
		<div class="row">
			<ul id="prof"> 
				<?php foreach($data['posts'] as $post):?> 
					<li id="profile">
						<img class="img-fluid rounded box" src="<?php echo $post->imgurl;?>" style="width: 300px; height:300px "/>
						<button data-imgid="<?php echo $post->imgid; ?>" name="delimg"  type="button" class="btn btn-outline-danger"><i class="fas fa-close"  aria-hidden="true"></i></button>
					</li>					
				<?php endforeach;?>
			</ul>
		</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>