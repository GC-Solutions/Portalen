var base_url = window.location.origin;
var absPath = document.URL.split('public/')
// This function generate the Graph 
function generateGraphs(graphDiscription , chartColumn , DataTable , searchFlag , mapArray , mapLabel  , Table_ID , placeholderId ,conArray)
{
    var isSeries = false;
    var columnAxisArrayDist = [];
    var columnAxisLabelsDict = {};
    var columnAxisArray = [];
	$.each(graphDiscription, function( key, graphValue ) {
        //console.log("bvjhbdfjhvbfdjbhv _________________");
        //console.log(chartColumn);
        //console.log(graphValue.graph_id);
                        if(graphValue.TableId == placeholderId){
                            columnAxisArray = [];
                            columnAxisLabels = {};
                            
                            $.each(chartColumn, function (chartKey, chartValue) {
                               
                               
                                if(chartValue.graph_id != undefined){
                                    var graphIds = chartValue.graph_id;
                                }else{
                                    var graphIds = graphValue.graph_type;
                                }
                                
                                if(chartValue.axis == "X") {
                                    if(graphValue.graph_type == graphIds){
                                        columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                        columnAxisLabels[chartValue.axis] = chartValue.label;
                                    }
                                    if(chartValue.Type != undefined){
                                        if(chartValue.Type == 'Dynamic'){
                                            columnAxisLabels['XAxisData'] = chartValue.Data;
                                        }
                                    }
                                  
                                }
                                if(chartValue.axis == "Y") {
                                    
                                    if(graphValue.graph_type == graphIds){

                                        columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                        columnAxisLabels[chartValue.axis] = chartValue.label;
                                        if( chartValue.custom_sum != undefined){
                                            columnAxisLabels['custom_sumY'] = chartValue.custom_sum;}
                                        if(chartValue.type != undefined){
                                            columnAxisLabels['typeY'] = chartValue.type;
                                        }
                                        if(chartValue.max != undefined){
                                            columnAxisLabels['maxY'] = chartValue.max;
                                        }
                                        if(chartValue.min != undefined){
                                            columnAxisLabels['minY'] = chartValue.min;
                                        }
                                        if(chartValue.Type != undefined){
                                            if(chartValue.Type == 'Dynamic'){
                                                columnAxisLabels['YAxisColumns'] = chartValue.Columns;
                                            }
                                        }
                                    }
                                    
                                }
                                if(chartValue.axis == "Y2") {
                                    if(graphValue.graph_type == graphIds){
                                        columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                        columnAxisLabels[chartValue.axis] = chartValue.label;
                                        if(chartValue.is_secondary == true) {
                                            isSeries = true;
                                        }
                                        columnAxisLabels['is_series'] = chartValue.is_series;
                                        if( chartValue.custom_sumY2 != undefined){
                                            columnAxisLabels['custom_sumY2'] = chartValue.custom_sumY2;}
                                        if( chartValue.custom_sum != undefined){
                                                columnAxisLabels['custom_sumY2'] = chartValue.custom_sum;}
                                        if(chartValue.type != undefined){
                                            columnAxisLabels['typeY2'] = chartValue.type;
                                        }
                                        if(isSeries) {
                                            columnAxisLabels['is_secondary_Y2'] = isSeries;
                                        }
                                        
                                        if(chartValue.max != undefined){
                                            columnAxisLabels['maxY2'] = chartValue.max;
                                        }
                                        if(chartValue.min != undefined){
                                            columnAxisLabels['minY2'] = chartValue.min;
                                        }
                                    }
                                }
                                if(chartValue.axis == "X1") {
                                    if(graphValue.graph_type == graphIds){
                                        columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                        columnAxisLabels[chartValue.axis] = chartValue.label;
                                        if(chartValue.drillDown == true) {
                                            drillDown = true;
                                        }
                                        columnAxisLabels['drillDown'] = chartValue.drillDown;
                                        if(chartValue.sunbrust == true) {
                                            sunbrust = true;
                                        }
                                        columnAxisLabels['sunbrust'] = chartValue.sunbrust;
                                        
                                    }
                                }

                                if(chartValue.axis == "X2") {
                                    if(graphValue.graph_type == graphIds){
                                        columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                        columnAxisLabels[chartValue.axis] = chartValue.label;
                                        if(chartValue.drillDown == true) {
                                            drillDown = true;
                                        }
                                        columnAxisLabels['drillDown'] = chartValue.drillDown;
                                         if(chartValue.sunbrust == true) {
                                            sunbrust = true;
                                        }
                                        columnAxisLabels['sunbrust'] = chartValue.sunbrust;
                                        
                                    }
                                    
                                }
                                if(chartValue.axis == "X3") {
                                    if(graphValue.graph_type == graphIds){
                                        columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                        columnAxisLabels[chartValue.axis] = chartValue.label;
                                        
                                        columnAxisLabels['sunbrust'] = chartValue.sunbrust;
                                        
                                    }
                                   
                                }
                                if(chartValue.axis == "X4") {
                                    if(graphValue.graph_type == graphIds){
                                        columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                        columnAxisLabels[chartValue.axis] = chartValue.label;
                                        columnAxisLabels['sunbrust'] = chartValue.sunbrust;
                                        
                                    }
                                   
                                }
                                if(chartValue.axis == "X5") {
                                    if(graphValue.graph_type == graphIds){
                                        columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                        columnAxisLabels[chartValue.axis] = chartValue.label;
                                        
                                        columnAxisLabels['sunbrust'] = chartValue.sunbrust;
                                        
                                    }
                                }

                               
                                if(chartValue.axis == "Y3") {
                                    columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                    columnAxisLabels[chartValue.axis] = chartValue.label;
                                    if( chartValue.custom_sumY3 != undefined){
                                        columnAxisLabels['custom_sumY3'] = chartValue.custom_sumY3;
                                    }
                                    if( chartValue.custom_sum != undefined){
                                        columnAxisLabels['custom_sumY3'] = chartValue.custom_sum;}
                                    if(chartValue.type != undefined){
                                        columnAxisLabels['typeY3'] = chartValue.type;
                                    }
                                    if(chartValue.hide_secondary_name == true ) {
                                        columnAxisLabels['hide_secondary_name_Y3'] = chartValue.hide_secondary_name;
                                    }
                                    // if(chartValue.is_secondary == true) {
                                    //     columnAxisLabels['is_secondary_Y3'] = true;
                                    // }
                                    if(chartValue.is_secondary != undefined) {
                                        columnAxisLabels['is_secondary_Y3'] = chartValue.is_secondary ;
                                    }
                                    if(chartValue.secondary_axis != undefined ) {
                                        columnAxisLabels['secondary_axis_Y3'] = chartValue.secondary_axis;
                                    }
                                    if(chartValue.max != undefined){
                                        columnAxisLabels['maxY3'] = chartValue.max;
                                    }
                                    if(chartValue.min != undefined){
                                        columnAxisLabels['minY3'] = chartValue.min;
                                    }
                                   
                                }
                                if(chartValue.axis == "Y4") {
                                    columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                    columnAxisLabels[chartValue.axis] = chartValue.label;
                                    if( chartValue.custom_sumY4 != undefined){
                                        columnAxisLabels['custom_sumY4'] = chartValue.custom_sumY4;}
                                    if( chartValue.custom_sum != undefined){
                                            columnAxisLabels['custom_sumY4'] = chartValue.custom_sum;}
                                    if(chartValue.type != undefined){
                                        columnAxisLabels['typeY4'] = chartValue.type;
                                    };
                                    if(chartValue.hide_secondary_name == true ) {
                                        columnAxisLabels['hide_secondary_name_Y4'] = chartValue.hide_secondary_name;
                                    }
                                    if(chartValue.is_secondary != undefined) {
                                        columnAxisLabels['is_secondary_Y4'] = chartValue.is_secondary ;
                                    }
                                     if(chartValue.secondary_axis != undefined ) {
                                        columnAxisLabels['secondary_axis_Y4'] = chartValue.secondary_axis;
                                    }
                                    if(chartValue.max != undefined){
                                        columnAxisLabels['maxY4'] = chartValue.max;
                                    }
                                    if(chartValue.min != undefined){
                                        columnAxisLabels['minY4'] = chartValue.min;
                                    }

                                }
                                if(chartValue.axis == "Y5") {
                                    columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                    columnAxisLabels[chartValue.axis] = chartValue.label;
                                    if( chartValue.custom_sumY5 != undefined){
                                        columnAxisLabels['custom_sumY5'] = chartValue.custom_sumY5;}
                                    if( chartValue.custom_sum != undefined){
                                            columnAxisLabels['custom_sumY5'] = chartValue.custom_sum;}
                                    if(chartValue.type != undefined){
                                        columnAxisLabels['typeY5'] = chartValue.type;
                                    }
                                    if(chartValue.hide_secondary_name == true ) {
                                        columnAxisLabels['hide_secondary_name_Y5'] = chartValue.hide_secondary_name;
                                    }
                                    if(chartValue.is_secondary != undefined) {
                                        columnAxisLabels['is_secondary_Y5'] = chartValue.is_secondary;
                                    }
                                    if(chartValue.secondary_axis != undefined ) {
                                        columnAxisLabels['secondary_axis_Y5'] = chartValue.secondary_axis;
                                    }
                                    if(chartValue.max != undefined){
                                        columnAxisLabels['maxY5'] = chartValue.max;
                                    }
                                    if(chartValue.min != undefined){
                                        columnAxisLabels['minY5'] = chartValue.min;
                                    }
                                }
                                if(chartValue.axis == "Y6") {
                                    columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                    columnAxisLabels[chartValue.axis] = chartValue.label;
                                    if( chartValue.custom_sumY6 != undefined){
                                        columnAxisLabels['custom_sumY6'] = chartValue.custom_sumY6;}
                                    if( chartValue.custom_sum != undefined){
                                            columnAxisLabels['custom_sumY6'] = chartValue.custom_sum;}
                                    if(chartValue.type != undefined){
                                        columnAxisLabels['typeY6'] = chartValue.type;
                                    };
                                    if(chartValue.hide_secondary_name == true ) {
                                        columnAxisLabels['hide_secondary_name_Y6'] = chartValue.hide_secondary_name;
                                    }
                                    if(chartValue.is_secondary != undefined) {

                                        columnAxisLabels['is_secondary_Y6'] = chartValue.is_secondary ;
                                    }
                                    if(chartValue.secondary_axis != undefined ) {
                                        columnAxisLabels['secondary_axis_Y6'] = chartValue.secondary_axis;
                                    }
                                    if(chartValue.max != undefined){
                                        columnAxisLabels['maxY6'] = chartValue.max;
                                    }
                                    if(chartValue.min != undefined){
                                        columnAxisLabels['minY6'] = chartValue.min;
                                    }
                                }
                                if(chartValue.axis == "Y7") {
                                    columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                    columnAxisLabels[chartValue.axis] = chartValue.label;
                                    if( chartValue.custom_sumY7 != undefined){
                                        columnAxisLabels['custom_sumY7'] = chartValue.custom_sumY7;}
                                    if( chartValue.custom_sum != undefined){
                                            columnAxisLabels['custom_sumY7'] = chartValue.custom_sum;}
                                    if(chartValue.type != undefined){
                                        columnAxisLabels['typeY7'] = chartValue.type;
                                    };
                                    if(chartValue.hide_secondary_name == true ) {
                                        columnAxisLabels['hide_secondary_name_Y7'] = chartValue.hide_secondary_name;
                                    }
                                    if(chartValue.is_secondary != undefined) {

                                        columnAxisLabels['is_secondary_Y7'] = chartValue.is_secondary ;
                                    }
                                    if(chartValue.secondary_axis != undefined ) {
                                        columnAxisLabels['secondary_axis_Y7'] = chartValue.secondary_axis;
                                    }
                                    if(chartValue.max != undefined){
                                        columnAxisLabels['maxY7'] = chartValue.max;
                                    }
                                    if(chartValue.min != undefined){
                                        columnAxisLabels['minY7'] = chartValue.min;
                                    }
                                }
                           
                                if(chartValue.axis == "Y8") {
                                    columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                    columnAxisLabels[chartValue.axis] = chartValue.label;
                                    if( chartValue.custom_sumY8 != undefined){
                                        columnAxisLabels['custom_sumY8'] = chartValue.custom_sumY8;}
                                    if( chartValue.custom_sum != undefined){
                                            columnAxisLabels['custom_sumY8'] = chartValue.custom_sum;}
                                    if(chartValue.type != undefined){
                                        columnAxisLabels['typeY8'] = chartValue.type;
                                    };
                                    if(chartValue.hide_secondary_name == true ) {
                                        columnAxisLabels['hide_secondary_name_Y8'] = chartValue.hide_secondary_name;
                                    }
                                    if(chartValue.is_secondary != undefined) {

                                        columnAxisLabels['is_secondary_Y8'] = chartValue.is_secondary ;
                                    }
                                    if(chartValue.secondary_axis != undefined ) {
                                        columnAxisLabels['secondary_axis_Y8'] = chartValue.secondary_axis;
                                    }
                                    if(chartValue.max != undefined){
                                        columnAxisLabels['maxY8'] = chartValue.max;
                                    }
                                    if(chartValue.min != undefined){
                                        columnAxisLabels['minY8'] = chartValue.min;
                                    }
                                }
                           
                                if(chartValue.axis == "Y9") {
                                    columnAxisArray[chartValue.axis] = parseInt(chartKey);
                                    columnAxisLabels[chartValue.axis] = chartValue.label;
                                    if( chartValue.custom_sumY9 != undefined){
                                        columnAxisLabels['custom_sumY9'] = chartValue.custom_sumY9;}
                                    if( chartValue.custom_sum != undefined){
                                            columnAxisLabels['custom_sumY9'] = chartValue.custom_sum;}
                                    if(chartValue.type != undefined){
                                        columnAxisLabels['typeY9'] = chartValue.type;
                                    };
                                    if(chartValue.hide_secondary_name == true ) {
                                        columnAxisLabels['hide_secondary_name_Y9'] = chartValue.hide_secondary_name;
                                    }
                                    if(chartValue.is_secondary != undefined) {

                                        columnAxisLabels['is_secondary_Y9'] = chartValue.is_secondary ;
                                    }
                                    if(chartValue.secondary_axis != undefined ) {
                                        columnAxisLabels['secondary_axis_Y9'] = chartValue.secondary_axis;
                                    }
                                    if(chartValue.max != undefined){
                                        columnAxisLabels['maxY9'] = chartValue.max;
                                    }
                                    if(chartValue.min != undefined){
                                        columnAxisLabels['minY9'] = chartValue.min;
                                    }
                                }
                            });
                            if( columnAxisArrayDist[graphValue.graph_id] && columnAxisLabelsDict[graphValue.graph_id])
                                {
                                    
                                   columnAxisArrayDist[graphValue.graph_id] = columnAxisArray ;
                                   columnAxisLabelsDict[graphValue.graph_id] = columnAxisLabels;
                                }else{
                                    columnAxisArrayDist[graphValue.graph_id] = columnAxisArray ;
                                    //console.log(columnAxisLabels['custom_sumY3']);
                                     columnAxisLabelsDict[graphValue.graph_id] = columnAxisLabels;
                                     //console.log( columnAxisLabelsDict);
                                }
                          
                            var graphId = graphValue.graph_id;
                            //console.log(graphValue.graph_type)
                            //console.log(columnAxisLabelsDict);
                            if(conArray['graphSearchFlag_'+Table_ID] == '1') {
                                $('#'+Table_ID).on( 'draw.dt', function () {
                                    if(searchFlag == 1){
                                        drawChart = false;
                                    }else if(searchFlag == 2){
                                        drawChart = true;
                                    }
                                    });
                            }
                            
                            if(base_url != 'http://www.babcnew.com')
                            {
                                base_url = absPath[0]+'public';
                            }
                            if(columnAxisLabels['sunbrust'] == true){
                                $.getScript(base_url + '/assets/Custome_Code/Highsofts/customSunBrustChart.js', function()
                                {
                                    graphValue.graph_labels = columnAxisLabelsDict[graphValue.graph_id];
                                    columnAxisArray = columnAxisArrayDist[graphValue.graph_id];
                                    var is_series_flag = graphValue.graph_labels.is_series; 
                                    var tableData = getTableData(DataTable, columnAxisArray, Table_ID , is_series_flag,graphValue);
                                    createHighcharts(tableData,graphId,graphValue,DataTable,columnAxisArray);
                                    setTableEvents(DataTable,graphId,graphValue, columnAxisArray, searchFlag , mapArray , mapLabel );
                                 
                                });
                            }else{
                                $.getScript(base_url + '/assets/Custome_Code/Highsofts/customHighCharts.js', function()
                                {
                                    //console.log(graphId); 
                                  
                                    //console.log(columnAxisLabelsDict[graphValue.graph_id]);
                                   
                                    graphValue.graph_labels = columnAxisLabelsDict[graphValue.graph_id];
                                    columnAxisArray = columnAxisArrayDist[graphValue.graph_id];
                                    //console.log(graphValue);
                                    //console.log(columnAxisArray);
                                    var is_series_flag = graphValue.graph_labels.is_series; 
                                    var tableData = getTableData(DataTable, columnAxisArray, Table_ID , is_series_flag,graphValue);
                                    createHighcharts(tableData,graphId,graphValue,DataTable,columnAxisArray);
                                    setTableEvents(DataTable,graphId,graphValue, columnAxisArray, searchFlag , mapArray , mapLabel );
                                 
                                });
                            }
                            
                            
                        }
                    });
}