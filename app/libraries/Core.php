<?php
		/*
		* App Core Class
		* Creates URL & loads core controller
		* URL FORMAT - /controller/method/params
		*/
	Class Core
	{
		protected $currentController = 'Pages';
		protected $currentMethod = 'index';
		protected $params = [];
		private	  $NotAllowedMethods = ['view', '__construct', 'model'];

		public function __construct()
		{
			$url = $this->getUrl();
			// Look in controllers for first value
			if(isset($url[0]))
			{
				// If exists, set as controller
				$this->currentController = ucwords($url[0]);
				 // Unset 0 index
				unset($url[0]);
			}
			// Check for second part of url
			if(isset($url[1]))
			{
				$this->currentMethod = $url[1];
				unset($url[1]);
			}
			// Controller Exist
			$controllerExist = file_exists('../app/controllers/' . $this->currentController.'.php');
			$methodExist = FALSE;
			//If Controller Exist Require It
			if($controllerExist)
			{
				require_once '../app/controllers/'. $this->currentController . '.php';
				$this->currentController = new $this->currentController;
				// Check to see if method exists in controller
				$methodExist = method_exists($this->currentController, $this->currentMethod);
			}
			 // Get params
			$this->params = $url ? array_values($url) : [];
			//iF Not 
			if (!$methodExist || in_array($this->currentMethod, $this->NotAllowedMethods))
			{
				include(APPROOT.'/views/pages/notfound.php');
				die();
			}
			// Call a callback with array of params
			call_user_func_array([$this->currentController, $this->currentMethod], $this->params);	
		}	
		// GET url
		public function getUrl()
		{
			  if(isset($_GET['url']))
				{
					$url = rtrim($_GET['url'], '/');
					$url = filter_var($url, FILTER_SANITIZE_URL);
				 	$url = explode('/', $url);
					return $url;
				}
		}
	}
?>