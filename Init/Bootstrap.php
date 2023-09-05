<?php

    namespace MF\Init;

    abstract class Bootstrap{

        abstract protected function initRoutes();

        private $routes;

        public function __construct(){
            $this -> initRoutes();
            $this -> run($this -> getUrl());
        }

        public function setRoutes(array $routes){
            $this -> routes = $routes;
        }
        public function getRoutes(){
            return $this -> $routes;
        }

        protected function getUrl(){
            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            return $url;
        }

       protected  function run($url){
            $routes = $this -> routes;

            foreach($routes as $key => $route ){
                if($url === $route['route']){
                
                    $class = 'App\\Controllers\\' . ucfirst($route['controller']);

                    $controller = new $class;

                    $action = $route['action'];
                    $controller -> $action();
                }
                
            }
        }
    }