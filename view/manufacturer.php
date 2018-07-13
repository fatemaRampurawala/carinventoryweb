<?php
/* 
 * File created on : 12 July 2018
 * Last modified on : 13 July 2018
 * Purpose : design page to add car manufacturers
 */
require_once '../validateAccess.php';
require_once '../config.php';
?>
<html>
    <body>
        <P><span> Manufacturer's Name <input type="text" name="txt_manfct_name" id="manfct_name" maxlength="30"/>
                <input type="button" id="btn_add_name" value="Add"/></span></p>
                <div id="display_msg"></div>
                <div>
                    <a href="model.php">Add Models</a>
                </div>
    </body>
    <script src="<?php echo $config['js_url'].'jquery.js'; ?>"></script> 
    <script>
        
        var url = "<?php echo $config["base_url"]; ?>";
        $('#btn_add_name').click(function() {
        var name = $("#manfct_name").val();
        $.ajax({
        type: 'POST',
        url: url+'controller.php',
        data: "name="+name+"&action=addManufacturer",
        dataType:'json',
        success: function(data) { 
                $("#display_msg").html(data.msg);
        },
        error: function(xhr, ajaxOptions, thrownerror) {
        alert("Oops !! Some error has been occured");}
    });
    });
</script>
</html>