document.addEventListener("DOMContentLoaded", function()
{
  var likes = document.getElementsByName("liket");
  var show = document.getElementsByName("commentbtn");
  var comment = document.getElementsByName("cmntbtn");
 
  //like
  for (var i=0; i < likes.length; i++)
   {
      likes[i].onclick = function(event) 
      {
          if (event.target.className == "fa fa-heart-o")
              {
                  var imgid = (event.target && event.target.getAttribute('data-imgid'));
                  var nbr_cmt = document.querySelector('p[data-imgid="' + imgid + '"]');
                  var userid = (event.target && event.target.getAttribute('data-userid'));
                   if(userid == "")
                  {
                      window.location.href = window.location.host + "/Camagru/users/login";
                  }
                  var xhttp = new XMLHttpRequest();
                  var params = "imgid="+imgid+"&userid="+userid;
                  var path = window.location.protocol + "//" + window.location.hostname +
                  ":" + (window.location.port)+'/camagru/posts/addlikes';
                  xhttp.open('POST', path);
                  xhttp.withCredentials = true;
                  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                  xhttp.onreadystatechange = function(){
                      if (this.readyState == 4 && this.status == 200){
                          nbr_cmt.innerHTML = this.responseText;
                      }    
                  }
                  xhttp.send(params);
                  event.target.className = "fa fa-heart";
              }
//unlike
          else if (event.target.className == "fa fa-heart")
              {
                  var imgid = (event.target && event.target.getAttribute('data-imgid'));
                  var nbr_cmt = document.querySelector('p[data-imgid="' + imgid + '"]');
                  var userid = (event.target && event.target.getAttribute('data-userid'));
                  
                  var xhttp = new XMLHttpRequest();
                  var params = "imgid="+imgid+"&userid="+userid;
                  var path = window.location.protocol + "//" + window.location.hostname +
                  ":" + (window.location.port)+'/camagru/posts/dellikes';
                  xhttp.open('POST', path);
                  xhttp.withCredentials = true;
                  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                  xhttp.onreadystatechange = function(){
                      if (this.readyState == 4 && this.status == 200){
                          nbr_cmt.innerHTML = this.responseText;
                      }    
                  }
                  xhttp.send(params);
                  event.target.className = "fa fa-heart-o";
      }}
     
    }
    

 //comment
 for(var i = 0; i < comment.length; i++)
 { 
    comment[i].onclick = function(event)
    {
         var imgid = (event.target && event.target.getAttribute('data-imgid'));
         var userid = (event.target && event.target.getAttribute('data-userid'));
            if(userid == "")
            { window.location.replace(window.location.protocol + "//" + window.location.hostname +
                 ":" + (window.location.port)+"/Camagru/users/login");
            }
            var test = (event.target && event.target.parentElement);
            var val = test.firstElementChild;
            var cmnt = document.querySelector('p[data-iid="' + imgid + '"]');
            var xhttp = new XMLHttpRequest();
            var path = window.location.protocol + "//" + window.location.hostname +
                  ":" + (window.location.port)+'/camagru/posts/addComments';
                var params = "imgid="+imgid+"&userid="+userid+"&comment="+val.value;  
            xhttp.open('POST',path);
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
    }


});  