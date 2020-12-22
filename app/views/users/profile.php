<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT;?>/css/profile.css">    

<div class="container">
	<h1 class="text-center text-white">Yoo! Profile</h1>
		<!-- Component Code -->
		<div class="card md-8 container" style="width: 23rem;">
		<a href="#"><img src="../public/imgs/svg/avatar.png" class="card-img-top" id="svg" a>
		<div class="card-body">
			<small class="text-muted d-flex flex-row align-items-center"><svg fill="#aeaeae" height="12px" width="12px" class="mb-1 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
				<path d="M4 8V6a6 6 0 1 1 12 0v2h1a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h1zm5 6.73V17h2v-2.27a2 2 0 1 0-2 0zM7 6v2h6V6a3 3 0 0 0-6 0z" />
				</svg>
			<span>Members only</span></small>
			<div class="d-flex flex-row align-items-center">
			<div class="d-flex flex-column">
				<br>
				<small><a class="font-weight-bold text-dark" href="#">Username :<?php echo $_SESSION['username'];?></a></small>
				<br>
				<small class="font-weight-bold text-dark"> Email:<?php echo $_SESSION['email'];?></small>
			</div>
			</div>
		</div>
		</div>
	<h1 class="text-center text-white">Yoo! Gallery</h1>
	<hr class="mt-2 mb-5">

  
								<div class="row">
								
  
									<ul id="prof"> 
									<?php foreach($data['posts'] as $post):?> 
											<li id="profile">
												<img class="img-fluid rounded box" src="<?php echo $post->imgurl;?>" style="width: 300px; height:300px " id="box" data-imgid="<?php echo $post->imgid; ?>" name="delimg"/>
											</li>
											<?php endforeach;?>
										</ul>

								<div class="light"></div>
												</div>
			


  
<script>
   var delimg = document.getElementsByName("delimg");

  for(var i=0; i < delimg.length; i++){ 
            delimg[i].onclick = function(event){
            var imgid = (event.target && event.target.getAttribute('data-imgid'));
            var params = "imgid="+imgid;
            if(confirm("Are you sure you want to delete this Photo??"))
            {
                var xhttp = new XMLHttpRequest();
                xhttp.open('POST', 'http://192.168.99.100:8088/Camagru/Posts/delImage');
                
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200){
                        location.reload();
                    }
                }
                xhttp.send(params);
            }
           
        }
}
</script>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>