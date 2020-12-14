// Buttons to Start and Stop the stream and to clear and save Images
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
        video.stop()
    }, function(error){
    
    });

});
//////////////////Capture Canvas///////////////////////
capture.addEventListener("click",function(event)
{
    if(document.getElementById('img_filter').src !="")
    {
        var canvas = document.getElementById("canvas");
        var context = canvas.getContext('2d');
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
});

/////////////////////Take A stickers//////////////////
var emoji;
var filters = document.getElementById('img_filter');
var stickers = document.getElementsByName('stickers');
for(var i = 0; i < stickers.length; i++)
{
    stickers[i].onclick = function(event)
    {
        if(canvas.toDataURL() !== document.getElementById('canvas').toDataURL())
        {
            emoji = this.value;
            filters.src = emoji;
        }
        if(checker)
        {

            filters.style.display = 'block';
            emoji = this.value;
            filters.src = emoji;
        }
    }
}
///////////////////////Save Images ////////////////////////
save.addEventListener("click", function()
{
    if(canvas.toDataURL() !== document.getElementById('canvas').toDataURL())
    {
        var datacanva = canvas.toDataURL("image/png");
        var val = "image64="+datacanva+"&imagesticker="+emoji;
        var ajax = new XMLHttpRequest();

        ajax.open("POST","http://192.168.99.101:8088/Camagru/Posts/takeImage");
        ajax.withCredentials = true;
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



/////////////////////////////Clear ///////////////////

trash.addEventListener("click", function(){

    context.clearRect(0, 0, canvas.width,canvas.height)
});