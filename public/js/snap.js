//initialisation de var 

var video = document.getElementById('video'),
    canva = document.getElementById('canvas'),
    snap = document.getElementById("snap"),
    context = canva.getContext('2d'),
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
  video.srcObject.getTracks().forEach(function(video) {
    video.stop();
  });
  });

//Sanp A pic
snap.addEventListener("click", function()
{
    context.drawImage(video, 0, 0, w, h);
    canva = 1;          
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
  snap.disabled = true;
  
     
  }
);

// Clear canvas
document.getElementById('clear').addEventListener("click", clearcanvas);
function clearcanvas(){
   context.clearRect(0, 0, w, h);
   imgfilter.src = "";
   canvasfilter.src = "";
   imgfilter.style.display = 'none';
   canvasfilter.style.display = 'none';
   canva = 0;
   placefilter = imgfilter;


};



// Iteration sur stickers

for (var j= 0; j <= 11; j++)
{
  filter[j].onclick = function(event) {
  placefilter.style.display = 'block';
  sticker = this.value;
  filter_checked = 1;
  placefilter.src = sticker;
  snap.disabled = false;
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

window.addEventListener('DOMContentLoaded', uploadimg);
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




// save a pic
  save.addEventListener("click", function(event) {
    
    var imgData = canvas.toDataURL("image/png");
      var params = "image=" + imgData + "&sticker=" + sticker;
   var xhr = new XMLHttpRequest();
   xhr.open('POST', 'http://192.168.99.102:8088/camagru/posts/SaveImage');

   xhr.withCredentialcanva = true;
   xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   if(canva == 1 && filter_checked == 1 && camera_allowed == 1)
   {
    
    xhr.send(params);
   }
   location.reload();
      
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
    console.log('set interval')                                                                                    
     takeSnapshot()
 }, document.getElementById('myInterval').value * 1000);
}



