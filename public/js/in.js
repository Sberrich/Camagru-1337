// The buttons to start & stop stream and to capture the image
var btnStart = document.getElementById( "btn-start" );
var btnCapture = document.getElementById("btn-capture");
var btnsave = document.getElementById( "btn-save" );
var check = false;

// The video stream
btnStart.addEventListener( "click", function(){
    check = true;
    var video = document.getElementById("stream");
    
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
}
);
 
// Capture canvas
btnCapture.addEventListener("click", function()
{
  if (document.getElementById('imgfilter').src != ""){
    var canvas = document.getElementById("canvas");  
    var ctx = canvas.getContext( '2d' );
    if(canvas.width != 400 || canvas.height != 300)
    {
      window.location.reload(true);
    }
    ctx.drawImage( stream, 0, 0, canvas.width, canvas.height );
    document.getElementById('clear').disabled = false;
  }else
    {
      alert("Choose a sticker");
    }
}
);

// stickers
var emoticon;
var imgfilter = document.getElementById('imgfilter');
var filter = document.getElementsByName('filter');

for (var j= 0; j <= filter.length -1; j++)
{

  filter[j].onclick = function(event) {
    if(canvas.toDataURL() !== document.getElementById('canvas2').toDataURL())
    {
      emoticon = this.value;
      imgfilter.src = emoticon;
    }
    if(check){
      imgfilter.style.display = 'block';
      emoticon = this.value;
      imgfilter.src = emoticon;
    }
  }
}

// saveimage
btnsave.addEventListener( "click", function(){  
 if(canvas.toDataURL() !== document.getElementById('canvas2').toDataURL()) {
   var canvasData = canvas.toDataURL("image/png");
   var params = "imgData="+canvasData+"&filtrsticker="+emoticon;
   var ajax = new XMLHttpRequest();

   ajax.open("POST", "http://localhost/Camagru/Posts/SaveImage");
   ajax.withCredentials = true;
   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   ajax.onreadystatechange = function()
    {
      if (this.readyState == 4 && this.status == 200)
      { 
        
      }
    }
    ajax.send(params);
    window.location.reload(true);
 }
}
);

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
        document.getElementById('clear').disabled = false;
    }
}

el("file").addEventListener("change", readImage, false);

// clear
document.getElementById('clear').addEventListener('click', function(){
  context.clearRect(0, 0, canvas.width, canvas.height);
});

/////////like/////////////

///////////////////////// comments/////////////////////////

var comment = document.getElementsByName('cmnt')
for(var i=0; i < comment.length; i++){ 
  comment[i].onclick = function(event){
    var imgid = (event.target && event.target.getAttribute('data-c-post_id'));
    var userid = (event.target && event.target.getAttribute('data-c-user_id'));
      if(userid == "")
      { window.location.replace("http://192.168.99.101:8088/Camagru/users/login");
      }
    var test = (event.target && event.target.parentElement);
    var val = test.firstElementChild;
    var ajax = new XMLHttpRequest();
    var params = "c_post_id="+imgid+"&c_user_id="+userid+"&comment="+val.value;  
    ajax.open('POST', 'http://192.168.99.101:8088/Camagru/Posts/comment');
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

//////////////////////////like/////////////////////////////////
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
    window.location.replace("http://192.168.99.101:8088/Camagru/users/login");
    return ;
  }
  var ajax = new XMLHttpRequest();
  ajax.open('POST', 'http://192.168.99.101:8088/Camagru/Posts/Like');
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

///////////////////////// comments/////////////////////////

var comment = document.getElementsByName('cmnt')
for(var i=0; i < comment.length; i++){ 
  comment[i].onclick = function(event){
    var imgid = (event.target && event.target.getAttribute('data-c-post_id'));
    var userid = (event.target && event.target.getAttribute('data-c-user_id'));
      if(userid == "")
      { window.location.replace("http://localhost/Camagru/users/login");
      }
    var test = (event.target && event.target.parentElement);
    var val = test.firstElementChild;
    var xhttp = new XMLHttpRequest();
    var params = "c_post_id="+imgid+"&c_user_id="+userid+"&comment="+val.value;  
    xhttp.open('POST', 'http://localhost/Camagru/Posts/comment');
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

//////////////////////////like/////////////////////////////////
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
    window.location.replace("http://localhost/Camagru/users/login");
    return ;
  }
  var xhttp = new XMLHttpRequest();
  xhttp.open('POST', 'http://localhost/Camagru/Posts/Like');
  xhttp.withCredentials = true;
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
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(params);
}