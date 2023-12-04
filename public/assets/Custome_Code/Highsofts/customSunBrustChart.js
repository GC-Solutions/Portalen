
var drawChart = false;
function ShowGraphData(url, Graph_ID , graphValue) {
    if(Graph_ID.includes("GraphHC_") == true){
        
        $.getJSON(url, function (jsonData, status) {

            if(jsonData.dataSourceCallCheck == 1)
            {
                //console.log(jsonData);
                var is_series_flag = graphValue.graph_labels.is_series;   
                const tableData = getTableData('', '', Graph_ID, is_series_flag, graphValue, jsonData.graph_data, jsonData.xAxis);
                //console.log(tableData);
                //createHighcharts(tableData, Graph_ID,graphValue);
                
                //createHighcharts(graphData = null, Graph_ID, jsonData);
               
            }
            // if (jsonData.graph_type == 1) {
            // } else if (jsonData.graph_type == 2) {
            //     //lineChart(jsonData, Graph_ID);
            // } else if (jsonData.graph_type == 3) {
            //     $(document).ready(function() {
            //             createHighcharts(graphData = null, Graph_ID, jsonData);
            //     });
            // } else if (jsonData.graph_type == 4) {
            //     //areaChart(jsonData, Graph_ID);
            // } else if (jsonData.graph_type == 5) {
            //     //comboChart(jsonData, Graph_ID);
            // }
        });
    } else{
        $("#" + Graph_ID).closest(".card-box").removeClass('hide');
        $.get(url, function (data, status) {
            var jsonData = JSON.parse(data);
            if (jsonData && (jsonData.graph_type != '' || jsonData.graph_type != null)) {
                if (jsonData.graph_type == 1) {
                    pieChart(jsonData, Graph_ID);
                } else if (jsonData.graph_type == 2) {
                    lineChart(jsonData, Graph_ID);
                } else if (jsonData.graph_type == 3) {
                    columnChart(jsonData, Graph_ID);
                } else if (jsonData.graph_type == 4) {
                    areaChart(jsonData, Graph_ID);
                } else if (jsonData.graph_type == 5) {
                    comboChart(jsonData, Graph_ID);
                }

                setTimeout(function () {
                    if ((jsonData.buttonText).trim() != '' && (jsonData.buttonColor).trim() != '' && (jsonData.buttonAction).trim() != '') {
                        $('#' + Graph_ID + ' .graph_action').append(getActionHtml(jsonData.buttonColor, jsonData.buttonAction, jsonData.buttonText));
                    }
                    if (jsonData.graph_title != '' || jsonData.graph_title != null) {
                        $('#' + Graph_ID + ' .graph_title').append(jsonData.graph_title);
                    }
                }, 100);
            }
        });
    }
}

// Code for HighCharts --------------------------------


function getActionHtml(actionColor, actionLink, actionText) {
    var actionButtonHtml = "<div class='btn-group' style='padding: 10px 0px;'><button onclick='window.location.href=\"" + actionLink + "\"' type='button' class='btn " + actionColor + "'>" +
        "" + actionText + "<i class='fa fa-plus'></i>" +
        "</button>" +
        "</div>";
    return actionButtonHtml;
}

function getTableData(table, columnAxisArray, graph_id, series_graph, graphValue, graphData , xAxisDS) {
    const dataArray = [],
        
        yAxis = {},
        xAxisDrill=[],
        xAxisDrill2=[],
        xAxisDrill3=[],
        xAxisDrill4=[],
        xAxisDrill5=[],
        yAxisSecondary = {},
        
        yAxisThird = {},
        yAxisFourth = {},yAxisFifth = {},yAxisSixth = {},
        dataTableArray=[];
        var totalAxis = {};
        var seriesXAxis = {};
        let seriesDataArray = [] , xAxis = [];

    //console.log(columnAxisArray);
    if((table)){
        table.rows({ search: "applied" }).every(function(array,index, i) {

            const data = this.data();
            const seriesAxisArray = [];
            dataTableArray.push(data);

            xAxis.push(data[columnAxisArray.X]);
            xAxisDrill.push(data[columnAxisArray.X1]);
            xAxisDrill2.push(data[columnAxisArray.X2]);
            xAxisDrill2.push(data[columnAxisArray.X3]);
            xAxisDrill2.push(data[columnAxisArray.X4]);
            xAxisDrill2.push(data[columnAxisArray.X5]);
            seriesAxisArray.push(data[columnAxisArray.X]);
            seriesAxisArray.push(parseInt(data[columnAxisArray.Y].replace(/[.\s]/g, '').replace(/[,]/g, '.')));
            seriesAxisArray.push(data[columnAxisArray.Y2]);
            seriesDataArray.push(seriesAxisArray)
            /*if(data[columnAxisArray.Y2] != '' && data[columnAxisArray.Y2] != undefined ){
                yAxisSeries.push(data[columnAxisArray.Y2]);
            }*/
        });
    }else{
       
        //seriesDataArray.push(graphData);
        seriesDataArray = graphData;
        xAxis = xAxisDS;
    }
    ////console.log(xAxis);
    //var yAxisSeriesValuesArray = getDataSeriesResult(seriesDataArray, 0, 2, 1);
    //Ch    
    
   
    var yAxisSeriesValuesArray = [];
    if(series_graph == true){
    //if (graph_id === "GraphHC_5") {
    //if (graph_id === "GraphHC_2" || graph_id === "GraphHC_5" || graph_id === "GraphHC_4" || graph_id === "GraphHC_3" || graph_id === "GraphHC_1") {
        //console.log('getDataSeriesResult1:', seriesDataArray);
        //execute this particular method just for HC type 2
        yAxisSeriesValuesArray = getDataSeriesResult(seriesDataArray, 0, 2, 1, graph_id);
      
    }
    else {
        //getHCDataSeriesResult
        //console.log('setTimeout1 =>',graph_id);
        yAxisSeriesValuesArray = getHCDataSeriesResult(seriesDataArray, 0, 2, 1);
    } 

    if(yAxisSeriesValuesArray)
    {
        seriesXAxis = yAxisSeriesValuesArray[(Object.keys(yAxisSeriesValuesArray).length)-1];
        delete yAxisSeriesValuesArray[(Object.keys(yAxisSeriesValuesArray).length)-1];
    }
  
    var countXaxis = {};
    var countYaxis = {};
    var countYaxisDrill = {};
    var countYaxisDrill2 = {};
    var countYaxisDrill3 = {};
    var countYaxisDrill4 = {};
    var countYaxisDrill5 = {};
    var countYaxisSecondary = {};
    var countY2axisDrill = {};
    var countY2axisDrill2 = {};
    var countY2axisDrill3 = {};
    var countY2axisDrill4 = {};
    var countY2axisDrill5 = {};
        
    var countYaxisThird = {};
    var countYaxisThirdCustomTemp = {};
    var countYaxisThirdCustom= {};
    var countYaxisFourth = {};
    var countYaxisFourthCustomTemp = {};
    var countYaxisFourthCustom= {};
    var countYaxisFifth = {};
    var countYaxisFifthCustomTemp = {};
    var countYaxisFifthCustom= {};
    var countYaxisSixth = {};
    var countYaxisSixthCustomTemp = {};
    var countYaxisSixthCustom= {};


    var countYaxisSeventh = {};
    var countYaxisSeventhCustomTemp = {};
    var countYaxisSeventhCustom= {};

    var countYaxisEight = {};
    var countYaxisEightCustomTemp = {};
    var countYaxisEightCustom= {};

    var countYaxisNinth = {};
    var countYaxisNinthCustomTemp = {};
    var countYaxisNinthCustom= {};


    var chartXaxis=[];
    var chartYaxis=[];
    var chartYaxisDrill=[];
    var chartYaxisDrill2=[];
    var chartYaxisDrill3=[];
    var chartYaxisDrill4=[];
    var chartYaxisDrill5=[];
    var chartY2axisDrill=[];
    var chartYaxisSecondary=[];
    var chartYaxisThird=[];
    var chartYaxisFourth=[];
    var chartYaxisFifth=[];
    var chartYaxisSixth=[];
    var chartYaxisSeventh=[];
    var chartYaxisEight=[];
    var chartYaxisNinth=[];

    xAxis.forEach(function(i) {
        countXaxis[i] = (countXaxis[i]||0)+1;
    });
    //console.log("here0");

    var uniqueItems = Array.from(new Set(xAxisDrill))
    var uniqueItems2  = Array.from(new Set(xAxisDrill2))
    var uniqueItems3  = Array.from(new Set(xAxisDrill3))
    var uniqueItems4  = Array.from(new Set(xAxisDrill4))
    var uniqueItems5  = Array.from(new Set(xAxisDrill5))
    /*yAxisSeries.forEach(function(i) {
        countYaxisSeries[i] = (countYaxisSeries[i]||0)+1;
    });*/
    var yAxisTotal = 0 ;
    var yAxisSecondaryTotal = 0 ;
    var yAxisThirdTotal = 0 ;
    var yAxisFourthTotal = 0 ;
    var yAxisFifthTotal = 0 ;
    var yAxisSixthTotal = 0 ;
    var yAxisSeventhTotal = 0 ;
    var yAxisEightTotal = 0 ; 
    var yAxisNinthTotal = 0 ; 

    $.each(countXaxis, function(keyXaxis, valueXaxis)
    {
        var yAxisSum = 0;
        var yAxisSumDr = {};
        var yAxisSumDr2 = {};
        var yAxisSumDr3 = {};
        var yAxisSumDr4 = {};
        var yAxisSumDr5 = {};
        var yAxisSecondarySum = 0;
        var yAxisSecondarySumDr = {};
        var yAxisSecondarySumDr2 = {};
        var yAxisSecondarySumDr3 = {};
        var yAxisSecondarySumDr4 = {};
        var yAxisSecondarySumDr5 = {};
        var yAxisThirdSum = 0;
        var yAxisFourthSum = 0;
        var yAxisFifthSum = 0;
        var yAxisSixthSum = 0;
        var yAxisSeventhSum = 0;
        var yAxisEightSum = 0;
        var yAxisNinthSum = 0;
        var keyValue4X2 = 0;
        var keyValue4X3 = 0;
        var keyValue4X4 = 0;
        var keyValue4X5 = 0;
        var resArr = {};
        var resArr6 = {};
                            
        $.each(dataTableArray, function(key, value)
        {
            if(value[columnAxisArray.X] == keyXaxis && keyXaxis !== undefined){

                var yAxisVal = '';
                var yAxisValDr = '';
                var yAxisValDr2 = '';
                var yAxisValDr3 = '';
                var yAxisValDr4 = '';
                var yAxisValDr5 = '';
                var yAxisSecondaryVal = '';
                var yAxisSecondaryValDr = '';
                var yAxisSecondaryValDr2 = '';
                var yAxisSecondaryValDr3 = '';
                var yAxisSecondaryValDr4 = '';
                var yAxisSecondaryValDr5 = '';
                var yAxisThirdVal = '';
                var yAxisFourthVal = '';
                var yAxisFifthVal = '';
                var yAxisSixthVal = '';
                var yAxisSeventhVal = '';
                var yAxisEightVal = '';
                var yAxisNinthVal = '';
                
                if(value[columnAxisArray.Y] != '' && value[columnAxisArray.Y] != undefined ){
                    yAxisVal = parseInt(value[columnAxisArray.Y].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                    yAxisSum += (yAxisVal || 0);
                    countYaxis[keyXaxis] =  yAxisSum;
                   
                    
                    if(uniqueItems != undefined){
                        $.each(uniqueItems , function(it, va){
                            if(value[columnAxisArray.X1] == va){

                                yAxisValDr = parseInt(value[columnAxisArray.Y].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                                if(yAxisSumDr[va] == undefined)
                                {
                                    yAxisSumDr[va] = yAxisValDr; 
                                }else{
                                    yAxisSumDr[va] = ((yAxisSumDr[va]+ yAxisValDr) || 0); 
                                }
                                keyValue4X2 = va;
                                countYaxisDrill[keyXaxis] = yAxisSumDr;
                                return false;
                            }
                            
                        });
                    }
                    if(uniqueItems2 != undefined){
                        $.each(uniqueItems2 , function(its, vas){
                            if(value[columnAxisArray.X2] == vas){

                                yAxisValDr2 = parseInt(value[columnAxisArray.Y].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                                if(yAxisSumDr2[vas] == undefined)
                                {
                                    yAxisSumDr2[vas] = yAxisValDr2; 
                                }else{
                                    yAxisSumDr2[vas] = ((yAxisSumDr2[vas]+ yAxisValDr2) || 0); 
                                }
                                countYaxisDrill2[keyValue4X2] = yAxisSumDr2;
                                return false;
                            }
                        });
                    }
                
                if(uniqueItems3 != undefined){
                        $.each(uniqueItems3 , function(itss, vass){
                            if(value[columnAxisArray.X3] == vass){

                                yAxisValDr3 = parseInt(value[columnAxisArray.Y].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                                if(yAxisSumDr3[vass] == undefined)
                                {
                                    yAxisSumDr3[vass] = yAxisValDr3; 
                                }else{
                                    yAxisSumDr3[vass] = ((yAxisSumDr3[vas]+ yAxisValDr3) || 0); 
                                }
                                countYaxisDrill3[keyValue4X3] = yAxisSumDr3;
                                return false;
                            }
                        });
                    }
                
                    if(uniqueItems4 != undefined){
                        $.each(uniqueItems4 , function(its, vas){
                            if(value[columnAxisArray.X4] == vas){

                                yAxisValDr4 = parseInt(value[columnAxisArray.Y].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                                if(yAxisSumDr4[vas] == undefined)
                                {
                                    yAxisSumDr4[vas] = yAxisValDr4; 
                                }else{
                                    yAxisSumDr4[vas] = ((yAxisSumDr4[vas]+ yAxisValDr4) || 0); 
                                }
                                countYaxisDrill4[keyValue4X4] = yAxisSumDr4;
                                return false;
                            }
                        });
                    }
                    if(uniqueItems5 != undefined){
                        $.each(uniqueItems5 , function(its, vas){
                            if(value[columnAxisArray.X5] == vas){

                                yAxisValDr5 = parseInt(value[columnAxisArray.Y].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                                if(yAxisSumDr5[vas] == undefined)
                                {
                                    yAxisSumDr5[vas] = yAxisValDr5; 
                                }else{
                                    yAxisSumDr5[vas] = ((yAxisSumDr5[vas]+ yAxisValDr5) || 0); 
                                }
                                countYaxisDrill5[keyValue4X5] = yAxisSumDr5;
                                return false;
                            }
                        });
                    }
                }
                
                if(value[columnAxisArray.Y2] != '' && value[columnAxisArray.Y2] != undefined ){
                    yAxisSecondaryVal = parseInt(value[columnAxisArray.Y2].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                    yAxisSecondarySum += (yAxisSecondaryVal || 0);
                    countYaxisSecondary[keyXaxis] =  yAxisSecondarySum;

                    $.each(uniqueItems , function(it, va){
                        if(value[columnAxisArray.X1] == va){

                            yAxisSecondaryValDr = parseInt(value[columnAxisArray.Y2].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                            if(yAxisSecondarySumDr[va] == undefined)
                            {
                                yAxisSecondarySumDr[va] = yAxisSecondaryValDr; 
                            }else{
                                yAxisSecondarySumDr[va] = ((yAxisSecondarySumDr[va]+ yAxisSecondaryValDr) || 0); 
                            }
                            countY2axisDrill[keyXaxis] = yAxisSecondarySumDr;
                            return false;
                        }
                        
                    });

                }
                if(value[columnAxisArray.Y3] != '' && value[columnAxisArray.Y3] !== undefined ){
                   
                    if(graphValue.graph_labels.custom_sumY3 != undefined)
                    {
                        var customSumString = graphValue.graph_labels.custom_sumY3;
                        var customSumStringTotal = graphValue.graph_labels.custom_sumY3;
                        re = /\(.*?\)/g;
                        var customSumY3= customSumString.match(re);
                        $.each(customSumY3 , function(k , v){
                            var columnIndex= v.replace(/[{()}]/g, '');

                            yAxisThirdVal = parseInt(value[columnIndex].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                            if(resArr[columnIndex] != undefined){
                                resArr[columnIndex] = (yAxisThirdVal||0) + resArr[columnIndex];
                            }
                            else{
                                resArr[columnIndex] = (yAxisThirdVal||0);
                              
                            }
                            if(countYaxisThirdCustom[columnIndex] != undefined){
                                countYaxisThirdCustom[columnIndex] = (yAxisThirdVal||0) + countYaxisThirdCustom[columnIndex];
                            }
                            else{
                                countYaxisThirdCustom[columnIndex] = (yAxisThirdVal||0);
                            
                            }
                            
                            customSumString =  customSumString.replace('(' + columnIndex + ')', resArr[columnIndex]);
                            customSumStringTotal =  customSumStringTotal.replace('(' + columnIndex + ')', countYaxisThirdCustom[columnIndex]);
                             
                        });
                        
                        customSumString = eval(customSumString);
                        if(customSumString != '' && customSumString != undefined ){
                            customSumString = parseFloat(customSumString.toFixed(2));
                                
                        } 
                        customSumStringTotal = eval(customSumStringTotal);
                        if(customSumStringTotal != '' && customSumStringTotal != undefined ){
                            customSumStringTotal = parseFloat(customSumStringTotal.toFixed(2));
                                
                        } 
                        countYaxisThird[keyXaxis] =  customSumString;
                        countYaxisThirdCustomTemp=  customSumStringTotal;
                       

                    }else{
                        yAxisThirdVal = parseInt(value[columnAxisArray.Y3].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                        yAxisThirdSum += (yAxisThirdVal || 0);
                        countYaxisThird[keyXaxis] =  yAxisThirdSum;

                    }
                }
                if(value[columnAxisArray.Y4] != '' && value[columnAxisArray.Y4] != undefined ){
                    
                    if(graphValue.graph_labels.custom_sumY4 != undefined)
                    {
                        var customSumString = graphValue.graph_labels.custom_sumY4;

                        var customSumStringTotal = graphValue.graph_labels.custom_sumY4;
                        re = /\(.*?\)/g;
                        var customSumY4= customSumString.match(re);

                        $.each(customSumY4 , function(k , v){
                            var columnIndex= v.replace(/[{()}]/g, '');

                            yAxisFourthVal = parseInt(value[columnIndex].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                            
                            if(resArr[columnIndex] != undefined){
                                resArr[columnIndex] = (yAxisFourthVal||0) + resArr[columnIndex];
                            }
                            else{
                                resArr[columnIndex] = (yAxisFourthVal||0);
                              
                            }
                           
                            if(countYaxisFourthCustom[columnIndex] != undefined){
                                countYaxisFourthCustom[columnIndex] = (yAxisFourthVal||0) + countYaxisFourthCustom[columnIndex];
                            }
                            else{
                                countYaxisFourthCustom[columnIndex] = (yAxisFourthVal||0);
                            
                            }
                           
                            customSumString =  customSumString.replace('(' + columnIndex + ')', resArr[columnIndex]);
                            customSumStringTotal =  customSumStringTotal.replace('(' + columnIndex + ')', countYaxisFourthCustom[columnIndex]);
                             
                        });
                       
                        customSumString = eval(customSumString);
                        if(isNaN(customSumString) )
                        {
                            customSumString = 0;
                        }
                       
                        if(customSumString != '' && customSumString != undefined ){
                            customSumString = parseFloat(customSumString.toFixed(2));
                                
                        }

                        customSumStringTotal = eval(customSumStringTotal);

                         if(isNaN(customSumStringTotal) )
                        {
                            customSumStringTotal = 0;
                        }
                        if(customSumStringTotal != '' && customSumStringTotal != undefined ){
                            customSumStringTotal = parseFloat(customSumStringTotal.toFixed(2));
                        } 
                        countYaxisFourth[keyXaxis] =  customSumString;
                        countYaxisFourthCustomTemp=  customSumStringTotal;
                       

                       
                    }else{
                        yAxisFourthVal = parseInt(value[columnAxisArray.Y4].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                        yAxisFourthSum += (yAxisFourthVal || 0);
                        countYaxisFourth[keyXaxis] =  yAxisFourthSum;
                    }
                }
                if(value[columnAxisArray.Y5] != '' && value[columnAxisArray.Y5] != undefined ){
                     if(graphValue.graph_labels.custom_sumY5 != undefined)
                    {
                        var customSumString = graphValue.graph_labels.custom_sumY5;
                        
                        var customSumStringTotal = graphValue.graph_labels.custom_sumY5;
                        re = /\(.*?\)/g;
                        var customSumY5= customSumString.match(re);

                        $.each(customSumY5 , function(k , v){
                            var columnIndex= v.replace(/[{()}]/g, '');

                            yAxisFifthVal = parseInt(value[columnIndex].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                            
                            if(resArr[columnIndex] != undefined){
                                resArr[columnIndex] = (yAxisFifthVal||0) + resArr[columnIndex];
                            }
                            else{
                                resArr[columnIndex] = (yAxisFifthVal||0);
                              
                            }
                           
                            if(countYaxisFifthCustom[columnIndex] != undefined){
                                countYaxisFifthCustom[columnIndex] = (yAxisFifthVal||0) + countYaxisFifthCustom[columnIndex];
                            }
                            else{
                                countYaxisFifthCustom[columnIndex] = (yAxisFifthVal||0);
                            
                            }
                           
                            customSumString =  customSumString.replace('(' + columnIndex + ')', resArr[columnIndex]);
                            customSumStringTotal =  customSumStringTotal.replace('(' + columnIndex + ')', countYaxisFifthCustom[columnIndex]);
                             
                        });
                       
                        customSumString = eval(customSumString);
                        if(isNaN(customSumString) )
                        {
                            customSumString = 0;
                        }
                       
                        if(customSumString != '' && customSumString != undefined ){
                            customSumString = parseFloat(customSumString.toFixed(2));
                                
                        }

                        customSumStringTotal = eval(customSumStringTotal);

                         if(isNaN(customSumStringTotal) )
                        {
                            customSumStringTotal = 0;
                        }
                        if(customSumStringTotal != '' && customSumStringTotal != undefined ){
                            customSumStringTotal = parseFloat(customSumStringTotal.toFixed(2));
                        } 
                        countYaxisFifth[keyXaxis] =  customSumString;
                        countYaxisFifthCustomTemp=  customSumStringTotal;
               
                    }else{
                        yAxisFifthVal = parseInt(value[columnAxisArray.Y5].replace(/[.\s]/g, '').replace(/[,]/g, '.')); 
                        yAxisFifthSum += (yAxisFifthVal || 0);
                        countYaxisFifth[keyXaxis] =  yAxisFifthSum;
                    }
                }
                if(value[columnAxisArray.Y6] != '' && value[columnAxisArray.Y6] != undefined ){
                    
                    if(graphValue.graph_labels.custom_sumY6 != undefined)
                    {
                        var customSumString = graphValue.graph_labels.custom_sumY6;
                       
                        var customSumStringTotal = graphValue.graph_labels.custom_sumY6;
                        re = /\(.*?\)/g;
                        var customSumY6= customSumString.match(re);

                        $.each(customSumY6 , function(k , v){
                            var columnIndex= v.replace(/[{()}]/g, '');

                            yAxisSixthVal = parseInt(value[columnIndex].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                            
                            if(resArr[columnIndex] != undefined){
                                resArr[columnIndex] = (yAxisSixthVal||0) + resArr[columnIndex];
                            }
                            else{
                                resArr[columnIndex] = (yAxisSixthVal||0);
                              
                            }
                           
                            if(countYaxisSixthCustom[columnIndex] != undefined){
                                countYaxisSixthCustom[columnIndex] = (yAxisSixthVal||0) + countYaxisSixthCustom[columnIndex];
                            }
                            else{
                                countYaxisSixthCustom[columnIndex] = (yAxisSixthVal||0);
                            
                            }
                           
                            customSumString =  customSumString.replace('(' + columnIndex + ')', resArr[columnIndex]);
                            customSumStringTotal =  customSumStringTotal.replace('(' + columnIndex + ')', countYaxisSixthCustom[columnIndex]);
                             
                        });
                       
                        customSumString = eval(customSumString);
                        if(isNaN(customSumString) )
                        {
                            customSumString = 0;
                        }
                       
                        if(customSumString != '' && customSumString != undefined ){
                            customSumString = parseFloat(customSumString.toFixed(2));
                                
                        }

                        customSumStringTotal = eval(customSumStringTotal);

                         if(isNaN(customSumStringTotal) )
                        {
                            customSumStringTotal = 0;
                        }
                        if(customSumStringTotal != '' && customSumStringTotal != undefined ){
                            customSumStringTotal = parseFloat(customSumStringTotal.toFixed(2));
                        } 
                        countYaxisSixth[keyXaxis] =  customSumString;
                        countYaxisSixthCustomTemp=  customSumStringTotal;
                       
                    }else{
                        yAxisSixthVal = parseInt(value[columnAxisArray.Y6].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                        yAxisSixthSum += (yAxisSixthVal || 0);
                        countYaxisSixth[keyXaxis] =  yAxisSixthSum;
                    }
                }
                
                if(value[columnAxisArray.Y7] != '' && value[columnAxisArray.Y7] != undefined ){
                    
                    if(graphValue.graph_labels.custom_sumY7 != undefined)
                    {
                        var customSumString = graphValue.graph_labels.custom_sumY7;
                       
                        var customSumStringTotal = graphValue.graph_labels.custom_sumY7;
                        re = /\(.*?\)/g;
                        var customSumY7= customSumString.match(re);

                        $.each(customSumY7 , function(k , v){
                            var columnIndex= v.replace(/[{()}]/g, '');

                            yAxisSeventhVal = parseInt(value[columnIndex].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                            
                            if(resArr[columnIndex] != undefined){
                                resArr[columnIndex] = (yAxisSeventhVal||0) + resArr[columnIndex];
                            }
                            else{
                                resArr[columnIndex] = (yAxisSeventhVal||0);
                              
                            }
                           
                            if(countYaxisSeventhCustom[columnIndex] != undefined){
                                countYaxisSeventhCustom[columnIndex] = (yAxisSeventhVal||0) + countYaxisSeventhCustom[columnIndex];
                            }
                            else{
                                countYaxisSventhCustom[columnIndex] = (yAxisSeventhVal||0);
                            
                            }
                           
                            customSumString =  customSumString.replace('(' + columnIndex + ')', resArr[columnIndex]);
                            customSumStringTotal =  customSumStringTotal.replace('(' + columnIndex + ')', countYaxisSeventhCustom[columnIndex]);
                             
                        });
                       
                        customSumString = eval(customSumString);
                        if(isNaN(customSumString) )
                        {
                            customSumString = 0;
                        }
                       
                        if(customSumString != '' && customSumString != undefined ){
                            customSumString = parseFloat(customSumString.toFixed(2));
                                
                        }

                        customSumStringTotal = eval(customSumStringTotal);

                         if(isNaN(customSumStringTotal) )
                        {
                            customSumStringTotal = 0;
                        }
                        if(customSumStringTotal != '' && customSumStringTotal != undefined ){
                            customSumStringTotal = parseFloat(customSumStringTotal.toFixed(2));
                        } 
                        countYaxisSeventh[keyXaxis] =  customSumString;
                        countYaxisSeventhCustomTemp=  customSumStringTotal;
                       
                    }else{
                        yAxisSeventhVal = parseInt(value[columnAxisArray.Y7].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                        yAxisSeventhSum += (yAxisSeventhVal || 0);
                        countYaxisSeventh[keyXaxis] =  yAxisSeventhSum;
                    }
                }

                if(value[columnAxisArray.Y8] != '' && value[columnAxisArray.Y8] != undefined ){
                    
                    if(graphValue.graph_labels.custom_sumY8 != undefined)
                    {
                        var customSumString = graphValue.graph_labels.custom_sumY8;
                       
                        var customSumStringTotal = graphValue.graph_labels.custom_sumY8;
                        re = /\(.*?\)/g;
                        var customSumY8= customSumString.match(re);

                        $.each(customSumY8 , function(k , v){
                            var columnIndex= v.replace(/[{()}]/g, '');

                            yAxisEigthVal = parseInt(value[columnIndex].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                            
                            if(resArr[columnIndex] != undefined){
                                resArr[columnIndex] = (yAxisEigthVal||0) + resArr[columnIndex];
                            }
                            else{
                                resArr[columnIndex] = (yAxisEigthVal||0);
                              
                            }
                           
                            if(countYaxisEigthCustom[columnIndex] != undefined){
                                countYaxisEigthCustom[columnIndex] = (yAxisEigthVal||0) + countYaxisEigthCustom[columnIndex];
                            }
                            else{
                                countYaxisEigthCustom[columnIndex] = (yAxisEigthVal||0);
                            
                            }
                           
                            customSumString =  customSumString.replace('(' + columnIndex + ')', resArr[columnIndex]);
                            customSumStringTotal =  customSumStringTotal.replace('(' + columnIndex + ')', countYaxisEigthCustom[columnIndex]);
                             
                        });
                       
                        customSumString = eval(customSumString);
                        if(isNaN(customSumString) )
                        {
                            customSumString = 0;
                        }
                       
                        if(customSumString != '' && customSumString != undefined ){
                            customSumString = parseFloat(customSumString.toFixed(2));
                                
                        }

                        customSumStringTotal = eval(customSumStringTotal);

                         if(isNaN(customSumStringTotal) )
                        {
                            customSumStringTotal = 0;
                        }
                        if(customSumStringTotal != '' && customSumStringTotal != undefined ){
                            customSumStringTotal = parseFloat(customSumStringTotal.toFixed(2));
                        } 
                        countYaxisEight[keyXaxis] =  customSumString;
                        countYaxisEightCustomTemp=  customSumStringTotal;
                       
                    }else{
                        yAxisEightVal = parseInt(value[columnAxisArray.Y8].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                        yAxisEightSum += (yAxisEightVal || 0);
                        countYaxisEight[keyXaxis] =  yAxisEightSum;
                    }
                }
                if(value[columnAxisArray.Y9] != '' && value[columnAxisArray.Y9] != undefined ){
                    
                    if(graphValue.graph_labels.custom_sumY9 != undefined)
                    {
                        var customSumString = graphValue.graph_labels.custom_sumY9;
                       
                        var customSumStringTotal = graphValue.graph_labels.custom_sumY9;
                        re = /\(.*?\)/g;
                        var customSumY9= customSumString.match(re);

                        $.each(customSumY9 , function(k , v){
                            var columnIndex= v.replace(/[{()}]/g, '');

                            yAxisNinthVal = parseInt(value[columnIndex].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                            
                            if(resArr[columnIndex] != undefined){
                                resArr[columnIndex] = (yAxisNinthVal||0) + resArr[columnIndex];
                            }
                            else{
                                resArr[columnIndex] = (yAxisNinthVal||0);
                              
                            }
                           
                            if(countYaxisNinthCustom[columnIndex] != undefined){
                                countYaxisNinthCustom[columnIndex] = (yAxisNinthVal||0) + countYaxisNinthCustom[columnIndex];
                            }
                            else{
                                countYaxisNinthCustom[columnIndex] = (yAxisNinthVal||0);
                            
                            }
                           
                            customSumString =  customSumString.replace('(' + columnIndex + ')', resArr[columnIndex]);
                            customSumStringTotal =  customSumStringTotal.replace('(' + columnIndex + ')', countYaxisNinthCustom[columnIndex]);
                             
                        });
                       
                        customSumString = eval(customSumString);
                        if(isNaN(customSumString) )
                        {
                            customSumString = 0;
                        }
                       
                        if(customSumString != '' && customSumString != undefined ){
                            customSumString = parseFloat(customSumString.toFixed(2));
                                
                        }

                        customSumStringTotal = eval(customSumStringTotal);

                         if(isNaN(customSumStringTotal) )
                        {
                            customSumStringTotal = 0;
                        }
                        if(customSumStringTotal != '' && customSumStringTotal != undefined ){
                            customSumStringTotal = parseFloat(customSumStringTotal.toFixed(2));
                        } 
                        countYaxisNinth[keyXaxis] =  customSumString;
                        countYaxisNinthCustomTemp=  customSumStringTotal;
                       
                    }else{
                        yAxisNinthVal = parseInt(value[columnAxisArray.Y9].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                        yAxisNinthSum += (yAxisNinthVal || 0);
                        countYaxisNinth[keyXaxis] =  yAxisNinthSum;
                    }
                }

        }
        });
        totalAxis[1] = yAxisTotal = yAxisTotal + countYaxis[keyXaxis];
        totalAxis[2] = yAxisSecondaryTotal = yAxisSecondaryTotal + countYaxisSecondary[keyXaxis] ;
        
        if(countYaxisThirdCustomTemp == undefined || JSON.stringify(countYaxisThirdCustomTemp) === '{}'){
            totalAxis[3] = yAxisThirdTotal = yAxisThirdTotal + countYaxisThird[keyXaxis];
        }else{
                totalAxis[3] =  countYaxisThirdCustomTemp;
        }
        //totalAxis[4] = yAxisFourthTotal = yAxisFourthTotal + countYaxisFourth[keyXaxis];
        //totalAxis[5] = yAxisFifthTotal = yAxisFifthTotal + countYaxisFifth[keyXaxis];
        //totalAxis[6] = yAxisSixthTotal = yAxisSixthTotal + countYaxisSixth[keyXaxis];   
        if(countYaxisFourthCustomTemp == undefined || JSON.stringify(countYaxisFourthCustomTemp) === '{}'){
            totalAxis[4] = yAxisFourthTotal = yAxisFourthTotal + countYaxisFourth[keyXaxis];
        }else{
                totalAxis[4] =  countYaxisFourthCustomTemp;
        }
        if(countYaxisFifthCustomTemp == undefined || JSON.stringify(countYaxisFifthCustomTemp) === '{}'){
            totalAxis[5] = yAxisFifthTotal = yAxisFifthTotal + countYaxisFifth[keyXaxis];
        }else{
                totalAxis[5] =  countYaxisFifthCustomTemp;
        }
        if(countYaxisSixthCustomTemp == undefined || JSON.stringify(countYaxisSixthCustomTemp) === '{}'){
            totalAxis[6] = yAxisSixthTotal = yAxisSixthTotal + countYaxisSixth[keyXaxis];
        }else{
                totalAxis[6] =  countYaxisSixthCustomTemp;
        }
        if(countYaxisSixthCustomTemp == undefined || JSON.stringify(countYaxisSixthCustomTemp) === '{}'){
            totalAxis[6] = yAxisSixthTotal = yAxisSixthTotal + countYaxisSixth[keyXaxis];
        }else{
                totalAxis[6] =  countYaxisSixthCustomTemp;
        }
        if(countYaxisSeventhCustomTemp == undefined || JSON.stringify(countYaxisSeventhCustomTemp) === '{}'){
            totalAxis[7] = yAxisSeventhTotal = yAxisSeventhTotal + countYaxisSeventh[keyXaxis];
        }else{
                totalAxis[7] =  countYaxisSeventhCustomTemp;
        }
         if(countYaxisEightCustomTemp == undefined || JSON.stringify(countYaxisEightCustomTemp) === '{}'){
            totalAxis[8] = yAxisEightTotal = yAxisEightTotal + countYaxisEight[keyXaxis];
        }else{
                totalAxis[8] =  countYaxisEightCustomTemp;
        }
        if(countYaxisNinthCustomTemp == undefined || JSON.stringify(countYaxisNinthCustomTemp) === '{}'){
            totalAxis[9] = yAxisNinthTotal = yAxisNinthTotal + countYaxisNinth[keyXaxis];
        }else{
                totalAxis[9] =  countYaxisNinthCustomTemp;
        }

    });
   
    //console.log(countYaxisDrill2); 
    //console.log(countYaxis);

    /*console.info('seriesSumOfXValuesArray=>',seriesSumOfXValuesArray);
    $.each(countYaxisSeries, function(keyYaxisSeries, valueYaxisSeries)
    {
        var yAxisSeriesSum = 0;
        $.each(dataTableArray, function(key, value)
        {
            var yAxisSeriesVal = '';
            if(value[columnAxisArray.Y2] == keyYaxisSeries){
                if(value[columnAxisArray.Y2] != '' && value[columnAxisArray.Y2] != undefined ){
                    yAxisSeriesVal = parseInt(value[columnAxisArray.Y].replace(/[.\s]/g, '').replace(/[,]/g, '.'));
                    yAxisSeriesSum += (yAxisSeriesVal || 0);
                    yAxisSeriesValuesArray[parseInt(keyYaxisSeries)] =  yAxisSeriesSum;
                }
            }

        });
    });*/

    //console.info('yAxisSeriesValuesArray' , yAxisSeriesValuesArray);
    // Object.keys(yAxis).forEach(function(i, key) {
    //     countYaxis[i] = yAxis[i]
    // });
    // Object.keys(yAxisSecondary).forEach(function(i, key) {
    //     countYaxisSecondary[i] = yAxisSecondary[i]
    // });
    // Object.keys(yAxisThird).forEach(function(i, key) {
    //     countYaxisThird[i] = yAxisThird[i]
    // });
    // Object.keys(yAxisFourth).forEach(function(i, key) {
    //     countYaxisFourth[i] = yAxisFourth[i]
    // });
    // Object.keys(yAxisFifth).forEach(function(i, key) {
    //     countYaxisFifth[i] = yAxisFifth[i]
    // });
    // Object.keys(yAxisSixth).forEach(function(i, key) {
    //     countYaxisSixth[i] = yAxisSixth[i]
    // });
    

  //   const ordered = {};
  //   Object.keys(countYaxis).sort().forEach(function(key) {
  //     ordered[key] = unordered[key];
  //   });
  //    Object.keys(countYaxis).forEach(function eachKey(key) { 
  //       //console.log(key); // alerts key 
  //       //console.log(countYaxis[key]); // alerts value
  // });
  
    // if(table.order()[0][1] == 'desc')
    //     {
    //     Object.keys(countYaxis).sort().reverse().forEach(function(key) {

    //         if(columnAxisArray.X1 == undefined ){
    //             chartYaxis.push(countYaxis[key])
    //             chartYaxisSecondary.push(countYaxisSecondary[key])
    //             chartYaxisThird.push(countYaxisThird[key])
    //             chartYaxisFourth.push(countYaxisFourth[key])
    //             chartYaxisFifth.push(countYaxisFifth[key])
    //             chartYaxisSixth.push(countYaxisSixth[key])
    //         }else{
    //             chartYaxis = countYaxis
    //             chartYaxisSecondary = countYaxisSecondary
    //             chartYaxisThird = countYaxisThird
    //             chartYaxisFourth = countYaxisFourth
    //             chartYaxisFifth = countYaxisFifth
    //             chartYaxisSixth = countYaxisSixth
    //             chartYaxisDrill = countYaxisDrill
    //             chartY2axisDrill = countY2axisDrill
    //         }
    //         chartXaxis.push(key)
    //     });
    // }
    // if(table.order()[0][1] == 'asc')
    //     {
        
    //     Object.keys(countYaxis).sort().forEach(function(key) {

    //         if(columnAxisArray.X1 == undefined ){
    //             chartYaxis.push(countYaxis[key])
    //             chartYaxisSecondary.push(countYaxisSecondary[key])
    //             chartYaxisThird.push(countYaxisThird[key])
    //             chartYaxisFourth.push(countYaxisFourth[key])
    //             chartYaxisFifth.push(countYaxisFifth[key])
    //             chartYaxisSixth.push(countYaxisSixth[key])
    //         }else{
    //             chartYaxis = countYaxis
    //             chartYaxisSecondary = countYaxisSecondary
    //             chartYaxisThird = countYaxisThird
    //             chartYaxisFourth = countYaxisFourth
    //             chartYaxisFifth = countYaxisFifth
    //             chartYaxisSixth = countYaxisSixth
    //             chartYaxisDrill = countYaxisDrill
    //             chartY2axisDrill = countY2axisDrill
    //         }
    //         chartXaxis.push(key)
    //     });
    // }
    
        Object.keys(countYaxis).forEach(function(key) {

            if(columnAxisArray.X1 == undefined ){
                chartYaxis.push(countYaxis[key])
                chartYaxisSecondary.push(countYaxisSecondary[key])
                chartYaxisThird.push(countYaxisThird[key])
                chartYaxisFourth.push(countYaxisFourth[key])
                chartYaxisFifth.push(countYaxisFifth[key])
                chartYaxisSixth.push(countYaxisSixth[key])
                chartYaxisSeventh.push(countYaxisSeventh[key])
                chartYaxisNinth.push(countYaxisNinth[key])
                chartYaxisEight.push(chartYaxisEight[key])
                
            }else{
                chartYaxis = countYaxis
                chartYaxisSecondary = countYaxisSecondary
                chartYaxisThird = countYaxisThird
                chartYaxisFourth = countYaxisFourth
                chartYaxisFifth = countYaxisFifth
                chartYaxisSixth = countYaxisSixth
                chartYaxisSeventh = countYaxisSeventh
                chartYaxisEight = countYaxisEight
                chartYaxisNinth = countYaxisNinth
                chartYaxisDrill = countYaxisDrill
                chartYaxisDrill2 = countYaxisDrill2
                chartYaxisDrill3 = countYaxisDrill3
                chartYaxisDrill4 = countYaxisDrill4
                chartYaxisDrill5 = countYaxisDrill5
                chartY2axisDrill = countY2axisDrill
            }
            chartXaxis.push(key)
        });

    if(seriesXAxis && seriesXAxis.includes(chartXaxis[0]))
    {
        chartXaxis = seriesXAxis;
    }
    
    if(chartXaxis.length == 0 || chartYaxis.length == 0) {
        return false;
    } 
    else {
        // if(series_graph == true){
        //     chartXaxis = chartXaxis.sort();
        // }
      
        // if(table.order()[0][1] == 'desc')
        // {
        //     chartXaxis.sort().reverse();
        //     chartYaxis.sort().reverse();
            
        // }
      
        dataArray.push(chartXaxis,chartYaxis,chartYaxisSecondary,chartYaxisThird,chartYaxisFourth, yAxisSeriesValuesArray, chartYaxisFifth, chartYaxisSixth,  totalAxis, chartYaxisDrill,chartY2axisDrill, uniqueItems,  chartYaxisSeventh, chartYaxisEight, chartYaxisNinth , chartYaxisDrill2, chartYaxisDrill3 , chartYaxisDrill4 , chartYaxisDrill5, uniqueItems2 );
        return dataArray;
    }
}

//function getDataSeriesResult(dataArray, rowIndex, colIndex, dataIndex) {
    //CH
    
function getDataSeriesResult(dataArray, rowIndex, colIndex, dataIndex, graph_id) {
    var newObj = {};
    if (dataArray.length !== 0) {
        //console.info('getDataSeriesResult: ', dataArray, 'graph_id', graph_id);
        var result = {}, ret = [];
        var newCols = [];
        var seriesSum = 0;
        for (var i = 0; i < dataArray.length; i++) {
            var serviesVal = '';
            if (!result[dataArray[i][rowIndex]]) {
                result[dataArray[i][rowIndex]] = {};
            }

            serviesVal = parseFloat(dataArray[i][dataIndex]);
            seriesSum += (serviesVal || 0); //I removed +
            result[dataArray[i][rowIndex]][dataArray[i][colIndex]] = seriesSum;

            //To get column names
            if (newCols.indexOf(dataArray[i][colIndex]) == -1) {
                newCols.push(dataArray[i][colIndex]);
            }
        }

        newCols.sort();
        var item = [];
        var item1 = [];
        item.push.apply(item, newCols);
        ret.push(item);

        for (var key in result) {
            item = [];
            for (var i = 0; i < newCols.length; i++) {
                item.push(result[key][newCols[i]] || 0);
            }
            ret.push(item);
        }

        $.each(ret, function (key, value) {
            $.each(ret[key], function (newKey, newValue) {
                var keyName = newKey;
                if (!newObj[keyName]) {
                    newObj[keyName] = [];
                }
                newObj[newKey].push(ret[key][newKey]);
            });
        });
        
      
        const uniqueFirst = [...new Set(dataArray.map(item => item[0]))];
        const uniqueLast = [...new Set(dataArray.map(item => item[2]))];
  
        //return newObj;
        var objs = [];
        var completeData = [];
        
        (uniqueLast).forEach(function (category) {var tempSum = 0;
            var tempSum = 0;
            objs = [];
            const str = category;
            //objs.push(str);
            (uniqueFirst).forEach(function (year) {
                var result = dataArray.filter(a => (a[0] == year && a[2] == category)); 
                var vals = result.map(a => a[1]);
                var sum = vals.reduce(function(a, b) { return a + b; }, 0);
                objs.push(sum);
                tempSum = tempSum + sum;
                if (category === '01') {            
                    //console.info('getDataSeriesResult (', category, 'year: ', year, ') result: ', result.length, 'vals', objs, 'sum', sum);
                }
            });
            objs.unshift(str);
            objs.push(tempSum);
            completeData.push(objs);
        });
        var newXAxisArray = []; 

        //for(var j = 1; j < completeData[0].length - 1; j++){
        for (var i = 0; i < dataArray.length; i++) {
            
            if(newXAxisArray.includes(dataArray[i][0]) !== true){
                newXAxisArray.push(dataArray[i][0]); 
            }              
        }
           
        //}
        
        completeData.push(newXAxisArray);

        var temp = Object.assign({}, completeData);
        
        //newObj =  completeData;
        //console.info('getDataSeriesResult: (returned current obj)', newObj, ' our calc: ', completeData, 'abc: ', temp);
        return temp;

        /*
        console.info('getDataSeriesResult', '', 'last obj: ', dataArray[0][0]);
        if (dataArray[0][0] === '2008') {
            var result = dataArray.filter(a => (a[0] == '2008' && a[2] == '01'));       
            console.info('getDataSeriesResult -> test', result);
            console.info('getDataSeriesResult', uniqueFirst, 'last: ', uniqueLast);
        } */
        
    }
    else {
       // console.info('Empty','');
    }
    return newObj;
}

function getHCDataSeriesResult(dataArray, rowIndex, colIndex, dataIndex) {
    //console.info('getDataSeriesResultHC: ', '');
    //console.info('retret=>',dataArray, rowIndex, colIndex, dataIndex);
    var result = {}, ret = [];
    var newCols = [];
    var seriesSum = 0;
    for (var i = 0; i < dataArray.length; i++) {
        var serviesVal = '';
        if (!result[dataArray[i][rowIndex]]) {
            result[dataArray[i][rowIndex]] = {};
        }

        serviesVal = parseFloat(dataArray[i][dataIndex]);
        seriesSum += (serviesVal || 0);
        //console.info('seriesSum',seriesSum)
        //result[dataArray[i][rowIndex]][dataArray[i][colIndex]] = parseFloat(dataArray[i][dataIndex]);
        result[dataArray[i][rowIndex]][dataArray[i][colIndex]] = seriesSum;

        //To get column names
        if (newCols.indexOf(dataArray[i][colIndex]) == -1) {
            newCols.push(dataArray[i][colIndex]);
        }
        //console.info('opop',dataArray[i][dataIndex])
    }
    //console.info('result=>',result)
    newCols.sort();
    var item = [];
    var item1 = [];
    //Add Header Row
    //item.push('  ');

    item.push.apply(item, newCols);

    ret.push(item);
    //console.info('item',item)
    //Add content
    for (var key in result) {
        item = [];
        //item.push(key);
        for (var i = 0; i < newCols.length; i++) {
            item.push(result[key][newCols[i]] || 0);
        }
        ret.push(item);
    }
    ////console.log('ret=>',ret);
    var newObj = {};
    $.each(ret, function (key, value) {
        ////console.log(ret[key]);
        ////console.log('---break---');
        $.each(ret[key], function (newKey, newValue) {

            var keyName = newKey;
            if (!newObj[keyName]) {
                newObj[keyName] = [];
            }
            newObj[newKey].push(ret[key][newKey]);
        });

    });

    ////console.log('newObj=>',newObj);

    return newObj;
    var newArray =[];

    for(var i=0; i < ret.length; i++){
        //console.info(ret[i].length)
        //item1 = [];
        for(var j=0; j < ret[i].length; j++){
            //console.info('ret[i][j]',ret[i][j])
            //item1.push(ret[i][0]);
            //item1.push(ret[i][j]);
            item1[i][i] = ret[i][j];
            //item1.push(ret[i][ret[i][j]] || 0);
            //newArray.push(ret[i][ret[i][j]]);
            //item1.push(ret[i] +':'+ret[i][j]);con
            //console.info('baballlllllllllllll', ret[i][j]);
            //return false;
            //newArray.splice(i, 0, ret[i][j]);
            //newArray[i].push(ret[i][j]);
            //newArray.push(ret[i][j]);
        }
        console.info('inner',item1)
        //console.info('item1=>', item1)
        //return false
        //newArray.push(item1);
    }
    //console.info('newArray=>', newArray)
    //console.info('item1=>', item1)
    //console.info('ret=>', ret)

}
function createHighcharts(graphData, graphId, graphLabel,dataTable, columnAxisArray) {

    
    var graphSeriesCount = graphLabel.graph_labels;
    var first = true;
    var columnSeriesOne = graphLabel.graph_labels.typeY ? graphLabel.graph_labels.typeY : "column";
    var columnSeriesTwo = graphLabel.graph_labels.typeY2 ? graphLabel.graph_labels.typeY2 : "column";
    var columnSeriesThree = graphLabel.graph_labels.typeY3 ? graphLabel.graph_labels.typeY3 : "column";
    var columnSeriesFourth = graphLabel.graph_labels.typeY4 ? graphLabel.graph_labels.typeY4 : "column";
    var columnSeriesFifth = graphLabel.graph_labels.typeY5 ? graphLabel.graph_labels.typeY5 : "column";
    var columnSeriesSixth = graphLabel.graph_labels.typeY6 ? graphLabel.graph_labels.typeY6 : "column";
    var columnSeriesSeventh = graphLabel.graph_labels.typeY7 ? graphLabel.graph_labels.typeY7 : "column";
    var columnSeriesEigth = graphLabel.graph_labels.typeY8 ? graphLabel.graph_labels.typeY8 : "column";
    var columnSeriesNinth = graphLabel.graph_labels.typeY9 ? graphLabel.graph_labels.typeY9 : "column";
    
    var xAxisData = [];
    var x1AxisData = [];
    var yAxisData = [];
    var y2AxisData = [];
    var y3AxisData = [];
    var y4AxisData = [];
    var y5AxisData = [];
    var y6AxisData = [];
    var y7AxisData = [];
    var y8AxisData = [];
    var y9AxisData = [];

    var yDrillDown = [];
    var yDrillDown2 = [];
    var y2DrillDown = [];
    var deactivate3D = 0;
    
    var y3Flag = 0;
    var y4Flag = 0;
    var y5Flag = 0;
    var y6Flag = 0;
    var y7Flag = 0;
    var y8Flag = 0;
    var y9Flag = 0;

    var isSecondaryYaxis = false;
    var isSecondaryY2axis = false;
    var isSecondaryY3axis = false;
    var isSecondaryY4axis = false;
    var isSecondaryY5axis = false;
    var isSecondaryY6axis = false;
    var isSecondaryY7axis = false;
    var isSecondaryY8axis = false;
    var isSecondaryY9axis = false;


    var yAxisOpposit = 0;
    var y3AxisOpposit = 0;
    var y4AxisOpposit = 0;
    var y5AxisOpposit = 0;
    var y6AxisOpposit = 0;
    var y7AxisOpposit = 0;
    var y8AxisOpposit = 0;
    var y9AxisOpposit = 0;

    var yAxismax = null;
    var yAxismin = null;
    var y2Axismax = null;
    var y2Axismin = null;
    var y3Axismax = null;
    var y3Axismin = null;
    var y4Axismax = null;
    var y4Axismin = null;
    var y5Axismax = null;
    var y5Axismin = null;
    var y6Axismax = null;
    var y6Axismin = null;
    var y7Axismax = null;
    var y7Axismin = null;
    var y8Axismax = null;
    var y8Axismin = null;
    var y9Axismax = null;
    var y9Axismin = null;

   
    var y2AxisTitle = '';
    var y3AxisTitle = '';
    var y4AxisTitle = '';
    var y5AxisTitle = '';
    var y6AxisTitle = '';
    var y7AxisTitle = '';
    var y8AxisTitle = '';
    var y9AxisTitle = '';
    
    
    if(graphLabel.graph_type == 2) {
        columnSeriesOne = "spline";
        columnSeriesTwo = "spline";
        columnSeriesThree = "spline";
        columnSeriesFourth = "spline";
        columnSeriesFifth = "spline";
        columnSeriesSixth = "spline";
        columnSeriesSeventh = "spline";
        columnSeriesEight = "spline";
        columnSeriesNinth = "spline";
    }

    if(graphLabel.graph_type == 6) {
        columnSeriesOne = "column";
        columnSeriesTwo = "spline";
        //console.info('ooo',columnSeriesOne,'PPPP',columnSeriesTwo);
    }
    if(graphLabel.graph_type == 3) {
        columnSeriesOne = "column";
        columnSeriesTwo = "column";
        //console.info('ooo',columnSeriesOne,'PPPP',columnSeriesTwo);
    }
    if(graphLabel.graph_type == 7) {
        columnSeriesOne = "column";
        columnSeriesTwo = "column";
        columnSeriesThree = "spline";
    }
    
    if(graphLabel.graph_labels.is_secondary_Y2 == true){
        isSecondaryY2axis = true;
        yAxisOpposit = 1;
    }
    if(graphLabel.graph_labels.is_secondary_Y3 == true){
        isSecondaryY3axis = true;
        y3AxisOpposit = 2 ;
     }
    if(graphLabel.graph_labels.hide_secondary_name_Y3 != undefined){
            y3AxisTitle = '';
   
        }else{
             y3AxisTitle = graphLabel.graph_labels.Y3 ;
        }
    if(graphLabel.graph_labels.secondary_axis_Y4 != undefined){
        isSecondaryY4axis = graphLabel.graph_labels.is_secondary_Y4;
       
        if(graphLabel.graph_labels.secondary_axis_Y4 != undefined)
        {
            y4AxisOpposit = parseInt(graphLabel.graph_labels.secondary_axis_Y4);
        }}
    if(graphLabel.graph_labels.hide_secondary_name_Y4 != undefined){
            y4AxisTitle = '';
   
    }else{
             y4AxisTitle = graphLabel.graph_labels.Y4 ;
    }
    if(graphLabel.graph_labels.secondary_axis_Y5 != undefined){
        isSecondaryY5axis = graphLabel.graph_labels.is_secondary_Y5;
        if(graphLabel.graph_labels.secondary_axis_Y5 != undefined)
        {
            y5AxisOpposit = parseInt(graphLabel.graph_labels.secondary_axis_Y5);
        }
    }
    if(graphLabel.graph_labels.hide_secondary_name_Y5 != undefined){
            y5AxisTitle = '';
   
    }else{
             y5AxisTitle = graphLabel.graph_labels.Y5 ;
    }
    
    if(graphLabel.graph_labels.secondary_axis_Y6 != undefined){
        isSecondaryY6axis = graphLabel.graph_labels.is_secondary_Y6;
        if(graphLabel.graph_labels.secondary_axis_Y6 != undefined)
        {
            y6AxisOpposit = parseInt(graphLabel.graph_labels.secondary_axis_Y6);
        }
    }
    if(graphLabel.graph_labels.hide_secondary_name_Y6 != undefined){
            y6AxisTitle = '';
   
    }else{
             y6AxisTitle = graphLabel.graph_labels.Y6 ;
    }

    if(graphLabel.graph_labels.secondary_axis_Y7 != undefined){
        isSecondaryY7axis = graphLabel.graph_labels.is_secondary_Y7;
        if(graphLabel.graph_labels.secondary_axis_Y7 != undefined)
        {
            y7AxisOpposit = parseInt(graphLabel.graph_labels.secondary_axis_Y7);
        }
    }
    if(graphLabel.graph_labels.hide_secondary_name_Y7 != undefined){
            y7AxisTitle = '';
   
    }else{
             y7AxisTitle = graphLabel.graph_labels.Y7 ;
    }

    if(graphLabel.graph_labels.secondary_axis_Y8 != undefined){
        isSecondaryY8axis = graphLabel.graph_labels.is_secondary_Y8;
        if(graphLabel.graph_labels.secondary_axis_Y8 != undefined)
        {
            y8AxisOpposit = parseInt(graphLabel.graph_labels.secondary_axis_Y8);
        }
    }
    if(graphLabel.graph_labels.hide_secondary_name_Y8 != undefined){
            y8AxisTitle = '';
   
    }else{
             y8AxisTitle = graphLabel.graph_labels.Y8 ;
    }
    if(graphLabel.graph_labels.secondary_axis_Y9 != undefined){
        isSecondaryY9axis = graphLabel.graph_labels.is_secondary_Y9;
        if(graphLabel.graph_labels.secondary_axis_Y9 != undefined)
        {
            y9AxisOpposit = parseInt(graphLabel.graph_labels.secondary_axis_Y9);
        }
    }
    if(graphLabel.graph_labels.hide_secondary_name_Y9 != undefined){
            y9AxisTitle = '';
   
    }else{
             y9AxisTitle = graphLabel.graph_labels.Y9 ;
    }

    if(graphLabel.graph_labels.maxY  != undefined){
        yAxismax = graphLabel.graph_labels.maxY;
    } 
    if(graphLabel.graph_labels.minY != undefined){
        yAxismin = graphLabel.graph_labels.minY;
    }
    if(graphLabel.graph_labels.maxY2  != undefined){
        y2Axismax = graphLabel.graph_labels.maxY2;
    } 
    if(graphLabel.graph_labels.minY2 != undefined){
        y2Axismin = graphLabel.graph_labels.minY2;
    }
    if(graphLabel.graph_labels.maxY3  != undefined){
        y3Axismax = graphLabel.graph_labels.maxY3;
    } 
    if(graphLabel.graph_labels.minY3 != undefined){
        y3Axismin = graphLabel.graph_labels.minY3;
    }
    if(graphLabel.graph_labels.maxY4  != undefined){
        y4Axismax = graphLabel.graph_labels.maxY4;
    } 
    if(graphLabel.graph_labels.minY4 != undefined){
        y4Axismin = graphLabel.graph_labels.minY4;
    }
    if(graphLabel.graph_labels.maxY5  != undefined){
        y5Axismax = graphLabel.graph_labels.maxY5;
    } 
    if(graphLabel.graph_labels.minY5 != undefined){
        y5Axismin = graphLabel.graph_labels.minY5;
    }
    if(graphLabel.graph_labels.maxY6  != undefined){
        y6Axismax = graphLabel.graph_labels.maxY6;
    } 
    if(graphLabel.graph_labels.minY6 != undefined){
        y6Axismin = graphLabel.graph_labels.minY6;
    }
    if(graphLabel.graph_labels.maxY7  != undefined){
        y7Axismax = graphLabel.graph_labels.maxY7;
    } 
    if(graphLabel.graph_labels.minY7 != undefined){
        y7Axismin = graphLabel.graph_labels.minY7;
    }
   
    if(graphLabel.Deactivate3d == '1')
    {
        deactivate3D = 0;
    }else{
        deactivate3D = 1;
    }

    if (graphData != false && graphData != null) {
        xAxisData = graphData[0];
        yAxisDataCount = 0; 
        yAxisData = graphData[1];
        y2AxisDataCount=0;
        y2AxisData = graphData[2];
        y3AxisDataCount = 0;
        y3AxisData = graphData[3];
        y4AxisDataCount = 0;
        y4AxisData = graphData[4];
        y5AxisDataCount = 0;
        y5AxisData = graphData[6];
        y6AxisDataCount = 0;
        y6AxisData = graphData[7];
        y7AxisDataCount = 0;
        y7AxisData = graphData[12];
        y8AxisDataCount = 0;
        y8AxisData = graphData[13];
        y9AxisDataCount = 0;
        y9AxisData = graphData[14];
        
        yDrillDown = graphData[9];
        yDrillDown2 = graphData[15];
        yDrillDown3 = graphData[16];
        yDrillDown4 = graphData[17];
        yDrillDown5 = graphData[18];

        y2DrillDown = graphData[10];
        var totalGraph = graphData[8];
        var testvar = {};
       
        var data123 = [];
        var num = 0;
        var num1 = 0;

        for (var i = 0 ; i <= xAxisData.length ; i++) {
            var objectcc = {};
            
            var parentId = '';
            if(i == 0)
            {
                objectcc = { id: '0.0',
                        parent: '',
                        name: 'Year'}
                data123.push(objectcc);  
            }else{
                parentId = '1.'+ i;
                objectcc = { id: parentId,
                        parent: '0.0',
                        name:  xAxisData[i-1]}
            
            
                data123.push(objectcc);   
                var secondStep = xAxisData[i-1];
                secondStep = yDrillDown[secondStep];
                
                for( var j in secondStep){
                    var objectcc = {};

                    num = num + 1;
                    var parentId2 = '2.'+ num;
                    objectcc = { 
                            id: parentId2,
                            parent: parentId,
                            name: j, 
                            value: secondStep[j]
                        }
                
                    data123.push(objectcc); 

                    var thirdStep = yDrillDown2[j];
                    for( var k in thirdStep){
                        var objectcc = {};
                        num1 = num1 + 1;
                        var parentId3 = '3.'+ num1;
                        objectcc = { 
                                id: parentId3 ,
                                parent: parentId2,
                                name: k, 
                                value: thirdStep[k]
                            }
                        data123.push(objectcc);
                    }
                    



                    if(yDrillDown3 != undefined){
                        var fourthStep = yDrillDown3[k];
                        for( var l in fourthStep){
                            var objectcc = {};
                            num2 = num2 + 1;
                            var parentId4 = '4.'+ num2;
                            objectcc = { 
                                    id: parentId4,
                                    parent: parentId3,
                                    name: l, 
                                    value: fourthStep[l]
                                }
                            data123.push(objectcc);
                        }
                        
                        var fifthStep = yDrillDown4[l];
                        for( var m in fifthStep){
                            var objectcc = {};
                            num4 = num4 + 1;
                            var parentId5 = '5.'+ num4;
                            objectcc = { 
                                    id: parentId5,
                                    parent: parentId4,
                                    name: m, 
                                    value: fifthStep[m]
                                }
                            data123.push(objectcc);
                        }
                        
                        var sixthStep = yDrillDown2[m];
                        for( var n in sixthStep){
                            var objectcc = {};
                            num5 = num5 + 1;
                            var parentId6 = '6.'+ num5;
                            objectcc = { 
                                    id: parentId6,
                                    parent: parentId5,
                                    name: n, 
                                    value: sixthStep[n]
                                }
                            data123.push(objectcc);
                        }
                    }




                }
            }   
        }
        
        var lab = graphLabel.graph_labels.Y;
        if(yAxisData.length != 0){
                yAxisDataCount = totalGraph[1].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');                    
        }
        testvar[lab] = yAxisDataCount;

        var lab = graphLabel.graph_labels.Y2;
        if(y2AxisData.length != 0){
                y2AxisDataCount = totalGraph[2].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');                    
        }
        testvar[lab] = y2AxisDataCount;

        var lab = graphLabel.graph_labels.Y3;
        if(y3AxisData.length != 0){
                y3AxisDataCount = totalGraph[3].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');                    
        }
        testvar[lab] = y3AxisDataCount;

    
        var lab = graphLabel.graph_labels.Y4;
        if(y4AxisData.length != 0){
                y4AxisDataCount = totalGraph[4].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');                    
        }
        testvar[lab] = y4AxisDataCount;

        var lab = graphLabel.graph_labels.Y5;
         if(y5AxisData.length != 0){
                y5AxisDataCount = totalGraph[5].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');                    
        }
        testvar[lab] = y5AxisDataCount;

        var lab = graphLabel.graph_labels.Y6;
         if(y6AxisData.length != 0){
                y6AxisDataCount = totalGraph[6].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');                    
        }
        testvar[lab] = y6AxisDataCount;

        var lab = graphLabel.graph_labels.Y7;
        if(y7AxisData.length != 0){
                y7AxisDataCount = totalGraph[7].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');                    
        }
        testvar[lab] = y7AxisDataCount;

        var lab = graphLabel.graph_labels.Y8;
        if(y8AxisData.length != 0){
                y8AxisDataCount = totalGraph[8].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');                    
        }
        testvar[lab] = y8AxisDataCount;

        var lab = graphLabel.graph_labels.Y9;
        if(y9AxisData.length != 0){
                y9AxisDataCount = totalGraph[9].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');                    
        }
        testvar[lab] = y9AxisDataCount;


        var series = [];
        var seriesDrill = [];
        var seriesCnt = 0;
        
        if(graphLabel.graph_labels.is_series == true) {
            if (graphData[5] != false && graphData[5] != null) {
                /*series.push({
                     name: graphLabel.graph_labels.Y,
                     type: columnSeriesOne,
                     data: yAxisData
                    }
                 );*/
                
                var seriesColumnName = graphData[5][0];
                
                $.each(graphData[5], function(key, value)
                {
                    var seriesCnt = 0;
                    if (graphData != false && graphData != null) {
                        var columnName = value[0];
    
                        var removeName = value;
                        removeName.shift();
                        var totalVal = removeName.pop();
                        var tempName = columnName == null ? '' : columnName.trim();
                        testvar[tempName] = totalVal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                        series.push({
                            name: columnName,
                            type: columnSeriesTwo,
                            data: removeName
                        });
                    }

                 });
                
            }
        } else if (graphLabel.graph_labels.is_series == false || graphLabel.graph_labels.is_series == undefined) {
         
            if(graphLabel.graph_type == 8)
            {
                
                var dataY = [];
                var dataY2 = [];
                var testArrForX1 = [];
                $.each(xAxisData , function(key , value){
                    dataY.push({
                            name: graphLabel.graph_labels.Y,
                            type: columnSeriesOne,
                            y: yAxisData[value],
                            drilldown :graphLabel.graph_labels.Y+'|'+value
                        });
                    dataY2.push({
                            name: graphLabel.graph_labels.Y2,
                            type: columnSeriesTwo,
                            y: y2AxisData[value],
                            drilldown : graphLabel.graph_labels.Y2+'|'+value
                        } );

                    var lab = graphLabel.graph_labels.Y2+'|'+value;
                    testvar[lab] = y2AxisData[value].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');;

                    var lab = graphLabel.graph_labels.Y+'|'+value;
                    testvar[lab] = yAxisData[value].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');;

                    var newArrY = [];
                    var newArrY2 = [];
                    var tempArrKey =[] ;
                    var tempArrKey2 =[] ;
                    var keysss = '';
                    var tempArr = [];
                    keysss = Object.keys(yDrillDown[value]);
                    var i , len = keysss.length;

                    keysss.sort();

                    for (i = 0; i < len; i++) {
                      k = keysss[i];
                      tempArr.push([k, yDrillDown[value][k]]);
                      
                    }
                    yDrillDown[value] = tempArr;
                    var keysss = '';
                    var tempArr = [];

                    keysss = Object.keys(y2DrillDown[value]);
                    var i , len = keysss.length;

                    keysss.sort();

                    for (i = 0; i < len; i++) {
                      k = keysss[i];
                      tempArr.push([k, y2DrillDown[value][k]]);
                      
                    }
                    y2DrillDown[value] = tempArr;

                    $.each(yDrillDown[value], function(k , v) {
                       
                        x1AxisData.push(v[0]);
                        if(v == undefined)
                        {
                             v = 0; 
                        }
                        newArrY.push(v[1]);
                        tempArrKey2.push(v[0]);
                       
                    });
                    $.each(y2DrillDown[value], function(k , v) {
                       
                        if(v == undefined)
                        {
                             v = 0; 
                        }
                        newArrY2.push(v);
                        tempArrKey.push(v[0]);
                       
                       
                    });
                    
                    testArrForX1[graphLabel.graph_labels.Y+'|'+value] = tempArrKey2;
                    testArrForX1[graphLabel.graph_labels.Y2+'|'+value] = tempArrKey;
                    
                    seriesDrill.push({
                        name : graphLabel.graph_labels.Y,
                        id:graphLabel.graph_labels.Y+'|'+value,
                        data:newArrY
                    },
                    {
                        name : graphLabel.graph_labels.Y2,
                        id:graphLabel.graph_labels.Y2+'|'+value,
                        data:newArrY2
                    },

                    );
                });
               
                series.push({
                        name : graphLabel.graph_labels.Y,
                        data:dataY},
                        {
                        name : graphLabel.graph_labels.Y2,
                        data:dataY2}
                        );
            }
            else{
                series.push({

                        name: graphLabel.graph_labels.Y,
                        type: columnSeriesOne,
                        data: yAxisData
                    },
                    {
                        name: graphLabel.graph_labels.Y2,
                        type: columnSeriesTwo,
                        data: y2AxisData,
                        yAxis: yAxisOpposit
                    }
                );

                
            }

            if(y3Flag == 0 && typeof y3AxisData[0] != "undefined"){ 
                series.push({
                        name: graphLabel.graph_labels.Y3,
                        type: columnSeriesThree,
                        data: y3AxisData,
                        yAxis: y3AxisOpposit
                    }
                );
            }
            
            if(y4Flag == 0 && typeof y4AxisData[0] != "undefined"){ 
                series.push({
                        name: graphLabel.graph_labels.Y4,
                        type: columnSeriesFourth,
                        data: y4AxisData,
                        yAxis: y4AxisOpposit
                    }
                );
            }
            if(y5Flag == 0 && typeof y5AxisData[0] != "undefined"){ 
                series.push({
                        name: graphLabel.graph_labels.Y5,
                        type: columnSeriesFifth,
                        data: y5AxisData,
                        yAxis: y5AxisOpposit
                    }
                );
            }
            
            if(y6Flag == 0 && typeof y6AxisData[0] != "undefined"){ 
                series.push({
                        name: graphLabel.graph_labels.Y6,
                        type: columnSeriesSixth,
                        data: y6AxisData,
                        yAxis: y6AxisOpposit
                    }
                );
            }
            if(y7Flag == 0 && typeof y7AxisData[0] != "undefined"){ 
                series.push({
                        name: graphLabel.graph_labels.Y7,
                        type: columnSeriesSeventh,
                        data: y7AxisData,
                        yAxis: y7AxisOpposit
                    }
                );
            }

            if(y8Flag == 0 && typeof y8AxisData[0] != "undefined"){ 
                series.push({
                        name: graphLabel.graph_labels.Y8,
                        type: columnSeriesEight,
                        data: y8AxisData,
                        yAxis: y8AxisOpposit
                    }
                );
            }
            if(y9Flag == 0 && typeof y9AxisData[0] != "undefined"){ 
                series.push({
                        name: graphLabel.graph_labels.Y9,
                        type: columnSeriesNinth,
                        data: y9AxisData,
                        yAxis: y9AxisOpposit
                    }
                );
            }
             if(graphLabel.graph_type == '9')
                {
                    var PieData = [];
                    var namess= '';
                    $.each(totalGraph , function(keyy , valuee){
                        
                        if(keyy == 1)
                        {
                            namess = graphLabel.graph_labels.Y
                        }
                        else if(keyy == 2)
                        {
                            namess = graphLabel.graph_labels.Y2
                        }
                        else if(keyy == 3)
                        {
                            namess = graphLabel.graph_labels.Y3
                        }
                        else if(keyy == 4)
                        {
                            namess = graphLabel.graph_labels.Y4
                        }else if(keyy == 5)
                        {
                            namess = graphLabel.graph_labels.Y5
                        }else if(keyy == 6)
                        {
                            namess = graphLabel.graph_labels.Y6
                        }
                        else if(keyy == 7)
                        {
                            namess = graphLabel.graph_labels.Y7
                        }else if(keyy == 8)
                        {
                            namess = graphLabel.graph_labels.Y8
                        }
                        else if(keyy == 9)
                        {
                            namess = graphLabel.graph_labels.Y9
                        }

                        if(valuee != NaN){    
                            PieData.push({
                                name: namess,
                                y: valuee
                            });
                        }
                    });
                    series.push({
                                    name: "Test",
                                    type: 'pie',
                                    data: PieData,
                                    center: [100, 80],
                                    size: 100,
                                    showInLegend: false,
                                    dataLabels: {
                                        enabled: false}
                                }
                    );
               
                }   
        }
    }
   

    var testFlag = 0;

    Highcharts.setOptions({
        lang: {
            thousandsSep: "."
        }
    });
    Highcharts.setOptions({
colors: ['#758EBF', '#027373', '#ca2a25', '#fbc31f', '#F2B999', '#76bfdd', '#72c07f', '#e0762c', '#E87254', '#61b6bb', '#ab204e', '#ca2a25', '#e2c439', '#007162', '#ff8b6c', '#d4db6a', '#b10418', '#b8dce4', '#ca9c2b']    //Defaults to ["#7cb5ec", "#434348", "#90ed7d", "#f7a35c", "#8085e9", "#f15c80", "#e4d354", "#2b908f", "#f45b5b", "#91e8e1"].
   // colors: ['#2f7ed8', '#0d233a', '#8bbc21', '#910000', '#1aadce',
   // '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a']

});
    (function(H) {  
  H.wrap(H.seriesTypes.sunburst.prototype, 'drillUp', function (proceed) {

    //console.log("Before drillup.");

    proceed.apply(this, Array.prototype.slice.call(arguments, 1));
    //console.log(this.rootNode);
    var id_node = [];
                    id_node = this.rootNode.split('.');
                    id_node = id_node[0];
                    
                    
                    if(this.rootNode == '0.0')
                    {
                        var x_id = 'X';
                    }else if (id_node  == ""){
                        var x_id = 'first';
                    }else{
                        var x_id = 'X' + id_node ;
                    }
    var tableId = dataTable.table().node().id;
    var ColumnName = dataTable.columns(columnAxisArray[x_id]).header()[0].id;
    var xAxis = columnAxisArray[x_id];
    var title = dataTable.columns(xAxis).header();
    title = title[0];
    title = $(title).html().replace(/[\W]/g, '-');
                        
                        if(title.includes('-span-class--filter-datatable-label--'))
                        {
                            title1 = '-span-class--filter-datatable-label--'+ColumnName+'--span-'+tableId
                           
                        }
                        title = title + tableId;
    //title = title.attr("id");
    //console.log(tableId+ColumnName);
    
    title = title + tableId;
    $('#fromTo_'+tableId+ColumnName).find('input:text').val('');
    $('#mainS_'+tableId+ColumnName).find('input:text').val('');
    $('#exc_div'+tableId+ColumnName).find('input:text').val('');

    drawChart = true;
    dataTable
    .column(columnAxisArray[x_id])
    .search('' , true , false)
    .draw();          
    drawChart = true;
    $('#'+title1).val('').trigger('change.select2'); 
    //console.log("After drillup.");

  });
})(Highcharts);
Highcharts.getOptions().colors.splice(0, 0, 'transparent');
//console.log(graphLabel);
Highcharts.chart(graphId, {

    chart: {
        //height: '75%'
    },

    title: {
         text: graphLabel.graph_title
    },
     plotOptions: {
        series: {
            cursor: 'pointer',
            events: {
                click: function (event) {
                    
                    var id_node = [];
                    id_node = event.point.parent.split('.');
                    id_node = id_node[0];
                    
                    //console.log(event.point);
                    if(event.point.parent == '0.0')
                    {
                        var x_id = 'X';
                    }else if (id_node  == ""){
                        var x_id = 'first';
                    }else{
                        var x_id = 'X' + id_node ;
                    }
                    //console.log(event.point.parent);
                    //console.log(x_id);
                    //console.log(id_node);

                    if(x_id != 'first'){
                        searchVariable = event.point.name;
                        var tableId = dataTable.table().node().id;
                        var ColumnName = dataTable.columns(columnAxisArray[x_id]).header()[0].id;
                        var xAxis = columnAxisArray[x_id];
                        var title = dataTable.columns(xAxis).header();
                       
                        title = $(title).html().replace(/[\W]/g, '-');
                        
                        if(title.includes('-span-class--filter-datatable-label--'))
                        {
                            title1 = '-span-class--filter-datatable-label--'+ColumnName+'--span-'+tableId
                           
                        }
                        title = title + tableId;
                        
                        var val = $('#exc_div' + tableId+ColumnName).attr("style");
                        if(val != 'display: none;'){
                           $('#exc_div'+tableId+ColumnName).find('input:text').val(searchVariable);
                        }
                        var val = $('#fromTo_' + tableId+ColumnName).attr("style");
                        if(val != 'display:none'){
                            $('#fromTo_'+tableId+ColumnName).find('input:text').val(searchVariable);
                        }

                        var val = $('#mainS_' + tableId+ColumnName).attr("style");
                        if(val != 'display: none;'){
                            $('#mainS_'+tableId+ColumnName).find('input:text').val(searchVariable);
                        }
                   
                        
                        drawChart = true;
                        dataTable
                                .column(columnAxisArray[x_id])
                                .search(searchVariable, true, false )
                                .draw( );
                        drawChart = true;
                        $('#'+title1).val(searchVariable).trigger('change.select2');   
                        }else{
                            
                            $('.select2-selection__rendered').empty();
                            $(':input').val('');
                            $.fn.dataTable.ext.search.pop();
                            
                            drawChart = true;
                            dataTable
                                 .search( '' )
                                 .columns().search( '' )
                                 .draw();
                            drawChart = true;
                       
                    }
                }
                
            }
        }
    },
    series: [{
        turboThreshold: 2000,
        type: "sunburst",
        data: data123,
        allowDrillToNode: true,
        cursor: 'pointer',
        dataLabels: {
            format: '{point.name}',
            filter: {
                property: 'innerArcLength',
                operator: '>',
                value: 16
            }
        },
        levels: [{
            level: 1,
            levelIsConstant: false,
            dataLabels: {
                filter: {
                    property: 'outerArcLength',
                    operator: '>',
                    value: 64
                }
            }
        }, {
            level: 2,
            colorByPoint: true
        },
        {
            level: 3,
            colorVariation: {
                key: 'brightness',
                to: -0.5
            }
        }
        
        //{
            //level: 4,
            //colorVariation: {
                //key: 'brightness',
                //to: 0.5
            //}
        //}
        
       ]
        

    }],
    tooltip: {

        headerFormat: "",
        pointFormat: '{graphValue.graph_labels.Y} <b>{point.name}</b>      <b>{point.value}</b>'
    },
    
        exporting: {
    buttons: {
      contextButton: {
        menuItems: [
          'viewFullscreen',
          'printChart',
          'downloadPDF',
          'separator',
          'downloadCSV',
          'downloadXLS',
          'viewData'
        ]
      }
    }
  },


 // HM_
  states: {
    hover: {
      enabled: true,       // Enable separate styles for the hovered series to visualize that the user hovers either the series itself or the legend.
      halo: {
      //   attributes: null,  // A collection of SVG attributes to override the appearance of the halo, for example fill, stroke and stroke-width.
        opacity: 0.25,     // Opacity for the halo unless a specific fill is overridden using the attributes setting. Note that Highcharts is only able to apply opacity to colors of hex or rgb(a) formats.
        size: 30,          // The pixel size of the halo. For point markers this is the radius of the halo. For pie slices it is the width of the halo outside the slice. For bubbles it defaults to 5 and is the width of the halo outside the bubble.
      },
      lineWidth: 20,        // Pixel with of the graph line.
      marker: {
        enabled: true,         // Enable or disable the point marker.
        // fillColor: null,       // The fill color of the point marker. When null, the series' or point's color is used.
        lineColor: '#FFFFFF',  // The color of the point marker's outline. When null, the series' or point's color is used.
        lineWidth: 10,          // The width of the point marker's outline.
        radius: 10           // The radius of the point marker.
       //  symbol: null           // A predefined shape or symbol for the marker. When null, the symbol is pulled from options.symbols. Other possible values are "circle", "square", "diamond", "triangle" and "triangle-down".
      }

    }
  },
  







});
     
     }  

// Code for default --------------------------------

function setTableEvents(table, graphId,graphValue, columnAxisArray, searchFlag , mapArray , mapLabel) {
    table.on("page", function() {
        drawChart = true;
    });

    table.on("draw", function() {

            if (drawChart) {
                drawChart = false;
            } else {
                if(graphId != ''){
          
                    var is_series_flag = graphValue.graph_labels.is_series; 

                    const tableData = getTableData(table, columnAxisArray, graphId, is_series_flag, graphValue);

                    createHighcharts(tableData, graphId,graphValue, table, columnAxisArray);
                    
                }
 
            }
    });

}

// Code for Charts Not being used yet 


function lineChart(jsonData, Graph_ID) {
    google.charts.load('visualization', '1.1', {packages: ['corechart', 'controls']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chartData = new google.visualization.DataTable();
        if ((jsonData.graph_labels) != '' || jsonData.graph_labels != null) {
            var labels = jsonData.graph_labels;
            var i;
            for (i = 0; i < labels.length; ++i) {
                if (i == 0) {
                    chartData.addColumn('string', labels[i]);
                } else {
                    chartData.addColumn('number', labels[i]);
                }
            }
        }

        if ((jsonData.graph_data) != '' || jsonData.graph_data != null) {
            if (labels.length == 2) {
                (jsonData.graph_data).forEach(function (packet) {
                    chartData.addRow([
                        packet[0],
                        parseFloat(packet[1]),
                    ]);
                });
            } else {
                (jsonData.graph_data).forEach(function (packet) {
                    chartData.addRow([
                        packet[0],
                        parseFloat(packet[1]),
                        parseFloat(packet[2]),
                    ]);
                });
            }

        }


        var graphTitle = '';

        if (jsonData.graph_title != '' || jsonData.graph_title != null) {
            graphTitle = jsonData.graph_title;
        }
        var options = {
            title: graphTitle,
            curveType: 'function',
        };
        var chartLocation = $('#' + Graph_ID + ' .graph')[0];

        if (jsonData.filter_column != '' && jsonData.filter_column != null) {
            var donutRangeSlider = new google.visualization.ControlWrapper({
                'controlType': 'CategoryFilter',
                'containerId': $('#' + Graph_ID + ' .graph_filter')[0],
                'options': {
                    'filterColumnLabel': jsonData.filter_column,
                    'ui': {
                        'allowTyping': false,
                        'allowMultiple': true
                    }
                }
            });

            var LineChart = new google.visualization.ChartWrapper({
                'chartType': 'LineChart',
                'containerId': chartLocation
            });
            var chart = new google.visualization.Dashboard(chartLocation);
            chart.bind(donutRangeSlider, LineChart);
            chart.draw(chartData,options);
        } else {
            var chart = new google.visualization.LineChart(chartLocation);
            chart.draw(chartData, options);
        }
    }
}


// Not used 
function pieChart(jsonData, Graph_ID) {
    google.charts.load('visualization', '1.1', {packages: ['corechart', 'controls']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chartData = new google.visualization.DataTable();
        if ((jsonData.graph_labels) != '' || jsonData.graph_labels != null) {
            var labels = jsonData.graph_labels;
            var i;
            for (i = 0; i < labels.length; ++i) {
                if (i == 0) {
                    chartData.addColumn('string', labels[i]);
                } else {
                    chartData.addColumn('number', labels[i]);
                }
            }
        }

        if ((jsonData.graph_data) != '' || jsonData.graph_data != null) {
            if (labels.length == 2) {
                (jsonData.graph_data).forEach(function (packet) {
                    chartData.addRow([
                        packet[0],
                        parseFloat(packet[1]),
                    ]);
                });
            } else {
                (jsonData.graph_data).forEach(function (packet) {
                    chartData.addRow([
                        packet[0],
                        parseFloat(packet[1]),
                        parseFloat(packet[2]),
                    ]);
                });
            }

        }


        var graphTitle = '';

        if (jsonData.graph_title != '' || jsonData.graph_title != null) {
            graphTitle = jsonData.graph_title;
        }
        var options = {
            title: graphTitle
        };
        var chartLocation = $('#' + Graph_ID + ' .graph')[0];

        if (jsonData.filter_column != '' && jsonData.filter_column != null) {
            var donutRangeSlider = new google.visualization.ControlWrapper({
                'controlType': 'CategoryFilter',
                'containerId': $('#' + Graph_ID + ' .graph_filter')[0],
                'options': {
                    'filterColumnLabel': jsonData.filter_column,
                    'ui': {
                        'allowTyping': false,
                        'allowMultiple': true
                    }
                }
            });

            var PieChart = new google.visualization.ChartWrapper({
                'chartType': 'PieChart',
                'containerId': chartLocation
            });
            var chart = new google.visualization.Dashboard(chartLocation);
            chart.bind(donutRangeSlider, PieChart);
            chart.draw(chartData);
        } else {
            var chart = new google.visualization.PieChart(chartLocation);
            chart.draw(chartData, options);
        }
    }
}
function areaChart(jsonData, Graph_ID) {
    google.charts.load('visualization', '1.1', {packages: ['corechart', 'controls']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        if ((jsonData.graph_data) != '' || jsonData.graph_data != null) {
            var graphTitle = '';

            if (jsonData.graph_title != '' || jsonData.graph_title != null) {
                graphTitle = jsonData.graph_title;
            }
            var options = {
                title: graphTitle
            };

            var productWiseData = google.visualization.arrayToDataTable(getDataResult(jsonData.graph_data, 0, 2, 1));
            var chartLocation = $('#' + Graph_ID + ' .graph')[0];
            var chart = new google.visualization.AreaChart(chartLocation);
            chart.draw(productWiseData, options);
            return false;
        }
    }
    return false;


    /*google.charts.load('visualization', '1.1', {packages: ['corechart', 'controls']});
     google.charts.setOnLoadCallback(drawChart);

     function drawChart() {
     var chartData = new google.visualization.DataTable();
     if ((jsonData.graph_labels) != '' || jsonData.graph_labels != null) {
     var labels = jsonData.graph_labels;
     var i;
     for (i = 0; i < labels.length; ++i) {
     if (i == 0) {
     chartData.addColumn('string', labels[i]);
     } else {
     chartData.addColumn('number', labels[i]);
     }
     }
     }

     if ((jsonData.graph_data) != '' || jsonData.graph_data != null) {
     if (labels.length == 2) {
     (jsonData.graph_data).forEach(function (packet) {
     chartData.addRow([
     packet[0],
     parseFloat(packet[1]),
     ]);
     });
     } else {
     (jsonData.graph_data).forEach(function (packet) {
     chartData.addRow([
     packet[0],
     parseFloat(packet[1]),
     parseFloat(packet[2]),
     ]);
     });
     }

     }


     var graphTitle = '';

     if (jsonData.graph_title != '' || jsonData.graph_title != null) {
     graphTitle = jsonData.graph_title;
     }
     var options = {
     title: graphTitle
     };

     var chartLocation = $('#' + Graph_ID + ' .graph')[0];
     if (jsonData.filter_column != '' && jsonData.filter_column != null) {
     var donutRangeSlider = new google.visualization.ControlWrapper({
     'controlType': 'CategoryFilter',
     'containerId': $('#' + Graph_ID + ' .graph_filter')[0],
     'options': {
     'filterColumnLabel': jsonData.filter_column,
     'ui': {
     'allowTyping': false,
     'allowMultiple': true
     }
     }
     });

     var AreaChart = new google.visualization.ChartWrapper({
     'chartType': 'AreaChart',
     'containerId': chartLocation
     });
     var chart = new google.visualization.Dashboard(chartLocation);
     chart.bind(donutRangeSlider, AreaChart);
     chart.draw(chartData);
     } else {
     var chart = new google.visualization.AreaChart(chartLocation);
     chart.draw(chartData, options);
     }
     }*/
}

function comboChart(jsonData, Graph_ID) {
    google.charts.load('visualization', '1.1', {packages: ['corechart', 'controls']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chartData = new google.visualization.DataTable();
        if ((jsonData.graph_labels) != '' || jsonData.graph_labels != null) {
            var labels = jsonData.graph_labels;
            var i;
            for (i = 0; i < labels.length; ++i) {
                if (i == 0) {
                    chartData.addColumn('string', labels[i]);
                } else {
                    chartData.addColumn('number', labels[i]);
                }
            }
        }

        if ((jsonData.graph_data) != '' || jsonData.graph_data != null) {
            if (labels.length == 2) {
                (jsonData.graph_data).forEach(function (packet) {
                    chartData.addRow([
                        packet[0],
                        parseFloat(packet[1]),
                    ]);
                });
            } else {
                (jsonData.graph_data).forEach(function (packet) {
                    chartData.addRow([
                        packet[0],
                        parseFloat(packet[1]),
                        parseFloat(packet[2]),
                    ]);
                });
            }

        }


        var graphTitle = '';

        if (jsonData.graph_title != '' || jsonData.graph_title != null) {
            graphTitle = jsonData.graph_title;
        }
        var options = {
            title: graphTitle,
            seriesType: 'bars',
            series: {5: {type: 'line'}}
        };
        var chartLocation = $('#' + Graph_ID + ' .graph')[0];
        if (jsonData.filter_column != '' && jsonData.filter_column != null) {
            var donutRangeSlider = new google.visualization.ControlWrapper({
                'controlType': 'CategoryFilter',
                'containerId': $('#' + Graph_ID + ' .graph_filter')[0],
                'options': {
                    'filterColumnLabel': jsonData.filter_column,
                    'ui': {
                        'allowTyping': false,
                        'allowMultiple': true
                    }
                }
            });

            var ComboChart = new google.visualization.ChartWrapper({
                'chartType': 'ComboChart',
                'containerId': chartLocation
            });
            var chart = new google.visualization.Dashboard(chartLocation);
            chart.bind(donutRangeSlider, ComboChart);
            chart.draw(chartData);
        } else {
            var chart = new google.visualization.ComboChart(chartLocation);
            chart.draw(chartData, options);
        }
    }
}

function getDataResult(dataArray, rowIndex, colIndex, dataIndex) {
    //console.info('retret=>',dataArray, rowIndex, colIndex, dataIndex);
    var result = {}, ret = [];
    var newCols = [];
    for (var i = 0; i < dataArray.length; i++) {
        if (!result[dataArray[i][rowIndex]]) {
            result[dataArray[i][rowIndex]] = {};
        }
        result[dataArray[i][rowIndex]][dataArray[i][colIndex]] = parseFloat(dataArray[i][dataIndex]);

        //To get column names
        if (newCols.indexOf(dataArray[i][colIndex]) == -1) {
            newCols.push(dataArray[i][colIndex]);
        }
    }
    newCols.sort();
    var item = [];
    //Add Header Row
    item.push('  ');
    item.push.apply(item, newCols);
    ret.push(item);
    //Add content
    for (var key in result) {
        item = [];
        item.push(key);
        for (var i = 0; i < newCols.length; i++) {
            item.push(result[key][newCols[i]] || 0);
        }
        ret.push(item);
    }

    return ret;
}


function columnChart(jsonData, Graph_ID) {

    google.charts.load("visualization", "1.1", {packages:["bar"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        if ((jsonData.graph_data) != '' || jsonData.graph_data != null) {
            var graphTitle = '';

            if (jsonData.graph_title != '' || jsonData.graph_title != null) {
                graphTitle = jsonData.graph_title;
            }
            var options = {
                title: graphTitle
            };

            var productWiseData = google.visualization.arrayToDataTable(getDataResult(jsonData.graph_data, 0, 2, 1));
            var chartLocation = $('#' + Graph_ID + ' .graph')[0];
            var chart = new google.charts.Bar(chartLocation);
            chart.draw(productWiseData,options);
            return false;
        }
        if (jsonData.filter_column != '' && jsonData.filter_column != null) {
            var nameSelect = new google.visualization.ControlWrapper({
                'controlType': 'CategoryFilter',
                'containerId': $('#' + Graph_ID + ' .graph_filter')[0],
                'options': {
                    'filterColumnLabel': jsonData.filter_column,
                    'ui': {
                        'allowTyping': false,
                        'allowMultiple': true
                    }
                }
            });
            var dashboard = new google.visualization.Dashboard(chartLocation);
            var ColumnChart = new google.visualization.ChartWrapper({
                'chartType': 'ColumnChart',
                'containerId': chartLocation
            });
            dashboard.bind(nameSelect, ColumnChart);
            dashboard.draw(productWiseData,options);
            //var chart = new google.charts.Bar(chartLocation);
            //chart.bind(donutRangeSlider, ColumnChart);
            //chart.draw(productWiseData,options);
            //}
            //dashboard.bind(nameSelect, pieChart);
            // Draw the dashboard.
            //dashboard.draw(productWiseData, options);
        } else {
            var chart = new google.visualization.ColumnChart(chartLocation);
            chart.draw(productWiseData, options);
        }

        // Create a dashboard.



        /*var pieChart = new google.visualization.ChartWrapper({
         'chartType': 'BarChart',
         'containerId': chartLocation
         });
         dashboard.bind(nameSelect, pieChart);*/
        //if (jsonData.filter_column != '' && jsonData.filter_column != null) {
        /*var nameSelect = new google.visualization.ControlWrapper({
         'controlType': 'CategoryFilter',
         'containerId': $('#' + Graph_ID + ' .graph_filter')[0],
         'options': {
         'filterColumnLabel': jsonData.filter_column,
         'ui': {
         'allowTyping': false,
         'allowMultiple': true
         }
         }
         });*/
        //var chart = new google.charts.Bar(chartLocation);
        //chart.bind(donutRangeSlider, ColumnChart);
        //chart.draw(productWiseData,options);
        //}
        //dashboard.bind(nameSelect, pieChart);
        // Draw the dashboard.
        //dashboard.draw(productWiseData, options);

        /*var chart = new google.charts.Bar(document.getElementById('columnchart_year'));
         chart.draw(yearWiseData, {});*/
    }

    /*google.charts.load("visualization", "1.1", {packages:["bar"]});
     //google.charts.load('visualization', '1.1', {packages: ['corechart', 'controls']});
     google.charts.setOnLoadCallback(drawChart);

     function drawChart() {
     var chartData = new google.visualization.DataTable();
     if ((jsonData.graph_labels) != '' || jsonData.graph_labels != null) {
     var labels = jsonData.graph_labels;
     var i;
     for (i = 0; i < labels.length; ++i) {
     if (i == 0) {
     chartData.addColumn('string', labels[i]);
     } else {
     chartData.addColumn('number', labels[i]);
     }
     }
     }

     if ((jsonData.graph_data) != '' || jsonData.graph_data != null) {
     if (labels.length == 2) {
     (jsonData.graph_data).forEach(function (packet) {
     chartData.addRow([
     packet[0],
     parseFloat(packet[1]),
     ]);
     });
     } else {
     (jsonData.graph_data).forEach(function (packet) {
     chartData.addRow([
     packet[0],
     parseFloat(packet[1]),
     parseFloat(packet[2]),
     ]);
     });
     }

     }
     var graphTitle = '';

     if (jsonData.graph_title != '' || jsonData.graph_title != null) {
     graphTitle = jsonData.graph_title;
     }
     var options = {
     title: graphTitle
     };
     var chartLocation = $('#' + Graph_ID + ' .graph')[0];

     if (jsonData.filter_column != '' && jsonData.filter_column != null) {
     var donutRangeSlider = new google.visualization.ControlWrapper({
     'controlType': 'CategoryFilter',
     'containerId': $('#' + Graph_ID + ' .graph_filter')[0],
     'options': {
     'filterColumnLabel': jsonData.filter_column,
     'ui': {
     'allowTyping': false,
     'allowMultiple': true
     }
     }
     });

     var ColumnChart = new google.visualization.ChartWrapper({
     'chartType': 'ColumnChart',
     'containerId': chartLocation
     });
     var chart = new google.visualization.Dashboard(chartLocation);
     chart.bind(donutRangeSlider, ColumnChart);
     chart.draw(chartData,options);
     } else {
     var chart = new google.visualization.ColumnChart(chartLocation);
     chart.draw(chartData, options);
     }
     }*/
}