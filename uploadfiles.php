<?php
require_once 'config.php';
require_once 'validateAccess.php';
if(!empty($_FILES["file"]))
{
    $response = array("uploadedFiles"=>'');
    $validFileExtensions = array("jpeg", "jpg", "png");
    $validFileType = array("image/png","image/jpg","image/jpeg");
    foreach ($_FILES["file"]["name"] as $key=>$value){
        $type = $_FILES["file"]["type"][$key];
        $size = $_FILES["file"]["size"][$key];
        $error = $_FILES["file"]["error"][$key];
        $tmpName = $_FILES["file"]["tmp_name"][$key];
        $name = $value;
        $temporary = explode(".", $name);
        $file_extension = strtolower(end($temporary));
        if (in_array($type,$validFileType) && 
            ($size < 100000)//Approx. 100kb files can be uploaded.
            && in_array($file_extension, $validFileExtensions)) {
            
            if ($error > 0)
            {
                $response["status"] = "failed";
                $response["msg"] = "Code: " . $error;
                break;
            }
            else{
                if (file_exists("upload/" . $name)) {
                    $response["status"] = "failed";
                    $response["msg"] = $name ." already exists ";
                    break;
                }
                else{
                    $sourcePath = $tmpName; // Storing source path of the file in a variable
                    $targetPath = "upload/".$name; // Target path where file is to be stored
                    move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
                    $response["status"] = "success";
                    $response["uploadedFiles"] .= $name.",";
                    $response["msg"] = "Image Uploaded Successfully ";
                }
            }
        }
        else{
            $response["status"] = "failed";
            $response["msg"] = "Invalid file Size or Type ";
            break;
        }
}
if(isset($response["uploadedFiles"])){
   $response["uploadedFiles"]=trim($response["uploadedFiles"], ",");
}
echo json_encode($response);
}
?>
