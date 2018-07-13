<?php

/* 
 * File created on : 12 July 2018
 * Last modified on : 13 July 2018
 * Purpose : to deal with all Manufacturer related operations 
 */
include_once 'database.php';
class Manufacturer extends Database{
    public $data;
    
    /*
     * @Purpose : call to add Manufacturer
     */
    public function addManufacturer(){
        $record["table"]="manufacturer";
        /* scalability : using array here,
         * easy to modify-if in future more coloumns will added*/
        $record["coloumns"]=array("name");
        $record["values"]=array($this->data["name"]);
        $status = $this->insertRecord($record);
        if($status===true){
            $response = array("status"=>"success","msg"=>"Manufacturer added Successfully.");
        }else{
            $response = array("status"=>"error","msg"=>"Error in adding manufacturer.");
        }
        return $response;
    }
    
    /*
     * @Purpose : call to get Manufacturer
     */
    public function getManufacturer(){
        $record["table"]="manufacturer";
        /* scalability : using array here,
         * easy to modify-if in future more coloumns will added*/
        $record["coloumns"]=array("id","name");
        $record["condition"]=1;
        $result = $this->getRecords($record);
        $manufacturerList = array();
        while ($row = $result->fetch_assoc()) {
            $manufacturerList[$row['id']] = ucfirst($row["name"]);/* assuming every table has id field*/
        }
        $response = array("status"=>"success","list"=>$manufacturerList);
        return $response; 
    }
}