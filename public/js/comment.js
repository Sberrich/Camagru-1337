

      function comment(event)
      {
       var postid = (event.target && event.target.getAttribute('data-c-post_id'));
       var userid = (event.target && event.target.getAttribute('data-c-user_id'));
       
       var co = document.getElementsByName('comment_'+postid);
       var com = co[0].value;
       if(com.trim() == "" && userid != ""){
         co[0].placeholder = 'Please enter valid comment';
         return ;
       }
       if (userid == "") {
         window.location.replace("http://192.168.99.100:8088/Camagru/users/login");
         return;
       }
        var xhttp = new XMLHttpRequest();
       var params = "post_id=" + postid + "&user_id=" + userid + "&content=" + com;
       xhttp.open('POST', 'http://192.168.99.100:8088/Camagru/Posts/comment');
       xhttp.withCredentials = true;
       xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
       xhttp.send(params);
       setInterval(function(){ window.location.reload(); }, 50);
      }
      
      