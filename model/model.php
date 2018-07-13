<?php

/* 
 * File created on : 12 July 2018
 * Last modified on : 13 July 2018
 * Purpose : to deal with all model related operations 
 */
include_once 'database.php';
class Model extends Database{
    public $data;
    
    /*
     * @Purpose : call to add Models with details
     */
    public function addModel(){
        $isModelExists = FALSE;
        $this->data["model_name"]= trim($this->data["model_name"]);
        $isModelExists = $this->checkModel();// if true return model id otherwise returm bool false
        /*
         * check if model already exists then,  get model id
         */
        if($isModelExists){
            $modelId = $isModelExists;
        }else{
            // add new models
            $record["table"]="model";
            $record["coloumns"]=array("man_id","name");
            $record["values"]=array($this->data["manufacturer_id"],$this->data["model_name"]);
            $status = $this->insertRecord($record);
            if($status!==true){
                $response = array("status"=>"error","msg"=>"Error in adding Model.");
                return $response;
            }
            $modelId = $this->getLastId();
        }
        $response = $this->addCar($modelId);
        return $response;
    }
    
    /*
     * @Purpose : check if model with same name and manufaturer exists,
     * to avoid data redundancy
     */
    public function checkModel(){
        $record["table"]="model";
            $record["coloumns"]=array("id");
            $record["condition"]=" man_id=".$this->data["manufacturer_id"]." and"
                    . " name='".$this->data["model_name"]."'";
            
            $result = $this->getRecords($record);
            $row = $this->fetchRecords($result);
            if($row){
                return $row[0]['id'];
            }else{
                return false;
            }
    }
    
    /*
     * @Purpose : add car details with model information
     */
    public function addCar($modelId){
        $record["table"]="car";
        /* scalability : using array here,
         * easy to modify-if in future more coloumns will added*/
        $record["coloumns"]=array("model_id", "manufacturing_year", "registration_no", "color",
            "price", "note", "pics");
        $record["values"]=array($modelId,
                                $this->data["manufacturing_yr"],
                                $this->data["reg_no"],
                                $this->data["color"],
                                $this->data["price"],
                                $this->data["note"],
                                $this->data["pics"],
                );
        $status = $this->insertRecord($record);
        if($status===true){
            $response = array("status"=>"success","msg"=>"model added Successfully.");
        }else{
            $response = array("status"=>"error","msg"=>"Error in adding Model.");
        }
        return $response;
    }

    /*
     * @Purpose : get all available models 
     */
    public function getModel(){
        $record["table"]="model";
        $record["coloumns"]=array("id","man_id","name");
        $record["condition"]=1;
        $result = $this->getRecords($record);
        $modelList = array();
        while ($row = $result->fetch_assoc()) {
            $modelList[$row['id']] = $row;/* assuming every table has id field*/
        }
        $response = array("status"=>"success","list"=>$modelList);
        return $response; 
    }
    
    /*
     * @Purpose : call to get all cars
     */
    public function getCars(){
        $record["table"]="car";
        $record["coloumns"]=array("id","model_id", "manufacturing_year", "registration_no", "color",
            "price", "note", "pics");
        $record["condition"]=1;
        $result = $this->getRecords($record);
        $carList = array();
        if($result->num_rows){
            while ($row = $result->fetch_assoc()) {
                $carList[$row['id']] = $row;/* assuming every table has id field*/
            }
        }
        $response = array("status"=>"success","list"=>$carList);
        return $response; 
    }
    /*
     * @Purpose : call to handle sell cars logic
     */
    public function sellCar(){
        // for sales tracking purpose, can also fetch car record and
        //  stored it in sales related tables before deleting it
        $record["table"]="car";
        $record["condition"]="id='".$this->data['car_id']."'";
        $status = $this->deleteRecords($record);
        $response = array();
               if($status===true){
            $response = array("status"=>"success","msg"=>"Car Sold Out");
        }else{
            $response = array("status"=>"error","msg"=>"Error in selling car.");
        }
        return $response;
    }
}