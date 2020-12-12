<?php require APPROOT.'/views/inc/header.php'; ?>

<div class="jumbotron">
<h1 class="display-2"><?php echo $data['title']; ?></h1>
   <div>
       <p class="lead">Your account has been created.</p>
       <div class="elementor-image">
		 <img width="427" height="567" src="https://myhappyforce.com/wp-content/uploads/2020/05/hf_agree.png" 
         sizes="(max-width: 400px) 120vw, 400px" ><img width="400" height="500" >
         </div>
    </div> 
    <a href="<?php echo URLROOT;?>/users/login"><button type="button" class="btn btn-primary btn-block py-2">Log in</button></a>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>