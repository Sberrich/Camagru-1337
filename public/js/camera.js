// Buttons to Start and Stop the stream and to clear and save Images

var start = document.getElementById("btn-start");
var capture = document.getElementById("capture");
var stopit = document.getElementById("btn-stop");
var save = document.getElementById("save");
var trash = document.getElementById("clear");
var checker = false;
var video = document.getElementById("video");

//////////////////Start The Studio Stream////////////////////
start.addEventListener("click", function(event)
{
    checker = true;
    
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
            emoji= filters.src;
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
        ajax.open('POST','http://192.168.99.100:8088/Camagru/Posts/SaveImage');
        ajax.withCredentials = true;
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        ajax.onreadystatechange = function()
        {
          if (this.readyState == 4 && this.status == 200)
          {
            console.log;
            //   location.reload();
          }
        }
        ajax.send(val);
 }
    
});


/////////////////////////upload///////////////////////////





/////////////////////////////Clear ///////////////////
