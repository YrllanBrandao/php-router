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

        protected function extractMethodameAndParam($row) {
            // Use uma expressão regular para encontrar o nome da função e seus parâmetros
            if (preg_match('/(\w+)\((.+)\)/', $row, $matches)) {
                $action = $matches[1];
                $param = $matches[2];
                
                // Retorne o nome da função e os parâmetros em um array
                return array('action' => $action, 'param' => $param);
            } else {
                return null;
            }
        }
       protected  function run($url){
            $routes = $this -> routes;

            foreach($routes as $key => $route ){
                if($url === $route['route']){
                
                    $class = 'App\\Controllers\\' . ucfirst($route['controller']);

                    $controller = new $class;

                    $action = $route['action'];
                  
               

                    if (strpos($action, '(') !== false && strpos($action, ')') !== false) {
                        $data = $this -> extractMethodameAndParam($action);


                        $action_redirect = $data['action'];
                        $controller -> $action_redirect($data['param']);
                        exit;
                    } else {
                        $controller -> $action();
                        exit;
                    }
                    
                }
                
            }

               $controller =  new \App\Controllers\IndexController;
            
               $controller -> notFound();
            
           
        }
    }