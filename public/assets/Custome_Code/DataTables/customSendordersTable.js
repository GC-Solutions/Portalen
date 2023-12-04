function ShowSendOrdersData(sendOrderDataUrl, table_ID) {
    $.get(sendOrderDataUrl, function (data, status) {
            if (data.trim() != '' || data.trim() != null) {
                var jsonData = JSON.parse(data);
                
                var mainData = jsonData.data.MainData;
                var orderData = jsonData.data.orderRow;
                var formId = jsonData.data.formId;
                console.log(mainData);
                console.log(orderData);
                  var i = 0;
                $('#Form' + table_ID).append(getformHtml(mainData , orderData , formId));   
                console.log('#Form' + table_ID);     
                $('#orderRowDatabtn').click(function(event) {
                   
                    if(i== 0){
                        var original = document.getElementById('orderRowData');
                    }
                    else{
                        var original = document.getElementById('orderRowData'+i);
                    }
                   
                    var text = document.createElement('div');
                    text.id = "orderRowData" + ++i;
                    var val = '';
                    $.each(orderData , function(k , v){

                         val += '<div class="form-group row">'+
                       '<label class="control-label col-md-5">'+v.columnName+
                        '</label>'+
                        '<div class="col-md-5">'+
                        '<input type="text" name="'+v.columnName+i+'" value="" class="form-control"/>'+
                        '</div></div>'
                     });
                     val +=  '<input type="hidden" name="rowData" value="'+i+'">' ;
                     text.innerHTML =val;
           
                    original.after(text);
                });             
                

            }

        });
}
function getformHtml(mainData, orderData , formId){


    var val = '';
    $.each(mainData , function(k , v){
        
        if(v.columnType == 'textField'){

            val += '<div class="form-body"><div class="form-group row">'+
                   '<label class="control-label col-md-5">'+v.columnName+
                    '</label>'+
                    '<div class="col-md-5">'+
                    '<input type="text" name="'+v.columnName+'" value="" class="form-control"/>'+
                    '</div></div>';
        }
    });
    if(typeof orderData != undefined){
        val += '<div id="orderRowData" >' 
        $.each(orderData , function(k , v){
           
            if(v.columnType == 'textField'){

                val += '<div class="form-group row">'+
                       '<label class="control-label col-md-5">'+v.columnName+
                        '</label>'+
                        '<div class="col-md-5">'+
                        '<input type="text" name="'+v.columnName+'" value="" class="form-control"/>'+
                        '</div></div>';
            }
        });
        val += '</div> <div class="form-body"><div class="form-group row" ><div style="padding-left: 533px;" ><input type="button" id="orderRowDatabtn" onlick="duplicate();" value= "Add More orders rows"/></div></div></div>';
        }
    var html = '<form action="SendOrdersData" method="post" class="form-horizontal" enctype="multipart/form-data">'+
                '<input type="hidden" name="formId" value="'+formId+'">'    
                + val+
                '<div class="form-body"> <div class="form-group"> <div class="offset-md-5 col-md-7">'+
                                        '<div class="btn-group">'+
                                            '<button type="submit" class="btn btn-danger">'+
                                                'Update'+
                                            '</button></div> </div> </div></div></form>';
            
    return html;
}


   
 



