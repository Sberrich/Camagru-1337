<?php require APPROOT .'/views/inc/header.php';?>
<div class="container">


<main role="main">

<div class="jumbotron">
<img src="../public/imgs/svg/profile.svg" alt="" class="img-fluid"/>
  <p class="lead"></p>
  <hr class="my-4"><p></p>
    <a class="btn-outline-success btn-lg" href="<?php echo URLROOT;?>/posts/camera" role="button">Add Photo</a>  
</div>

<div class="album py-5 bg-light">
  <div class="container">
    <div class="row justify-content-start">
     <?php foreach($data['posts'] as $post)   : ?>
      <div class="col-md-4">    
        <div class="card mb-4 box-shadow">
        <?php echo '<img class="card-img-top" src="'.$post->imgurl.'" alt="Card image cap">'; ?>
          <div class="card-body">
              <div class="container">
                <div class="row justify-content-start">
                    <div class="col-md-4"><p class="card-text"><?php echo $post->username; ?></p></div>
                    <div class="col-md-4"  ><p class="card-text" style="width: 200px"><?php echo $post->imgedate; ?></p></div>
                </div>
            <div class="row ">
                <div class="col-md-4 justify-content-start">
                   <i class="fa fa-heart" aria-hidden="true"> <?php echo $post->likes; ?></i>
                </div>
                <div class="col-md-4 justify-content-end">
                   <i class="fa fa-comments" aria-hidden="true"> <?php echo $post->comments; ?></i>
                </div>
                <div class="col-md-4 justify-content-end"  >
                   <i class="fa fa-trash-o" data-imgid="<?php echo $post->imgid; ?>" name="delimg"></i>
                </div>
            </div>
              </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
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
                xhttp.open('POST', 'http://192.168.99.100:8088/Camagru/Posts/delImage');
                xhttp.withCredentials = true;
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
</main>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>
