<?php
  class Pages extends Controller {
    public function __construct(){
     $this->postModel = $this->model('Post');
    }
    public function index()
    {
            $posts = $this->postModel->getImage();
            $likes = $this->postModel->getlikes();
            $comments = $this->postModel->getComments();
            $data = [
                'title'=>'Camagru '. $_SESSION['username'].'',
                'posts' => $posts,
                'likes' => $likes,
                'comments' => $comments
            ];
     
      $this->view('pages/index', $data);
    }
    public function about(){
      $data = ['title'=>'Samir Berrichi'];
      $this->view('pages/about', $data);
    }
    
  }