$('body').on("click", "#"+tableTestId+"_ExportReporttoPdf" , function () {
    var tableId = $(this).attr("data-tableId");
    alert(tableId);
   
    $("#" + tableId + '_wrapper  button.buttons-pdf').click();
});

function onClick(){

}