// Buttons to Start and Stop the stream and to clear and save Images
/*/ 
var start = document.getElementById("btn-start");
var capture = document.getElementById("capture");
var stopit = document.getElementById("btn-stop");
var save = document.getElementById("save");
var trash = document.getElementById("clear");
var checker = false;

//////////////////Start The Studio Stream////////////////////
start.addEventListener("click", function(event)
{
    checker = true;
    var video = document.getElementById("video");

    navigator.getMedia = navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia;
    
    navigator.getMedia({
    video: true,
    audio: false
    }, function(stream){
        video.srcObject = stream;
        video.play()
    }, function(error){
    
    });

});



//////////////////stop The Studio Stream ////////////////////
stopit.addEventListener("click", function(event)
{
    checker = false;
    var video = document.getElementById("video");

    vendorUrl = window.URL || window.webkitURL;
    context.strokeRect(0, 0, w, h);
    navigator.getMedia = navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia;
    
    navigator.getMedia({
    video: true,
    audio: false
    }, function(stream){
        video.srcObject = stream;
        video.pause()
    }, function(error){
    
    });

});

//////////////////Capture Canvas///////////////////////
var canvas = document.getElementById("canvas");
var context = canvas.getContext('2d');
capture.addEventListener("click", function(event)
{
    if(document.getElementById('img_filter').src !="")
    {
       
        if(canvas.width != 400 || canvas.height != 300)
        {
            window.location.reload(true);
        }
        context.drawImage(video, 0, 0, canvas.width,canvas.height);
        trash.disabled = false;
    }else
    {
        alert("You Should Take A sticker");
    }
}

);




/////////////////////Take A stickers//////////////////

var emoji = "none";
var filters = document.getElementById('img_filter');
var stickers = document.getElementsByName('stickers');
for(var i = 0; i < stickers.length; i++)
{
    stickers[i].onclick = function(event)
    {
        if(canvas.toDataURL() !== document.getElementById('canvas2').toDataURL())
        {
            emoji = this.value;
            filters.src = emoji;
        }
        if(checker)
        {

            filters.style.display = 'block';
            filters.src = this.value;
            emoji = filters.src.replace("http://192.168.99.100:8088/Camagru", "..");
        }
    }
}
///////////////////////Save Images ////////////////////////
save.addEventListener("click", function()
{
    if(canvas.toDataURL() !== document.getElementById('canvas2').toDataURL())
    {
        var canvadata = canvas.toDataURL("image/png");
        var val = "image="+canvadata+"&sticker="+emoji;
        var ajax = new XMLHttpRequest();
        ajax.open('POST','http://192.168.99.100:8088/camagru/posts/SaveImage');
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.onreadystatechange = function()
        {
          if (this.readyState == 4 && this.status == 200)
          {
          }
        }
        ajax.send(val);
        window.location.reload(true);
 }
    
});


/////////////////////////upload///////////////////////////
function el(file){return document.getElementById(file);}

var canvas  = el("canvas");
var context = canvas.getContext("2d");

function readImage() {
    if ( this.files && this.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {
           var img = new Image();
           img.addEventListener("load", function() {
             context.clearRect(0, 0, canvas.width, canvas.height);
             context.drawImage(img, 0, 0, canvas.width, canvas.height);
           });
           img.src = e.target.result;
        };       
        FR.readAsDataURL( this.files[0] );
        trash.disabled = false;
    }
}

el("file").addEventListener("change", readImage, false);

/////////////////////////////Clear ///////////////////
trash.addEventListener('click',function(event)
{
    context.clearRect(0,0,canvas.width,canvas.height);
});


/////////////////////Comment///////////////////
var comment = document.getElementsByName('cmnt')
for(var i=0; i < comment.length; i++){ 
  comment[i].onclick = function(event){
    var imgid = (event.target && event.target.getAttribute('data-c-post_id'));
    var userid = (event.target && event.target.getAttribute('data-c-user_id'));
      if(userid == "")
      { window.location.replace("http://192.168.99.100:8088/Camagru/users/login");
      }
    var test = (event.target && event.target.parentElement);
    var val = test.firstElementChild;
    var ajax = new XMLHttpRequest();
    var params = "c_post_id="+imgid+"&c_user_id="+userid+"&comment="+val.value;  
    ajax.open('POST', 'http://192.168.99.100:8088/Camagru/Posts/comment');
    ajax.withCredentials = true;
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            location.reload();
            
        }    
    }
    ajax.send(params);

}
}

//////////////////////////Comment/////////////////////////////////
function like(event)
{
  if( !event ) event = window.event;
  var postid = (event.target && event.target.getAttribute('data-post_id'));
  var userid = (event.target && event.target.getAttribute('data-user_id'));
  var like_nbr = (event.target && event.target.getAttribute('data-like_nbr'));
  var li = document.getElementById('l_'+postid);
  var c = li.getAttribute('class');
  var li_nb = document.getElementById('li_nb_'+postid);
  // var sym = 0;
  if (userid == "") {
    window.location.replace("http://192.168.99.100:8088/Camagru/users/login");
    return ;
  }
  var ajax = new XMLHttpRequest();
  ajax.open('POST', 'http://192.168.99.100:8088/Camagru/Posts/Like');
  ajax.withCredentials = true;
  if (event.target.className == "fa fa-heart-o")
  {
      event.target.className = "fa fa-heart";
      like_nbr++;
      li_nb.innerHTML = like_nbr;
      event.target.setAttribute('data-like_nbr', like_nbr);
      
  }
  else if (event.target.className == "fa fa-heart")
  {
      event.target.className = "fa fa-heart-o";
      // if(like_nbr <= 0)
      //       sym = 1;
      like_nbr--;
      event.target.setAttribute('data-like_nbr', like_nbr);
      li_nb.innerHTML = like_nbr;

  }
  var params = "post_id=" + postid + "&user_id=" + userid + "&c=" + c + "&like_nbr=" + like_nbr;
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.send(params);
}

*/
