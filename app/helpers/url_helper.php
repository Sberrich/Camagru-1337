<?php
    function redirect($page){
        echo "<script>location.replace('". URLROOT . '/' . $page."')</script>";
    }
