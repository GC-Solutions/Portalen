
function ShowMapData(url, Map_ID) {
    if(Map_ID.includes("MapHC_") == true){

        $.getJSON(url, function (data, status) {
                createHighMaps(Map_ID, data);
        });
    } 
}


// Code for Maps --------------------------------
function getMapData(mapData, mapArr, mapLabel ,  mapArrayNew, mapLabelNew , csvData , MapType){
    var newArr = {};
    var drillArr = [];

    mapData.rows({ search: "applied" }).every(function(array,index, i) {
        const data = this.data();

        const seriesAxisArray = [];
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

        $.each(mapLabelNew , function(key , value){
            
            if(newArr[data[mapArr.code]+'_'+[value]] == undefined)
                newArr[data[mapArr.code]+'_'+[value]] = 0;

            newArr[data[mapArr.code]+'_'+[value]] = newArr[data[mapArr.code]+'_'+[value]] + intVal(data[mapArrayNew[key]]);
        });


        if(MapType == 3){
            
            $.each(csvData , function(key , value){

            if(value[1] == data[2])
            {
                $.each(mapLabelNew , function(key1 , value1){
                    

                    if(newArr[value[3]+'_'+[value1]] == undefined)
                        newArr[value[3]+'_'+[value1]] = 0;

                    newArr[value[3]+'_'+[value1]] = newArr[value[3]+'_'+[value1]] + intVal(data[mapArrayNew[key1]]);
                                
                    });
                    return false;
                }
                
            });
        }
        
        if(MapType == 2){
            
            $.each(csvData , function(key , value){

            if(value[1] == data[2])
            {
                $.each(mapLabelNew , function(key1 , value1){
                    

                    if(newArr[data[3]+'_'+[value1]] == undefined)
                        newArr[data[3]+'_'+[value1]] = 0;

                    newArr[data[3]+'_'+[value1]] = newArr[data[3]+'_'+[value1]] + intVal(data[mapArrayNew[key1]]);
                    newArr[data[3]+'_lat'] = value[9] ;
                    newArr[data[3]+'_lon'] = value[10] ;
                
                
                    });
                    return false;
                }
                
            });
        }
        

    });
    
    var obj = [];
    var mainJ = {};
    var name = [];
    var nameLabel = [];
   
    for (var key in newArr) {

       var tmp = {};
       var flag = 0;
       name = key.split('_'); 
       nameLabel = name[1].split('label');
       if(nameLabel[1] != undefined){
            var labelName = 'label'+nameLabel[1];
            var valueName = 'value'+nameLabel[1];
       }else{
            var labelName = 'label'+nameLabel[0];
            var valueName = 'value'+nameLabel[0];
       }
     

       if(obj){
           for (var newArrkey in obj) {
                
                if(obj[newArrkey]['code'] == name[0])
                {
                    obj[newArrkey][labelName] =  name[1];
                    obj[newArrkey][valueName] =  newArr[key];
                    flag = 1; 
                }
           }
        }
        if(flag == 0){
           
            tmp['code'] = name[0];
            tmp[valueName] = newArr[key];
            tmp[labelName] = name[1];
            
            obj.push(tmp); 
        }
    }
    //console.log(obj);
    mainj = 
    {   
        //"map_title":mapLabel.title, //Title Text Map
        "map_label":mapLabelNew,
        "map_data": obj
    };
 
    return mainj;
    
}
function createHighMaps(mapId, mapData , mapLabelNew , MapType , mapDisplayLabelNew) {

    var jsonData = mapData;

    if(mapLabelNew == undefined){
            var mapLabelNew = [];
            mapLabelNew =  jsonData.map_label;
    }
   
    var data1 = jsonData.map_data.map(function(el){
        //console.log(el);

           if(mapLabelNew[0].indexOf('label') != -1)
           {
                var arr = [];
                arr = mapLabelNew[0].split('label');
                var nam = 'value'+arr[1];
           }else{
                var nam = 'value'+mapLabelNew[0];

           }
            
            if(el[nam] == 0)
            {
               var size = 1;
            }
            else{
                var size = el[nam]
            }
            
            if(el.valuelat != undefined && el.valuelon != undefined )
            {
                return {name:el.code , lat: el.valuelat, lon: el.valuelon, data:el}
            }else if(MapType == 1){
                return {name: 'test', z: el[nam], 'iso-a2': el.code, data:el}
            }
            else {
                return {name: 'test', z: el[nam], 'key': el.code, data:el}
            }
            //return {name: 'test', z: el[nam], 'key': el.code, data:el}
    });

    //console.log(data1);

    if(MapType == 2 || MapType == 3){

        if(MapType == 3){
             var mapGeoJSON = Highcharts.maps['countries/se/se-all'];       
            // Generate non-random data for the map
            $.each(mapGeoJSON.features, function (index, feature) {
               
                $.each(data1 , function(key1 , value1){
                    
                    if(feature.properties['woe-name'] == value1['key'])
                    {
                        value1['hc-key'] =  feature.properties['hc-key'];
                    }
                });
              
            });
            var series =[{
                data: data1,
                name: '', // Cities
                states: {
                    hover: {
                        color: '#BADA55'
                    }
                }, dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }];

        }else{
             var series = [{
                    // Use the se-all map with no data as a basemap
                    name: 'Basemap',
                    borderColor: '#A0A0A0',
                    nullColor: 'rgba(200, 200, 200, 0.3)',
                    showInLegend: false
                }, {
                    name: 'Separators',
                    type: 'mapline',
                    nullColor: '#707070',
                    showInLegend: false,
                    enableMouseTracking: false
                }, {
                    // Specify points using lat/lon
                    type: 'mappoint',
                    name: '', // Cities
                    color: Highcharts.getOptions().colors[1],
                    data: data1
                }];

        }

        Highcharts.mapChart(mapId, {

        chart: {
            map: 'countries/se/se-all'
        },

        title: {
            text: jsonData.map_title
        },


        mapNavigation: {
                    enabled: true,
                    buttonOptions: {
                        verticalAlign: 'bottom'
                    }
                },

        tooltip: {
            formatter: function() {
                    var text = '';
                    var labelmapName = [];
                    var labelmapNamess = '';
                    var pointData = this.point.data;
                    var formatData = '';
                    text = '<b>'+this.point.name+'</b><br>';
                    $.each(mapLabelNew , function(ke , val){
                        labelmapName = val.split('label');
                        
                        var labelDisplayName =  '';
                        
                        if(labelmapName[1] != undefined)
                        {
                            if(typeof mapDisplayLabelNew !== 'undefined')
                            {
                                labelDisplayName = mapDisplayLabelNew[ke];
                            } else {
                                labelDisplayName = labelmapName[1];
                            }


                            labelmapNamess = 'value'+labelmapName[1];
                            formatData = pointData[labelmapNamess].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'); 
                            text += "<br>"+labelDisplayName+':'+ formatData ;
                        }else{

                            if(typeof mapDisplayLabelNew !== 'undefined')
                            {
                                labelDisplayName = mapDisplayLabelNew[ke];
                            } else {
                                labelDisplayName = val;
                            }

                            labelmapNamess = 'value'+val;
                            formatData = pointData[labelmapNamess].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'); 
                            
                            text += "<br>"+labelDisplayName +':'+ formatData ;
                        
                        }
                       });
                    return text;
            }
        },

        series: series
    });
      }else{
    // Initiate the chart
    Highcharts.mapChart( mapId , {
                        chart: {
                            borderWidth: 1,
                            map: 'custom/world'
                        },

                        title: {
                            text: jsonData.map_title
                        },

                        subtitle: {
                            text: ''
                        },

                        legend: {
                            enabled: false
                        },

                        mapNavigation: {
                            enabled: true,
                            buttonOptions: {
                                verticalAlign: 'bottom'
                            }
                        },
                        
                    
                        
                        tooltip: {
                           
                            formatter: function() {
                                    var text = '';
                                    var labelmapName = [];
                                    var labelmapNamess = '';
                                    var pointData = this.point.data;
                                    var formatData = '';
                                    text = '<b>'+this.point.name+'</b><br>';
                                    $.each(mapLabelNew , function(ke , val){
                                        labelmapName = val.split('label');
                                        console.log(mapLabelNew);
                                        var labelDisplayName =  '';
                        
                                        if(labelmapName[1] != undefined)
                                        {
                                            if(typeof mapDisplayLabelNew !== 'undefined')
                                            {
                                                labelDisplayName = mapDisplayLabelNew[ke];
                                            } else {
                                                labelDisplayName = labelmapName[1];
                                            }
                                            labelmapNamess = 'value'+labelmapName[1];
                                            formatData = pointData[labelmapNamess].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'); 
                                            text += "<br>"+labelDisplayName +':'+ formatData ;
                                        }else{
                                            if(typeof mapDisplayLabelNew !== 'undefined')
                                            {
                                                labelDisplayName = mapDisplayLabelNew[ke];
                                            } else {
                                                labelDisplayName = val;
                                            }
                                            labelmapNamess = 'value'+val;
                                            formatData = pointData[labelmapNamess].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'); 
                                            
                                            text += "<br>"+labelDisplayName +':'+ formatData ;
                                        
                                        }
                                       });
                                    return text;
                                  }
                            },

                        series: [{
                            name: 'Countries',
                            color: '#E0E0E0',
                            enableMouseTracking: false
                        }, {
                            type: 'mapbubble',
                            name: 'test',
                            joinBy: 'iso-a2',
                            data: data1,
                            minSize: '3%',
                            maxSize: '12%'
                            
                        }]
                    });
}

}

// Code for default --------------------------------
var drawChart = false;
var csvData = [];
function setTableEvents(table, graphId,graphValue, columnAxisArray, searchFlag , mapArray , mapLabel , mapArrayNew , mapLabelNew , MapTYpe , mapDisplayLabelNew ) {
    table.on("page", function() {
        drawChart = true;
    });

    table.on("draw", function() {

            if (drawChart) {
                drawChart = false;
            } else {
                    var base_url1 = window.location.origin;
                    var UrlBase = '';
                    if( base_url1.includes('212.247.32.103:8082')){
                        UrlBase = "/bpu/public/assets/Custome_Code/Highsofts/MapsCSV/SEMaps.csv";
                    }else{
                        UrlBase = "/public/assets/Custome_Code/Highsofts/MapsCSV/SEMaps.csv";
                    }
                    
                    csvData = '';
                    if(MapTYpe  == '2' || MapTYpe  == '3'){
                        $.ajax({
                              type: "GET",  
                              url: UrlBase,
                              dataType: "text",
                               async: false,
                                cache: false,
                                timeout: 3000,       
                              success: function(response)  
                              {
                                csvData = $.csv.toArrays(response);
                                
                              }   
                            });
                    }
                    
                if(graphId != ''){
                   
                    var is_series_flag = graphValue.graph_labels.is_series;         
                    const tableData = getTableData(table, columnAxisArray, graphId, is_series_flag);
                    createHighcharts(tableData, graphId,graphValue );
                }
               if(mapArray.code != undefined)
                {
                    
                    const tableData = getMapData(table, mapArray, mapLabel,mapArrayNew , mapLabelNew,csvData , MapTYpe);
                    createHighMaps('MapHC_1', tableData,mapLabelNew , MapTYpe , mapDisplayLabelNew);
                }
            }
        
    });

}
