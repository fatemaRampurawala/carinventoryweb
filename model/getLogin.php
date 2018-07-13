<?php

/* 
 * File created on : 12 July 2018
 * Last modified on : 13 July 2018
 * Purpose : to handle login logics and set session data
 */

class GetLogin{
    public $data = array();
    /*
     * @Purpose : call to authenticate user
     */
    public function login(){
         if(($_REQUEST["username"]=="admin" && $_REQUEST["pswd"]=="admin")){
            /*
             * here we can also use database. 
             * users table for validate username password combination
             */
            $_SESSION["username"]="fatema";
            $response=array("action"=>"success"); 

        }else{
            $response=array("action"=>"error","msg"=>"Invalid UserName or Password"); 
        }
        return $response;
    }
}