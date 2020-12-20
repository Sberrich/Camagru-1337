var video = document.getElementById('video'),
    full_canvas = document.getElementById('canvas'),
    take_pic = document.getElementById("snap"),
    context = canvas.getContext('2d'),
    h = 480,
    w = 640,
    emoticon,
    full_canvas = 0,
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
pause.addEventListener("click",function(event)
{
  video.srcObject.getTracks().forEach(function(video) {
    video.stop();
  });
  });


take_pic.addEventListener("click", function()
{
    context.drawImage(video, 0, 0, w, h);
    full_canvas = 1;          
  }
);

upload_img.addEventListener("click", function()
{
  if(filter_checked == 1){
    imgfilter.src = "";
  }
  emoticon = "";
  placefilter = canvasfilter;
  filter_checked = 1;
  take_pic.disabled = true;
  
     
  }
);


document.getElementById('clear').addEventListener("click", clearcanvas);
function clearcanvas(){
   context.clearRect(0, 0, w, h);
   imgfilter.src = "";
   canvasfilter.src = "";
   imgfilter.style.display = 'none';
   canvasfilter.style.display = 'none';
   full_canvas = 0;
   placefilter = imgfilter;


};





for (var j= 0; j <= 3; j++)
{
  filter[j].onclick = function(event) {
  placefilter.style.display = 'block';
  emoticon = this.value;
  filter_checked = 1;
  placefilter.src = emoticon;
  take_pic.disabled = false;
}
}





function isImage(file)
{
   const validImageTypes = ['image/jpg', 'image/jpeg', 'image/png'];
   const fileType = file['type'];
   if (validImageTypes.indexOf(fileType))
       return true;
   else
       return false;
}




 





window.addEventListener('DOMContentLoaded', uploadimg);
  function uploadimg(){
      upload_img.addEventListener('change', function(ev) {
       var file = ev.target.files[0];
          var img = new Image;

          img.onload = function () {
               context.drawImage(img, 0, 0, w, h);
               full_canvas = 1;
               camera_allowed = 1;
               
          }

     
          if(file && isImage(file))
          {
           img.src = URL.createObjectURL(file);
          }
      });

  }





  save.addEventListener("click", function(event) {
    
    var imgData = canvas.toDataURL("image/png");
      var params = "image=" + imgData + "&sticker=" + emoticon;
   var xhr = new XMLHttpRequest();
   xhr.open('POST', 'http://localhost/camagru/posts/SaveImage');

   xhr.withCredentialfull_canvas = true;
   xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   if(full_canvas == 1 && filter_checked == 1 && camera_allowed == 1)
   {
    
    xhr.send(params);
   }
   location.reload();
      
});






///////////Take Evry


function takeSnapshot() {
  context.drawImage(video, 0, 0, w, h);
  full_canvas = 1; 
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

