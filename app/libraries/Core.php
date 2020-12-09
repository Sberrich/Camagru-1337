<?php
	Class Core{
		protected $currentController = 'Pages';
		protected $currentMethod = 'index';
		protected $params = [];
		private	  $NotAllowedMethods = ['view', '__construct', 'model'];


		public function getUrl(){
      		if(isset($_GET['url'])){
        		 $url = rtrim($_GET['url'], '/');
        		 $url = filter_var($url, FILTER_SANITIZE_URL);
        		 $url = explode('/', $url);
        		return $url;
    	  		}
    		}


		public function __construct(){
			$url = $this->getUrl();
			if(isset($url[0]))
			{
				$this->currentController = ucwords($url[0]);
				unset($url[0]);
			}
			if(isset($url[1]))
			{
				$this->currentMethod = $url[1];
				unset($url[1]);
			}
			$controllerExist = file_exists('../app/controllers/' . $this->currentController.'.php');
			$methodExist = FALSE;
			if($controllerExist)
			{
				require_once '../app/controllers/'. $this->currentController . '.php';
				$this->currentController = new $this->currentController;
				$methodExist = method_exists($this->currentController, $this->currentMethod);
			}
			$this->params = $url ? array_values($url) : [];
			if (!$methodExist || in_array($this->currentMethod, $this->NotAllowedMethods))
			{
				include(APPROOT.'/views/pages/notfound.php');
				die();
			}
			call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

		}	
	}