var base_url = window.location.origin;
var absPath = document.URL.split('public/')
// This function generate footer sum
function GenerateFooter(api , footerColumn ,  pannelIds , placeholderId , tableID , rowGroupArrNew)
 {

	var footerColumnArray = {};
    var footerColumnArray1 = {}; 
    var panelIdsExist = [];
  	var thousanSep = '';
    var customSumCal = {};
    var customFormula = 0;
    var columnTotal = 0;
    var resultSUm = 0;
    var footerSum = {};
    var colName = '';

    $.each(footerColumn, function( index, value ) {
        
        api.columns().eq(0).each( function (ind) {
            var title= api.column(ind).header();
            
            if(value.column_name == title.getAttribute("id"))
            {
                index = ind ; 
                return false;
            }
           
        });
        var intVal = function (index) {
            var retuenVal =  0;

            if(typeof index === 'string')
            {
                returnVal = parseFloat(index.replace(/[.\s]/g, '').replace(/[,]/g, '.') * 1) ;
                
            }else if(typeof index === 'number')
            {
                returnVal = index;
            }
                
                return returnVal;
            };
        thousanSep = value.thousand_sep;

        var columnTotal = api
            .column( index, { search: 'applied' } )
            .data()
            .reduce( function (a, b) {
                var resultValue = intVal(a) + intVal(b);
                return resultValue;
            }, 0 );


        columnTotal = columnTotal;
        var resultSUm = api
            .column( index, { search: 'applied' } )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
       
        if(value.decimal != undefined)
        {
            resultSUm = resultSUm.toFixed(value.decimal);
        }else{
            resultSUm = resultSUm.toFixed(0);
        }
       
        //panel and graph Ids
        var flag  = 0 ;
        var columnTotalTemp = 0; 
       
        $.each(pannelIds, function( key, panelGraphId ) {
            
            var check =  '';
            var columnName = $(".panelColumns_" + placeholderId+'_'+panelGraphId).text();
            var denominationText = $(".denominationText_" + placeholderId+'_'+panelGraphId).text();
            var customSumFormula = $(".customFormula_" + placeholderId+'_'+panelGraphId).text();
            var checkFlag  = $(".allowDecimal_" + placeholderId+'_'+panelGraphId).text();
            var testav = value['custom_sum'].trim();
           
            if(customSumFormula == value['custom_sum'] || (customSumFormula.indexOf(testav) >=0 && customSumFormula.includes("/") === -1) ){
                if(columnName.indexOf(',') != -1){
                    var check = columnName.split(',');
                }
               
                if(checkFlag == 1  && flag == 0)
                {
                
                    columnTotalTemp  = columnTotal.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1'+thousanSep);
                    flag = 1 ;
                }else if(flag == 0){
                    
                    columnTotalTemp = columnTotal.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1'+thousanSep);
                    flag = 1 ;
                }
                
                if(columnName != '' && columnName === value.column_name || check.indexOf(value.column_name) >=0 ) {
                    footerColumnArray[value.column_name] = resultSUm;
                    if(columnName.indexOf(',') == -1){
                       panelIdsExist.push(panelGraphId);
                    }
                    var panelResult = columnTotalTemp + ' '+denominationText;
                   
                    $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '.info-box-number' ).text(panelResult);
                    $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '#info-box-text' ).children("#info-box-number").text(panelResult);
                    $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '#info-box-text2' ).children("#info-box-number").text(panelResult);
                    
                }
            }
        });

        if(value.decimal != undefined)
        {
            columnTotal = columnTotal.toFixed(value.decimal).toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1'+thousanSep);
        
        }else{
            columnTotal = columnTotal.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1'+thousanSep);
      
        }
        
        footerColumnArray1[value.column_name] = resultSUm;
        
        if(value.denomination_text != '' && value.denomination_text != undefined)
        {
                columnTotal = columnTotal +'&nbsp;'+value.denomination_text;
        }
        if(value.footer_visible != '' && value.footer_visible == 1 && value.perform_custom_sum == 0) {
           
            $( api.column(index ).footer() ).addClass('footerWidth').html(columnTotal);
            //$( api.column( index ).footer() ).html(columnTotal);
        }

        if(value.perform_custom_sum == 1) {
           
            customSumCal[index] = index +'|'+value.custom_sum+'|'+ value.footer_visible+'|'+value.thousand_sep+'|'+value.decimal_point+'|'+value.decimal;
            if(value.denomination_text != '')
            {
                customSumCal[index] = customSumCal[index] +'|'+value.denomination_text;
            }
            
        }
    });
  
    $.each(customSumCal, function(customSumCalKey , customSumCalValue){
        
        if(customSumCal[customSumCalKey] != ''  && customSumCal[customSumCalKey] != undefined)
        {
            var fiedsSum = customSumCal[customSumCalKey].split('|');
            var percentageFlag = 0;
           
            if(fiedsSum[2] == '1')
            {
                formula = fiedsSum[1];
                percentageFlag = fiedsSum[1];
                
                if(Object.keys(footerColumnArray1).length != 0) 
                {
                    oldFormula = formula;
                    $.each(footerColumnArray1, function( index, value ) {
                       
                        formula = formula.replace("("+index+")", "("+value+")");
                    });
                  
                    if(oldFormula == formula)
                    {
                        formula = '0,00';
                    }else{
                        formula = eval(formula);
                    }
                   
                    if ( formula < 0  ){

                        formula = formula.toString().split('.').join('');
                        formula = formula.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'); 
                    } else if((formula != '' && formula != undefined)){
                         
                        var decimal = 2 ;
                        if(fiedsSum[5] != '' && fiedsSum[5] != 'undefined')
                        {
                            decimal = fiedsSum[5] ;
                        }
                       
                        if(percentageFlag.indexOf('100') == -1){
                            
                            if(!isNaN(formula))
                            {
                                if(fiedsSum[4] != '' && fiedsSum[4] != 'undefined'){

                                    //formula = formula.split('.').join('');
                                    formula = formula.toFixed(2).toString().split('.').join(',');          
                                    }
                                if( fiedsSum[3] != ' ' && fiedsSum[3] != 'undefined'){
                                    formula = formula.toString().split('.').join('');
                                    formula = formula.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1'+fiedsSum[3]);  
                                    //formula = formula.toFixed(3).toString().split('.').join(','); 
                                }
                                else{
                                    if(!isNaN(formula)){
                                        formula = formula.toFixed(2).toString().split('.').join(',');
                                    }
                                   
                                }  
                               
                            }else if(Number.isInteger(formula)==false && !isNaN(formula)) { 

                                // if(typeof formula === 'string' == false)
                                // {
                                //     formula = formula.toString();
                                // }
                                
                                if(fiedsSum[4] != '' && fiedsSum[4] != 'undefined'){

                                    //formula = formula.split('.').join('');
                                    formula = formula.toFixed(2).toString().split('.').join(',');          
                                    }
                                if( fiedsSum[3] != ' ' && fiedsSum[3] != 'undefined'){
                                    formula = formula.split('.').join('');
                                    formula = formula.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1'+fiedsSum[3]);  
                                    //formula = formula.toFixed(3).toString().split('.').join(','); 
                                }
                        }else if(isNaN(formula) || formula == undefined){
                                    formula = '0,00';
                        }
                        }else{
                               
                                if(isNaN(formula) || formula == undefined){
                                    formula = '0,00';
                                } else{
                                    formula = formula.toFixed(2).toString().split('.').join(',');
                               }        
                        }
                    }
                    
                    if(fiedsSum[6] != 'undefined')
                    {
                        formula = formula +" "+ fiedsSum[6];
                    }
                    if(formula != 'NaN %'){
                       
                        $( api.column( fiedsSum[0] ).footer() ).addClass('footerWidth').html(formula);
                        //$( api.column( fiedsSum[0] ).footer() ).html(formula);
                    }
                }
            }
        }    
    });
  
    var panelIdsCustom = $(pannelIds).not(panelIdsExist).get();
   
    var divideOfTwo = 1;
    
    $.each(panelIdsCustom, function( key, panelGraphId ) {
       // console.log(panelGraphId);
            var checkFlag  = $(".allowDecimal_" + placeholderId+'_'+panelGraphId).text();
            var columnName = $(".panelColumns_" + placeholderId+'_'+panelGraphId).text();
            var customFormula = $(".customFormula_" + placeholderId+'_'+panelGraphId).text();
            var sumType = $(".sumType_" + placeholderId+'_'+panelGraphId).text();
            var allowRowGroupCal = $(".allowRowGroupCal_" + placeholderId+'_'+panelGraphId).text();
            var rowGroupColumnName = $(".rowGroupColumnName_" + placeholderId+'_'+panelGraphId).text();
            var TimeTableSeparator = $(".TimeTableSeparator_" + placeholderId+'_'+panelGraphId).text();
            var ColumnDataType = $(".ColumnDataType_" + placeholderId+'_'+panelGraphId).text();
           
           
            if(sumType == 1){
                var info = api.page.info();
                var rowsshown = info.recordsDisplay;
               
                var denominationText = $(".denominationText_" + placeholderId+'_'+panelGraphId).text();
                rowsshown = rowsshown+' '+denominationText;
                if(ColumnDataType == '2') {
                    rowsshown = rowsshown.toString().split(' ').join('');
                }
                //console.log(columnName);
                $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '.info-box-number' ).text(rowsshown); 
                $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '#info-box-text' ).children("#info-box-number").text(rowsshown);
                $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '#info-box-text2' ).children("#info-box-number").text(rowsshown);
            
            }else if(sumType == 2){
                console.log(columnName);
                var myTable = $('#'+tableID).DataTable();
                var TableData = myTable.row().data();
                var SumIndex = '';
                $.each(TableData , function(key, value){
                    var title = myTable.column(key).header();
                    var tempTitle = $(title).text();
                   
                    tempTitle = tempTitle.trim();
                   
                    columnName = columnName.trim();
                    
                    if(columnName == tempTitle){
                       
                        SumIndex = key;
                        return false;
                       
                    }
                });
               
                
                var intVal = function (index) {
                    var retuenVal =  0;
        
                    if(typeof index === 'string')
                    {
                        if( TimeTableSeparator == '1'){
                                returnVal =  Number.parseFloat(index.replace(/[,]/g, '.')*1) ;
                        }
                        else {
                            returnVal =  Number.parseFloat(index.replace(/[.]/g, '').replace(/[,]/g, '.')*1) ;
                        }
                    }else if(typeof index === 'number')
                    {
                        returnVal = index;
                    }
                        
                        return returnVal;
                    };
                //console.log(SumIndex);
                var TableDataMain = myTable.column(SumIndex , { search: 'applied' } )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                
                if(TableDataMain)  {  
                    TableDataMain = TableDataMain.toFixed(0).split('.').join('');
                    TableDataMain = TableDataMain.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');
                }
                if(ColumnDataType == '2') {
                    TableDataMain = TableDataMain.toString().split(' ').join('');
                }
                $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '.info-box-number' ).text(TableDataMain); 
                $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '#info-box-text' ).children("#info-box-number").text(TableDataMain);
                $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '#info-box-text2' ).children("#info-box-number").text(TableDataMain);
            
                

            }
           
            if(allowRowGroupCal == '1'){
                var newCustomFormaula = customFormula.trim();
                var customFormula12 = customFormula.trim();
                var myTable = $('#'+tableID).DataTable();
                var TableData = myTable.row().data();
                
                var ColId1 = ''; 
                var ColId2 = ''; 
                $.each(TableData , function(key, value){
                    var title = myTable.column(key).header();
                    var tempTitle = $(title).text();
                    tempTitle = tempTitle.trim();
                    if(columnName == tempTitle){
                        ColId1 = key;
                    }else if(rowGroupColumnName == tempTitle){
                        ColId2 = key;
                    }
                });
               // console.log("jhbjhbhj");
                var lencount = 0;     
                $('#Table_1 tbody tr').each(function() {
                    
                    if($(this).attr("class") == 'dtrg-group dtrg-start dtrg-level-0' || $(this).attr("class") == 'collapsed dtrg-group dtrg-start dtrg-level-0'){
                        var Child = $(this).children("td");
                       
                        var goupHtml = Child[0]['innerText'];
                       
                        //console.log(goupHtml);
                        
                        if(customFormula.includes("==")){
                            
                            var val = goupHtml.split("(");
                            val1 = val[1];
                            val = val[0].trim();
                           
                          
                            if(customFormula.includes(val)){
                                
                                val = val1.split(")");
                               
                                customFormula12 = val[0];
                            }
                        }else{
                            var MainValue = Child[ColId1]['innerText'];
                      
                            var columnVal = goupHtml.split("-"); 
                        
                            var intValue = MainValue.replaceAll('.', '');
                            intValue = intValue.replaceAll(',', '');
                            // customFormula = customFormula.replace(columnVal[0], intValue);
                            customFormula = customFormula.split(columnVal[0]).join(intValue);
                            lencount = lencount+1;
                        }
                        
                    } 
                        
                });

                if(customFormula.includes('==')){

                    var denominationText = $(".denominationText_" + placeholderId+'_'+panelGraphId).text();
                    if(customFormula12 == customFormula){
                        customFormula12 = '0 '+denominationText;
                    }else{
                        customFormula12 = customFormula12+' '+denominationText;
                    }
                    
                    if(ColumnDataType == '2') {
                        customFormula12 = customFormula12.toString().split(' ').join('');
                    }
                    
                    $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '.info-box-number' ).text(customFormula12); 
                    $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '#info-box-text' ).children("#info-box-number").text(customFormula12);
                    $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '#info-box-text2' ).children("#info-box-number").text(customFormula12);
            
                }else{
                    var check1 = customFormula.split(")");
                    var check2 = newCustomFormaula.split(")");
                    
                    if(lencount != check2.length){
                        $.each(check2 , function(key, value){
                            if(value != ""){
                                if(check1.includes(value) && value != ''){
                                    value = value.replaceAll('+', '');
                                    value = value.replaceAll('-', '');
                                    value = value.replaceAll('/', '');
                                    value = value.replaceAll('*', '');
                                    value = value.split("(");
                                    
                                    $.each(value , function(valuekey, valuevalue){
                                        if(valuevalue != ""){
                                            if(valuevalue != '100'){
                                                customFormula = customFormula.replace(valuevalue, 0);
                                            }
                                            
                                        }
                                            
                                    });
                                }
                            }
                            
                        });
                    }else{
                        $.each(check2 , function(key, value){
                            if(value != ""){
                                if(check1.includes(value) && value != ''){
                                    value = value.replaceAll('+', '');
                                    value = value.replaceAll('-', '');
                                    value = value.replaceAll('/', '');
                                    value = value.replaceAll('*', '');
                                    value = value.split("(");
                                    
                                    $.each(value , function(valuekey, valuevalue){
                                        if(valuevalue != ""){
                                            if(valuevalue != '100'){
                                                customFormula = customFormula.replace(valuevalue, 0);
                                            }
                                            
                                        }
                                            
                                    });
                                }
                            }
                            
                        });
                    }
                        
    
                    console.log(customFormula);
                    customFormula = eval(customFormula);
                    console.log(customFormula);
                    if((customFormula != '' && customFormula != undefined ) || customFormula == 0){
                     
                           if(isNaN(customFormula))
                           {
                               customFormula = 0;
                           }
                           if(checkFlag)
                           {
                               customFormula = customFormula.toFixed(2).toString().split('.').join(',');
                           }else{
                               customFormula = customFormula.toFixed(0).split('.').join('');
                               customFormula = customFormula.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');
                           }
                          
                           var denominationText = $(".denominationText_" + placeholderId+'_'+panelGraphId).text();
                           customFormula = customFormula+' '+denominationText;
                           if(ColumnDataType == '2') {
                            customFormula = customFormula.toString().split(' ').join('');
                             }
                           $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '.info-box-number' ).text(customFormula); 
                           $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '#info-box-text' ).children("#info-box-number").text(customFormula);
                           $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '#info-box-text2' ).children("#info-box-number").text(customFormula);
                       
                    }

                }

               
               
            }else{
               
                if(Object.keys(footerColumnArray1).length !=  0 ){
                    var newCustomFormaula = customFormula;
                    $.each(footerColumnArray1, function( index, value ) {
                        customFormula = customFormula.replace('('+index+')', '('+value+')' );
                    });
                   
                    if(customFormula != newCustomFormaula){
                        customFormula = eval(customFormula);
                        if(customFormula != '' && customFormula != undefined ){
                            
                            if(isNaN(customFormula))
                            {
                                customFormula = 0;
                            }
                            if(checkFlag)
                            {
                                customFormula = customFormula.toFixed(2).toString().split('.').join(',');
                            }else{
                                customFormula = customFormula.toFixed(0).split('.').join('');
                                customFormula = customFormula.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');
                            }
                        
                            var denominationText = $(".denominationText_" + placeholderId+'_'+panelGraphId).text();
                            customFormula = customFormula+' '+denominationText;
                            // console.log("herer"+customFormula);
                            // console.log(ColumnDataType);
                            if(ColumnDataType == '2') {
                                customFormula = customFormula.toString().split(' ').join('');
                                
                            }

                            $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '.info-box-number' ).text(customFormula); 
                            $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '#info-box-text' ).children("#info-box-number").text(customFormula);
                            $(".panelColumns_" + placeholderId+'_'+panelGraphId).siblings( '#info-box-text2' ).children("#info-box-number").text(customFormula);
                        
                        }
                    }
                }
            }
    });
}