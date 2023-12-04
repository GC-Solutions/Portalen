//Index
// (1)This Function create the row group button and all the drop down on those menu like group by differnt columns or sort by inner data or outer data etc.
// (2)This Function is used to trigger the  functionality like open all row groups or close all row group or to set rowgroup from different column or to sort the or serach the data by inner data or outer row data .
// (3)This ftn stop the event from happening 

//---------------------------------(1)---------------------------------------------
function tableRowGroupButton(tableId, groupRowsColumn, sort , predefineSearchFlag, groupRowsFlag ) {

    var tableToolsButton = "<div class='btn-group pull-left table_action_buttons' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Row Group " +
        "<i class='fa fa-angle-down'></i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right'>";

        if(groupRowsColumn != undefined && groupRowsColumn.length != 0 && groupRowsFlag == 1){
            tableToolsButton = tableToolsButton +"<li><a onclick='rowGroupShifting(  \""+tableId+"\" , \"OpenAll\" )'>Open All</a></li>" +
            "<li><a onclick='rowGroupShifting(  \""+tableId+"\" , \"CloseAll\" )'>Close All</a></li>" ;
            tableToolsButton = tableToolsButton + "<li class='dropdown-item dropdown-submenu'>"
                            +"<p class='test123' onclick='testtFTN(event);' >Group By</p>"+
                            "<ul class=' example12 dropdown-menu' >";
              $.each(groupRowsColumn, function (i, title) {
                var titleValue = groupRowsColumn[i]; 
                var columnKey = i;
                tableToolsButton = tableToolsButton + 
                            "<li class='dropdown-item'>"+ 
                            "<a onclick='rowGroupShifting(  \""+tableId+"\" , \"groupBy\" ,\""+columnKey+"\", event ,\""+sort+"\" ,\""+predefineSearchFlag+"\"  )'>Group BY "+titleValue+"</a></li>"+
                            "</li>"  ;
                        

            });
            tableToolsButton= tableToolsButton + "</ul>" ;
            tableToolsButton = tableToolsButton + "<li class='dropdown-item dropdown-submenu'>"
            +"<p class='test123' onclick='testtFTN(event);' >Sort By</p>"+
            "<ul class=' example12 dropdown-menu' >";
               
            tableToolsButton = tableToolsButton + 
            "<li class='dropdown-item'>"+ 
            "<a onclick='rowGroupShifting(  \""+tableId+"\" , \"sortBy\" , \"\", \"internal\" ,\""+sort+"\" ,\""+predefineSearchFlag+"\"  )'>Inner Rows </a></li>"+
            "</li>" + "<li class='dropdown-item'>"+ 
            "<a onclick='rowGroupShifting(  \""+tableId+"\" , \"sortBy\" , \"\", \"external\" ,\""+sort+"\" ,\""+predefineSearchFlag+"\"  )'>Outer Rows </a></li>"+
            "</li>"  ;
            tableToolsButton= tableToolsButton + "</ul>" ;   
            tableToolsButton = tableToolsButton + "<li class='dropdown-item dropdown-submenu'>"
            +"<p class='test123' onclick='testtFTN(event);' >Search By</p>"+
            "<ul class=' example12 dropdown-menu' >";
               
            tableToolsButton = tableToolsButton + 
            "<li class='dropdown-item'>"+ 
            "<a onclick='rowGroupShifting(  \""+tableId+"\" , \"sortBy\" , \"\", \"innerSearch\" ,\""+sort+"\" ,\""+predefineSearchFlag+"\"  )'>Inner Rows </a></li>"+
            "</li>" + "<li class='dropdown-item'>"+ 
            "<a onclick='rowGroupShifting(  \""+tableId+"\" , \"sortBy\" , \"\", \"outerSearch\" ,\""+sort+"\" ,\""+predefineSearchFlag+"\"  )'>Outer Rows </a></li>"+
            "</li>"  ;
            tableToolsButton= tableToolsButton + "</ul>" ;  
        }

        tableToolsButton= tableToolsButton + "</ul>" +
        "</div>";
    return tableToolsButton;
}

//---------------------------------(2)---------------------------------------------
function rowGroupShifting(tableId , name, columnId , event , sort, predefineSearchFlag, groupRowsFlag)
{
  
   if(name == 'OpenAll')
   {
    var table1 = $('#'+tableId).DataTable();
    openAll = 'openall';
    closeAll = '';
    
    table1.draw(false);
   }else if(name == 'CloseAll')
   {
    var table1 = $('#'+tableId).DataTable();
    closeAll = 'closeall';
    openAll = '';
    table1.draw(false);
   }else if (name == 'groupBy')
   {

    var table = $('#'+tableId).DataTable();
    event.preventDefault();
    closeAll = '';
    openAll = '';
   
    table.rowGroup().dataSrc(columnId);
    if(predefineSearchFlag != 0){
        table.order.fixed({pre: [[sort, 'asc']]}).draw();
    }
    else{
         table.order.fixed({pre: [[columnId, 'asc']]}).draw();
    }
    }else if(name == 'sortBy'){
    var table = $('#'+tableId).DataTable();
  
        var url = 'setSession';
        $.ajax({
            type: "POST",
            url: url,
            data: {data:event}, // serializes the form's elements.
            success: function(data)
            {
                setGlobal = event;
           

            }
          });
    }
}

//---------------------------------(3)---------------------------------------------
function testtFTN(event)
{
   event.stopPropagation();
}


