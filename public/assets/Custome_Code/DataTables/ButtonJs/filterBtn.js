// this function is used to change the filter type of different columns
function tableFilterButton(tableId,column_title) {

    var tableFilterButton = "<div class='btn-group pull-left table_action_buttons ' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Filter" +
        "</a>" +
        "<ul class='dropdown-menu pull-right' >" ; 
        
    $.each(column_title, function (i, title) {
                var titleValue = column_title[i]; 
                var sndName = tableId + titleValue;
                tableFilterButton = tableFilterButton + "<li class='dropdown-item dropdown-submenu'>"
                            +"<p class='test123' onclick='testtFTN(event);' >"+titleValue+"</p>"+
                            "<ul class=' example12 dropdown-menu' >"+
                            "<li class='dropdown-item'>"+ 
                            "<a onclick='rangeFtn(  \""+sndName+"\" , \"mainS_\" )'>Normal</a></li>"+
                            "<li class='dropdown-item'>"+ 
                            "<a onclick='rangeFtn(  \""+sndName+"\" , \"fromTo_\" )'>Range</a></li>"+
                            "<li class='dropdown-item'>"+ 
                            "<a onclick='rangeFtn(  \""+sndName+"\" , \"exc_div\" )'>Exclude</a></li>"  ;
               
                $.each(window[tableId + 'AllowMultipleSelectionColumn'],  function(k , v) {
                   
                    if(titleValue == v)
                    {
                        tableFilterButton = tableFilterButton +  "<li class='dropdown-item'>"+ 
                            "<a onclick='rangeFtn(  \""+sndName+"\" , \"searchDiv_\" )'>Multiple Search</a></li>";
                    }
                });
                 tableFilterButton = tableFilterButton +"</ul></li>";

            });
    tableFilterButton = tableFilterButton +
                "</ul>" +
                "</div>";
    
    return tableFilterButton;
} 

function testtFTN(event)
{
   event.stopPropagation();
}
// this function is ued to change the filter type to range one 
function rangeFtn(dropDown,type) {
    if (type == 'fromTo_') {
        $('#mainS_' + dropDown).hide();
        $('#fromTo_' + dropDown).show();
        $('#exc_div' + dropDown).hide();
        $('#searchDiv_' + dropDown).hide();
    } else if (type == 'mainS_') {
        $('#mainS_' + dropDown).show();
        $('#fromTo_' + dropDown).hide();
        $('#exc_div' + dropDown).hide();
        $('#searchDiv_' + dropDown).hide();
    }else if (type == 'searchDiv_') {
        $('#mainS_' + dropDown).hide();
        $('#fromTo_' + dropDown).hide();
        $('#exc_div' + dropDown).hide();
        $('#searchDiv_' + dropDown).show();
    }else if (type == 'exc_div') {
        var val = $('#exc_div' + dropDown).attr("style");
        if(val == 'display: none;'){
            $('#mainS_' + dropDown).hide();
            $('#fromTo_' + dropDown).hide();
            $('#exc_div' + dropDown).show();
            $('#searchDiv_' + dropDown).hide();
        }else{
            $('#mainS_' + dropDown).show();
            $('#exc_div' + dropDown).hide();
            $('#searchDiv_' + dropDown).hide();
        }
        
    }

}
// End of Table Filter Button
//----------------------------------------------------------------------------------------------------
