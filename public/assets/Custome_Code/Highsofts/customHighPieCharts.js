
// Code for default --------------------------------
var drawChart = false;
function setTableEvents(table, graphId,graphValue, columnAxisArray, searchFlag , mapArray , mapLabel, pieChartArray , pieChartLabel , pieChartPresent = 0, pieId , calType ,displayType , pieType , showLabelPie, pieChartArrayDrillDown , pieChartLabelDrillDown) {
    table.on("page", function() {
       
        drawChart = true;
    });
                 
   
            if (drawChart) {
                drawChart = false;
            } else {
               
                ////console.log("here pie");
                //console.log(pieId);
                if(pieId != 0 )
                {
                    const tableData = getPieChartData(table, pieChartArray, pieChartLabel , calType , displayType, pieType , pieChartArrayDrillDown , pieChartLabelDrillDown);
                    createPieCharts(pieId, tableData , pieType, displayType, showLabelPie);
                    
                }
            }
        


}
// Code for PIE Chart

function getPieChartData(pieChartData, pieChartArr, pieChartLabel, calType, displayType, pieType,pieChartArrayDrillDown, pieChartLabelDrillDown ,){
    
    
    var index = '';
    var mainArr = [];
    var mainArr1 = [];
    var mainArr2 = {};
    var customSumArr = {};
    var pieData = {};
    if(pieType != 3){
        if(calType == 3){
            for (var key in pieChartArr) {
                var newArr = {};
                newArr['name'] = key;

                index = pieChartArr[key];

                
                    if(!isNaN(index)){

                        var intVal = function (valz) {
                        var retuenVal =  0;
                        if(typeof valz === 'string')
                        {
                                returnVal = parseInt(valz.replace(/[.\s]/g, '').replace(/[,]/g, '.') * 1) ;
                                returnVal = Math.round(returnVal);
                            }else if(typeof valz === 'number')
                            {
                                returnVal = valz;
                            }
                            return returnVal;
                        };

                        newArr['value'] = pieChartData
                                        .column( index , { search: 'applied' } )
                                        .data()
                                        .reduce( function (a, b) {
                                            var resultValue = intVal(a) + intVal(b);
                                            return resultValue;
                                        }, 0 );

                        mainArr.push(newArr);  
                    }else{
                        customSumArr[key] = pieChartArr[key];
                    }
                } 
                for (var key in customSumArr){
                    var newArr = {};
                    
                    newArr['name'] = customSumArr[key];

                    $.each(mainArr, function( index, value ) {
                        var tempKey = Object.keys(value)[0];
                        var tempValue = Object.keys(value)[1];
                        key = key.replace(value['name'], value['value']);
                    });
                    
                    key = eval(key);   
                    key = key.toFixed(2);
                                           
                    newArr['value'] = key;
                    mainArr.push(newArr); 
               
                }                   
        }else if(calType == 2){
           
           var ind = [];
           for (var key in pieChartArr) {
                if(key != undefined){
                    if(typeof pieChartArr[key] === 'number')
                        ind.push(pieChartArr[key]);
                }
           }
           
            var newArr = [];
            var main =ind[0];
            var secondry = ind[1];

            pieChartData.rows({ search: "applied" }).every(function(array,index, i) {
                const data = this.data();

                var val = parseInt(data[secondry].replace(/[.\s]/g, '').replace(/[,]/g, '.') * 1) ;
                var tempVar = data[main].trim();
                
                if(newArr[tempVar] ){
                    newArr[tempVar] = newArr[tempVar] + val;
                }else{
                    newArr[tempVar] = val;
                }
           
            });
            var cnt = 0;
            for(var key in newArr)
            {
                cnt = newArr[key] + cnt;
            }
           
            for(var key in newArr)
            {
                var tempArr = {};
                tempArr['name'] = key.trim(); 
                if(displayType == 1){
                    tempArr['value'] = (newArr[key]/cnt)*100; 
                }else if (displayType == 2){
                    tempArr['value'] = newArr[key]; 
                }
                mainArr.push(tempArr);
            }
        }else if(calType == 1){
           
           var ind = [];
           for (var key in pieChartArr) {
                if(key != undefined){
                    if(typeof pieChartArr[key] === 'number')
                        ind.push(pieChartArr[key]);
                }
           }
            var newArr = [];
            var main =ind[0];
            var cnt = pieChartData.rows().count();
            
            pieChartData.rows({ search: "applied" }).every(function(array,index, i) {
            const data = this.data();

            if( data[main] in newArr ){
                newArr[data[main]] = newArr[data[main]] + 1;
            }else{
                if(displayType == 1){
                    newArr[data[main]] = 1;
                }else{
                    newArr[data[main]] = 0;
                }
            }
            });

         
            for(var key in newArr)
            {
                var tempArr = {};
                tempArr['name'] = key.trim(); 
                if(displayType == 1){
                    tempArr['value'] = ((newArr[key]/cnt)*100); 
                }else if (displayType == 2)
                {
                    tempArr['value'] = newArr[key]; 
                }
                
                mainArr.push(tempArr);
            }
        }
    }else{
        if(calType == 3){
            for (var key in pieChartArr) {
                var newArr = {};
                newArr['name'] = key;

                index = pieChartArr[key];

                    if(!isNaN(index)){

                        var intVal = function (valz) {
                        var retuenVal =  0;
                        if(typeof valz === 'string')
                        {
                                returnVal = parseInt(valz.replace(/[.\s]/g, '').replace(/[,]/g, '.') * 1) ;
                                returnVal = Math.round(returnVal);
                            }else if(typeof valz === 'number')
                            {
                                returnVal = valz;
                            }
                            return returnVal;
                        };

                        newArr['value'] = pieChartData
                                        .column( index , { search: 'applied' } )
                                        .data()
                                        .reduce( function (a, b) {
                                            var resultValue = intVal(a) + intVal(b);
                                            return resultValue;
                                        }, 0 );

                        mainArr.push(newArr);  
                    }else{
                        customSumArr[key] = pieChartArr[key];
                    }
                } 
                for (var key in customSumArr){
                    var newArr = {};
                    
                    newArr['name'] = customSumArr[key];

                    $.each(mainArr, function( index, value ) {
                        var tempKey = Object.keys(value)[0];
                        var tempValue = Object.keys(value)[1];
                        key = key.replace(value['name'], value['value']);
                    });
                    
                    key = eval(key);   
                    key = key.toFixed(2);
                                           
                    newArr['value'] = key;
                    mainArr.push(newArr); 
               
                }                   
        }else if(calType == 2){
            
           var ind = [];
           for (var key in pieChartArr) {
                if(key != undefined){
                    if(typeof pieChartArr[key] === 'number')
                        ind.push(pieChartArr[key]);
                }
           }
           for (var key in pieChartArrayDrillDown) {
                if(key != undefined){
                    if(typeof pieChartArrayDrillDown[key] === 'number')
                        ind.push(pieChartArrayDrillDown[key]);
                }
           }
            
            var newArr = [];
            var newArr1 = [];
            var newArr2 = {};
            var main =ind[0];
            var secondry = ind[1];
            var main1 =ind[2];
            var secondry2 = ind[3];
            var drill1 = [];

            pieChartData.rows({ search: "applied" }).every(function(array,index, i) {
            const data = this.data();
          
            var val = parseInt(data[secondry].replace(/[.\s]/g, '').replace(/[,]/g, '.') * 1) ;
            var tempVar = data[main].trim();

            var val1 = parseInt(data[secondry2].replace(/[.\s]/g, '').replace(/[,]/g, '.') * 1) ;
            var tempVar1 = data[main1].trim();
            
            if(newArr[tempVar] ){
                newArr[tempVar] = newArr[tempVar] + val;
            }else{
                newArr[tempVar] = val;
            }
           
            
            var newArr1 = {};
           
            if(newArr2[tempVar] != undefined && newArr2[tempVar][tempVar1] != undefined ){
               
                newArr2[tempVar][tempVar1] = newArr2[tempVar][tempVar1] + val1;
            }else{
                
                
                if(newArr2[tempVar] != undefined && newArr2[tempVar].length != 0 ){
                    
                    newArr1 = newArr2[tempVar] ;
                    newArr1[tempVar1] = val1;
                    newArr2[tempVar]=newArr1;
                }else
                {
                    newArr1[tempVar1] = val1;
                    newArr2[tempVar]=(newArr1);
                }
               
            }
            
             
            });
            
            var cnt = 0;
            

            for(var key in newArr)
            {
                cnt = newArr[key] + cnt;
                
            }
           
            for(var key in newArr)
            {
                var cnt1 = 0;
                var tempArr = {};
                tempArr['name'] = key.trim(); 
                if(displayType == 1){
                    tempArr['y'] = (newArr[key]/cnt)*100; 
                }else if (displayType == 2){
                    tempArr['y'] = newArr[key]; 
                }
                tempArr['drilldown'] = key.trim();

                mainArr.push(tempArr);

                var tempArr3 = newArr2[key];
                for(var key2 in tempArr3){
                    cnt1 = tempArr3[key2] + cnt1;
                }

                var dataArr = [];

                var tempArr = {};
                tempArr['name'] = key.trim(); 
                tempArr['id'] = key.trim(); 
                for(var key2 in tempArr3)
                {
                     var dataArr1 = [];
                    if(displayType == 1){
                        var testVar = (tempArr3[key2]/cnt1)*100; 
                    }else if (displayType == 2){
                        var testVar = tempArr3[key2]; 
                    }
                    dataArr1 = [key2,testVar];
                    dataArr.push(dataArr1);
                    tempArr['data'] =  dataArr;

                }
                mainArr1.push(tempArr);
            }
            
        }else if(calType == 1){
           
           var ind = [];
           for (var key in pieChartArr) {
                if(key != undefined){
                    if(typeof pieChartArr[key] === 'number')
                        ind.push(pieChartArr[key]);
                }
           }
            var newArr = [];
            var main =ind[0];
            var cnt = pieChartData.rows().count();
            
            pieChartData.rows({ search: "applied" }).every(function(array,index, i) {
            const data = this.data();

            if( data[main] in newArr ){
                newArr[data[main]] = newArr[data[main]] + 1;
            }else{
                if(displayType == 1){
                    newArr[data[main]] = 1;
                }else{
                    newArr[data[main]] = 0;
                }
            }
            });

         
            for(var key in newArr)
            {
                var tempArr = {};
                tempArr['name'] = key.trim(); 
                if(displayType == 1){
                    tempArr['value'] = ((newArr[key]/cnt)*100); 
                }else if (displayType == 2)
                {
                    tempArr['value'] = newArr[key]; 
                }
                
                mainArr.push(tempArr);
            }
        }
    }
    
    //console.log(mainArr1);
    pieData['pie_chart_title'] = pieChartLabel['label'];
    pieData['chart_type'] = pieChartLabel['type'];
    pieData['pie_data'] = mainArr;
    pieData['pie_data_drilldown'] = mainArr1; 
    return pieData;
    
}
function ShowPieChartData(url, PieChart_ID) {
    if(PieChart_ID.includes("PieChartHC_") == true){
        $.getJSON(url, function (data, status) {
                var jsonData = data;
                //console.log(data);
                createPieCharts(PieChart_ID, data, jsonData.chart_type, jsonData.display_type);
        });
    } 
}

function createPieCharts(pieId, pieChartData, pieType, displayType,showLabelPie) {

    var jsonData = pieChartData;
    //console.log('here');
    //console.log(pieType);
    //console.log(pieId);
    //console.log(jsonData);
    if(pieType == 1){
        var data1 = jsonData.pie_data.map(function(el){
                return {name: el.name , y: el.value }
        });
   
       Highcharts.setOptions({
        colors: ['#1a2b57', '#095645', '#ca2a25', '#fbc31f', '#a3ebcf', '#76bfdd', '#72c07f', '#e0762c', '#ffe75d', '#61b6bb', '#ab204e', '#ca2a25', '#e2c439', '#007162', '#ff8b6c', '#d4db6a', '#b10418', '#b8dce4', '#ca9c2b']


        });

    //Defaults to ["#7cb5ec", "#434348", "#90ed7d", "#f7a35c", "#8085e9", "#f15c80", "#e4d354", "#2b908f", "#f45b5b", "#91e8e1"].
   // colors: ['#2f7ed8', '#0d233a', '#8bbc21', '#910000', '#1aadce',
   // '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a']

 //Pie chart 1 begins here
    Highcharts.chart(pieId, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false,
            type:'pie',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 0
            },
       
    backgroundColor: "rgba(255, 255, 255, 0)",
    plotBackgroundColor: "rgba(255, 255, 255, 0)"
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





        title: {
            text: jsonData.pie_chart_title,
        },
        credits: {
            enabled: false
        },
        legend: {
                    enabled: showLabelPie == '1' ? false : true,
                    align: 'center',
                    verticalAlign: 'top',
                    floating: false,
                    x: 0,
                    y: 10,
                   
                    labelFormatter : function() { 
                        if(displayType == 1) {
                            //return this.name + '(<span style=\"color:'+this.color+'\">'+Highcharts.numberFormat(this.percentage, 2)+ '%)';
                            return this.name + '('+Highcharts.numberFormat(this.percentage, 2)+ '%)';

                        }else{
                            //return this.name  +'(<span style=\"color:'+this.color+'\">'+this.y+ ')';
                            var formatData = this.y.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');  
                            return this.name  + '('+formatData+ ')';

                             } 
                    }
                },
                tooltip: {

            //pointFormat: '{series.name}: <b>{point.y:.2f}%</b>'
          formatter:function(){
                
                if(displayType == 1)
                    return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' %';
                else{
                     var formatData = this.point.y.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');  
                
                     return '<b>'+ this.point.name +'</b>: '+formatData ;
                    }
            }
 
        },
        
        
        plotOptions: {
            pie:   {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            },
            showInLegend: true
        }
        },

        
        series: [{
            name: jsonData.pie_chart_title,
            data: data1
        }]
    });
        //Pie chart 2 begins here
    }else if(pieType == 2){
         var data1 = jsonData.pie_data.map(function(el){
            return {name: el.name , y: el.value }
        });
        Highcharts.chart(pieId, {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false,
                type:'pie'
            },
            title: {
                text: jsonData.pie_chart_title,
            },
            tooltip: {
                //pointFormat: '{series.name}:<b>{point.y:.2f}%</b>'
                formatter:function(){
                    if(displayType == 1)
                        return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' %';
                    else{
                         var formatData = this.point.y.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                         return '<b>'+ this.point.name +'</b>: '+ formatData;
                     }
                }
            },
            plotOptions: {
                pie: { dataLabels: {  enabled: true, distance: -50,    style: {    fontWeight: 'bold',  color: 'white'  }  }, startAngle: -90,    endAngle: 90,     center: ['50%', '75%'], size: '110%' }
            },
            series: [{
                name: jsonData.pie_chart_title,
                innerSize: '50%',
                data: data1
                }]
            });
    }else  if(pieType == 3){

    var data1 = jsonData.pie_data;
    var data2 = jsonData.pie_data_drilldown;
    //console.log(data2);
    Highcharts.setOptions({
    colors: ['#1a2b57', '#095645', '#ca2a25', '#fbc31f', '#a3ebcf', '#76bfdd', '#72c07f', '#e0762c', '#ffe75d', '#61b6bb', '#ab204e', '#ca2a25', '#e2c439', '#007162', '#ff8b6c', '#d4db6a', '#b10418', '#b8dce4', '#ca9c2b']


    });
 //Pie chart 1 begins here
    Highcharts.chart(pieId, {
        chart: {
            events: {
               
                click:function(e)
                {
                    //console.log("nkndvkjnkjvnkdfjvnkjdfnvk");
                },
            },
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false,
            type:'pie',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 0
            },

       
    backgroundColor: "rgba(255, 255, 255, 0)",
    plotBackgroundColor: "rgba(255, 255, 255, 0)"
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

        title: {
            text: jsonData.pie_chart_title,
        },
        credits: {
            enabled: false
        },
        legend: {
                    enabled: showLabelPie == '1' ? false : true,
                    align: 'center',
                    verticalAlign: 'top',
                    floating: false,
                    x: 0,
                    y: 10,
                   
                    labelFormatter : function() { 
                        if(displayType == 1) {
                            //return this.name + '(<span style=\"color:'+this.color+'\">'+Highcharts.numberFormat(this.percentage, 2)+ '%)';
                            return this.name + '('+Highcharts.numberFormat(this.percentage, 2)+ '%)';

                        }else{
                            //return this.name  +'(<span style=\"color:'+this.color+'\">'+this.y+ ')';
                            return this.name  + '('+this.y+ ')';

                             } 
                    }
                },
                tooltip: {

            //pointFormat: '{series.name}: <b>{point.y:.2f}%</b>'
          formatter:function(){
                
                
                if(displayType == 1)
                    return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' %';
                else
                     return '<b>'+ this.point.name +'</b>: '+ this.point.y;
            }
 
        },
        
        
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                },
                 point: {
                events: {
                         click: function() {
                                //console.log("Kjhbdvhjsdbjhsd");                    
                         },
                         
                     }
                     }
            
            }
        },  
        series: [{
            name: jsonData.pie_chart_title,
            data: data1,
        }],
        drilldown: {
            series: data2
        }
    });

    }
}


