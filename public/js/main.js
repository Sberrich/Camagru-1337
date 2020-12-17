document.getElementById('btn').addEventListener('click', function(){
    if( document.getElementById('navbarsExampleDefault').style.display == "block")
      document.getElementById('navbarsExampleDefault').style.display = "none";
    else
      document.getElementById('navbarsExampleDefault').style.display = "block";
    });
    
   (function(){
       var video = document.getElementById('video'),
           canvas = document.getElementById('canvas');
        if (canvas == null)
           return;
        var   w = canvas.width,
           h = canvas.height,
           context = canvas.getContext('2d'),
           imagefile = document.getElementById('upFile'),
           stick = 'none',
           width = window.innerWidth,
           height = window.innerHeight,
           vendorUrl = window.URL || window.webkitURL;
           context.strokeRect(0, 0, w, h);
    
    
       navigator.getMedia =    navigator.getUserMedia ||
                               navigator.webkitGetUserMedia ||
                               navigator.mozGetUserMedia ||
                               navigator.msGetUserMedia;
    
       navigator.getMedia({
           video: true,
           audio: false
       }, function(stream){
           video.srcObject = stream;
           if(video.play())
               document.getElementById('capture').disabled = false;
    
       }, function(error){
    
       });
       
       var imgfilter = document.getElementById("img_filter");
       var radio = document.getElementsByName('stickers');
       for (var i = 0, length = radio.length; i < length; i++)
       {
           radio[i].onclick = function() {
            imgfilter.style.display = 'block';
           imgfilter.src = this.value;
           stick = imgfilter.src.replace("http://192.168.99.100:8088/Camagru", "..");
         
         
       }
    }
    
    
       window.addEventListener('DOMContentLoaded', initImageLoder);
       function initImageLoder(){
           imagefile.addEventListener('change', handleManualUploadedFiles);
    
           function handleManualUploadedFiles(ev){
               var file = ev.target.files[0];
               handleFile(file);
           }
       }
       function handleFile(file){
           var reader = new FileReader();
           reader.onloadend = function(e){
               var tempImageStore =  new Image();
    
               tempImageStore.onload = function(ev){
                   h = ev.target.height;
                   w = ev.target.width;
                   context.clearRect(0, 0, w , h);
                   context.drawImage(ev.target, 0, 0, 400, 300);
                   document.getElementById('up').disabled = false;
                   document.getElementById('clear').disabled = false;
               }
               tempImageStore.src = event.target.result;
           }
           reader.readAsDataURL(file);
       }
       
       
       document.getElementById('capture').addEventListener('click', function(){
       
                if (imgfilter.src != "")
                {
                    h = canvas.height;
                    w = canvas.width;  
                    context.drawImage(video, 0, 0, w , h);
                    document.getElementById('up').disabled = false;
                    document.getElementById('clear').disabled = false;
                    
        
                }
                else {
                    alert("Choose a sticker");
                }
        
    
    
       });
       document.getElementById('up').addEventListener('click', function(){
            if (imgfilter.src != "")
                {
                   saveImage();
                    reloadDIV();
                  
                   h = canvas.height;
                   w = canvas.width; 
                   context.clearRect(0, 0, w , h);
                   context.strokeRect(0, 0, w, h);
                  
   
        
                }
                else {
                    alert("Choose a sticker");
                    document.getElementById('capture').disabled = true;
                }
           
       });
       document.getElementById('clear').addEventListener('click', function(){
        h = canvas.height;
        w = canvas.width;
        context.clearRect(0, 0, w , h);
        context.strokeRect(0, 0, w, h);
    });
        
    function saveImage(){
        
        var canvasData = canvas.toDataURL("image/png");
        var params = "image64="+canvasData+"&imagesticker="+stick;
        var xhttp = new XMLHttpRequest();
        xhttp.open('POST', 'http://192.168.99.100:8088/Camagru/Posts/takeImage');
       
        xhttp.withCredentials = true;
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.onreadystatechange = function()
                    {
                       if (this.readyState == 4 && this.status == 200)
                       {
                          location.reload(); 
                       }
                   }
       xhttp.send(params);
        
    }

    })();

    //////////////////////////////Upload/////////////////////////////
    