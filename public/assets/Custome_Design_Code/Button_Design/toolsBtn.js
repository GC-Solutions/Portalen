//Index 
// (1)This function is used to create the Tools Button which contain clear all data from the filter as well with copy , import csv , export csv , excel , pdf.
// (2)This function is used to trigger the clear all filter values from the filter on entire Table .

//--------------------------------------(1)---------------------------------------------------------------
function tableToolsButton(tableId) {
    var tableToolsButton = "<div class='btn-group pull-left table_action_buttons' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Tools" +
        "<i class='fa fa-angle-down'></i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right'>" +
        "<li><a onclick='testftn("+tableId+")'>Clear All </a></li>"+
        "<li><a class='CopyData' id ='"+tableId+"_CopyData' data-tableId='" + tableId + "'><i class='fa fa-clipboard'></i>Copy</a></li>" +
        "<li><a class='ImportReporttoCSV'  id ='"+tableId+"_ImportCSV' data-tableId='" + tableId + "'><i class='fa fa-file-excel-o'></i>Import CSV</a></li>" +
        "<li><a class='ExportReporttoCSV'  id ='"+tableId+"_ExportReporttoCSV' data-tableId='" + tableId + "'><i class='fa fa-file-excel-o'></i>Export to CSV</a></li>" +
        "<li><a class='ExportReporttoExcel' id ='"+tableId+"_ExportReporttoExcel' data-tableId='" + tableId + "'><i class='fa fa-file-excel-o'></i>Export to Excel</a></li>" +
        "<li><a class='ExportReporttoPdf' id ='"+tableId+"_ExportReporttoPdf' data-tableId='" + tableId + "'><i class='fa fa-file-pdf-o'></i> Export to PDF </a></li>" +
        "</ul>" +
        "</div>";
    return tableToolsButton;
}
//--------------------------------------(2)---------------------------------------------------------------
function testftn(id)
{
    $('.select2-selection__rendered').empty();
    $(':input').val('');
    $.fn.dataTable.ext.search.pop();
    var table = $('#Table_1').DataTable();

    table
     .search( '' )
     .columns().search( '' )
     .draw();
}
