
<?php
require_once 'config.php';


// put your code here
?><!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form id="frm_login">
            <div>
                <span>Username</span><input type="text" name="username" id="username">
                <span>Password</span><input type="password" name="pswd" id="pswd">
                <input type="button" value="Login" id="login">
            </div>
        </form>
    </body>
    <script src="<?php echo $config['js_url'].'jquery.js'; ?>"></script> 
    <script>
    $('#login').click(function() {
        $.ajax({
        type: 'POST',
        url: 'controller.php',
        data: $('#frm_login').serialize()+"&action=login",
        dataType:'json',
        success: function(data) { 
            if(data.action=="success"){
                window.location.href = "<?php echo $config['base_url'].'view/manufacturer.php' ?>"
            }else{
                alert(data.msg);
            }
        },
        error: function(xhr, ajaxOptions, thrownerror) { 
         alert("Oops !! Some error has been occured");
        }
    });
    });
    </script>
</html>
