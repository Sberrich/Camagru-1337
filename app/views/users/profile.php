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

			<div class="container">

							<h1 class="font-weight-light text-center text-lg-left mt-4 mb-0">Yoo! Gallery</h1>
							<hr class="mt-2 mb-5">
							

							<div class="row text-center text-lg-left">
							<?php foreach($data['posts'] as $post):?>
								<div class="col-lg-3 col-md-4 col-6">
								<a href="#" class="d-block mb-4 h-100" id="rmimg">
									
									<img onmouseout="ok(this)" onmouseover="danger(this)"  data-imgid="<?php echo $post->imgid; ?>"  name="delimg" class="img-fluid img-thumbnail" src="<?php echo $post->imgurl;?>" 
									></a>
								</div>
								<?php endforeach;?>
							</div>
			</div>		
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
				var path = window.location.protocol + "//" + window.location.hostname +
                  ":" + (window.location.port)+'/camagru/posts/delImage';
                xhttp.open('POST', path);
                
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



function danger(x) {
	
	
	x.style.background = 'red';
}

function ok(x) {
	
	
	x.style.background = 'white';
}

</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>