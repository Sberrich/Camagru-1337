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