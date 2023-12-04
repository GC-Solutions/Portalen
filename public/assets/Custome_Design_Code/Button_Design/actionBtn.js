//Index
// (1) This function is used for showwing Action Button 
// (2) This function add all the action button link to Acton button like (update a column value or Action Button )
// (3) This Function is used to call the Fancy Box for update the row 
// (4) this function is used for Action Button for Products that will add more info  
// (5) This function helps to open/trigger  the form for products
// (6) This Function is used to call the Fancy Box for update the product 
//------------------------------------------------------------------------------------------------------------------------------------------------------------

//----------------------------------(1)-------------------------------------------------//

function tableActionsButton(tableId) {
    
    console.info('tableActionsButton: ' + tableId );
    var tableActionsButton = "<div class='btn-group pull-left table_action_buttons test_act_"+tableId+"' id='actions_"+tableId+"'>"+
            "<a class='btn dimGray-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>"+
            "Actions"+
            "<i class='fa fa-angle-down'>"+
            "</i>"+
            "</a>"+
            "</div>";

    return tableActionsButton;
}
//----------------------------------(2)-------------------------------------------------//
function tableSubActionsButton(tableId, links, names, action_name, status , queryString) {
    console.info('tableSubActionsButton1 =>', tableId, links, names, action_name);

    var t = "";
    var link2_ = String(links).split('%');
    if(typeof names === 'string') 
    {
        var names2_ = names.split('%');
    }else{
        var names2_ =  names;
    }
   

    var link_ = link2_.filter(v=>v!='');
    var names_ = names2_.filter(v=>v!='');
    var color_ = status ? "deepPink-bgcolor" : "dimGray-bgcolor";
    
    var tableActionsButton = "<div class='btn-group pull-left table_action_buttons test_act_"+tableId+"' id='actions_"+tableId+"'>"+
    "<button class='btn dimGray-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>"+
    "Actions"+
    "<i class='fa fa-angle-down'>"+
    "</i>"+
    "</button>"+
    "</div>";

    var tableSubActionsButton = "<div class='btn-group pull-left table_action_buttons test_act_"+tableId+"' id='actions_"+tableId+"'>"+
            "<a class='btn "+color_+
            " btn-outline dropdown-toggle' data-toggle='dropdown'>"+
            action_name+
            "<i class='fa fa-angle-down'>"+
            "</i>"+
            "</a>"+
            "<ul class='dropdown-menu pull-right'>";

    for (i = 0; i < link_.length; ++i) {


        if(link_[i].indexOf("getUpdatePredefined") >= 0){

            link_[i] = link_[i].replace('})',', "curLoc" : "'+ window.location.href +'" })');
            console.log(link_[i]);
        }
        
        if (link_[i].indexOf("getUpdateDataSourceCall") >= 0 || link_[i].indexOf("getUpdatePredefined") >= 0) {
            t += "<li>"+
            "<a href='#' onclick='"+link_[i]+"'>"+
            names_[i]+
            "</a>"+
            "</li>";

        }
        else {
            console.log('overhere');
            var testVar = link_[i].split('&');
            console.log(testVar);

            $.each(testVar, function (k, v) {
                console.log(v.indexOf('columnValue='));
                if(v.indexOf('columnValue=') != -1)
                {

                   
                    if (typeof testVar[k + 1] != "undefined" && testVar[k + 1].indexOf('=') < 1){
                        var check = testVar[k + 1].indexOf('=');
                        testVar[k] = v+'and'+testVar[k + 1];
                        testVar.splice(k + 1);
                        return false;
                    }
                }
            });
            
            var tempLoc = testVar[0].split('/');
            console.log(tempLoc);
            var last = tempLoc[tempLoc.length - 1]
            console.log(last);
            var location = last+'&'+testVar[1];
            
            if(testVar.length > 1){
                if(typeof testVar[2] !=  'undefined' && typeof testVar[3] !=  'undefined'){
                    var columnName = testVar[2].split('=');
                    var columnValue = testVar[3].split('='); 
                    var FIDs = testVar[1].split('=');
                    var formId = columnName[1] + FIDs[1] + columnValue[1];
                }
                else{
                    var columnName = [];
                    var columnValue = []; 
                    if(testVar[1].indexOf("InvoiceNo") != '-1')
                    {
                        var tempIn = testVar[1].split('=');
                        var formId = tempIn[1];
                    }else{
                        var formId = "form1";
                    }
                    

                }
                if(typeof testVar[4] !=  'undefined' && typeof testVar[5] !=  'undefined'){
                    var pageId = testVar[4].split('=');
                    var tableId = testVar[5].split('='); 
                   
                }else{
                    var pageId = [];
                    var tableId = []; 
                   
                }
     
                // form creation for 
                var form = $('<form></form>');
                form.attr("method", "post");
                form.attr("id", formId);
                form.attr("action", location);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", 'backbutton');
                field.attr("value", link_[i]);

                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", 'currLoc');
                var locCurr = window.location.href+queryString;
                console.log(locCurr);
                field.attr("value", locCurr);

                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", columnName[0]);
                field.attr("value", columnName[1]);

                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name",  columnValue[0]);
                field.attr("value", columnValue[1]);
                form.append(field);
                if(typeof pageId !=  'undefined'){
                    
                    var field = $('<input></input>');
                    field.attr("type", "hidden");
                    field.attr("name",  pageId[0]);
                    field.attr("value", pageId[1]);
                    form.append(field);
                }
                
                if(typeof tableId !=  'undefined'){
                    
                    var field = $('<input></input>');
                    field.attr("type", "hidden");
                    field.attr("name",  tableId[0]);
                    field.attr("value", tableId[1]);
                    form.append(field);
                }

                
                $(form).appendTo('body');
               
                ////NEW CODE over Here
                var form = 'document.getElementById("'+formId+'")';
                console.log(formId);
                if(typeof pageId !==  'undefined' && pageId.length > 0)
                {
                    t += "<li>"+
                    // Added line http://"+ SA
                    "<a href='#' onclick='ftnCall("+form+")'>"+
                    names_[i]+
                    "</a>"+
                "</li>";
                }else {
                    t += "<li>"+
                    // Added line http://"+ SA
                    "<a href='#' onclick='"+form+".submit();'>"+
                    names_[i]+
                    "</a>"+
                    "</li>";
                }
            }
            console.log(t);
        }
        
        tableSubActionsButton += t;
    }
    tableSubActionsButton += "</ul></div>";
    console.info('tableSubActionsButton =>', tableSubActionsButton);

    return status ? tableSubActionsButton : tableActionsButton;
}

//----------------------------------(3)-------------------------------------------------//
function ftnCall(formId){

    var form = formId;
    var data_string = $(form).serializeArray();
    var url = formId.action;
        $.ajax({
               type: "POST",
               url: url,
               data: data_string, // serializes the form's elements.
               success: function(data)
               {
                   $.fancybox(data);

               }
             });
}

//----------------------------------(4)-------------------------------------------------//
function tableAddMoreInfo(tableId) {

    var tableAddMoreInfo = "<div class='btn-group pull-left table_action_buttons test_product_"+tableId+"' id='product_"+tableId+"'>" +
        "<a class='btn dimGray-bgcolor  btn-outline '> Add More Info </a></div>";
    
    return tableAddMoreInfo;
}

//----------------------------------(5)-------------------------------------------------//
function tableAddMoreInfoSub(tableId, datarow) {
    proRowData = datarow;
    var tableAddMoreInfo = "<div class='btn-group pull-left table_action_buttons test_product_"+tableId+"' id='product_"+tableId+"'>" +
        "<a class='btn deepPink-bgcolor  btn-outline ' onclick='callForm("+tableId+")'> Add More Info </a></div>";
    
    return tableAddMoreInfo;
}

//----------------------------------(6)-------------------------------------------------//
function callForm(rowdata){

    var tableIdPro1 = tableIdPro[rowdata.id];
    var data_string = {};
    var hea = proRowDataheader[rowdata.id];
    $.each(hea, function (i, title) {
               data_string[title]= proRowData[i];
               
     });

    data_string['TableId'] = tableIdPro1;

    var url = "AddMoreInfo";
        $.ajax({
               type: "POST",
               url: url,
               data: {data:data_string}, // serializes the form's elements.
               success: function(data)
               {
                   $.fancybox(data);
                  
               }
             });
}