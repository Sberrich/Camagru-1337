var delimg = document.getElementsByName("delimg");

  for(var i=0; i < delimg.length; i++){ 
            delimg[i].onclick = function(event){
            var imgid = (event.target && event.target.getAttribute('data-imgid'));
            var params = "imgid="+imgid;
            if(confirm("Are you sure you want to delete this Photo??"))
            {
                var xhttp = new XMLHttpRequest();
                xhttp.open('POST', 'http://192.168.99.102:8088/camagru/Posts/delImage');
                
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200){
                        location.reload();
                    }
                }
                xhttp.send(params);
            }
           
        }
}