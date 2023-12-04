function ShowPanelData(panelDataUrl, Panel_ID, panelInformationUrl,placeholderPanelId) {
    $.get(panelDataUrl, function (data, status) {
            if (data.trim() != '' || data.trim() != null) {
                var jsonData = JSON.parse(data);
                
                if ((jsonData.panelColor).trim() != '' || (jsonData.panelImage).trim() != '') {
                    $('#' + Panel_ID).append(getPanelHtml(jsonData.panelImage, jsonData.panelColor, jsonData.tableId, jsonData.panelColumns,placeholderPanelId,jsonData.panelType,jsonData.panelProgress,jsonData.panelText));
                }

                setTimeout(function () {
                    if ((jsonData.buttonText).trim() != '' && (jsonData.buttonColor).trim() != '' && (jsonData.buttonAction).trim() != '') {
                        $('#' + Panel_ID + ' .progress-description').append(getReadMore(jsonData.buttonColor, jsonData.buttonAction, jsonData.buttonText));
                    }
                }, 100);

               
                setTimeout(function () {
                    
                    if(jsonData.panelType == '1')
                    {
                        $('#' + Panel_ID + ' .info-box-text').append(jsonData.title);
                        $('#' + Panel_ID + ' .info-box-number').append(jsonData.number);
                    }if(jsonData.panelType == '4')
                    {
                        $('#' + Panel_ID + ' .info-box-text').append(jsonData.title);
                        jsonData.number= jsonData.number.toString().replace(jsonData.denominationText,'');
                        jsonData.number= jsonData.number.replace(/ /g,'');
                        $('#' + Panel_ID + ' .info-box-number').attr( 'data-value',jsonData.number);
                        $('#' + Panel_ID + ' .info-box-number').append(jsonData.number);
                    }if(jsonData.panelType == '5')
                    {
                         jsonData.title= jsonData.title.replace(jsonData.panelFormula,"</span><span id='info-box-number'></span>");
                         jsonData.panelD3Text= jsonData.panelD3Text.replace(jsonData.panelFormula,"<span id='info-box-number'></span>");
            
                         $('#' + Panel_ID + ' #info-box-text').append(jsonData.title);
                         $('#' + Panel_ID + ' #info-box-text2').append(jsonData.panelD3Text);
                         $('#' + Panel_ID + ' #info-box-number').append(jsonData.number);
                     }
                    
                    $('#' + Panel_ID + ' .tableID').append(jsonData.tableId);
                    $('#' + Panel_ID + ' .sumType_'+jsonData.tableId+'_'+placeholderPanelId).append(jsonData.panelSumType);
                    $('#' + Panel_ID + ' .customFormula_'+jsonData.tableId+'_'+placeholderPanelId).append(jsonData.panelFormula);
                    $('#' + Panel_ID + ' .panelColumns_'+jsonData.tableId+'_'+placeholderPanelId).append(jsonData.panelColumns);
                    $('#' + Panel_ID + ' .columnOperatoins_'+jsonData.tableId+'_'+placeholderPanelId).append(jsonData.columnOperatoins);
                    $('#' + Panel_ID + ' .denominationText_'+jsonData.tableId+'_'+placeholderPanelId).append(jsonData.denominationText);
                    $('#' + Panel_ID + ' .placeholderPanelId_'+jsonData.tableId+'_'+placeholderPanelId).append(placeholderPanelId);
                    $('#' + Panel_ID + ' .allowDecimal_'+jsonData.tableId+'_'+placeholderPanelId).append(jsonData.allowDecimalFlag);
                    $('#' + Panel_ID + ' .allowRowGroupCal_'+jsonData.tableId+'_'+placeholderPanelId).append(jsonData.EnableGroupRowCal);
                    $('#' + Panel_ID + ' .rowGroupColumnName_'+jsonData.tableId+'_'+placeholderPanelId).append(jsonData.RowGroupColumnName);
                    $('#' + Panel_ID + ' .TimeTableSeparator_'+jsonData.tableId+'_'+placeholderPanelId).append(jsonData.TimeTableSeparator);
                    $('#' + Panel_ID + ' .ColumnDataType_'+jsonData.tableId+'_'+placeholderPanelId).append(jsonData.ColumnDataType);
                    
                    
                    
                    
                            //var panelDataAttr = 'data-'+jsonData.panelColumns;
                            //var panelColumn = $('#' + Panel_ID + ' .panelColumns_'+jsonData.tableId).append(jsonData.panelColumns);
                            //panelColumn.prop(panelDataAttr, jsonData.panelColumns)
                        //}
                    //});
                }, 100);
            }

        }
    );
}


function getReadMore(actionColor, actionLink, actionText) {
    var actionButtonHtml = "<div class='pull-right'><a class='panel_read_more' style='color: black;' onclick='window.location.href=\"" + actionLink + "\"'>" +
        "" + actionText +
        "</a>" +
        "</div>";
    return actionButtonHtml;
}

function getPanelHtml(panelImage, panelColor, tableId, panelColumns,placeholderPanelId,panelType,panelProgress, panelText) {

if(panelType == 1){
 var panelHtml = "<div class='info-box bg-white'>" +
        "</span>" +
      // "<div class='info-box-content'>" +
        "<span class='info-box-text' id='info-box-text'></span>" +
        "<span class='info-box-number' id='info-box-number'></span>" +
        "<div class='progress'><div class='progress-bar progress-bar-cyan width-100' ></div></div>" +
 
  //"<div class="progress-bar progress-bar-green width-60" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>"+
        "<span class='progress-description'></span>" +
        "<span class='tableID' style='display: none;'></span>" +
        "<span class='sumType_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='customFormula_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='panelColumns_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='columnOperatoins_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='placeholderPanelId_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='denominationText_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='allowDecimal_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='allowRowGroupCal_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='rowGroupColumnName_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='TimeTableSeparator_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='ColumnDataType_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
       
        
        "</div></div>";
    }
if(panelType == 4){
/////   This is the  default code for new panel design.

 // var panelHtml = 
 //   "<div class='state-overview'>"+
 //    "<div class='overview-panel "+panelColor+"' >" +
 //    "<div class=' symbol' ><i class='fa fa-users usr-clr'></i></div>" +
 //    "<div class='value white'><p data-counter='counterup' data-value='' class='info-box-number' id = 'info-box-number'><span  class='info-box-text' id = 'info-box-text'></span></p></div>" +
 //    "<span class='progress-description'></span>" +
 //    "<span class='tableID' style='display: none;'></span>" +
 //    "<span class='sumType_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
 //    "<span class='customFormula_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
 //    "<span class='panelColumns_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
 //    "<span class='columnOperatoins_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
 //    "<span class='placeholderPanelId_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
 //    "<span class='denominationText_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
 //    "</div></div>";


/////   This is the  update code  for new panel design.

    var panelHtml = 
       
        "<div class='overview-panel state-overview ' style='height: 91px;'>" +
        "<div class='state-overview symbol' style='margin-top: -12px; color: black;'><i class='fa fa-users usr-clr'></i></div>" +
        "<div class='state-overview value white' style='color: black;border-color: #78d1ff;margin-top: 15px;'><span  class='info-box-text' id = 'info-box-text'></span><span data-counter='counterup' data-value='' class='info-box-number' id = 'info-box-number'></span>" +
        "<span class='progress-description'></span>" +
        "<span class='tableID' style='display: none;'></span>" +
        "<span class='sumType_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='customFormula_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='panelColumns_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='columnOperatoins_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='placeholderPanelId_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='denominationText_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='allowDecimal_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='allowRowGroupCal_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='rowGroupColumnName_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='TimeTableSeparator_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='ColumnDataType_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        
        
        "</div></div></div>";

    //var panelHtml = 
       
        // "<div class='overview-panel state-overview ' style='height: 91px;'>" +
        // "<div class='state-overview symbol' style='margin-top: -12px; color: black;'><i class='fa fa-users usr-clr'></i></div>" +
        // "<div class='state-overview value white' style='color: black;border-color: #78d1ff;margin-top: 15px;'><span  class='info-box-text' id = 'info-box-text'></span><span data-counter='counterup' data-value='94527493' class='info-box-number' id = 'info-box-number'>94527493</span>" +
        // "<span class='progress-description'></span>" +
        // "<span class='tableID' style='display: none;'></span>" +
        // "<span class='sumType_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
        // "<span class='customFormula_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
        // "<span class='panelColumns_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        // "<span class='columnOperatoins_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        // "<span class='placeholderPanelId_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        // "<span class='denominationText_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        // "</div></div></div>";


    }
    if(panelType == 5){
        var panelHtml = 

        "<div class='card'>"+
        "<div class='panel-body' >"+
        "<span id ='info-box-text' style='display: block; font-size: 1.17em; margin-top: 1em; margin-bottom: 1em; margin-left: 0; margin-right: 0; font-weight: bold;'></span>"+
        "<div class='progressbar-xs progress-rounded progress-striped progress ng-isolate-scope active'>"+
        "<div class='progress-bar progress-bar-"+panelColor+" width-"+panelProgress+"' role='progressbar' aria-valuenow='73' aria-valuemin='0' aria-valuemax='112'></div>"+
        "</div>"+
        "<span class ='text-small margin-top-10 full-width' id ='info-box-text2'></span>"+
        "<span class='progress-description'></span>" +
        "<span class='tableID' style='display: none;'></span>" +
        "<span class='sumType_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='customFormula_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='panelColumns_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='columnOperatoins_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='placeholderPanelId_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='denominationText_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='allowDecimal_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='allowRowGroupCal_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='rowGroupColumnName_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='TimeTableSeparator_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        "<span class='ColumnDataType_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
        
        
        "</div></div></div></div>";
    }
//     if(panelType == 6){
// /////   This is the  default code for new panel design.

//  // var panelHtml = 
//  //   "<div class='state-overview'>"+
//  //    "<div class='overview-panel "+panelColor+"' >" +
//  //    "<div class=' symbol' ><i class='fa fa-users usr-clr'></i></div>" +
//  //    "<div class='value white'><p data-counter='counterup' data-value='' class='info-box-number' id = 'info-box-number'><span  class='info-box-text' id = 'info-box-text'></span></p></div>" +
//  //    "<span class='progress-description'></span>" +
//  //    "<span class='tableID' style='display: none;'></span>" +
//  //    "<span class='sumType_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
//  //    "<span class='customFormula_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
//  //    "<span class='panelColumns_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
//  //    "<span class='columnOperatoins_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
//  //    "<span class='placeholderPanelId_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
//  //    "<span class='denominationText_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
//  //    "</div></div>";


// /////   This is the  update code  for new panel design.

//     var panelHtml = 
       
//         "<div class='overview-panel state-overview ' style='height: 91px;'>" +
//         "<div class='state-overview symbol' style='margin-top: -12px; color: black;'><i class='fa fa-users usr-clr'></i></div>" +
//         "<div class='state-overview value white' style='color: black;border-color: #78d1ff;margin-top: 15px;'><span  class='info-box-text' id = 'info-box-text'></span><span data-counter='counterup' data-value='7171911' class='info-box-number' id = 'info-box-number'>7171911</span>" +
//         "<span class='progress-description'></span>" +
//         "<span class='tableID' style='display: none;'></span>" +
//         "<span class='sumType_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
//         "<span class='customFormula_"+ tableId +'_'+placeholderPanelId+"' style='display: none;'></span>" +
//         "<span class='panelColumns_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
//         "<span class='columnOperatoins_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
//         "<span class='placeholderPanelId_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
//         "<span class='denominationText_"+ tableId+'_'+placeholderPanelId+"' style='display: none;'></span>" +
//         "</div></div></div>";
//     }


return panelHtml;




    //data-'+panelColumns+'='"+ panelColumns +"'
}