<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
	<h1 style="text-align: center;">Profil</h1>
	<hr class="mt-2 mb-5">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body" >
			
				<strong >Username</strong> 
				<div class="form-group form-control form-control-lg">
				<label><?php echo $_SESSION['username'];?></label>
			</div>
			<strong>Email</strong>
			<div class="form-group form-control form-control-lg">
				<label> <?php echo $_SESSION['email'];?></label>
			</div>
		</div>
	</div>
</div>
</div>
<br>
<h1 style="text-align: center;">Photos</h1>
	<hr class="mt-2 mb-5">
	

<div class="row text-center text-lg-left">
<?php foreach($data as $post):?>
    <div class="col-lg-3 col-md-4 col-6">
      <a class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="<?php echo $post->imgurl;?>">
            <form action="<?php echo  URLROOT;?>/posts/delImage" method="POST">
            	<button type="submit" name="submit" class="btn btn-danger">Delete</button>
            	
            	<input  name="postId" type="hidden" value="<?php echo $post->imgid;?>">
            </form>
            
          </a>

    </div>
    <?php endforeach;?>
  </div>



</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>