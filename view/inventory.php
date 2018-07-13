<?php

/* 
 * File created on : 12 July 2018
 * Last modified on : 13 July 2018
 * Purpose : design page to view Inventory
 */
require_once '../validateAccess.php';
require_once '../config.php';
?>
<html>
    <body>
        <div>
            <a href="manufacturer.php.php">Add Manufacturer</a>
        </div>
        <div>
            <a href="model.php">Add Models</a>
        </div>
        <table >
            <thead>
            <td>Manufacturer</td>
            <td>Model</td>
            <td>Count</td>
            </thead>
            <tbody id="show_models"></tbody>
        </table>
        <div id="popup">
        <table class="dn" id="head">
            <thead>
            <th>Color</th>
            <th>Manufacturing Year</th>
            <th>Price</th>
            <th>Registration No.</th>
            <th>Note</th>
            <th>pics</th>
            </thead>
            <tbody id="cars">
                
            </tbody>
        </table>
        </div>
    </body>
        <script src="<?php echo $config['js_url'].'jquery.js'; ?>"></script> 
        <script src="<?php echo $config['js_url'].'jquery-ui.js'; ?>"></script> 
        <link rel="stylesheet" href="<?php echo $config['base_url'];?>css/jquery-ui.css">
    <script>
        $('.dn').hide();
        var url = "<?php echo $config["base_url"]; ?>";
        var model_count = new Object;
        $( document ).ready(function() {
        var name = $("#manfct_name").val();
        $.ajax({
        type: 'POST',
        url: url+'controller.php',
        data: "action=showModels",
        dataType:'json',
        success: function(data) { 

                var model_id = new Array;
                var i=0;
                var id=0;
                $.each(data.cars,function(index,value){
                    id = value.model_id;
                   if($.inArray(id,model_id)>-1){
                       model_count[id]++;
                   }else{
                       model_count[id]=1;
                       model_id[i++]=id;
                       $("#show_models").append(
                            '<tr onclick="showPopup(\''+id+'\');" id=tr_model_'+id+' class="model_clk">'  +
                                '<td>'+data['manufacturer'][data['models'][id]['man_id']]+'</td>' +
                                '<td>'+data['models'][id]['name']+'</td>' +
                                '<td id="model_count_'+id+'"></td>' +
                            '</tr>');
                   }
                   var picLink = value['pics'].split(',');
                   var pics_str = '';
                   $.each(picLink,function (i,val){
                       if(val){
                          pics_str+='<a href="'+url+'upload/'+val+'">'+val+'</a>'; 
                       }
                   });
                   $("#cars").append(
                        '<tr class="model_'+id+' tr_model" id="tr_'+index+'">'+
                            '<td>'+value.color+'</td>'+
                            '<td>'+value.manufacturing_year+'</td>'+
                            '<td>'+value.price+'</td>'+
                            '<td>'+value.registration_no+'</td>'+
                            '<td>'+value.note+'</td>'+
                            '<td>'+pics_str+'</td>'+
                            '<td><input type="button" onclick="sellCar(\''+index+'\',\''+id+'\');" value="sold"></td>'+
                        '</tr>'   
                    );

                });
                updateCounts();
                $(".model_clk").css('cursor', 'pointer');
        },
        error: function(xhr, ajaxOptions, thrownerror) {
        alert("Oops !! Some error has been occured");}
            });
    });
    
        function updateCounts(){
                $.each(model_count,function(id,count){
                    $("#model_count_"+id).html(count);
                });
        }
        
        function showPopup(model_id){
        $(".tr_model").hide();
        $("#popup").dialog({
            minWidth: 800
        });
        $(".model_"+model_id).show();
        $("#head").show();
        }
        
        function sellCar(car_id,model_id){
            $.ajax({
                    type: 'POST',
                    url: url+'controller.php',
                    data: "action=sellCar&car_id="+car_id,
                    dataType:'json',
                    success: function(data) {
                        if(data.status=="success"){
                            $("#tr_"+car_id).remove();
                            model_count[model_id]--;
                            updateCounts();
                        }
                    },
                error: function(xhr, ajaxOptions, thrownerror){
                    alert("Oops !! Some error has been occured");
                }
            });
        }
        
</script>
</html>