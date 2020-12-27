function like(event) {
 
     
    var postid = (event.target && event.target.getAttribute('data-post_id'));
    var userid = (event.target && event.target.getAttribute('data-user_id'));
    var like_nbr = (event.target && event.target.getAttribute('data-like_nbr'));
    
    var li = document.getElementById('li_'+ postid);
    var c = li.getAttribute('class');
    var li_nb = document.getElementById('li_nb_'+postid);
    var sym = 0;

     if (userid == "") {
       window.location.replace("http://192.168.99.102:8088/Camagru/users/login");
       return ;
     }
     var xhttp = new XMLHttpRequest();
     
     xhttp.withCredentials = true;
     xhttp.open('POST', 'http://192.168.99.102:8088/Camagru/Posts/Like');
     if (event.target.className == "far fa-heart") {
       event.target.className = "fas fa-heart";
       like_nbr++;
       li_nb.innerHTML = like_nbr;
       event.target.setAttribute('data-like_nbr', like_nbr);
     }
     else if (event.target.className == "fas fa-heart") {
       event.target.className = "far fa-heart";
       if(like_nbr <= 0)
        sym = 1;
        like_nbr--;
        event.target.setAttribute('data-like_nbr', like_nbr);
       li_nb.innerHTML = like_nbr + sym;
       
     }
     var params = "post_id=" + postid + "&user_id=" + userid + "&c=" + c + "&like_nbr=" + like_nbr;
     xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     xhttp.send(params);
    }
