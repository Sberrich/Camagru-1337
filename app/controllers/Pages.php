<?php
  //Class Pages 
  class Pages extends Controller
  {
    public function __construct()
    {
        parent::__construct();
    }
    //Index Method
    public function index()
    {
      $data = [
        'title' => 'Welcome to Camagru',
        'description' => 'This is a small web application allowing you to make basic photo newing using your webcam and some predefined images.',
      ];
      $this->view('pages/index', $data);
    }
    //About Method
    public function about()
    {
      $data = ['title'=>'Samir Berrichi'];
      $this->view('pages/about', $data);
    }
    //Not Found Method
    public function error()
    {
      $this->view('pages/notfound');
    }
  }
?>