<?php

/* 
 * File created on : 12 July 2018
 * Last modified on : 13 July 2018
 * Purpose : design page to add car models
 */

require_once '../validateAccess.php';
require_once '../config.php';
?>
<html>
    <div>
                    <a href="inventory.php">View Inventory</a>
                </div>
    <body>
         <div id="display_msg"></div>
        <form id="add_car_details">
        <div>
            Model <input type="text" id="model_name" name="model_name" maxlength="30">
            <span>
                <select id="drp_manufacturer" name="manufacturer_id">
                    <option>No Manufaturer</option>
                </select>
            </span>
        </div>
            
            <div> Manufacturing Year <input name="manufacturing_yr" type="text" maxlength="4"  ></div>
        <div> Registration Number : <input type="text" maxlength="10" name="reg_no" placeholder="MH01AB1234"></div>
        <div> Color : <input type="text" maxlength="10" name="color" placeholder="white"></div>
        <div> Price : <input type="text" maxlength="10" name="price" placeholder="500000"></div>
        <div> Note : <textarea maxlength="100" name="note" placeholder="Notes"></textarea></div>
        <div><input type="button" id="btn_add_model" value="Submit"></div>
        <input type="hidden" id="pics" name="pics" value=""/>
        </form>
        <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
            <div id="selectImage">
                <label>Select Your Image</label><br/>
                <input type="file" name="file[]" id="file" required multiple="true"/>
                <input type="submit" value="Upload" class="submit" />
            </div>
        </form>
        
        
    </body>
   <script src="<?php echo $config['js_url'].'jquery.js'; ?>"></script> 
    <script>
        
        var url = "<?php echo $config["base_url"]; ?>";
       // var name = $("#manfct_name").val();
        $( document ).ready(function() {
            
            $.ajax({
                type: 'POST',
                url: url+'controller.php',
                data: "action=getManufacturer",
                dataType:'json',
                success: function(data) { 
                if(data.status=="success" ){
                        var str='';
                        $.each(data.list,function(i,name){
                            
                            str += '<option value="'+i+'">'+name+'</option>';
                        });
                    if(str){
                        $("#drp_manufacturer").html(str);
                    }else{
                        alert('Please Add Manufaturer');
                    }
                    
                }
                }
            });
            
            $('#btn_add_model').click(function() {
                $.ajax({
                    type: 'POST',
                    url: url+'controller.php',
                    data: $("#add_car_details").serialize()+"&action=addModel",
                    dataType:'json',
                    success: function(data) { 
                        if(data.status=="success" ){
                         $("#display_msg").html(data.msg);

                        }
                        },
                    error: function(xhr, ajaxOptions, thrownerror) {
                      //  alert("Oops !! Some error has been occured");
                  }
                });
            });
            $("#uploadimage").on('submit',(function(e) {
                e.preventDefault();
                $("#message").empty();
                $('#loading').show();
                $.ajax({
                    url: "<?php echo $config['base_url'];?>uploadfiles.php", // Url to which the request is send
                    type: "POST",             // Type of request to be send, called as method
                    data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false,       // The content type used when sending data to the server.
                    cache: false,             // To unable request pages to be cached
                    processData:false,
                    dataType:'json',        // To send DOMDocument or non processed data file it is set to false
                    success: function(data)   // A function to be called if request succeeds
                    {
                        console.log("data");
                     if(data && data.status=="success"){
                         $('#pics').val(data.uploadedFiles);
                     }else{
                         alert('Error in file upload');
                     }   
                    }
                });
            }));
        });
    </script>
</html>