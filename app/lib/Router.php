<?php

namespace app\lib;

class Router{
	private array $routes = [];
	private Request $request;
	private $currentController;
	private $currentMethod;

	public function __construct(Request $request){
		$this->request = $request;
	}

	public function get($uri, $callback): void{
		$this->routes['GET'][$uri] = $callback;
	}


	public function post($uri, $callback): void{
		$this->routes['POST'][$uri] = $callback;
	}

	public function hasRoute(string $uri, $method = 'GET'): bool{
		return array_key_exists($uri, $this->routes[$method]);
	}

	public function dispatch(){
		$params = [];
		$method = $this->request->getMethod();
		$uri = rtrim($this->request->getPath(), '/');
		$uri = rtrim($uri, '.php');
		$uri_fragments = explode('/', rtrim($uri, '/'));
		$uri_fragments = array_slice($uri_fragments, 0, 2);
	
		if(count($uri_fragments) > 1){
			$uri = $uri_fragments[0].'/'.$uri_fragments[1];
		}

		// get the controller and method defined in the route
		if($this->hasRoute($uri, $method)){
			$callback = $this->routes[$method][$uri];
			if(is_string($callback)){
				$this->currentController = $this->getController($callback);
				$this->currentMethod = $this->getMethod($this->currentController, DEFAULT_METHOD);
			}else if(is_array($callback)){
				if(isset($callback[0])){
					if($callback[0] == $uri_fragments[0]){
						unset($uri_fragments[0]);
					}

					$this->currentController = $this->getController($callback[0]);
				}
				
				if(isset($callback[1]) && count($uri_fragments)){
					if(isset($uri_fragments[0]) && $callback[1] == $uri_fragments[0]){
						unset($uri_fragments[0]);
					}else if(isset($uri_fragments[1]) && $callback[1] == $uri_fragments[1]){
						unset($uri_fragments[1]);
					}

					$this->currentMethod = $this->getMethod($this->currentController, $callback[1]);
				}

				if(count($uri_fragments)){
					$params = $uri_fragments;
				}
			}
		}else{
			$action = $uri_fragments[count($uri_fragments)-1];
			$this->currentController = $this->getController($uri_fragments[0]);
			$this->currentMethod = $this->getMethod($this->currentController, $action);
		}
		

		return call_user_func_array([$this->currentController, $this->currentMethod], $params);
	}

	private function getController($className){
		if(class_exists('app\\controller\\'.ucwords($className))){
			$class = 'app\\controller\\'.ucwords($className);
			return new $class;
		}else if(class_exists($className)){
			return new $className;
		}

		$class = DEFAULT_CONTROLLER;
		return new $class;
	}

	public function getMethod($controller, $methodName): string{
		if(method_exists($controller, $methodName)){
			return $methodName;
		}else if($methodName == 'home'){
			return DEFAULT_METHOD;
		}

		return 'error';
	}
}