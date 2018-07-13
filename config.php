<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(!isset($config)){
 $config["base_url"]= "http://" . $_SERVER['SERVER_NAME'] ."/carinventory/";
 $config["base_path"]= dirname(__FILE__);
 $config["js_url"]="{$config["base_url"]}js/";
 $config["pics_url"]="{$config["base_url"]}pics/";
 $config["pic_upload_path"]="{$config["base_path"]}\pics\\";
}
//var_dump($config);