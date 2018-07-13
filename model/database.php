<?php
/* 
 * File created on : 12 July 2018
 * Last modified on : 13 July 2018
 * Purpose : to deal with all database related operations and error handling
 */
class Database{
    private $dbConn;
    public $error = array();
    /*
     * @Purpose : call to make db connection
     */
    function __construct(){
        $this->dbConn = new mysqli('localhost', 'admin', 'admin','car_inventory');
        /* check connection */
        if ($this->dbConn->connect_errno) {
            $this->error = $this->errorHandler
                    (array("status"=>"failed","msg"=>$this->dbConn->connect_error));
              
        }
    }
    
    /*
     * @Purpose : call to get last inserted id
     */
    function getLastId(){
        return $this->dbConn->insert_id;
    }
    
    /*
     * @Purpose : get records from mysql tables
     */
    function getRecords($param){
        $coloumns = implode("`,`",$param["coloumns"]);
        $query = "SELECT `".$coloumns."` FROM ".$param["table"].
                " WHERE ".$param["condition"]." ".(isset($param["otherOptions"])?$param["otherOptions"]:"");
        return $this->execQuery($query);// returns a resource   
    }
    
    /*
     * @Purpose : delete records from mysql tables
     */    
    function deleteRecords($param){
        $query = "DELETE FROM ".$param["table"].
                " WHERE ".$param["condition"];
       return $this->execQuery($query);// returns a resource

    }
    
    /*
     * @Purpose : get records from Result set resource
     */
    function fetchRecords($result){
       /* fetch associative array */
       $records = array();
       $i=0;
       while ($row = $result->fetch_assoc()) {
           $records[$i++] = $row;/* assuming every table has id field*/
       }
       return $records;
    }

    /*
     * @Purpose : insert records into mysql tables
     */
    function insertRecord($param){
        $coloumns = implode("`,`",$param["coloumns"]);
        $values = implode("','" ,$param["values"] );
        $query = "Insert Into ".$param["table"]." ( `".$coloumns."` ) VALUES ( '" .$values. "' )";
        return $this->execQuery($query);// return boolean value
    }
    
    /*
     * @Purpose : single point function to execute all db queries throughout the project
     */
    function execQuery($query){
         return $this->dbConn->query($query);
    }
    
    /*
     * @Purpose : error handler for any db error
     */
    function errorHandler($error_array){
       return "Connection Status : ".$error_array['status'].
           "Error : ".$error_array['msg'];
    }
    
    /*
     * @Purpose : close db connection
     */
    function __destruct(){
       mysqli_close($this->dbConn);
    }
    
}
