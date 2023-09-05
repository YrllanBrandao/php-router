<?php


namespace MF\Controller;
abstract class Action{
    private function getClassName(){
        $class = get_class($this);
        $class = str_replace('App\\Controllers\\', '', $class);
        $class = str_replace('Controller', '', $class);
        return strtolower($class);
    }
    public  function render($view, $data = []){
        extract($data);
        
        require_once '../App/Views/' .  $this -> getClassName() . '/' . $view . '.php';
    }

}