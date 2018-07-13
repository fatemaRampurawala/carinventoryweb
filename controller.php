<?php
require_once 'config.php';
require_once 'validateAccess.php';
/* 
 * File created on : 12 July 2018
 * Last modified on : 13 July 2018
 * Purpose : Main controller tp handle client side requests 
 */

class Controller{
    /* data contains form data from client*/
    public $data;
     /*
      * @Purpose : call to authenticate user
      */
     public function login(){
         include 'model/getLogin.php';
         $loginObj = new GetLogin();
         $loginObj->data = $_REQUEST;
         return $loginObj->login();
     }
     /*
      * @Purpose : call to add Manufaturer
      */
     public function addManufacturer(){
         include 'model/manufacturer.php';
         $manufacturerObj = new Manufacturer();
         $manufacturerObj->data = $this->data;
         return $manufacturerObj->addManufacturer();
         
     }
     
     /*
      * @Purpose : call to add car model and other details
      */
     public function addModel(){
         include 'model/model.php';
         $modelObj = new Model();
         $modelObj->data = $this->data;
         return $modelObj->addModel();
         
     }
     
     /*
      * @Purpose : call to get List of all manufacturer
      */
     public function getManufacturer(){
         include 'model/manufacturer.php';
         $manufacturerObj = new Manufacturer();
         return $manufacturerObj->getManufacturer();
     }
     
     /*
      * @Purpose : call to view all available cars in inventory
      */
     public function getAllcars(){
         include 'model/model.php';
         $modelObj = new Model();
         $modelObj->data = $this->data;
         $data = $modelObj->getModel();
         $response=array();
         if($data['list']){
             $response["models"]=$data['list'];
             $cars=$modelObj->getCars();
             if($cars['list']){
                $response["cars"]=$cars['list'];
             }
        }
        return $response;
    }
     
    /*
      * @Purpose : call to view all available cars in inventory with manufacturer information
      */

     public function showModels(){
        $manufacturer = $this->getManufacturer();
        $cars = $this->getAllcars();
        $cars["manufacturer"]=$manufacturer["list"];
        return $cars;
     }
     
     /*
      * @Purpose : call to sell cars on sold button action
      */
     public function sellCar(){
         include 'model/model.php';
         $modelObj = new Model();
         $modelObj->data = $this->data;
         return $modelObj->sellCar();
     }
    
}
try{
    if(isset($_POST["action"])){
        $controllerObj = new Controller();
        $action = $_POST["action"];
        $controllerObj->data = $_POST;
        echo json_encode($controllerObj->$action());
    }
}  catch(Exception $e){
    echo json_encode(array("status"=>"error","msg"=>"Script Error"));
}