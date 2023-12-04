// this ftn show the rowgroup btn functionality

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


// This function is used for performing row group shifting
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
// this ftn stop the event from happening 
function testtFTN(event)
{
   event.stopPropagation();
}


