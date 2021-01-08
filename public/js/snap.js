//initialisation de var 

var video = document.getElementById('video'),
    canvac = document.getElementById('canvas'),
    
    snap = document.getElementById("snap"),
    context = canvac ? canvac.getContext('2d') : null,
    h = 480,
    w = 640,
    sticker,
    canva = 0,
    filter_checked = 0,
    camera_allowed = 0,
    canvasfilter = document.getElementById('canvasf'),
    imgfilter = document.getElementById('imgf'),
    placefilter = imgfilter,
    filter = document.getElementsByName('filter'),
    upload_img = document.getElementById('file'),
    save = document.getElementById("save");
    start = document.getElementById("btn-start");
    pause = document.getElementById("btn-stop");
 
if (video)
{
  //start de stream
start.addEventListener("click",function(event){

  if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
  {
      navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream)
      {
        try {
              video.src = window.URL.createObjectURL(stream);
        } catch (error) {
              video.srcObject = stream;
            }
          video.play();
          camera_allowed = 1;
      }
      ).catch(function(error) {
    
  });
  } else if(navigator.webkitGetUserMedia) {
     
     navigator.webkitGetUserMedia({ video: true }, function(stream){
         try {
                 video.src = window.URL.createObjectURL(stream);
             } catch (error) {
                  video.srcObject = stream;
             }
         video.play();
         camera_allowed= 1;
     }, function(err) {
          console.log("The following error occurred: " + err.name);
       });
  }
});
//pause the stream
pause.addEventListener("click",function(event)
{
  
  if(video)
  {
    if(camera_allowed == 1){
    video.srcObject.getTracks().forEach(function(video) {
        video.stop();
     
    }); }
  }
  });

//Sanp A pic
snap.addEventListener("click", function()
{
  if(filter_checked == 1){
    canvac.setAttribute("width", w);
    canvac.setAttribute("height", h);
    context.drawImage(video, 0, 0, w, h);
    canva = 1;          
  }
  else
  {
       alert("Choose Stickers Bro");
     }
  }
);
//Upload img
upload_img.addEventListener("click", function()
{
  if(filter_checked == 1){
    imgfilter.src = "";
  }
  sticker = "";
  placefilter = canvasfilter;
  filter_checked = 1;
 
  
     
  }
);
function clearcanvas(){
  context.clearRect(0, 0, w, h);
  imgfilter.src = "";
  canvasfilter.src = "";
  imgfilter.style.display = 'none';
  canvasfilter.style.display = 'none';
  canva = 0;
  placefilter = imgfilter;


};

// Clear canvas
document.getElementById('clear').addEventListener("click", clearcanvas);




// Iteration sur stickers

for (var j= 0; j <= 11; j++)
{
  filter[j].onclick = function(event) {
  placefilter.style.display = 'block';
  sticker = this.value;
  filter_checked = 1;
  placefilter.src = sticker;
 
}
}


// check if image in inputs
function isImage(file)
{
   const validImageTypes = ['image/jpg', 'image/jpeg', 'image/png'];
   const fileType = file['type'];
   if (validImageTypes.indexOf(fileType))
       return true;
   else
       return false;
}
// uploading fonction
function uploadimg(){
  upload_img.addEventListener('change', function(ev) {
   var file = ev.target.files[0];
      var img = new Image;

      img.onload = function () {
           context.drawImage(img, 0, 0, w, h);
           canva = 1;
           camera_allowed = 1;
           
      }

 
      if(file && isImage(file))
      {
       img.src = URL.createObjectURL(file);
      }
  });

}
window.addEventListener('DOMContentLoaded', uploadimg);
 

// save a pic
save.addEventListener("click", function(event) {
    
    var imgData = canvas.toDataURL("image/png");
    var params = "image=" + imgData + "&sticker=" + sticker;
    var xhr = new XMLHttpRequest();
    var path = window.location.protocol + "//" + window.location.hostname +
              ":" + (window.location.port)+'/camagru/posts/SaveImage';
   xhr.open('POST', path);
   xhr.withCredentials = true;
   xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   if(canva == 1 && filter_checked == 1 && camera_allowed == 1)
   {
      xhr.send(params);
   }
});


///////////Take Evry
// count down

function takeSnapshot() {
  context.drawImage(video, 0, 0, w, h);
  canva = 1; 
}
       


function takeAuto() {
  //takeSnapshot() // get snapshot right away then wait and repeat
  var counter = parseInt(document.getElementById('myInterval').value)
  var interval
  interval = setInterval(function() {
    if(counter <= 0)
    {
      counter = 1;
    }
    if(--counter == 0)
    {
      document.getElementById('counter').style.display = 'none'
      clearInterval(interval);
    }
    else{
      document.getElementById('counter').style.display = 'block'
      document.getElementById('counter').innerHTML = counter
    }
  }, 1000);
 setTimeout(function(){                                                                                      
     takeSnapshot()
 }, document.getElementById('myInterval').value * 1000);
}
}


