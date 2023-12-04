//Index
// (1) This function is used for creating the Table Button with CRUD option when the table is editable.

//---------------------------------(1)---------------------------------------------
function tableButton(tableId) {

    var tableToolsButton = "<div class='btn-group pull-left table_action_buttons' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Table" +
        "<i class='fa fa-angle-down'></i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right'>" ;
       
            tableToolsButton =  tableToolsButton +
            "<li><a id ='"+tableId+"_buttons-create' > New </a></li>"+
            "<li><a id ='"+tableId+"_buttons-edit' > Edit</a></li>"+
            "<li><a id ='"+tableId+"_buttons-remove' > Delete </a></li>"+
            "<li><a id ='"+tableId+"_buttons-select-all' > Select ALL </a></li>"+
            "<li><a id ='"+tableId+"_buttons-select-none' > De Select ALL </a></li>" ;
       
        tableToolsButton= tableToolsButton + "</ul>" +
        "</div>";
    return tableToolsButton;
}