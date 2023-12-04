
var base_url = window.location.origin;
var absPath = document.URL.split('public/');
if(base_url != 'http://www.babcnew.com')
{
    base_url = absPath[0]+'public';
}
var openAll = '';
var closeAll = '';

var rowGroupId = 0;
var sortFlag = 0;
var rowGroupOrder = '';
var ColumnIndex = -1;
var proRowDataheader = [];
var tableIdPro = [];
var productInfo = '';
var  tableLink = [];
var rowId ;
var setGlobal = '';
var collapsedGroups = {};
var groupRowsColumn = 0;
var setGlobal1 = {};
var setGlobalPrevious1 = {};
var setGlobalSearch = '';
var setGlobalPrevious = '';
var rangeFilterCheck = 0;
var ColumnIndexRange  = '';
var tabRange = '';
var sortVariable = '';
var tableTestId = '';
var lastOrdeState = 'asc';
var sortColumnID  = '';
var CheckFlagg  = '0';
var lastOrder = [];
var runtymDownload = 0;
var checkVal12 = '';
var ExcelCheck = '0';
var rowGroupArrNew = {};



function ShowTableData(url, Table_ID, columnsUrl, placeholderId, tableTitle,searchValue,pannelIds,graphDiscription,mapPresent,pieChartPresent,pieDiscription, queryString , tableIds , commonField , tableLinked , mapDiscription , sessionSearch , sessionSearchRange, sessionSort , sessionsearchVarMulti , pageName , pageId) {
    if(base_url != 'http://www.babcnew.com')
    {
        base_url = absPath[0]+'public';
    }
    var CSVURL =   base_url+"/csvUpload?placeholderId="+placeholderId;
    var columnAlignment = '';
    var footerColumn = '';
    var chartColumn = '';
    var mapColumn = '';
    var pieChartColumn = '';
    var mapArray = [];
    var mapLabel = [];
    var mapArrayNew = [];
    var mapLabelNew = [];
    var mapDisplayLabelNew = [];
    var pieChartArray = [];
    var pieChartLabel = [];
    var columnAxisArray = [];
    var pieChartArrayDrillDown  = [];
    var pieChartLabelDrillDown = [];
    var columnTitle = '';
    var searchFlag = 0;
    var scrollFlag = 0;
    var multipleSearchSelectorFlag = 0;
    var conArray = {};
    var groupRowsFlag = 0;
    //var groupRowsColumn = 0;
    var groupRowsColumnArr = [];
    var collapsedGroups = {};
    var predefineSearch = [];
    var rangePredefineSearchFlag = 0;
    var predefineSearchForRange = [];
    var hideColumn = [];
    var sort = 0;
    var defaultSortType = 'asc';
    var sortingValue= 0;
    var predefineSearchFlag =0;
    var columnOrder = [];
    var excludeZeroCol = [];
    var headerExcel = [];
    var rowsCount = 10;
    var editor;
    var rowVal = [];
    var rowIdx;
    var rowCom;
    var entryMain = '';
    var EnableCrud = 0;
    var MinFilterWidth = '';
    var MaxFilterWidth = '' ;
    var tableDesign = '0' ;
    var ScrollWidth  = '200px';
    var FooterSumLocation ='';
    var PaginationFlag = 0 ; 
    var EnableChildRows = 0;
    var EnableChildRowsRunTym = 0;
    var FilterSessionEnable = 0;
    var EnableLiveImgSync = 0;
    var EnableExcelBtn = 0;
    var EnableXMLdownload = 0;
    var TableType = 1;
    var LiveReportSync = 0;
    var AllowDynamicForm = 0;
    var DesignType = 0;
    var OldDesignBtnTitle = '';
    var NewDesignBtnTitle = '';
    var NameOrgBtn = '';
    var NameLastBtn = '';
    var EnableLastSearchDF = '';
    var EnableFormOnActionBTN = '';
    var AllowColumnRowMarking = 0;
    var ColoringType ='';
    var ColoringJsonText = '';
    var ColumnNameColor = '';
    var ColorSettingType = '' ;
    var ColorTextMatchKey = '';
    var temp = [];
    var EnableSideBar = '';
    var TableSideBar = '';
    var RouteColumnIndex = '';
    var TabAction = '';
    var TableSideBar2 = '';
    var RouteColumnIndex2 = '';
    var TabAction2 = '';
    var SilderDesign = '';
    var EnableOnclickBtn = '';
    var EnableRowGroupLevel = '';
    var RowGroupLevelColumn = '';
    var EnablerowGroup = 0;
    var EnableRowGroupColumn = 0;
    var groupParent = [];
    var check1 = 0;
    var check2 = 0;
    var check3 = 0;
    var SortLevels = [];
    var EnableFilterWidth1 = 0;
    var CustomColumnWidth = [];
    var DataGroupingJson = [] ;
    var AllowDataGrouping =0;
    var ButtonName  = '';
    var AllowSearchAfter3Char =0;
    var ColSearchAfter3Char = [] ;
    var COlOrderName = [];
    var Flagcol = 0;
    var FlagcolN = 0;
    var EnableAllUpdates = 0;
    var EnableCheckBoxes = 0;
    var PredefinedUpdateName = '';
    var PredefinedUpdateId = '';
    var SelectPredefinedNames = '';
    var SaveFilterBTN =0;
    var AllowPDFImport = 0;
    var AllowExcelImport = 0;
    var NotiColumnMarking = 0;
	var AllowEnterSearch = 0;
   

    //var sessionSort = [];

    if (pannelIds.trim() != '' && pannelIds.trim() != null) {
        pannelIds = JSON.parse(pannelIds)
    }

    // if(document.getElementById('TabsEnabled') != undefined && Table_ID != 'Table_1') { // this part for focus for new design tool on top 
    //     $(".colTitle_" + Table_ID).html(tableTitle);
    // }else
    // {
        $("." + Table_ID).html(tableTitle);
    //}
    
    
    if(Table_ID){
        ButtonName = Table_ID;
    }
    // from here
    $.get(columnsUrl, function (data, status) {

        if (data.trim() != '' && data.trim() != null) {
            var jsonData = JSON.parse(data);
            columnAlignment = jsonData.columnAlignment;
            footerColumn = jsonData.footerColumn;
            addColumInfo = jsonData.AdditionalColumnProperties;
            scrollFlag = jsonData.scrollFlag;
            chartColumn = jsonData.chartColumns;
            mapColumn = jsonData.mapColumn;
            pieChartColumn= jsonData.PieChartColumn;
            columnTitle = jsonData.columnTitle;
            groupRowsFlag = jsonData.GroupRowsFlag;
            predefineSearch = jsonData.PredefineSearch;
            hideColumn = jsonData.HideColumn;
            groupRowsColumnArr = jsonData.GroupRowsColumn;
            predefineSearchForRange = jsonData.PredefineSearchForRange;
            rangePredefineSearchFlag = jsonData.RangePredefineSearchFlag;
            defaultSortType = jsonData.PredefineSortOrder;
            columnOrder = jsonData.columnOrder;
            productInfo =  jsonData.ProductInfo;
            rowId  = jsonData.rowId;
            EnableCrud = jsonData.EnableCrud;
            tableDesign =  jsonData.TableDesign;
            ScrollWidth =  jsonData.ScrollWidth;
            FooterSumLocation =jsonData.FooterSumLocation;
            PaginationFlag = jsonData.PaginationFlag;
            EnableChildRows = jsonData.EnableChildRows;
            EnableChildRowsRunTym = jsonData.EnableChildRowsRunTym;
            FilterSessionEnable = jsonData.FilterSessionEnable;
            EnableLiveImgSync = jsonData.EnableLiveImgSync;
            EnableExcelBtn = jsonData.EnableExcelBtn;
            EnableXMLdownload  = jsonData.XMLdownload;
            TableType = jsonData.TableType;
            LiveReportSync = jsonData.LiveReportSync;
            AllowDynamicForm = jsonData.AllowDynamicForm;
            DesignType = jsonData.DesignType;
            OldDesignBtnTitle = jsonData.OldDesignBtnTitle;
            NewDesignBtnTitle = jsonData.NewDesignBtnTitle;
            NameOrgBtn = jsonData.NameOrgBtn;
            NameLastBtn = jsonData.NameLastBtn;
            EnableLastSearchDF = jsonData.EnableLastSearchDF;
            EnableFormOnActionBTN = jsonData.EnableFormOnActionBTN;
            AllowColumnRowMarking = jsonData.AllowColumnRowMarking;
            ColoringType = jsonData.ColoringType;
            ColoringJsonText = jsonData.ColoringJsonText;
            ColumnNameColor=jsonData.ColumnNameColor;
            ColorSettingType = jsonData.ColorSettingType;
            ColorTextMatchKey = jsonData.ColorTextMatchKey;
            EnableSideBar = jsonData.EnableSideBar;
            TableSideBar = jsonData.TableSideBar;
            RouteColumnIndex = jsonData.RouteColumnIndex;
            TabAction = jsonData.TabAction;
            TableSideBar2 = jsonData.TableSideBar2;
            RouteColumnIndex2 = jsonData.RouteColumnIndex2;
            TabAction2 = jsonData.TabAction2;
            SilderDesign = jsonData.SilderDesign;
            EnableOnclickBtn = jsonData.EnableOnclickBtn;
            CustomColumnWidth = jsonData.CustomColumnWidth;
            EnableFilterWidth1 = jsonData.EnableFilterWidth1;

            EnableRowGroupLevel = jsonData.EnableRowGroupLevel;
            RowGroupLevelColumn = jsonData.RowGroupLevelColumn;
            DataGroupingJson = jsonData.DataGroupingJson;
            AllowDataGrouping =jsonData.AllowDataGrouping;
            AllowSearchAfter3Char = jsonData.AllowSearchAfter3Char;
            ColSearchAfter3Char =jsonData.ColSearchAfter3Char;
            COlOrderName = jsonData.columnOrderName;
            PredefinedUpdateName = jsonData.PredefinedUpdateName;
            PredefinedUpdateId = jsonData.PredefinedUpdateId;
            EnableAllUpdates = jsonData.EnableAllUpdates;
            EnableCheckBoxes = jsonData.EnableCheckBoxes;
            SelectPredefinedNames = jsonData.SelectPredefinedNames;
            SaveFilterBTN = jsonData.SaveFilterBTN;
            AllowPDFImport = jsonData.AllowPDFImport; 
            AllowExcelImport = jsonData.AllowExcelImport;
            NotiColumnMarking = jsonData.NotiColumnMarking;
			AllowEnterSearch = jsonData.AllowEnterSearch;

            if( predefineSearch == undefined )
            {
                
            }
            if(groupRowsFlag == '1' || EnableRowGroupLevel == '1'){
                EnablerowGroup = '1';
            }
           
            
            if (EnableRowGroupLevel == '1'){
                EnableRowGroupColumn = RowGroupLevelColumn;
            }
            
            
            if(jsonData.MinFilterWidth != undefined){
                MinFilterWidth = jsonData.MinFilterWidth + 'px';
            }
            if(jsonData.MaxFilterWidth != undefined){
               
                MaxFilterWidth = jsonData.MaxFilterWidth + 'px';
            }
            //console.log(SaveFilterBTN);
            if(SaveFilterBTN){
                
                if( sessionSearch != "noData")
                {
                   
                    var sData = JSON.parse(sessionSearch);
                    predefineSearchFlag = 1;
                    predefineSearch = sData.PredefineSearch;
                   //console.log(sData.PredefineSearch);
                }
                //console.log(sessionsearchVarMulti.length);
                if(sessionsearchVarMulti !== undefined && sessionsearchVarMulti.length > 2)
                {
                   // console.log(typeof sessionsearchVarMulti);
                    var sData = JSON.parse(sessionsearchVarMulti);
                    predefineSearchFlag = 1;
                   
                    predefineSearch = sData[Table_ID]['PredefineSearch'];
                    //console.log(sData[Table_ID]['PredefineSearch']);
                }
         
               
                if( sessionSearchRange != "noData")
                {
                    var sData = JSON.parse(sessionSearchRange);
                    rangePredefineSearchFlag = 1;
                    predefineSearchForRange = sData.PredefineSearchForRange;
                    //console.log(predefineSearchForRange);
                }
                //console.log(predefineSearchForRange);
             
            }
           
            if(jsonData.ExcludeZeroCol != undefined){
                excludeZeroCol = jsonData.ExcludeZeroCol;
            }

          
            if(jsonData.RowsCount != 0){
                rowsCount = parseInt(jsonData.RowsCount);
            }else{
                 rowsCount = 10;
            }
            if(productInfo)
                tableIdPro[Table_ID] = productInfo[0]['RelatedDataTables'];

            if( jsonData.columnTitle)
                proRowDataheader[Table_ID] =  jsonData.columnTitle;
        
                       
            var lab = Table_ID + 'AllowMultipleSelectionColumn';
            window[lab]= jsonData.AllowMultipleSelectionColumn;
            
            multipleSearchSelectorFlag = jsonData.multipleSearchSelectorFlag;
            conArray['graphSearchFlag_'+Table_ID] = jsonData.searchFlag; // for graph check 
         
            var tHead = document.getElementById(Table_ID +"_thead");
            if(tHead){
                $.each(jsonData.columnTitle, function (i, title) {
                    var titleValue = title.trim() +'/'+jsonData.columnDb[i].trim();
                    var align  =  'style="float:left;"';
                    if(columnAlignment.includes(i)){
                        align = 'style="float: right;"';
                    }
                    $("#"+ Table_ID +"_thead tr").append("<th data-dbcolumn="+jsonData.columnDb[i].trim()+" id = '"+title.trim()+"'>" + '<span class="filter-datatable-label" '+align+' >'+title.trim() +'</span>'+ "</th>");
                });
            }else{
                $.each(jsonData.columnTitle, function (i, title) {
                    var titleValue = title.trim() +'/'+jsonData.columnDb[i].trim();
                    var align  =  'style="float: left;"';
                    if(columnAlignment.includes(i)){
                        align = 'style="float: right;"';
                    }
                    if(title != 'box')   {
                         $("#" + Table_ID + " thead tr").append("<th data-dbcolumn="+jsonData.columnDb[i].trim()+" id = '"+title.trim()+"'>" +' <i class="coluumnName fa fa-filter" id="'+Table_ID+'coluumnName'+title.trim()+'" aria-hidden="true"></i>' +'<span class="filter-datatable-label" '+align+'>'+title.trim() +'</span>'+ "</th>");
                    }else{
                     $("#" + Table_ID + " thead tr").append("<th data-dbcolumn="+jsonData.columnDb[i].trim()+" id = '"+title.trim()+"'></th>");
                    }
                });

            }
            var tFoot = document.getElementById( Table_ID + "_tfoot ");
            if(tFoot){
                $.each(jsonData.columnTitle, function (i, title) {
                    $("#" + Table_ID + "_tfoot tr").append("<th></th>");
                });
               
            }else{
                
                $.each(jsonData.columnTitle, function (i, title) {
                  
                    if(AllowDataGrouping == '1'){
                        var flag = 0;
                        $.each(DataGroupingJson, function (JKey, JValue) {
                            
                            if(i == JValue.start ){
                                flag = 1;
                               
                                $("#" + Table_ID + " tfoot tr").append('<th style="border-left: 2px solid;" ></th>');
                            }
                            if(i == JValue.End ){
                                flag = 1;
                                $("#" + Table_ID + " tfoot tr").append('<th style="border-right: 2px solid;" ></th>');
                            }

                            // if(i == JValue.start ){
                            //     flag = 1;
                               
                            //     $("#" + Table_ID + " tfoot tr").append('<th style="box-shadow:-2px 0px 0px 0px black;" ></th>');
                            // }
                            // if(i == JValue.End ){
                            //     flag = 1;
                            //     $("#" + Table_ID + " tfoot tr").append('<th style="box-shadow: 2px 0px 0px 0px black;" ></th>');
                            // }
                         
                        });
                        if(flag == 0 ){
                            $("#" + Table_ID + " tfoot tr").append("<th></th>");
                        }
                    }else{
                        $("#" + Table_ID + " tfoot tr").append("<th></th>");
                    }
                });
                
            }
                      
            if(jsonData.PredefineSort != '' && jsonData.PredefineSort != undefined){
                sort = jsonData.PredefineSort  ;
                //defaultSortType = PredefineSortOrder;
                predefineSearchFlag = 1;
            } 
            rowGroupId = sort;
            
            if (sessionSort != 'noData' && sessionSort != undefined) {
                //console.log(sessionSort);
                defaultSortType = sessionSort.PredefineSort;
                sort =sessionSort.PredefineSortIndex;

            }
            if (EnableRowGroupLevel == '1'){
                //SortLevels
                $.each(EnableRowGroupColumn , function (k, v) {
                    TempSortLevels = [v,'asc'] ; 
                    SortLevels.push(TempSortLevels);
                });
                
            }else{
                if (EnableAllUpdates == '1'){
                    SortLevels = [[1, defaultSortType]];
                }else{
                    SortLevels = [[sort, defaultSortType]];
                }
               
            }
            //console.log("tester over here ");
            //console.log(SortLevels);
            

            if(groupRowsFlag == 1){
                
            console.log(jsonData.GroupRowsColumn);
            var GroupRowsColumnCount = 1;
               $.each(jsonData.GroupRowsColumn, function (k, v) {
                   
                    $.each(jsonData.columnTitle, function (colk, colv) {
                       
                        if(v == colv ){
                            if(GroupRowsColumnCount == 1){

                                groupRowsColumn =  colk;
                                if(predefineSearchFlag != 1){
                                    sort = colk;
                                }
                            }
                            temp[colk] = colv ;
                            return false;
                        }
                    });
                    GroupRowsColumnCount = GroupRowsColumnCount+1;
                   
                });
               
                EnableRowGroupColumn = groupRowsColumn;
                
            }
         
              
            $.each(mapColumn, function (mapKey, mapValue) {
                if(mapValue.label == "code") {
                    mapArray[mapValue.label] = parseInt(mapKey);
                    mapLabel[mapValue.label] = mapValue.field;
                    mapLabel['title'] = mapValue.title;
                }
                if(mapValue.label == "z") {
                    mapArray[mapValue.label] = parseInt(mapKey);
                    mapLabel[mapValue.label] = mapValue.field;
                    mapLabel['title'] = mapValue.title;
                }
                if(mapValue.label == "y") {
                    mapArrayNew.push(parseInt(mapKey));
                    mapLabelNew.push(mapValue.field);
                    mapDisplayLabelNew.push(columnTitle[mapKey]);
                   
                   
                    //mapLabel['title'] = mapValue.title;
                }
                
            });
           
            $.each(pieChartColumn, function (pieChartKey, pieChartValue) {

                    pKey = parseInt(pieChartKey);
                    if(isNaN(pKey))
                    {
                         pKey = pieChartKey;
                    }
                    else{
                        pKey = parseInt(pieChartKey);
                    }
                    if(pieChartValue.drilldown == undefined){
                        if(pKey == 'PieChartType')
                        {
                            pieChartLabel['type'] = pieChartValue.type;
                        }else if(pKey == 'PieChartLabel')
                        {
                            pieChartLabel['label'] = pieChartValue.label;
                        }
                        else{
                            pieChartArray[pieChartValue.field] = pKey;
                        }

                        pieChartLabel['calType'] = pieChartValue.calType;
                    } else if(pieChartValue.drilldown != undefined){
                        pieChartLabelDrillDown['drilldown'] = pieChartValue.drilldown;
                        
                        if(pKey == 'PieChartType')
                        {
                            pieChartLabelDrillDown['type'] = pieChartValue.type;
                        }else if(pKey == 'PieChartLabel')
                        {
                            pieChartLabelDrillDown['label'] = pieChartValue.label;
                        }
                        else{
                            pieChartArrayDrillDown[pieChartValue.field] = pKey;
                        }
                    }
            });
            
        }
        
        if(columnAxisArray.X)
        {
            sortingValue = columnAxisArray.X;
        }else{
            sortingValue =  sort;
        }

        setTimeout(function () {
            $("#" + Table_ID + " thead tr").clone(true).appendTo( "#" + Table_ID + " thead" );
            $("#" + Table_ID + " thead tr:eq(1) th").each( function (i) {

           
            if(EnableFilterWidth1){
               
                if( CustomColumnWidth.hasOwnProperty(i)){
                    MinFilterWidth =  CustomColumnWidth[i]+'px';
                    $(this).css('width', CustomColumnWidth[i]+'px');
                   
                }else{
                    MinFilterWidth = '' ;
                    $(this).css('width', '150px');
                } 
            }else{
                if(AllowDataGrouping == '1'){
                    
                    $.each(DataGroupingJson, function (JKey, JValue) {
                        
                        $('th:eq('+JValue.start+')').css('border-left', '2px solid');
                        $('thead tr:eq(1) th:eq('+JValue.start+')').css('border-left', '2px solid');
                        $('th:eq('+JValue.End+')').css('border-right', '2px solid');
                        $('thead tr:eq(1) th:eq('+JValue.End+')').css('border-right', '2px solid');
                        // $('th:eq('+JValue.start+')').css('box-shadow', '-2px 0px 0px 0px black');
                        // $('thead tr:eq(1) th:eq('+JValue.start+')').css('box-shadow', '-2px 0px 0px 0px black');
                        // $('th:eq('+JValue.End+')').css('box-shadow', '2px 0px 0px 0px black');
                        // $('thead tr:eq(1) th:eq('+JValue.End+')').css('box-shadow', '2px 0px 0px 0px black');
                       
                       
                    });
                }
                $(this).css('width', '150px');
                
               
            }
            var title = $(this).text().split('/');
            var titleDbColumn = $(this).attr("data-dbcolumn");
            var titleId = $(this).attr("id");
           
           
            if( (titleId != 'box' && titleDbColumn != 'checkbox') && titleId != undefined ){
                titleId = titleId.replace('#' , '_');
                titleId = titleId.replace('%' , '_');
            
                
                if (title[0].toLowerCase() != 'action' && title[0].toLowerCase() != 'actions') {

                    if (searchValue.trim() != '' && searchValue.trim() != null) {
                        var searchValueJson = JSON.parse(searchValue);
                        var inpputValue = '';
                        $.each(searchValueJson, function (key, value) {
                            if(key == titleDbColumn) {
                                inpputValue = 'value="'+value +'"';
                            }
                        });
                    }
                
                
                    if( predefineSearch != undefined && predefineSearch[i] != null)
                    {
                        var defValue = predefineSearch[i].sSearch;
                        var style = '';
                    
                        if(!defValue){
                            style =' style="display: none;"';
                        }
                    
                        $(this).html('<div id="mainDiv" style="width:'+MaxFilterWidth+'; min-width:'+MinFilterWidth+';"  ><div class="input-group" id ="mainS_'+Table_ID+titleId +'"><input  style="padding-right: 16px;border: none;" id ="test" name="test" type="text" '+inpputValue+' class="form-control form-control-sm search_by" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="Search ' + '" value="'+ defValue +'" /><span class="close-icon" '+style+'>x</span></div><div class="input-group"  id ="fromTo_'+Table_ID+titleId +'" style="display:none" ><div style="width: 100px;"><input id ="'+Table_ID+"_"+titleId +'fromRange" value="" type="text" '+inpputValue+' style="width: 50px; height: 37px;" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="from" /><input id ="'+Table_ID+"_"+titleId +'toRange" type="text" '+inpputValue+' style="width: 50px; height: 37px;" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="To" /></div><span class="close-icon" id="close'+Table_ID+"_"+titleId +'" style="display: none;">x</span></div><div class="input-group" id = "exc_div'+Table_ID+titleId+'" style="display: none;"  ><input  id = "exc_'+Table_ID+titleId +'"  type="text" '+inpputValue+' class="form-control form-control-sm search_by exc" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder=" Exclude ' + title[0] + '"/><span class="close-icon" style="display: none;">x</span></div><div id ="searchDiv_'+Table_ID+titleId +'" style = "display:none; position: relative;"><span class="close-icon-select" id="close'+Table_ID+titleId +'"  style = "display:none;" >x</span></div></div>');
                    }else if(predefineSearchForRange != undefined && predefineSearchForRange[i] != null){
                        var defValueFrom = predefineSearchForRange[i].from;
                        var defValueTo = predefineSearchForRange[i].to;
                    
                        var style = '';
                    
                        if(!defValueFrom && !defValueTo){
                            style =' style="display: none;"';
                        }
                        $(this).html('<div id="mainDiv" style="width:'+MaxFilterWidth+'; min-width:'+MinFilterWidth+';"   ><div class="input-group" id ="mainS_'+Table_ID+titleId +'"><input  style="padding-right: 16px;border: none;" id ="test" name="test" type="text" '+inpputValue+' class="form-control form-control-sm search_by" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="Search ' + '" value="" /><span class="close-icon" style="display: none;">x</span></div><div class="input-group" id ="fromTo_'+Table_ID+titleId +'" style="display:none" ><div style="width: 100px;"><input id ="'+Table_ID+"_"+titleId +'fromRange" value="'+defValueFrom+'" type="text" '+inpputValue+' style="width: 50px; height: 37px;" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="from" /><input id ="'+Table_ID+"_"+titleId +'toRange"  value="'+defValueTo+'" type="text" '+inpputValue+' style="width: 50px; height: 37px;" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="To" /></div><span class="close-icon" id="close'+Table_ID+"_"+titleId +'" '+style+'>x</span></div><div class="input-group" id = "exc_div'+Table_ID+titleId+'" style="display: none;"  ><input  id = "exc_'+Table_ID+titleId +'"  type="text" '+inpputValue+' class="form-control form-control-sm search_by exc" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder=" Exclude ' + title[0] + '"/><span class="close-icon" style="display: none;">x</span></div><div id ="searchDiv_'+Table_ID+titleId +'" style = "display:none; position: relative;"><span class="close-icon-select" id="close'+Table_ID+titleId +'"  style = "display:none;">x</span></div></div>');
                    
                    }
                    else{
                        style =' style="display: none;"';
                        $(this).html('<div id="mainDiv" style="width:'+MaxFilterWidth+'; min-width:'+MinFilterWidth+';" ><div class="input-group" id ="mainS_'+Table_ID+titleId +'"><input  style="padding-right: 16px;border: none;" id ="test" name="test" type="text" '+inpputValue+' class="form-control form-control-sm search_by" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="Search ' + '" value="" /><span class="close-icon" '+style+'>x</span></div><div class="input-group" id ="fromTo_'+Table_ID+titleId +'" style="display:none" ><div style="width: 100px;"><input id ="'+Table_ID+"_"+titleId +'fromRange" value="" type="text" '+inpputValue+' style="width: 50px; height: 37px;" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="from" /><input id ="'+Table_ID+"_"+titleId +'toRange" type="text" '+inpputValue+' style="width: 50px; height: 37px;" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="To" /></div><span class="close-icon" id="close'+Table_ID+"_"+titleId +'" style="display: none;">x</span></div><div class="input-group" id = "exc_div'+Table_ID+titleId+'" style="display: none;"  ><input  id = "exc_'+Table_ID+titleId +'"  type="text" '+inpputValue+' class="form-control form-control-sm search_by exc" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder=" Exclude ' + title[0] + '"/><span class="close-icon" style="display: none;">x</span></div><div id ="searchDiv_'+Table_ID+titleId +'" style = "display:none; position: relative;"><span class="close-icon-select" id="close'+Table_ID+titleId +'"  style = "display:none;">x</span></div></div>');
                    }
                    

                } else {
                    $(this).html('');
                }
            }
           
            var tempVal = '';
                    // Start for Search Part 
            $( ".close-icon", this).on( 'click', function () {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                //console.log(keycode);
                var mainTable = $(this).closest('div').attr('id');
                $('#'+mainTable).find('ul').empty();
                $('#'+mainTable).find(':input').val('');
                searchFlag = 0;

                $(this).hide(); // hide the X button 
                
                if(tableIds != '')
                {
                    tableIds =JSON.stringify(tableIds);
                    //console.log(tableIds);
                    tableIds = JSON.parse(tableIds);
                    if(tableIds != "[]")
                    {
                        $.each(JSON.parse(tableIds) , function(idK , idV){
                            var searchVal  = ''; 
                        //console.log(Table_ID); 
                        //console.log(idK);
                        idV = idV.replace('#' , '_');
                        idV = idV.replace('%' , '_');
                      
                        if(Table_ID != idK){
                            //console.log(idV);
                            indx = 0;
                            var table1 = $('#'+idK).DataTable();
                            table1.columns( { search:'applied' }).every(function() {
                                 if(this.header().id == idV){
                                    searchVal  = ''; 
                                   
                                    if(typeof $("#mainS_"+idK+idV+" input").val() !== 'undefined' || $("#mainS_"+idK+idV+" input").val() != ''){
                                        searchVal = $("#mainS_"+idK+idV+" input").val();
                                    }
                                    indx = ( this ).index();
                                    //console.log( indx);
                                    if( searchVal == undefined)
                                        searchVal  = ''; 
                                    //console.log( searchVal);
                                    false;
                                  }
                                });
                            table1
                            .column(indx)
                            .search(searchVal, true, false )
                            .draw();

                        }else{
                                 DataTable
                                .column(i)
                                .search('', true, false )
                                .draw();
                            }
                            

                        });

                    }
                    else
                    {
                        var FilterName  = Table_ID+'_FilterData_'+DataTable.column(i).header().textContent.trim() ;
                                              
                        $('#Li_'+FilterName).remove();
                        const element1 = document.querySelectorAll('[id^="Li_"]');
                        
                        if(element1.length == 0){
                            $('#'+Table_ID+'_FilterDataDiv').hide();
                        }
                         DataTable
                        .column(i)
                        .search('', true, false )
                        .draw();
                    }
               
                   

                }else
                {
                    var FilterName  = Table_ID+'_FilterData_'+DataTable.column(i).header().textContent.trim() ;
                                              
                    $('#Li_'+FilterName).remove();
                    const element1 = document.querySelectorAll('[id^="Li_"]');
                    
                    if(element1.length == 0){
                        $('#'+Table_ID+'_FilterDataDiv').hide();
                    }
                    
                     DataTable
                    .column(i)
                    .search('', true, false )
                    .draw();
                }
               
            });

            $( ".close-icon-select", this).on( 'click', function () {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                //console.log(keycode);
                var mainTable = $(this).closest('div').attr('id');
                //$('#'+mainTable).find('ul').empty();
                console.log(mainTable); 
                $('#'+mainTable).find('li.select2-selection__choice').remove();
                $('#'+mainTable).find(':input').val('');
                searchFlag = 0;
                
                $(this).hide();
                var FilterName  = Table_ID+'_FilterData_'+DataTable.column(i).header().textContent.trim() ;
                                              
                $('#Li_'+FilterName).remove();
                const element1 = document.querySelectorAll('[id^="Li_"]');
                
                if(element1.length == 0){
                    $('#'+Table_ID+'_FilterDataDiv').hide();
                }
                
                DataTable
                    .column(i)
                    .search('', true, false )
                    .draw();
            });

            $(".exc" , this).on('keyup change', function (e){
                
                var colValue = this.value;
                var keyword = '';
                var keycode = (event.keyCode ? event.keyCode : event.which);
                //console.log(keycode);
                if(this.value !== ""){
                    $(this).next().show();
                }else{
                    $(this).next().hide();
                }
                if(conArray['graphSearchFlag_'+Table_ID] == '1'){   
                    if(keycode == '13' || keycode == '221')
                    {
                            searchFlag = 1;
                            if(this.value != ''){
                                keyword = '^(?!.*('+colValue+')).*$';
                            }
                            DataTable
                                .column(i)
                                .search(keyword, true, false )
                                .draw();
                    }
                    
                    if ( DataTable.column(i).search() !== this.value ) {
                       
                        searchFlag = 2;
                        if(this.value != ''){
                                keyword = '^(?!.*('+colValue+')).*$';
                            }
                            DataTable
                                .column(i)
                                .search(keyword, true, false )
                                .draw();
                  
                    }   
                }else{
                    if ( DataTable.column(i).search() !== this.value ) {
                        
                        searchFlag = 0;
                        if(this.value != ''){
                                keyword = '^(?!.*('+colValue+')).*$';
                            }
                            DataTable
                                .column(i)
                                .search(keyword, true, false )
                                .draw();
                            var FilterName  = Table_ID+'_FilterData_'+DataTable.column(i).header().textContent.trim() ;
                                    
                            if(document.getElementById(FilterName) === null){
                                $('#'+Table_ID+'_FilterDataDiv').show();
                               
                                $("<li  id ='Li_"+FilterName+"' ><a class='FilterData' id ='"+FilterName+"'  data-tableId='" + Table_ID + "'>"+DataTable.column(i).header().textContent+" =  "+this.value+"</a></li>").insertAfter('#'+Table_ID+'_FilterData');
                            }else{
                                if(this.value === ''){
                                   
                                    $('#Li_'+FilterName).remove();
                                    const element1 = document.querySelectorAll('[id^="Li_"]');     
                                    if(element1.length == 0){
                                        $('#'+Table_ID+'_FilterDataDiv').hide();
                                    }
                                }else{
                                    $('#'+Table_ID+'_FilterDataDiv').show();
                                   
                                    document.getElementById(FilterName).innerText  = DataTable.column(i).header().textContent+" =  "+this.value;
                                }
                            }
                    } 
                }
            });
           
            $( "#test" , this ).on( 'keyup change', function () {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                console.log(keycode);
                if(this.value !== ""){
                    $(this).next().show();
                }else{
                    $(this).next().hide();
                }
               
                var objtab = JSON.parse(tableLinked);
                if(setGlobalSearch == 'outerSearch'){
                    var ColInd = i;
                    var table1_ = $('#'+Table_ID).DataTable();
                    var click  = 'yes';
                    //var d = table1_.order();
                    var tempId = '';
                         //console.log(groupRowsColumn);
                    
                  
                        var api = table1_;
                        var rows = api.rows( {page:'current'} ).nodes();
                        var last=null;
                        var i1 = 0 ;
                        var group1 = '';
                        var tempArr = [];
                       
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
                        var Maindata = table1_.rows().data();
                        api.column(groupRowsColumn, {page:'current'} ).data().each( function ( group, i ) {
                            if ( last !== group ) {
                               

                                
                                var mainArr = {};
                                var customSum = {};
                                var valArr = {};
                               
                                if( i != 0)
                                {
                                    
                                    $.each(footerColumn, function( index, value ) {
                                    
                                        
                                        var columnTotal = 0;
                                        if(value['perform_custom_sum'] == 0 || value['footer_sum_only'] !== undefined)
                                        {   
                                                for (let index1 = i1; index1 < i; index1++) {
                                                   
                                                   columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                                }
                                            
                                            mainArr[value['column_name']] = columnTotal;
                                            if(value.decimal != undefined)
                                            {
                                                 valArr[index]   = columnTotal.toFixed(value.decimal).toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                                                
                                            }else{
                                                  valArr[index] = columnTotal.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            
                                            }
                                          
                                        }
                                        else if(value['perform_custom_sum'] == 1){
                                            
                                            for (let index1 = i1; index1 < i; index1++) {

                                               
                                                columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                             }
                                            
                                            mainArr[value['column_name']] = columnTotal;
                                            customSum[index] = value['custom_sum'];
                                        }
                                    });
                                    
                                   
                                    $.each(customSum, function( index, value ){
                                      
                                      
                                        var formula = value;
                                       
                                        $.each(mainArr, function( indexs, values ){
                                           
                                            formula = formula.replace(indexs, values);
                                        });
                                       
                                        formula = eval(formula);
                                       
                                        if(formula != '' && formula != undefined ){
                                            formula = formula.toFixed(2);
                                            formula = formula.split('.').join(',');
                                            //formula = formula.replace(/(\d)(?=(\d{2})+(?!\d))/g, '$1,');    
                                        }
            
                                        valArr[index]=formula;
                                    });   
                                   
                                    valArr['rowKeys'] = i;
                                    valArr['rowKeye'] = i1;
                                    valArr['rowgroup'] = last ;
                                     
                                }
                               
                               
                                group1 = group ;
                               
                                   
                                if(Object.keys(valArr).length >0) {
                                    tempArr.push(valArr);
                                } 
                                i1=i;
                                
                               // delete tempArr;
                                last = group;
                            }
                        } );
                        
                        if(rows.count())
                        {
                            
                          
                            var mainArr = {};
                            var customSum = {};
                            var valArr = {};
                           
                            $.each(footerColumn, function( index, value ) {
                            
                                
                                var columnTotal = 0;
                                if(value['perform_custom_sum'] == 0 || value['footer_sum_only'] !== undefined)
                                {   
                                        for (let index1 = i1; index1 < rows.count(); index1++) {
                                            columnTotal = columnTotal + intVal(rows.data()[index1][index]);
                                        }
                                    
                                    mainArr[value['column_name']] = columnTotal;
                                    if(value.decimal != undefined)
                                    {
                                            valArr[index]   = columnTotal.toFixed(value.decimal).toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                                        
                                    }else{
                                            valArr[index] = columnTotal.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    
                                    }
                                    
                                }
                                else if(value['perform_custom_sum'] == 1){
                                    
                                    for (let index1 = i1; index1 <  rows.count(); index1++) {
                                        columnTotal = columnTotal + intVal(rows.data()[index1][index]);
                                        }
                                    
                                    mainArr[value['column_name']] = columnTotal;
                                    customSum[index] = value['custom_sum'];
                                }
                            });
                            
                            
                            $.each(customSum, function( index, value ){
                                
                                
                                var formula = value;
                                
                                $.each(mainArr, function( indexs, values ){
                                    
                                    formula = formula.replace(indexs, values);
                                });
                                
                                formula = eval(formula);
                                
                                if(formula != '' && formula != undefined ){
                                    formula = formula.toFixed(2);
                                    formula = formula.split('.').join(',');
                                    //formula = formula.replace(/(\d)(?=(\d{2})+(?!\d))/g, '$1,');    
                                }
    
                                valArr[index]=formula;
                            });   
                            valArr['rowKeys'] =  rows.count();
                            valArr['rowKeye'] = i1;
                            valArr['rowgroup'] = group1 ;
                                  
                            if(Object.keys(valArr).length >0) {
                                    tempArr.push(valArr);
                                }  
                            
                        } 
                        var searchValue = (this.value);
                        
                        //var newtemp = [];
                        var rowId = 0;
                        var Maindata =  table1_.rows().data();
                        var newTempArr = table1_.rows().indexes();
                        
                       //console.log(newTempArr);
                       //console.log(tempArr);
                        for (let index = 0; index < tempArr.length; index++) {
                            var  compval = tempArr[index][ColInd].split(".").join('');
                            if(compval.includes(searchValue) )
                            {
                                var tempStart = tempArr[index]['rowKeye'];
                                var tempEnd = tempArr[index]['rowKeys'];
                                
                                //console.log(tempArr[index]);
                                for (let index1 = tempStart; index1 < tempEnd ; index1++) {
                                    var curData = Maindata[index1];
                                   
                                    //table1_.row(newTempArr[rowId]).data(curData).invalidate();
                                    //rowId++;
                                   // table1_.row(rowId).remove();
                                   
                                  
                                }
                               
                            }
                            
                        }
                        table1_.draw();
                        //delete tempArr;
                       // tempArr =  newtemp;
                        // //console.log(tempArr);
                        
                        // var j  =0;
                        // var rowId = 0;
                        // var Maindata =  table1_.rows().data();
                        // var newTempArr = table1_.rows().indexes();
                       
                        // api.column(groupRowsColumn, {page:'current'} ).data().each( function ( group, i ) {
                        //     if ( last !== group ) {

                        //        //console.log(tempArr[j]);
                        //         var tempStart = tempArr[j]['rowKeye'];
                        //         var tempEnd = tempArr[j]['rowKeys'];
                        //         var count = 0;
                        //         var collapsed = !!collapsedGroups[group];
                        //         tempArr[j]['countPos'] = rowId;
                        //         for (let index = tempStart; index < tempEnd ; index++) {
                        //             var curData = Maindata[index];
                                    
                        //             table1_.row(newTempArr[rowId]).data(curData).invalidate();
                        //             // table1_.row(rowId)
                        //             // .node().style.display = collapsed ? 'none' : '';
                        //             count++;
                        //             rowId++;
                                   
                                  
                        //         }
                        //         tempArr[j]['count'] = count;
                                
                        //         j = j +1;
                                    
                        //         last = group;
                                       
                        //     }
                        // } );
                       
                       
                    
                }else{
                    var tableIdsArr = [];
                   
                    if(tableLinked !== '' && typeof objtab[Table_ID] !=='undefined' )
                    {
                        var searchValue = (this.value);
                        $.each(objtab[Table_ID], function( po, vals ){
                        
                        if(typeof vals['rlink'] !== 'undefined')
                        {
                            tableIdsArr = [];
                            tableIdsArr[0] =  vals['linkedArr'];
                            commonField = vals['commonField'];
                            //console.log(vals['rlink']);
                        }else{
                            tableIdsArr[0] = Table_ID;
                            tableIdsArr[1] = vals['linkedArr'];
                            commonField = vals['commonField'];
                        }
                    
                        
                    // var index = DataTable.columns().names().indexOf( 'Year' );
                        //console.log(tableIdsArr);
                        for (var k = 0; k < tableIdsArr.length; k++) {
                            //console.log(vals['rlink']);
                            if(Table_ID == tableIdsArr[k] && typeof vals['rlink'] === 'undefined')
                            {
                                
                                if(conArray['graphSearchFlag_'+Table_ID] == '1'){
                                    if(keycode == '13' || keycode == '221')
                                    {
                                            searchFlag = 1;
                                            DataTable
                                            .column(i)
                                            .search( tempVal, true, false )
                                            .draw();
                                    }
                                    if ( DataTable.column(i).search() !== searchValue ) {
                                        
                                        tempVal = searchValue;
                                        searchFlag = 2;
                                        DataTable
                                            .column(i)
                                            .search( tempVal, true, false )
                                            .draw();
                                    } 
                                    
                                }else{
                                
                                    if ( DataTable.column(i).search() !== searchValue ) {
                                        
                                        searchFlag = 0;
                                        DataTable
                                            .column(i)
                                            .search(searchValue, true, false )
                                            .draw();
                                    } 
                                }
                            }else 
                            {
                                
                            
                            var table1 = $('#'+tableIdsArr[k]).DataTable();

                                var indx = 0;
                                var SearchedVal = '';
                                table1.columns( { search:'applied' }).every(function() {

                                
                                    //console.log( this.header().id);
                                    
                                    
                                    if(this.header().id == commonField){
                                    
                                        //console.log( this.header());
                                        indx = ( this ).index();
                                        //console.log( indx);
                                    

                                        false;
                                    }
                                });
                                DataTable.columns( { search:'applied' }).every(function(cell) {

                                    //console.log(DataTable.column(cell, {search:'applied'}).data());
                                    //console.log( this.header().id);
                                    //console.log(cell);
                                    
                                    if(this.header().id == commonField){
                                    
                                        //console.log(vals['rlink']);
                                    

                                            //console.log(this.data());
                                        
                                                $.each(this.data() , function (cell, i){
                                                    //console.log(i);
                                                    SearchedVal = SearchedVal+'|'+i;
                                                } );

                                            tempVal =  searchValue = SearchedVal;                          
                                        

                                        false;
                                    }
                                });
                                if(SearchedVal != ''){
                                    SearchedVal  = SearchedVal.replace(/^\|+|\|+$/g, '');
                                    tempVal =  searchValue = SearchedVal;    
                                }else{
                                    SearchedVal  = ' ';
                                    tempVal =  searchValue = SearchedVal; 
                                }
                                //console.log( SearchedVal);
                                
                                    if(table1.column(indx).header().id == commonField){
                                    
                                        //console.log('here');
                                        if(conArray['graphSearchFlag_'+tableIdsArr[k]] == '1'){
                                            if(keycode == '13' || keycode == '221')
                                            {
                                                    searchFlag = 1;
                                                    table1
                                                    .column(indx)
                                                    .search( tempVal, true, false )
                                                    .draw();
                                            }
                                            if ( DataTable.column(indx).search() !== searchValue ) {
                                                
                                                tempVal = searchValue;
                                                searchFlag = 2;
                                                table1
                                                    .column(indx)
                                                    .search( tempVal, true, false )
                                                    .draw();
                                            } 
                                            
                                        }else{

                                                searchFlag = 0;
                                                table1
                                                    .column(indx)
                                                    .search(searchValue, true, false )
                                                    .draw();
                                            
                                        }

                                    }
                                }
                            


                    
                    }
                });
                    }else{
                        
                        if(conArray['graphSearchFlag_'+Table_ID] == '1'){
                            if(keycode == '13' || keycode == '221')
                            {
                                    searchFlag = 1;
                                    DataTable
                                    .column(i)
                                    .search( tempVal, true, false )
                                    .draw();
                            }
                            if ( DataTable.column(i).search() !== this.value ) {
                                
                                tempVal = this.value;
                                searchFlag = 2;
                                DataTable
                                    .column(i)
                                    .search( tempVal, true, false )
                                    .draw();
                            } 
                            
                        }else{
                             
                            if(AllowSearchAfter3Char && ColSearchAfter3Char.includes(i)){
                                if ( this.value.length >= 3) { 
                                    if ( DataTable.column(i).search() !== this.value ) {
                                    
                                        searchFlag = 0;
                                        DataTable
                                            .column(i)
                                            .search(this.value, true, false )
                                            .draw();
                                    }
                                }else{
                                    if ( DataTable.column(i).search() !== this.value ) {
                                    
                                        searchFlag = 0;
                                        DataTable
                                            .column(i)
                                            .search('', true, false )
                                            .draw();
                                    }
                                }
                            }else{
                                if ( DataTable.column(i).search() !== this.value ) {
                                    
									
									searchFlag = 0;
									if(AllowEnterSearch == 1){
										
										if(keycode == 13){
											
											console.log("jhjbhjbhjbhjjjjjjjjiiiiiiiiiibvjhbsdhjvbsdhjb");
											 console.log(keycode);
											console.log(this.value);
											console.log(AllowEnterSearch);
											
											
											DataTable
											.column(i)
											.search(this.value  ,true, false )
											.draw();
										}
									}else{
										 
										DataTable
											.column(i)
											.search(this.value  ,true, false )
											.draw();
									}
                                   var FilterName  = Table_ID+'_FilterData_'+DataTable.column(i).header().textContent.trim();
                                   if(document.getElementById(FilterName) === null){
                                            // $('#'+Table_ID+'_FilterData')
                                            //         .append("<li id ='"+FilterName+"'><a class='FilterData'  data-tableId='" + Table_ID + "'></a>"+DataTable.column(i).header().textContent+" =  "+this.value+"</li>");
                                            $('#'+Table_ID+'_FilterDataDiv').show();
                                           
                                            $("<li  id ='Li_"+FilterName+"' ><a class='FilterData' id ='"+FilterName+"'  data-tableId='" + Table_ID + "'>"+DataTable.column(i).header().textContent+" =  "+this.value+"</a></li>").insertAfter('#'+Table_ID+'_FilterData');
                                   }else{
                                            if(this.value === '' || this.value == null){

                                               
                                                $('#Li_'+FilterName).remove();
                                                const element1 = document.querySelectorAll('[id^="Li_"]');
                                               
                                                if(element1.length == 0){
                                                    $('#'+Table_ID+'_FilterDataDiv').hide();
                                                }
                                                
                                                

                                            }else{
                                                $('#'+Table_ID+'_FilterDataDiv').show();
                                                document.getElementById(FilterName).innerText  = DataTable.column(i).header().textContent+" =  "+this.value;
                                            }
                                        }
                                } 
                            }
                        }
                    }
                }
                    
            });
            $( 'input', this ).on( 'keyup change', function (e) {
               
				  var keycode = (event.keyCode ? event.keyCode : event.which);
                    console.log("Search with Enter key, range");
                    console.log(keycode);
                    console.log(AllowEnterSearch);
                    
                    if(AllowEnterSearch == 1){
                        console.log("Allow Enter Search is active...");		
                        if(keycode != 13){
                            console.log("Not Enter, do nothing...");
                            return;
                        }
                    }
                    console.log("Continue with Code");
                    var getId = e.target.id;
                    var tab = '';
                    if(getId.includes("fromRange") || getId.includes("toRange"))
                    {
                       
                        if(getId.includes("fromRange"))
                        {
                            var fromCol = getId.split('fromRange');
                        }
                        if(getId.includes("toRange"))
                        {
                            var toCol = getId.split('toRange');
                            
                            toCol =    toCol.slice(0, -1);
                            
                        }
                        //alert(getId); 
                       
                        if(typeof fromCol !== 'undefined' )
                        {
                            tab = fromCol[0] ;
                        } else if (typeof toCol !==  'undefined' )
                        {
                            tab = toCol[0];
                        }
                    //     alert($('#Table_1_RollingPeriodfromRange').val());
                    //    alert( $('#'+tab+'toRange').val());
                    ColumnIndex = i ;
                   
                  
                    var colNameNew = $(this).attr("data-columnname");
                    var fromName = 'Table_1_'+colNameNew+'fromRange' ;
                    var toName  = 'Table_1_'+colNameNew+'toRange';
                   
                    if( $('#'+fromName).val() !== "" || $('#'+toName).val() !== ""){
                        $('#close'+Table_ID+'_'+colNameNew).show();
                    }else{
                        $('#close'+Table_ID+'_'+colNameNew).hide();
                    }
                    //var tempArr = ['Table_1_Kategori'];
                   // $.fn.dataTable.ext.search.pop();
                   //console.log(rangePredefineSearchFlag);
                   if(rangePredefineSearchFlag)
                   {
                    //console.log(predefineSearchForRange);
                       $.each(predefineSearchForRange , function(key, value){
                           var k = '';
                           var title = DataTable.column(key).header();
                           var tempTitle = $(title).text();
                           tempTitle = tempTitle.trim();
                            // if(tempTitle.includes('Normal'))  {
                            //     tempTitle =$(title).children('span').text(); 
                            // }
                          // tab = Table_ID+"_"+tempTitle;
                           ColumnIndexRange = key ;
                           tabRange = Table_ID+"_"+tempTitle ;
                            //console.log(key);
                           $.fn.dataTable.ext.search.push(
                               function( settings, data, dataIndex ) {
                               
                                  var tabID = tabRange.split('_');
                                  tabID = tabID[0]+'_'+tabID[1];
                                 
                                  if(settings.nTable.id == tabID){
                                      var min = parseInt( $('#'+tabRange+'fromRange').val(), 10 ) ;
                                      var max = parseInt( $('#'+tabRange+'toRange').val(), 10 ) ;
                                   
                                      var temp_data = data[key].split(' ').join('');
                                      var cntComma = 0;
                                      var cntDot = 0;
                                      var str = temp_data;
       
                                      for (var t = 0;  t <= str.length; t++) {
                                          
                                          if (str[t] === ".") 
                                           {
                                               cntDot = t;
                                           }
                                           else if(str[t] === ".")
                                           {
                                               cntComma = t;
                                           }
                                      }
                                     if(cntComma > 0)
                                      {
                                         temp_data = temp_data.split(',').join('');
                                      }else if (cntDot > 0){
                                         temp_data = temp_data.split('.').join('');
                                      }
                                      temp_data = parseInt(temp_data);
                                      temp_data = Math.round(temp_data);
                                      var columnFromTo = parseFloat(temp_data) || 0;
                                      
                                       if ( ( isNaN( min ) && isNaN( max ) ) ||
                                            ( isNaN( min ) && columnFromTo <= max ) ||
                                            ( min <= columnFromTo   && isNaN( max ) ) ||
                                            ( min <= columnFromTo   && columnFromTo <= max ) )
                                       {
                                           return true;
                                       }
                                       return false;
                                   }else
                                   {return true;}
                               }); 
                       });
                      
                   }
                   //DataTable.draw();
                   
                        ColumnIndexRange = i ;
                       
                        var title = DataTable.column(i).header();
                       
                        var tempTitle = $(title).text();   
                        // if(tempTitle.includes('Normal'))  {
                        //     var tempTitle =$(title).children('span').text(); 
                        // }    
                        //console.log(tempTitle); 
                        tempTitle = tempTitle.trim();  
                        tab = Table_ID+"_"+tempTitle;
                       
                        $.fn.dataTable.ext.search.push(
                        function( settings, data, dataIndex ) {
                        
                           
                           var tabID = tab.split('_');
                           tabID = tabID[0]+'_'+tabID[1];
                          
                           if(settings.nTable.id == tabID){
                               
                               var min = parseInt( $('#'+tab+'fromRange').val(), 10 ) ;
                               var max = parseInt( $('#'+tab+'toRange').val(), 10 ) ;
                              
                                if(isNaN(min) && isNaN(max)){ 
                                    min =  $('#'+tab+'fromRange').val() ;
                                    max =  $('#'+tab+'toRange').val();
                                    var temp_data = data[i];
                                    var  value = "" ;
                                    var  value1 = "" ;
                                    var  value2 = "" ;  var rang = '';

                                    for (let i = 0; i < min.length; i++) {
                                        value += min.charCodeAt(i);
                                    }
                                    
                                    for (let i = 0; i < max.length; i++) {
                                        value1 += max.charCodeAt(i);
                                    }
                                    if(max == '' && min != ''){
                                        rang = min.length;
                                    }else{
                                        rang =  max.length;
                                    }
                                    
                                    for (let i = 0; i < rang; i++) {
                                        value2 += temp_data.charCodeAt(i);
                                    }
                                    //console.log(value1);
                                    if (    (  value  == '' &&  value1  == '') ||
                                            (  value == '' && value2 <= value1 ) ||
                                            ( value <= value2   &&  value1 == '' ) ||
                                            ( value <= value2   && value2 <= value1 ) )
                                    {
                                        return true;
                                    }
                                    return false;
                               } else {
                                    var temp_data = data[i].split(' ').join('');
                                    var cntComma = 0;
                                    var cntDot = 0;
                                    var str = temp_data;
    
                                    for (var t = 0;  t <= str.length; t++) {
                                        
                                        if (str[t] === ".") 
                                        {
                                            cntDot = t;
                                        }
                                        else if(str[t] === ".")
                                        {
                                            cntComma = t;
                                        }
                                    }
                                
                                    if(cntComma > 0)
                                    {
                                    temp_data = temp_data.split(',').join('');
                                    }else if (cntDot > 0){
                                    temp_data = temp_data.split(',').join('');
                                    temp_data = temp_data.split('.').join('');
                                    }
                                    temp_data = parseInt(temp_data);
                                    
                                    temp_data = Math.round(temp_data);
                                    var columnFromTo = parseFloat(temp_data) || 0;
                                    
                                    if ( ( isNaN( min ) && isNaN( max ) ) ||
                                        ( isNaN( min ) && columnFromTo <= max ) ||
                                        ( min <= columnFromTo   && isNaN( max ) ) ||
                                        ( min <= columnFromTo   && columnFromTo <= max ) )
                                    {
                                        return true;
                                    }
                                    return false;
                                }
                             
                            }else
                            {return true;}
                        });
                        DataTable.draw();

                        //$.fn.dataTable.ext.search.pop();
                    }   
            });
           
            } );
            // End of search part
            
            // Start of custom order for row group

            $('#'+Table_ID).on( 'order.dt',  function (ev) { 
                
                  
                var table1_ = $('#'+Table_ID).DataTable();
                var click  = 'yes';
                var d = table1_.order();
                var tempId = '';
                
                //console.log(setGlobal1[Table_ID+'setGlobal']);
                if(setGlobal1[Table_ID+'setGlobal'] == Table_ID+'Header')
                {
                    var d = table1_.order();
                   
                    var api = table1_;
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;
                    var i1 = 0 ;
                    var group1 = '';
                    var tempArr = [];
                   
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
                    
                    var Maindata = table1_.rows( { search: 'applied' }).data();
                    
                    var rowId = 0;
                    var newTempArr = [];
                    newTempArr = table1_.rows({ search: 'applied' }).indexes();
                
                   
                    if(CheckFlagg != '1')
                    {
                        //console.log(table1_.order());
                        var tempSo = [];
                        tempSo = [d[0][0] , d[0][1]];
                        lastOrder[0] = tempSo;
                    }
                    
                    //console.log(lastOrder);
                   
                    if(groupRowsColumn == d[0][0]){
                        if(d[0][1] == 'asc')
                        {
                            Maindata.sort(function(a,b) {
                                var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                                return a1<b1 ? -1 : a1>b1 ? 1 :  a[d[0][0]]< b[d[0][0]] ? -1 :  a[d[0][0]]> b[d[0][0]] ? 1 : 0;
                                
                            });

                        }else if(d[0][1] == 'desc'){
                                Maindata.sort(function(a,b) {
                                var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                                return a1>b1 ? -1 : a1<b1 ? 1 :  a[d[0][0]]> b[d[0][0]] ? -1 :  a[d[0][0]]< b[d[0][0]] ? 1 : 0;
                            
                            
                            });
                        }
                        var len  = Maindata.length;
                       
                        for (let index = 0; index < len ; index++) {
                          
                           table1_.row(newTempArr[rowId]).data(Maindata[index]).invalidate();
                           //table1_.row(1).data()[2] = '89';
                           
                            
                            rowId++;
                          
                            
                        }
                       
                    }
                    var Maindata = table1_.rows({ search: 'applied' }).data();
                   
                    api.column(groupRowsColumn, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                           

                            //var columnTotal = 0;
                            var mainArr = {};
                            var customSum = {};
                            var valArr = {};
                           
                            if( i != 0)
                            {
                                
                                $.each(footerColumn, function( index, value ) {
                                
                                    
                                    var columnTotal = 0;
                                    if(value['perform_custom_sum'] == 0 || value['footer_sum_only'] !== undefined)
                                    {   
                                            for (let index1 = i1; index1 < i; index1++) {
                                               
                                               columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                            }
                                        
                                        mainArr[value['column_name']] = columnTotal;
                                        if(value.decimal != undefined)
                                        {
                                             valArr[index]   = columnTotal.toFixed(value.decimal).toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                                            
                                        }else{
                                              valArr[index] = columnTotal.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        
                                        }
                                      
                                    }
                                    else if(value['perform_custom_sum'] == 1){
                                        
                                        for (let index1 = i1; index1 < i; index1++) {

                                           
                                            columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                         }
                                        
                                        mainArr[value['column_name']] = columnTotal;
                                        customSum[index] = value['custom_sum'];
                                    }
                                });
                                
                               
                                $.each(customSum, function( index, value ){
                                  
                                  
                                    var formula = value;
                                   
                                    $.each(mainArr, function( indexs, values ){
                                       
                                        formula = formula.replace(indexs, values);
                                    });
                                   
                                    formula = eval(formula);
                                   
                                    if(formula != '' && formula != undefined ){
                                        formula = formula.toFixed(2);
                                        formula = formula.split('.').join(',');
                                        //formula = formula.replace(/(\d)(?=(\d{2})+(?!\d))/g, '$1,');    
                                    }
        
                                    valArr[index]=formula;
                                });   
                              
                                valArr['rowKeys'] = i;
                                valArr['rowKeye'] = i1;
                                valArr['rowgroup'] = last ;
                                 
                            }
                           
                           
                            group1 = group ;
                       
                           
                            if(Object.keys(valArr).length >0) {
                                tempArr.push(valArr);
                            } 
                            i1=i;
                            
                           // delete tempArr;
                            last = group;
                        }
                    } );
                    
                    if(rows.count())
                    {
                        
                      
                        var mainArr = {};
                        var customSum = {};
                        var valArr = {};
                       
                        $.each(footerColumn, function( index, value ) {
                        
                            
                            var columnTotal = 0;
                            if(value['perform_custom_sum'] == 0 || value['footer_sum_only'] !== undefined)
                            {   
                                    for (let index1 = i1; index1 < rows.count(); index1++) {
                                        columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                    }
                                
                                mainArr[value['column_name']] = columnTotal;
                                if(value.decimal != undefined)
                                {
                                        valArr[index]   = columnTotal.toFixed(value.decimal).toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                                    
                                }else{
                                        valArr[index] = columnTotal.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');

                                }
                                
                            }
                            else if(value['perform_custom_sum'] == 1){
                                
                                for (let index1 = i1; index1 <  rows.count(); index1++) {
                                    columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                    }
                                
                                mainArr[value['column_name']] = columnTotal;
                                customSum[index] = value['custom_sum'];
                            }
                        });
                        
                        
                        $.each(customSum, function( index, value ){
                            
                            
                            var formula = value;
                            
                            $.each(mainArr, function( indexs, values ){
                                
                                formula = formula.replace(indexs, values);
                            });
                            
                            formula = eval(formula);
                            
                            if(formula != '' && formula != undefined ){
                                formula = formula.toFixed(2);
                                formula = formula.split('.').join(',');
                                //formula = formula.replace(/(\d)(?=(\d{2})+(?!\d))/g, '$1,');    
                            }

                            valArr[index]=formula;
                        });   
                       
                        valArr['rowKeys'] =  rows.count();
                        valArr['rowKeye'] = i1;
                        valArr['rowgroup'] = group1 ;
                              
                        if(Object.keys(valArr).length >0) {
                                tempArr.push(valArr);
                            }  
                        
                    }
                    var tempd = d[0][0];
                    function ascCompare(a, b) {
                        var bandA = intVal(a[d[0][0]]);
                        var bandB = intVal(b[d[0][0]]);
                       
                       
                        if(CheckFlagg == 2)
                        {
                            d[0][0] = sortColumnID;
                        }else{
                            d[0][0] = lastOrder[0][0];
                        }
                       

                        if((a[d[0][0]] == "Infinity" || a[d[0][0]] == "NaN") && (b[d[0][0]] == "Infinity" || b[d[0][0]] == "NaN") ){
                            var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                            return a1<b1 ? -1 : a1>b1 ? 1 :  a[d[0][0]]< b[d[0][0]] ? -1 :  a[d[0][0]]> b[d[0][0]] ? 1 : 0;
                       
                        }
                        else if(a[d[0][0]] == "Infinity" || a[d[0][0]] == "NaN"){
                            var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                            return a1<b1 ? -1 : a1>b1 ? 1 :  a[d[0][0]]< b[d[0][0]] ? -1 :  a[d[0][0]]> b[d[0][0]] ? 1 : 0;
                        }
                        else if(b[d[0][0]] == "Infinity" || b[d[0][0]] == "NaN"){
                            var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                            return a1<b1 ? -1 : a1>b1 ? 1 :  a[d[0][0]]< b[d[0][0]] ? -1 :  a[d[0][0]]> b[d[0][0]] ? 1 : 0;
                       
                        }
                        else{
                             bandA = intVal(a[d[0][0]]);
                             bandB = intVal(b[d[0][0]]);
                        }
                      
                      
                     
                        let comparison = 0;
                        if (bandA > bandB) {
                          comparison = 1;
                        } else if (bandA < bandB) {
                          comparison = -1;
                        }
                        return comparison;
                       
                    }
                    function descCompare(a, b) {
                        var bandA = intVal(a[d[0][0]]);
                        var bandB = intVal(b[d[0][0]]);
                        if(CheckFlagg == 2)
                        {
                            d[0][0] = sortColumnID;
                        }else{
                            d[0][0] = lastOrder[0][0];
                        }
                       
                        if((a[d[0][0]] == "Infinity" || a[d[0][0]] == "NaN") && (b[d[0][0]] == "Infinity" || b[d[0][0]] == "NaN") ){
                            var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                            return a1>b1 ? -1 : a1<b1 ? 1 :  a[d[0][0]]> b[d[0][0]] ? -1 :  a[d[0][0]]< b[d[0][0]] ? 1 : 0;
                       
                        }
                        else if(a[d[0][0]] == "Infinity" || a[d[0][0]] == "NaN"){
                            var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                            return a1>b1 ? -1 : a1<b1 ? 1 :  a[d[0][0]]> b[d[0][0]] ? -1 :  a[d[0][0]]< b[d[0][0]] ? 1 : 0;
                        }
                        else if(b[d[0][0]] == "Infinity" || b[d[0][0]] == "NaN"){
                            var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                            return a1>b1 ? -1 : a1<b1 ? 1 :  a[d[0][0]]> b[d[0][0]] ? -1 :  a[d[0][0]]< b[d[0][0]] ? 1 : 0;
                       
                        }
                        else{
                             bandA = intVal(a[d[0][0]]);
                             bandB = intVal(b[d[0][0]]);
                        }
                      
                        let comparison = 0;
                        if (bandA < bandB) {
                          comparison = 1;
                        } else if (bandA > bandB) {
                          comparison = -1;
                        }
                        return comparison;
                    }
                    d[0][0] = lastOrder[0][0];
                    d[0][1] = lastOrder[0][1];
                    if(d[0][1] == 'asc')
                    {
                        tempArr = tempArr.sort(ascCompare);
                    }
                    else if(d[0][1] == 'desc'){
                       
                        tempArr = tempArr.sort(descCompare);
                    }
                    var j  =0;
                    var rowId = 0;
                    var Maindata =  table1_.rows( { search: 'applied' }).data();
                    var newTempArr = table1_.rows({ search: 'applied' }).indexes();
                   
                  
                    api.column(groupRowsColumn, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {

                           
                            var tempStart = tempArr[j]['rowKeye'];
                            var tempEnd = tempArr[j]['rowKeys'];
                            var count = 0;
                            var collapsed = !!collapsedGroups[group];
                            tempArr[j]['countPos'] = rowId;
                            var tempArray = [];
                           
                            if( setGlobalPrevious1[Table_ID+'setGlobalPrevious'] == Table_ID+'Inner')
                            {  
                               
                                for (let index = tempStart; index < tempEnd ; index++) {
                                
                                    tempArray.push(Maindata[index]);
                                    count++;
                                }
                               
                                var len = tempArray.length;

                                if(sortColumnID)
                                   {
                                      //console.log("jjjjjjjjjjjjjjjjjjjjjjjjjjj");
                                       //if(CheckFlagg == '1' ){
                                            //console.log("hjbdfhjv");
                                            CheckFlagg = 2;
                                            if(sortVariable == 'asc')
                                            {
                                                tempArray = tempArray.sort(ascCompare);
        
                                            }else if(sortVariable == 'desc'){
                                                tempArray = tempArray.sort(descCompare);
                                            }
                                          
                                       // }
                                      
                                      
                                }else{
                                    if(d[0][1] == 'asc' )
                                    {
                                        tempArray = tempArray.sort(ascCompare);

                                    }else if(d[0][1] == 'desc' ){
                                        tempArray = tempArray.sort(descCompare);
                                    }
                                }
                                
                           
                                for (let index = 0; index < len ; index++) {
                                
                                    table1_.row(newTempArr[rowId]).data(tempArray[index]).invalidate();
                                    rowId++;
                                
                                    
                                }
                                
                            }else{
                                for (let index = tempStart; index < tempEnd ; index++) {
                                    var curData = Maindata[index];
                                    
                                    table1_.row(newTempArr[rowId]).data(curData).invalidate();
                                    
                                    count++;
                                    rowId++;
                                
                                
                                }
                            }

                            
                            tempArr[j]['count'] = count;
                            
                            j = j +1;
                                
                            last = group;
                                   
                        }
                    } );
                    CheckFlagg = '0';
                    d[0][0] = tempd;
                    
                }
                
                //----------------------------------------
          
                if(setGlobal1[Table_ID+'setGlobal'] == Table_ID+'Inner'  && groupRowsFlag == 1)
                {
                
                    
                    var api = table1_;
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;
                    var i1 = 0 ;
                    var group1 = '';
                    var tempArr1 = [];
                    var Maindata = table1_.rows({ search: 'applied' }).data();
                    //console.log(Maindata);
                    
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
                    var Maindata = table1_.rows({ search: 'applied' }).data();
                    var rowId = 0;
                    var newTempArr = [];
                    newTempArr = table1_.rows({ search: 'applied' }).indexes();
                    if(groupRowsColumn == d[0][0]){
                        if(d[0][1] == 'asc')
                        {
                            Maindata.sort(function(a,b) {
                                var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                                return a1<b1 ? -1 : a1>b1 ? 1 :  a[d[0][0]]< b[d[0][0]] ? -1 :  a[d[0][0]]> b[d[0][0]] ? 1 : 0;
                                
                                
                            });

                        }else if(d[0][1] == 'desc'){
                                Maindata.sort(function(a,b) {
                                var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                                return a1>b1 ? -1 : a1<b1 ? 1 :  a[d[0][0]]> b[d[0][0]] ? -1 :  a[d[0][0]]< b[d[0][0]] ? 1 : 0;
                            
                            
                            });
                        }
                        var len  = Maindata.length;
                       
                        for (let index = 0; index < len ; index++) {
                          
                           table1_.row(newTempArr[rowId]).data(Maindata[index]).invalidate();
                           //table1_.row(1).data()[2] = '89';
                           
                            
                            rowId++;
                          
                            
                        }
                       
                    }
                   
                    if(setGlobalPrevious1[Table_ID+'setGlobalPrevious'] == Table_ID+'Header'){
                        var tempArr = [];
                        var Maindata = table1_.rows({ search: 'applied' }).data();
                  
                        api.column(groupRowsColumn, {page:'current'} ).data().each( function ( group, i ) {
                            if ( last !== group ) {
                               

                                //var columnTotal = 0;
                                var mainArr = {};
                                var customSum = {};
                                var valArr = {};
                               
                                if( i != 0)
                                {
                                    
                                    $.each(footerColumn, function( index, value ) {
                                    
                                        
                                        var columnTotal = 0;
                                        if(value['perform_custom_sum'] == 0 || value['footer_sum_only'] !== undefined)
                                        {   
                                                for (let index1 = i1; index1 < i; index1++) {
                                                   
                                                   columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                                }
                                            
                                            mainArr[value['column_name']] = columnTotal;
                                            if(value.decimal != undefined)
                                            {
                                                 valArr[index]   = columnTotal.toFixed(value.decimal).toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                                                
                                            }else{
                                                  valArr[index] = columnTotal.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            
                                            }
                                          
                                        }
                                        else if(value['perform_custom_sum'] == 1){
                                            
                                            for (let index1 = i1; index1 < i; index1++) {

                                               
                                                columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                             }
                                            
                                            mainArr[value['column_name']] = columnTotal;
                                            customSum[index] = value['custom_sum'];
                                        }
                                    });
                                    
                                   
                                    $.each(customSum, function( index, value ){
                                      
                                      
                                        var formula = value;
                                       
                                        $.each(mainArr, function( indexs, values ){
                                           
                                            formula = formula.replace(indexs, values);
                                        });
                                       
                                        formula = eval(formula);
                                       
                                        if(formula != '' && formula != undefined ){
                                            formula = formula.toFixed(2);
                                            formula = formula.split('.').join(',');
                                            //formula = formula.replace(/(\d)(?=(\d{2})+(?!\d))/g, '$1,');    
                                        }
            
                                        valArr[index]=formula;
                                    });   
                                  
                                    valArr['rowKeys'] = i;
                                    valArr['rowKeye'] = i1;
                                    valArr['rowgroup'] = last ;
                                     
                                }
                               
                               
                                group1 = group ;
                           
                               
                                if(Object.keys(valArr).length >0) {
                                    tempArr.push(valArr);
                                } 
                                i1=i;
                                
                               // delete tempArr;
                                last = group;
                            }
                        } );
                        
                        if(rows.count())
                        {
                            
                          
                            var mainArr = {};
                            var customSum = {};
                            var valArr = {};
                           
                            $.each(footerColumn, function( index, value ) {
                            
                                
                                var columnTotal = 0;
                                if(value['perform_custom_sum'] == 0 || value['footer_sum_only'] !== undefined)
                                {   
                                        for (let index1 = i1; index1 < rows.count(); index1++) {
                                            columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                        }
                                    
                                    mainArr[value['column_name']] = columnTotal;
                                    if(value.decimal != undefined)
                                    {
                                            valArr[index]   = columnTotal.toFixed(value.decimal).toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                                        
                                    }else{
                                            valArr[index] = columnTotal.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    
                                    }
                                    
                                }
                                else if(value['perform_custom_sum'] == 1){
                                    
                                    for (let index1 = i1; index1 <  rows.count(); index1++) {
                                        columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                        }
                                    
                                    mainArr[value['column_name']] = columnTotal;
                                    customSum[index] = value['custom_sum'];
                                }
                            });
                            
                            
                            $.each(customSum, function( index, value ){
                                
                                
                                var formula = value;
                                
                                $.each(mainArr, function( indexs, values ){
                                    
                                    formula = formula.replace(indexs, values);
                                });
                                
                                formula = eval(formula);
                                
                                if(formula != '' && formula != undefined ){
                                    formula = formula.toFixed(2);
                                    formula = formula.split('.').join(',');
                                    //formula = formula.replace(/(\d)(?=(\d{2})+(?!\d))/g, '$1,');    
                                }
    
                                valArr[index]=formula;
                            });   
                           
                            valArr['rowKeys'] =  rows.count();
                            valArr['rowKeye'] = i1;
                            valArr['rowgroup'] = group1 ;
                                  
                            if(Object.keys(valArr).length >0) {
                                    tempArr.push(valArr);
                                }  
                            
                        }

                        function ascCompare(a, b) {
                            var bandA = intVal(a[d[0][0]]);
                            var bandB = intVal(b[d[0][0]]);
                           
                            if((a[d[0][0]] == "Infinity" || a[d[0][0]] == "NaN") && (b[d[0][0]] == "Infinity" || b[d[0][0]] == "NaN") ){
                                var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                                return a1<b1 ? -1 : a1>b1 ? 1 :  a[d[0][0]]< b[d[0][0]] ? -1 :  a[d[0][0]]> b[d[0][0]] ? 1 : 0;
                           
                            }
                            else if(a[d[0][0]] == "Infinity" || a[d[0][0]] == "NaN"){
                                var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                                return a1<b1 ? -1 : a1>b1 ? 1 :  a[d[0][0]]< b[d[0][0]] ? -1 :  a[d[0][0]]> b[d[0][0]] ? 1 : 0;
                            }
                            else if(b[d[0][0]] == "Infinity" || b[d[0][0]] == "NaN"){
                                var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                                return a1<b1 ? -1 : a1>b1 ? 1 :  a[d[0][0]]< b[d[0][0]] ? -1 :  a[d[0][0]]> b[d[0][0]] ? 1 : 0;
                           
                            }
                            else{
                                 bandA = intVal(a[d[0][0]]);
                                 bandB = intVal(b[d[0][0]]);
                            }
                          
                          
                         
                            let comparison = 0;
                            if (bandA > bandB) {
                              comparison = 1;
                            } else if (bandA < bandB) {
                              comparison = -1;
                            }
                            return comparison;
                           
                          }
                        function descCompare(a, b) {
                            var bandA = intVal(a[d[0][0]]);
                            var bandB = intVal(b[d[0][0]]);
                           
                            if((a[d[0][0]] == "Infinity" || a[d[0][0]] == "NaN") && (b[d[0][0]] == "Infinity" || b[d[0][0]] == "NaN") ){
                                var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                                return a1>b1 ? -1 : a1<b1 ? 1 :  a[d[0][0]]> b[d[0][0]] ? -1 :  a[d[0][0]]< b[d[0][0]] ? 1 : 0;
                           
                            }
                            else if(a[d[0][0]] == "Infinity" || a[d[0][0]] == "NaN"){
                                var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                                return a1>b1 ? -1 : a1<b1 ? 1 :  a[d[0][0]]> b[d[0][0]] ? -1 :  a[d[0][0]]< b[d[0][0]] ? 1 : 0;
                            }
                            else if(b[d[0][0]] == "Infinity" || b[d[0][0]] == "NaN"){
                                var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                                return a1>b1 ? -1 : a1<b1 ? 1 :  a[d[0][0]]> b[d[0][0]] ? -1 :  a[d[0][0]]< b[d[0][0]] ? 1 : 0;
                           
                            }
                            else{
                                 bandA = intVal(a[d[0][0]]);
                                 bandB = intVal(b[d[0][0]]);
                            }
                          
                            let comparison = 0;
                            if (bandA < bandB) {
                              comparison = 1;
                            } else if (bandA > bandB) {
                              comparison = -1;
                            }
                            return comparison;
                        }
                        tempArr = tempArr.sort(ascCompare);
                        
                        var j  =0;
                        var rowId = 0;
                        var Maindata =  table1_.rows( { search: 'applied' }).data();
                        var newTempArr = table1_.rows({ search: 'applied' }).indexes();
                       
                      
                        api.column(groupRowsColumn, {page:'current'} ).data().each( function ( group, i ) {
                            if ( last !== group ) {

                               
                                var tempStart = tempArr[j]['rowKeye'];
                                var tempEnd = tempArr[j]['rowKeys'];
                                var count = 0;
                                var collapsed = !!collapsedGroups[group];
                                tempArr[j]['countPos'] = rowId;
                                var tempArray = [];
                                  
                                
                                for (let index = tempStart; index < tempEnd ; index++) {
                                
                                    tempArray.push(Maindata[index]);
                                    count++;
                                }
                                
                                var len = tempArray.length;
                                if(d[0][1] == 'asc')
                                {
                                    tempArr.sort(function(a,b) {
                                        if (intVal(a[d[0][0]]) === intVal(b[d[0][0]])) {
                                            return 0;
                                        }
                                        else {
                                            return (intVal(a[d[0][0]]) < intVal(b[d[0][0]])) ? -1 : 1;
                                        }
                                        
                                    });

                                }else if(d[0][1] == 'desc'){
                                    tempArr.sort(function(a,b) {
                                        if (intVal(a[d[0][0]]) === intVal(b[d[0][0]])) {
                                            return 0;
                                        }
                                        else {
                                            return (intVal(a[d[0][0]]) > intVal(b[d[0][0]])) ? -1 : 1;
                                        }
                                    
                                    });
                                }
                            
                                for (let index = 0; index < len ; index++) {
                                
                                    table1_.row(newTempArr[rowId]).data(tempArray[index]).invalidate();
                                    rowId++;
                                
                                    
                                }
                            
                                tempArr[j]['count'] = count;
                                j = j +1;       
                                last = group;
                                       
                            }
                        } );
                    }
                    else{

                        api.column(groupRowsColumn, {page:'current'} ).data().each( function ( group, i ) {
                            if ( last !== group ) {
                            
                                //var columnTotal = 0;
                                var mainArr = {};
                                var customSum = {};
                                var valArr = {};
                            
                                if( i != 0)
                                {
                                    $.each(footerColumn, function( index, value ) {
                                    
                                        
                                        var columnTotal = 0;
                                        if(value['perform_custom_sum'] == 0 || value['footer_sum_only'] !== undefined)
                                        {   
                                                for (let index1 = i1; index1 < i; index1++) {
                                                columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                                }
                                            
                                            mainArr[value['column_name']] = columnTotal;
                                            if(value.decimal != undefined)
                                            {
                                                valArr[index]   = columnTotal.toFixed(value.decimal).toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                                                
                                            }else{
                                                valArr[index] = columnTotal.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            
                                            }
                                        
                                        }
                                        else if(value['perform_custom_sum'] == 1){
                                            
                                            for (let index1 = i1; index1 < i; index1++) {
                                                columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                            }
                                            
                                            mainArr[value['column_name']] = columnTotal;
                                            customSum[index] = value['custom_sum'];
                                        }
                                    });
                                    
                                
                                    $.each(customSum, function( index, value ){
                                    
                                    
                                        var formula = value;
                                    
                                        $.each(mainArr, function( indexs, values ){
                                        
                                            formula = formula.replace(indexs, values);
                                        });
                                    
                                        formula = eval(formula);
                                    
                                        if(formula != '' && formula != undefined ){
                                            formula = formula.toFixed(2);
                                            formula = formula.split('.').join(',');
                                            //formula = formula.replace(/(\d)(?=(\d{2})+(?!\d))/g, '$1,');    
                                        }
            
                                        valArr[index]=formula;
                                    });   
                                    valArr['rowKeys'] = i;
                                    valArr['rowKeye'] = i1;
                                    valArr['rowgroup'] = last ;
                                    
                                }
                            
                            
                                group1 = group ;
                            
                                
                                if(Object.keys(valArr).length >0) {
                                    tempArr1.push(valArr);
                                } 
                                i1=i;
                                last = group;
                            }
                        } );
                        
                        if(rows.count())
                        {
                            
                        // var columnTotal = 0;
                            var mainArr = {};
                            var customSum = {};
                            var valArr = {};
                        
                            $.each(footerColumn, function( index, value ) {
                            
                                
                                var columnTotal = 0;
                                if(value['perform_custom_sum'] == 0 || value['footer_sum_only'] !== undefined)
                                {   
                                        for (let index1 = i1; index1 < rows.count(); index1++) {
                                            columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                        }
                                    
                                    mainArr[value['column_name']] = columnTotal;
                                    if(value.decimal != undefined)
                                    {
                                            valArr[index]   = columnTotal.toFixed(value.decimal).toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                                        
                                    }else{
                                            valArr[index] = columnTotal.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    
                                    }
                                    
                                }
                                else if(value['perform_custom_sum'] == 1){
                                    
                                    for (let index1 = i1; index1 <  rows.count(); index1++) {
                                        columnTotal = columnTotal + intVal(Maindata[index1][index]);
                                        }
                                    
                                    mainArr[value['column_name']] = columnTotal;
                                    customSum[index] = value['custom_sum'];
                                }
                            });
                            
                            
                            $.each(customSum, function( index, value ){
                                
                                
                                var formula = value;
                                
                                $.each(mainArr, function( indexs, values ){
                                    
                                    formula = formula.replace(indexs, values);
                                });
                                
                                formula = eval(formula);
                                
                                if(formula != '' && formula != undefined ){
                                    formula = formula.toFixed(2);
                                    formula = formula.split('.').join(',');
                                    //formula = formula.replace(/(\d)(?=(\d{2})+(?!\d))/g, '$1,');    
                                }
    
                                valArr[index]=formula;
                            });   
                            valArr['rowKeys'] =  rows.count();
                            valArr['rowKeye'] = i1;
                            valArr['rowgroup'] = group1 ;
                                
                            if(Object.keys(valArr).length >0) {
                                    tempArr1.push(valArr);
                                }  
                            
                        }
                    
                        var j =0;
                        var newTempArr = [];
                        newTempArr = table1_.rows().indexes();
                        table1_.column(groupRowsColumn, {page:'current'} ).data().each( function ( group, i ) {
                            if ( last !== group ) {
                            
                            
                                group1 = group ;
                                var tempArr = [];
                                var rowId = 0;
                                var cnt = 0;
                                //var collapsed = !!collapsedGroups[group];  
                                // if(closeAll == 'closeall'){
                                //     var collapsed = false;
                                // }else if(openAll == 'openall'){
                                //     var collapsed = true;
                                // }else{
                                //     var collapsed = !!collapsedGroups[group];
                                // }
                                if(i != 0)
                                    {  
                                        
                                    for (let index = i1; index < i; index++) {
                                    
                                        tempArr.push(Maindata[index]);
                                        cnt ++;
                                    }
                                    rowId = i1;
                                
                                    var len = tempArr.length;
                                    if(d[0][1] == 'asc')
                                    {
                                        tempArr.sort(function(a,b) {
                                            if (intVal(a[d[0][0]]) === intVal(b[d[0][0]])) {
                                                return 0;
                                            }
                                            else {
                                                return (intVal(a[d[0][0]]) < intVal(b[d[0][0]])) ? -1 : 1;
                                            }
                                            
                                        });
    
                                    }else if(d[0][1] == 'desc'){
                                        tempArr.sort(function(a,b) {
                                            if (intVal(a[d[0][0]]) === intVal(b[d[0][0]])) {
                                                return 0;
                                            }
                                            else {
                                                return (intVal(a[d[0][0]]) > intVal(b[d[0][0]])) ? -1 : 1;
                                            }
                                        
                                        });
                                    }
                                
                                    for (let index = 0; index < len ; index++) {
                                    
                                    table1_.row(newTempArr[rowId]).data(tempArr[index]).invalidate();
                                    //table1_.row(1).data()[2] = '89';
                                    
                                        
                                        rowId++;
                                    
                                        
                                    }
                                    
                                }
                                i1=i;
                                
                                delete tempArr;
                                last = group;

                            
                                    // var entry = $('<tr/>');
                                    // var k = 0 , cnt = 0 ;
                                    // var newArr = [];
                                    // var len = DataTable.columns().header().length;
                                    // $.each(tempArr1[j], function( ke, va ){
                                    //     newArr.push(parseInt(ke));
                                    // });
                                    
                                    // if(jsonData.HideColumn == undefined ){
                                    //     var hideColumn = [];
                                    //     hideColumn[0] = 1000;
                                    // }else{
                                    //     var hideColumn = [];
                                    //     hideColumn = jsonData.HideColumn;
                                    // }
                                    
                                    // for(k ; k < len; k++){
                                    //     var pass = 0 ;

                                    //     if(cnt == 0 && !(hideColumn.includes(k))){
                                    //             entry.append('<td >'+ group + ' (' + cnt + ' entries)</td>');
                                    //             cnt = cnt +1;
                                                
                                                
                                    //     }else if((newArr.includes(k)) && !(hideColumn.includes(k))  ){
                                            
                                    //         entry.append('<td class="td-right">'+tempArr1[j][k]+'</td>');
                                            
                                    //     }else if(k != 0 && !(hideColumn.includes(k)) ){
                                            
                                    //         entry.append('<td class="td-right"></td>');
                                            
                                    //     }
                                    // }
                                    // entry .attr('class', 'group');
                                    // entry .attr('data-name', group).toggleClass('collapsed', collapsed);
                                    
    
                                    // $(rows).eq( i ).before(
                                    //    entry
                                    // );
                            }
                        } );
                  
                            // table1_.rows( { order: 'applied' } ).draw();
                    }

                   

                }
                if(setGlobal1[Table_ID+'setGlobal'] == Table_ID+'InnerAll'){
                    var d = table1_.order();
                    var Maindata = table1_.rows({ search: 'applied' }).data();
                    var rowId = 0;
                    var newTempArr = [];
                    newTempArr = table1_.rows({ search: 'applied' }).indexes();
                    if(groupRowsColumn == d[0][0]){
                        if(d[0][1] == 'asc')
                        {
                            Maindata.sort(function(a,b) {
                                var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                                return a1<b1 ? -1 : a1>b1 ? 1 :  a[d[0][0]]< b[d[0][0]] ? -1 :  a[d[0][0]]> b[d[0][0]] ? 1 : 0;
                                
                                
                            });

                        }else if(d[0][1] == 'desc'){
                                Maindata.sort(function(a,b) {
                                var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                                return a1>b1 ? -1 : a1<b1 ? 1 :  a[d[0][0]]> b[d[0][0]] ? -1 :  a[d[0][0]]< b[d[0][0]] ? 1 : 0;
                            
                            
                            });
                        }
                        var len  = Maindata.length;
                       
                        for (let index = 0; index < len ; index++) {
                          
                           table1_.row(newTempArr[rowId]).data(Maindata[index]).invalidate();
                           //table1_.row(1).data()[2] = '89';
                           
                            
                            rowId++;
                          
                            
                        }
                       
                    }
                    var Maindata = table1_.rows({ search: 'applied' }).data();
               
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
                    
                    function ascCompare(a, b) {
                        var bandA = intVal(a[d[0][0]]);
                        var bandB = intVal(b[d[0][0]]);
                       
                        if((a[d[0][0]] == "Infinity" || a[d[0][0]] == "NaN") && (b[d[0][0]] == "Infinity" || b[d[0][0]] == "NaN") ){
                            var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                            return a1<b1 ? -1 : a1>b1 ? 1 :  a[d[0][0]]< b[d[0][0]] ? -1 :  a[d[0][0]]> b[d[0][0]] ? 1 : 0;
                       
                        }
                        else if(a[d[0][0]] == "Infinity" || a[d[0][0]] == "NaN"){
                            var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                            return a1<b1 ? -1 : a1>b1 ? 1 :  a[d[0][0]]< b[d[0][0]] ? -1 :  a[d[0][0]]> b[d[0][0]] ? 1 : 0;
                        }
                        else if(b[d[0][0]] == "Infinity" || b[d[0][0]] == "NaN"){
                            var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                            return a1<b1 ? -1 : a1>b1 ? 1 :  a[d[0][0]]< b[d[0][0]] ? -1 :  a[d[0][0]]> b[d[0][0]] ? 1 : 0;
                       
                        }
                        else{
                             bandA = intVal(a[d[0][0]]);
                             bandB = intVal(b[d[0][0]]);
                        }
                      
                      
                     
                        let comparison = 0;
                        if (bandA > bandB) {
                          comparison = 1;
                        } else if (bandA < bandB) {
                          comparison = -1;
                        }
                        return comparison;
                       
                    }
                    function descCompare(a, b) {
                        var bandA = intVal(a[d[0][0]]);
                        var bandB = intVal(b[d[0][0]]);
                       
                        if((a[d[0][0]] == "Infinity" || a[d[0][0]] == "NaN") && (b[d[0][0]] == "Infinity" || b[d[0][0]] == "NaN") ){
                            var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                            return a1>b1 ? -1 : a1<b1 ? 1 :  a[d[0][0]]> b[d[0][0]] ? -1 :  a[d[0][0]]< b[d[0][0]] ? 1 : 0;
                       
                        }
                        else if(a[d[0][0]] == "Infinity" || a[d[0][0]] == "NaN"){
                            var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                            return a1>b1 ? -1 : a1<b1 ? 1 :  a[d[0][0]]> b[d[0][0]] ? -1 :  a[d[0][0]]< b[d[0][0]] ? 1 : 0;
                        }
                        else if(b[d[0][0]] == "Infinity" || b[d[0][0]] == "NaN"){
                            var a1=typeof  a[d[0][0]], b1=typeof b[d[0][0]];
                            return a1>b1 ? -1 : a1<b1 ? 1 :  a[d[0][0]]> b[d[0][0]] ? -1 :  a[d[0][0]]< b[d[0][0]] ? 1 : 0;
                       
                        }
                        else{
                             bandA = intVal(a[d[0][0]]);
                             bandB = intVal(b[d[0][0]]);
                        }
                      
                        let comparison = 0;
                        if (bandA < bandB) {
                          comparison = 1;
                        } else if (bandA > bandB) {
                          comparison = -1;
                        }
                        return comparison;
                    }
                    if(d[0][1] == 'asc')
                    {
                        Maindata = Maindata.sort(ascCompare);
                    }
                    else if(d[0][1] == 'desc'){
                       
                        Maindata = Maindata.sort(descCompare);
                    }
                    
                    var len = table1_.rows({ search: 'applied' }).count();
                    rowId = 0;
                    
                    for (let index = 0; index < len ; index++) {
                                  
                       
                        table1_.row(newTempArr[rowId]).data(Maindata[index]).invalidate();
                        
                        rowId++;
                       
                         
                     
                    }
                   
                }
               
           // }
            });

            $.fn.dataTable.ext.type.order['sortme-asc'] = function (A , B) {
                
                if(groupRowsFlag == 1 && setGlobal1[Table_ID+'setGlobal'] == Table_ID+'Inner'  || setGlobal1[Table_ID+'setGlobal'] == Table_ID+'Header' ||  setGlobal1[Table_ID+'setGlobal'] == Table_ID+'InnerAll'){
                    //console.log(setGlobal);
                    if(navigator.userAgent.indexOf("Safari") != -1)
                    {
                        return true;
                    }
                    else if(navigator.userAgent.indexOf("Firefox") != -1 ) 
                    {
                        return false;
                    }
                    
                } else{
                   
                    if (A > B) return 1;
                     if (A < B) return -1;
                }
            //    else{
            //        //console.log("jknkjnkjnkjnjknkjnjknknjknjnknkjn");
            //     // return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            //     if (A > B) return 1;
            //     if (A < B) return -1;
            //    }
            };
            $.fn.dataTable.ext.type.order['sortme-desc'] = function ( a) {
                
                if(groupRowsFlag == 1 && setGlobal1[Table_ID+'setGlobal'] == Table_ID+'Inner'  || setGlobal1[Table_ID+'setGlobal'] == Table_ID+'Header' ||  setGlobal1[Table_ID+'setGlobal'] == Table_ID+'InnerAll'){
                    //console.log(setGlobal);
                    if(navigator.userAgent.indexOf("Safari") != -1)
                    {
                        return true;
                    }
                    else if(navigator.userAgent.indexOf("Firefox") != -1 ) 
                    {
                        return false;
                    }
                }else{
                    return true;
                }
    

           };
            // ENd of custom order for row group
            var length_ = $('#'+Table_ID).find("tr:first th").length;
            var array_length = -1;
             // Start of code when a datatable is created
            $('#'+Table_ID).on( 'draw.dt', function () {
               
                //console.log(Table_ID+' DataTables rendered.');
               
                var table1_ = $('#'+Table_ID).DataTable();
               
                var row_data = table1_.rows(0).data();

                if (row_data !== undefined) {
                    var array = Object.keys(row_data).map(item => row_data[item]);
                    array_length = array[0].length;
                    //console.log('Length: ' + length_ + ", " );
                    //console.log('Array: ' + array[0].length);
                    //console.log(Table_ID+' show actions.' + (array_length > length_));
                   
                    if (array_length > length_ && (EnableChildRows == 0 &&  EnableChildRowsRunTym == 0) && EnableOnclickBtn == 1) {
                       
                        $("#actions_"+ Table_ID).remove();
                        if(base_url != 'http://www.babcnew.com')
                        {
                            base_url = absPath[0]+'public';
                        }
                        //$.getScript(base_url + '/assets/Custome_Code/DataTables/customButton.js', function()
                            //{
								console.log("hello");
                                //$("." + Table_ID).append(tableActionsButton(Table_ID));
                                $("#" + Table_ID + "_wrapper .dt-buttons").append(tableActionsButton(Table_ID)); // MY LINE
                    
                            //});
                    }
                    
                    if(productInfo && array_length > 1){
                        if(base_url != 'http://www.babcnew.com')
                        {
                            base_url = absPath[0]+'public';
                        }

                        //$.getScript(base_url + '/assets/Custome_Code/DataTables/customButton.js', function()
                            //{
                                //$("." + Table_ID).append(tableAddMoreInfo(Table_ID));
                                $("#" + Table_ID + "_wrapper .dt-buttons").append(tableAddMoreInfo(Table_ID));
                            //});
                        
                    }
                }
            });
             // ENd of code when a datatable is created
    

            var mainArr = [];
            var editMainArr = [];
            $.each(jsonData.columnTitle, function (i, title) {
                objArr = {};
                objArr['label'] = title; 
                objArr['name'] = title
                mainArr.push(objArr);
                editMainArr.push(objArr);
            });
    
  
            editor = new $.fn.dataTable.Editor( {
                    ajax: function ( method, url, data, success, error ) {
                        $.ajax( {
                            type: "POST",
                            url:  CSVURL,
                            data: data,
                            dataType: "json",
                            
                            success: function (json) {
                               
                                if(data.action == 'create'){
                                    //console.log(json);
                                    
                                    if(json){
                                        
                                        $('#'+Table_ID).DataTable().ajax.reload();
                                        editor.close();
                                    }else{
                                         editor.close();
                                    }
                                }
                                else if(data.action =='remove'){
                                    //console.log(json);
                                    
                                    if(json){
                                        
                                       $('#'+Table_ID).DataTable().ajax.reload();
                                        editor.close();
                                    }else{
                                         editor.close();
                                    }
                                }else if(data.action =='edit'){
                                    //console.log(json);
                                    
                                    if(json){
                                        
                                        $('#'+Table_ID).DataTable().ajax.reload();
                                        editor.close();
                                    }else{
                                         editor.close();
                                    }
                                }
                            },
                            error: function (xhr, error, thrown) {
                                //console.log(xhr, error, thrown);
                                editor.close();
                            }
                        } );
                    },

                    table: "#" + Table_ID,
                    idSrc: rowId,
                    fields:  mainArr
                } );
            
            // over here  . 

            if(EnableChildRows == 1 || EnableChildRowsRunTym == 1){
                /* Formatting function for row details - modify as you need */
                function format ( d ) {
                    var lgt = d.length-1; 
                    //console.log(d[lgt]);
                
                    // `d` is the original data object for the row
                    var html = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';

                    if(d[lgt][0] != undefined){
                        var PacKey =  Object.keys(d[lgt][0]);
                        html += '<tr>';
                        for(var ki in PacKey){
                            html +=  '<td >' + PacKey[ki] + '</td>' ; 
                        }
                        html += '</tr>';
                    }

                    for(var i in d[lgt]){
                        html += '<tr>' ;
                        for(var k in d[lgt][i]){
                            html +=  '<td >' + d[lgt][i][k] + '</td>' ;  
                        }
                        html += '</tr>';
                        
                    }
                    html += '</table>'; 
                
                    return html ;
                }  
                $('#'+Table_ID).on('click', 'tbody td', function () {
                    var table1 = $('#'+Table_ID).DataTable();
                    var tr = $(this).closest('tr');
                   
                    var row = table1.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        var data = row.data();
            
                        row.child( format(data) ).show();
                        tr.addClass('shown');
                    }
                } );
            }
            if(tableDesign == '1'){
                var DataTable = $("#" + Table_ID).DataTable({
            
                    columnDefs: [
                        {
                            targets: ['_all'],
                            className: 'mdc-data-table__cell'
                        }
                    ],
    
                    language: {
                        "decimal": ",",
                        "thousands": ".",
                        "info":           "_START_ to _END_ of _TOTAL_ entries",
                        "infoEmpty":      "",
                        "infoFiltered":   "(_MAX_  Total entries)",
                        "search": "_INPUT_",
                        "searchPlaceholder": "Global Search",
                            "lengthMenu":     "_MENU_",
                    },
                        
                    select: {
                style:    'multi',
                
                },
                    "ajax": url , 
                    "colReorder": {
                        "realtime": true, 
                        //"order": columnOrder
                    },
                    "rowId": rowId,
                    
                    "deferRender": true, 
                    "select": false,
                    //"fixedColumns": false,
                   
                    // "fixedHeader": {
                    //         header: true,
                    //         footer: false,
                     
                    //     },
                    "fixedHeader" : {
                        header : true,
                        footer : false,
                        headerOffset: 0
                    },
                    "autoFill": false,
                                
                                dom:
                                "<'row'<'col-sm-12 table-controls'fBli>>" +  "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-3'><'col-sm-12'p>>" ,
                                
                                buttons: [
                                    {extend: "copy", className: "buttonsToHide"},
                                    {extend: 'csv',
                                        className: "buttonsToHide",
                            charset: 'UTF-32',
                        fieldSeparator: ';',
                            bom: true, },
                        
                    // {
                    //         extend: 'excel',
                    //         className: "buttonsToHide",
                    //         title: '',
                    //         exportOptions: {
                    //         columns: ':visible',
                    //         format: {
                                    
                    //             body: function(data, row, column, node) {
    
                    //                 var title= headerExcel[column];  
                    //                 var d =  data;
                    //                 if(excludeZeroCol != undefined && excludeZeroCol.includes(title) )
                    //                 {
                                        
                    //                 }else{
                                    
                    //                     var d = data.toString().replace(/\./g, "").replace(/,/, ".");
                    //                     if(d.charAt(1) != '.')
                    //                     {
                    //                     d = d.replace(/^0+/, '');
                    //                     }
                                    
                    //                 }
    
                    //                 return $.isNumeric(d) ? d : data;
    
                    //             }
                    //             }
                    //         }
                    // },
                    { 
                        extend: 'excelHtml5',
                        className: "buttonsToHide",
                        title: '',
                        exportOptions: {
                        columns: ':visible',
                        format: {
                                
                            body: function(data, row, column, node) {
                              alert("njknjk");
                                var title= headerExcel[column];  
                                var d =  data;
                                if(excludeZeroCol != undefined && excludeZeroCol.includes(title) )
                                {
                                    
                                }else{
                                
                                    var d = data.toString().replace(/\./g, "").replace(/,/, ".");
                                    if(d.charAt(1) != '.')
                                    {
                                    d = d.replace(/^0+/, '');
                                    }
                                
                                }

                                return $.isNumeric(d) ? d : data;

                            }
                            }
                        },
                        customize: function( xlsx ) {
                            var table = $('#'+Table_ID).DataTable();
                           //console.log(table.rows({search: 'applied'}).data());
                            if(EnableChildRows){
                                tdata = table.rows({search: 'applied'}).data();
                                tcnt = table.rows({search: 'applied'}).count();
                                // Get number of columns to remove last hidden index column.
                                var numColumns = table.columns().header().count();
                                
                                // Get sheet.
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        
                                var col = $('col', sheet);
                                // Set the column width.
                                $(col[1]).attr('width', 20);
                        
                                // Get a clone of the sheet data.        
                                var sheetData = $('sheetData', sheet).clone();
                                
                                // Clear the current sheet data for appending rows.
                                $('sheetData', sheet).empty();
                        
                                // Row index from last column.
                                var DT_row;        // Row count in Excel sheet.
                        
                                var rowCount = 1;
                                var testrowCount= 1;
                                // Itereate each row in the sheet data.
                                $(sheetData).children().each(function(index) {
                        
                                    // Used for DT row() API to get child data.
                                    var rowIndex = index - 1;
                                    
                                    // Don't process row if its the header row.
                                    if (index > 0) {
                                    
                                    // Get row
                                    var row = $(this.outerHTML);
                                    
                                    // Set the Excel row attr to the current Excel row count.
                                    row.attr('r', rowCount);
                                    
                                    // var colCount = 1;
                                    row.children().each(function(index) {
                                        var cell = $(this);
                                        
                                        // Set each cell's row value.
                                        var rc = cell.attr('r');
                                        rc = rc.replace(/\d+$/, "") + rowCount;
                                        cell.attr('r', rc);         
                                        // //console.log(cell.text());
                                        if (colCount === numColumns) {
                                        
                                        cell.html('');
                                        }
                                        
                                        colCount++;
                                    });
                                    
                                    // Get the row HTML and append to sheetData.
                                    row = row[0].outerHTML;
                                
                                    $('sheetData', sheet).append(row);
                                    rowCount = rowCount + 1 ;
                                
                                    if( rowIndex  <= tcnt){
                                        // Get the child data - could be any data attached to the row.
                                        var childData = tdata[rowIndex];
                                        var childLen = childData.length-1;
                                        //console.log(childData[childLen][0]);
                                        if (childData[childLen][0] != undefined) {
                                            
                                            // Prepare Excel formated row
                                            headerRow = '<row r="' + rowCount + 
                                                    '" s="2">' ;

                                            var PacKey =  Object.keys(childData[childLen][0]);
                                            
                                            var abc = ["A", "B", "C" ,"D"]; 
                                            var c = 0;
                                            for (var ki in PacKey) {
                                                headerRow +='<c t="inlineStr" r="'+abc[c] + rowCount + 
                                                '" s="2"><is><t>'+PacKey[ki] + 
                                                '</t></is></c>';
                                                c = c+1;
                                            }
                                            headerRow += '</row>';
                                            
                                            // Append header row to sheetData.
                                            $('sheetData', sheet).append(headerRow);
                                            rowCount++; // Inc excelt row counter.
                                            
                                            for(var ids in childData[childLen]){
                                                var abc = ["A", "B", "C" ,"D"]; 
                                                var c = 0;
                                                childRow = '<row r="' + rowCount + 
                                                '" >' ;
                                                for(var k in childData[childLen][ids]){
                                                    childRow +='<c t="inlineStr" r="'+abc[c] + rowCount + 
                                                    '" ><is><t>'+childData[childLen][ids][k] + 
                                                    '</t></is></c>';
                                                    c = c+1;
                                                }
                                                childRow += '</row>';
                                                // Append row to sheetData.
                                                $('sheetData', sheet).append(childRow);
                                                rowCount++; // Inc excelt row counter.
                                                
                                            }
                                            
                                        }
                                    }  
                                    // Just append the header row and increment the excel row counter.
                                    } else {
                                    var row = $(this.outerHTML);
                                    
                                    var colCount = 1;
                                    
                                    // Remove the last header cell.
                                    row.children().each(function(index) {
                                        var cell = $(this);
                                    
                                        if (colCount === numColumns) {
                                        cell.html('');
                                        }
                                        
                                        colCount++;
                                    });
                                    row = row[0].outerHTML;
                                    $('sheetData', sheet).append(row);
                                    rowCount++;
                                    }
                                });        
                            }       
                        }
                    },
                    {extend: "pdf", className: "buttonsToHide"  ,  
                     customize: function(doc, config) { 
                        var tableNode;
                        for (i = 0; i < doc.content.length; ++i) {
                          if(doc.content[i].table !== undefined){
                            tableNode = doc.content[i];
                            break;
                          }
                        }
       
                        var rowIndex = 0;
                        var tableColumnCount = tableNode.table.body[rowIndex].length;
                         console.log(tableColumnCount);
                        if(tableColumnCount > 8){
                            //
                            doc.pageOrientation = 'landscape';
                            doc.pageSize = 'A0';
                            doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                          
                            
                        }
                        }
                    } ,
                    { extend: 'create', editor: editor , className: "buttonsToHide"  },
                    {extend: 'edit', editor: editor ,  action: function () {
                        editRow.edit( {
                            title: 'Edit'
                            }  );
                        } , className: "buttonsToHide" },
                    { extend: 'remove' , className: "buttonsToHide" , editor: editor}, 
                    {
                    text: 'Import CSV'
                        , className: "buttonsToHide"
                    },
                    {
                        extend: 'selectAll',
                        className: 'btn-space buttonsToHide'
                    },{
                        extend: 'selectNone',
                        
                        className: 'btn-space buttonsToHide'
                    }
                    
    
                    ],
    
                    "search": {
                        "regex": true
                    },
                    
                    "processing": true,
                    "magicGoFaster": true,
    
                    searchCols: predefineSearch,
                    columnDefs: [
                        { "visible": false, "targets": hideColumn , "searchable": true },
                        { targets: columnAlignment, className: 'td-right' },
                        { targets: '_all', className: 'td-left'},
                    ],
                        
                    orderCellsTop: true,
                    order: [[sort, defaultSortType]],
                    // paging : groupRowsFlag == '1' ? false : true,
                    scrollY:       ScrollWidth,
                    scrollCollapse: true,
                    paging : PaginationFlag == '1' ? false : true,
                    rowGroup: {
    
                        
                        enable: EnablerowGroup == '1' ? true : false,
                        dataSrc: EnableRowGroupColumn,
                            startRender: function(rows, group) {
                            
                            if(closeAll == 'closeall'){
                                var collapsed = false;
                            }else if(openAll == 'openall'){
                                var collapsed = true;
                            }else{
                                var collapsed = !!collapsedGroups[group];
                            }
                            
                            // Code for making it collapse
                            rows.nodes().each(function (r) {
                                r.style.display = 'none';
                                if (collapsed) {
                                r.style.display = '';
                                }});
                            var columnTotal = 0;
                            var mainArr = {};
                            var customSum = {};
                            var valArr = {};
                        
                            $.each(footerColumn, function( index, value ) {
                                
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
                                
                                if(value['perform_custom_sum'] == 0 || value['footer_sum_only'] !== undefined)
                                {   
    
                                    columnTotal = rows
                                                .data()
                                                .pluck(index)
                                                .reduce( function (a, b) {
                                            var resultValue = intVal(a) + intVal(b);
                                            return resultValue;
                                        }, 0 );
                                    
                                    mainArr[value['column_name']] = columnTotal;
                                    if(value.decimal != undefined)
                                    {
                                            valArr[index]   = columnTotal.toFixed(value.decimal).toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                                        
                                    }else{
                                            valArr[index] = columnTotal.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    
                                    }
                                    
                                }
                                else if(value['perform_custom_sum'] == 1){
                                    columnTotal = rows
                                                .data()
                                                .pluck(index)
                                                .reduce( function (a, b) {
                                            var resultValue = intVal(a) + intVal(b);
                                            return resultValue;
                                        }, 0 );
                                    
                                    mainArr[value['column_name']] = columnTotal;
                                    customSum[index] = value['custom_sum'];
                                }
                            });
                            
                            
                            $.each(customSum, function( index, value ){
                                
                                
                                var formula = value;
                                
                                $.each(mainArr, function( indexs, values ){
                                    
                                    formula = formula.replace(indexs, values);
                                });
                                
                                formula = eval(formula);
                               
                                if(formula != '' && formula != undefined ){
                                    formula = formula.toFixed(2);
                                    formula = formula.split('.').join(',');
                                    //formula = formula.replace(/(\d)(?=(\d{2})+(?!\d))/g, '$1,');    
                                }
    
                                valArr[index]=formula;
                            });
    
                            // Add category name to the <tr>. NOTE: Hardcoded colspan
                            
                            var entry = $('<tr/>');
                            var k = 0 , cnt = 0 ;
                            var newArr = [];
                            var len = DataTable.columns().header().length;
                            $.each(valArr, function( ke, va ){
                                newArr.push(parseInt(ke));
                            });
                            
                            if(jsonData.HideColumn == undefined ){
                                var hideColumn = [];
                                hideColumn[0] = 1000;
                            }else{
                                var hideColumn = [];
                                hideColumn = jsonData.HideColumn;
                            }
                            
                            for(k ; k < len; k++){
                                var pass = 0 ;
                                if(cnt == 0 && !(hideColumn.includes(k))){
                                        entry.append('<td >'+group+ ' (' + rows.count() + ' entries)</td>');
                                        cnt = cnt +1;
                                        
                                }else if((newArr.includes(k)) && !(hideColumn.includes(k))  ){
                                    
                                    entry.append('<td class="td-right">'+valArr[k]+'</td>');
                                    
                                }else if(k != 0 && !(hideColumn.includes(k)) ){
                                    
                                    entry.append('<td class="td-right"></td>');
                                    
                                }
                            }
                            
                            
                            entry .attr('data-name', group)
                                    .toggleClass('collapsed', collapsed);
                            return entry;
    
                            }
                            
                        
                    },
                    "drawCallback": function( settings ) {
                        var api = this.api();
                
                        // Output the data for the visible rows to the browser's console
                        if(api.rows( {page:'current'} ).data()[0] != 'undefined'   ){
                                
                            if (pieDiscription != '' && pieDiscription != null) {
                                
                                $.each(JSON.parse(pieDiscription), function( key, pieValue ) {
                                
                                    
                                    if(pieValue.TableId == placeholderId){
                                        var pieId = pieValue.pie_id;
                                        var calType = pieValue.CalculationType;
                                        var displayType = pieValue.DisplayType;
                                        var pieType = pieValue.pieType;
                                        var showLabelPie = pieValue.ShowPieLabel;
                                        if(base_url != 'http://www.babcnew.com')
                                        {
                                            base_url = absPath[0]+'public';
                                        }   
                                        $.getScript(base_url + '/assets/Custome_Code/Highsofts/customHighPieCharts.js', function()
                                        {
                                            
                                            setTableEvents(DataTable,'','', '', '', '' , '' , pieChartArray , pieChartLabel , pieChartPresent ,pieId , calType, displayType , pieType, showLabelPie, pieChartArrayDrillDown, pieChartLabelDrillDown);
                                            
                                        });
                                    
                                    }
                                });
                            }
                        }
                    },
                    initComplete: function () {
                        /* part for new toool on top one 
                        // $("."+ Table_ID ).append($('#'+Table_ID+'_filter'));
                        // $("."+ Table_ID ).append($('.dt-buttons'));
                        */
                        if(EnableSideBar == '1' && TableType == '5'){
                            var path = TableSideBar+data[RouteColumnIndex]+'&silderActionId='+TabAction;
                            //console.log(TableType);
                            if(TableSideBar2 != ''){
                                var path2 = TableSideBar2+data[RouteColumnIndex2]+'&silderActionId='+TabAction2;
                                $(row).attr('onClick', "toggleNav('"+path+"' , '"+TableType+"' ,'"+path2+"')");
                            }else{
                                $(row).attr('onClick', "toggleNav('"+path+"' ,'"+TableType+"')");
                            }
                        }

                        count = 0;
                        var selectFlag = 0;
                        // this part of code is for setting the default mulitple seletion that's been set from the Admin side
                        if(window[Table_ID + 'AllowMultipleSelectionColumn']){
                           
                            for (var k in window[Table_ID + 'AllowMultipleSelectionColumn']){ 
                                
                                this.api().columns(k).every( function () {
                                    var title = this.header();
                                    var tempTitle = $(title).text();
                                    // if(tempTitle.includes('Normal'))  {
                                    //      tempTitle =$(title).children('span').text(); 
                                    // }
                                    
                                    tempTitle = tempTitle.replace('#' , '_');
                                    tempTitle = tempTitle.replace('%' , '_');
                                    tempTitle = tempTitle.trim();
                                    //replace spaces with dashes
                                    title = $(title).html().replace(/[\W]/g, '-');
                                    title = title + Table_ID;
                                    var column = this;
                                    
                                    if(multipleSearchSelectorFlag != 0){
                                        $('#mainS_'+Table_ID+tempTitle).hide();
                                        $('#searchDiv_'+Table_ID+tempTitle).show();
                                    }
                                    
                                    console.log(title);
                                    var select = $('<select id="' + title + '" class="select2 search_by" style="width:100%"></select>')
                                    .appendTo( "#searchDiv_"+Table_ID+tempTitle)
                                    .on( 'change', function () {
                                        //Get the "text" property from each selected data 
                                        //regex escape the value and store in array
                                       
                                        var data = $.map( $(this).select2('data'), function( value, key ) {
                                        return value.text ? '^' + $.fn.dataTable.util.escapeRegex(value.text) + '$' : null;
                                                    });
    
                                        
                                        //if no data selected use ""
                                        if (data.length === 0) {
                                        data = [""];
                                        }
                                    var val = data.join('|');
                                    
                                    if(val != '' ||  selectFlag == 1){
                                        
                                        column
                                            .search( val ? val : '', true, false )
                                            .draw();
                                        }
                                    });
                                    
    
                                    column.data().unique().sort().each( function ( d, j ) {
                                        select.append( '<option value="'+d+'">'+d+'</option>' );
                                    } );
                                    
                                        //use column title as selector and placeholder
                                    $('#' + title).select2({
                                    multiple: true,
                                    closeOnSelect: false,
                                    placeholder: "Search Multiple "
                                    });
                                
                                    //initially clear select otherwise first option is selected
                                    if(typeof predefineSearch === 'undefined' ){
                                        $('#'+title).val('').trigger('change');
                                    }else{
                                    var defValue = predefineSearch[k].sSearch;
                                    defValue = defValue.replace(/\W_/g,"");
                                    defValue = defValue.split('|');
                                    $('#'+title).val(defValue).trigger('change');  
                                    }
                                                            
                                });
    
                                };
    
                            }
                            selectFlag = 1;
                        // this part of code is for setting the default Range filter that's been set from the Admin side
                        var api = this.api();
                        if(rangePredefineSearchFlag)
                        {
                            //console.log(predefineSearchForRange);
                            $.each(predefineSearchForRange , function(key, value){
                                var k = '';
                                var title = api.column(key).header();
                                var tempTitle = $(title).text();  
                                // if(tempTitle.includes('Normal'))  {
                                //      tempTitle =$(title).children('span').text(); 
                                // } 
                                tempTitle = tempTitle.replace('#' , '_');
                                tempTitle = tempTitle.replace('%' , '_');
                                tempTitle = tempTitle.trim();
                                // var column = this;
                                var getToValue = '';
                                var getFromValues = '';
                                
                                $('#mainS_'+Table_ID+tempTitle).hide();
                                $('#fromTo_'+Table_ID+tempTitle).show();
                            
                                //tab = Table_ID+"_"+tempTitle;
                                
                                $.fn.dataTable.ext.search.push(
                                    function( settings, data, dataIndex ) {
                                            if(ColumnIndexRange != '')
                                            {
                                                title = api.column(ColumnIndexRange).header();
                                                tempTitle = $(title).text(); 
                                                tempTitle = tempTitle.trim();
                                                // if(tempTitle.includes('Normal'))  {
                                                //      tempTitle =$(title).children('span').text(); 
                                                // }        
                                            }
                                            tab = Table_ID+"_"+tempTitle;
                                            var tabID = tab.split('_');
                                            tabID = tabID[0]+'_'+tabID[1];
                                            
                                            if(settings.nTable.id == tabID){
        
                                            if(Object.keys(rangePredefineSearchFlag).length != 0 && ColumnIndexRange != ''){
        
                                                var min = parseInt( value['from'], 10 ) ;
                                                var max = parseInt( value['to'], 10 ) ;
                                                
                                                }else{
                                                    
                                                    var min = parseInt( $('#'+tab+'fromRange').val(), 10 ) ;
                                                    var max = parseInt( $('#'+tab+'toRange').val(), 10 ) ;
                                                }
                                                if(ColumnIndex != -1)
                                                {
                                                    key = ColumnIndex;
                                                }
                                                
                                                var temp_data = data[key].split(' ').join('');
                                                var cntComma = 0;
                                                var cntDot = 0;
                                                var str = temp_data;
        
                                                for (var t = 0;  t <= str.length; t++) {
                                                    
                                                    if (str[t] === ".") 
                                                        {
                                                            cntDot = t;
                                                        }
                                                        else if(str[t] === ".")
                                                        {
                                                            cntComma = t;
                                                        }
                                                }
                                                if(cntComma > 0)
                                                {
                                                    temp_data = temp_data.split(',').join('');
                                                }else if (cntDot > 0){
                                                    temp_data = temp_data.split('.').join('');
                                                }
                                                temp_data = parseInt(temp_data);
                                                temp_data = Math.round(temp_data);
                                                var columnFromTo = parseFloat(temp_data) || 0;
                                                
                                                    if ( ( isNaN( min ) && isNaN( max ) ) ||
                                                        ( isNaN( min ) && columnFromTo <= max ) ||
                                                        ( min <= columnFromTo   && isNaN( max ) ) ||
                                                        ( min <= columnFromTo   && columnFromTo <= max ) )
                                                    {
                                                        return true;
                                                    }
                                                    return false;
                                                }
                                                else
                                                {
                                                    return true;
                                                }
                                            
                                            
    
                                        
                                    });
                                    
                                    DataTable.draw();
                                    
                                    
                                
                            });
                        }
                        rangePredefineSearchFlag = {};
                        // This Part of code is for column order set at Admin Side
                        DataTable.colReorder.order(columnOrder);
                        api.columns().eq(0).each( function (ind) {
                            var title= api.column(ind).header();
                            if(api.column(ind).visible()){
                                if(headerExcel.includes(title.getAttribute("id")) != true){
                                    headerExcel.push(title.getAttribute("id"));
                                }
                            }       
                        });
                        //console.log("done");
                        if(FooterSumLocation != '1'){
                            var doc=document.getElementById( Table_ID +"_wrapper");
                            
                            div1 = doc.querySelector('.dataTables_scrollBody');
                            div2 = doc.querySelector('.dataTables_scrollFoot');
                            div3 = doc.querySelector('.dataTables_scrollHead');
                            //$( div2 ).insertBefore( div1 );
                            div2.style.overflow = '';
                            div3.style.overflow = '';
                            $(div1 ).prepend( $(div2) );
                            $(div1 ).prepend( $(div3) );
                            
                        }else{
                            var doc=document.getElementById( Table_ID +"_wrapper");
                            
                            div1 = doc.querySelector('.dataTables_scrollBody');
                            div2 = doc.querySelector('.dataTables_scrollFoot');
                            div3 = doc.querySelector('.dataTables_scrollHead');
                            //$( div2 ).insertBefore( div1 );
                            div2.style.overflow = '';
                            div3.style.overflow = '';
                            $(div1 ).append( $(div2) );
                            $(div1 ).prepend( $(div3) );
                        }
                        
                        
                            
                        
                        // this part of code is for new design template
                        // var tbody = document.getElementById( Table_ID +"_tbody");
                        // if(tbody){
                        //     $("#"+ Table_ID +"_tbody").append($('#'+Table_ID+' > tbody'));
                        // } 
                        // var tpage = document.getElementById( Table_ID +"_pagination ");
                        // if(tpage){
                        //      $("#"+ Table_ID +"_pagination ").append($('#'+Table_ID+'_paginate'));
                        // }
                        
                    },
                    
                    "footerCallback": function ( row, data, start, end, display ) {
                        
                        var api = this.api();
                        if(base_url != 'http://www.babcnew.com')
                        {
                            base_url = absPath[0]+'public';
                        }
                        //$.getScript(base_url + '/assets/Custome_Code/DataTables/customFooterSum.js', function()
                        //{
                            
                            GenerateFooter(api , footerColumn ,  pannelIds , placeholderId ,Table_ID , rowGroupArrNew);
                        //});
                    },
                    "rowCallback": function( row, data ) {

                        ////console.log(data);
                        // console.log(row[0]);
                        var length_ = $('#'+Table_ID).find("tr:first th").length;
                        var array_length = Object.keys(data).length;
                        
                        if(EnableOnclickBtn == '0' && array_length > length_ ){
                           
                            // $.getScript(base_url + '/public/assets/Custome_Code/DataTables/customButton.js', function()
                            // {});
                            var links = data[Object.keys(data).length-1];
                            var names = data[Object.keys(data).length-2];
                            
                            var colName = '';
                            var namesNew = names.split('%').join('') ;
                           
                            if($('td:eq(0)', row).text().includes(namesNew) ){
                                colName = $('td:eq(0)', row).text();
                                colName = colName.replace(namesNew , '');
                            }else {
                               
                                colName = $('td:eq(0)', row).text();
                            }
                           
                            var temp1 = tableSubActionsButtonRows(Table_ID, links,names , colName , $('td:eq(1)', row).text() );
                            $('td:eq(0)', row).html(temp1);

                        }
                        if(EnableSideBar == '1' && TableType == '4'){
                            var path = TableSideBar+data[RouteColumnIndex]+'&silderActionId='+TabAction;
                            //console.log(TableType);
                            if(TableSideBar2 != ''){
                                var path2 = TableSideBar2+data[RouteColumnIndex2]+'&silderActionId='+TabAction2;
                                $(row).attr('onClick', "toggleNav('"+path+"' , '"+TableType+"' ,'"+path2+"')");
                            }else{
                                $(row).attr('onClick', "toggleNav('"+path+"' ,'"+TableType+"')");
                            }
                        }

                        if(AllowColumnRowMarking == '1'){
                            if(ColoringType == '1'){
                                if(ColoringJsonText){
                                    $.each(ColoringJsonText, function (JsonKey, JsonValue) {
                                    
                                        $.each(JsonValue, function (JKey, JValue) {
                                            
                                            if ( data[JsonKey] == JValue.ColumnText ) {
                                                $('td:eq('+JsonKey+')', row).addClass('columnColor');
                                                $('td:eq('+JsonKey+')', row).css('color', JValue.TextColor);
                                            }
                                        });
                                       
                                    });
                                }else{
                                  
                                    $.each(ColumnNameColor, function (JsonKey, JsonValue) {
                                            var actualData = data[JsonKey] ;
                                        $.each(JsonValue, function (JKey, JValue) {
                                            
                                            if(ColorSettingType == 2)
                                            {
                                                 
                                                actualData =   parseFloat(data[JsonKey].replace(/[.\s]/g, '').replace(/[,]/g, '.') * 1);
                                            }
                                            else if(ColorSettingType == 4)
                                            {
                                                actualData = new Date(data[JsonKey]);
                                                JValue.SecondParameter=new Date(JValue.SecondParameter);
                                            }
                                            
                                            
                                            if(JValue.Condition === '='){
                                              
                                                if ( actualData  === String(JValue.SecondParameter) ) {
                                                   
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }else if (actualData  == 'Bråskande'){
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }else if(JValue.Condition == '!='){
                                                if ( actualData  != JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '>'){
                                                if ( actualData  > JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '<'){
                                                if ( actualData < JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '>='){
                                                if ( actualData  >= JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }else if(JValue.Condition == '<='){
                                                if ( actualData  <= JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == 'InBetween'){
                                                if ( actualData >= JValue.FirstParameter  && actualData  <= JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }
                                            
                                        });
                                       
                                    });
                                }
                                
                            }else if(ColoringType == '3'){
                                console.log( NotiColumnMarking);
                                console.log("bherkl");
                                if(ColoringJsonText){
                                    $.each(ColoringJsonText, function (JsonKey, JsonValue) {
                                    
                                        $.each(JsonValue, function (JKey, JValue) {
                                            if ( data[JsonKey] == JValue.ColumnText ) {
                                                $(row).addClass('columnColor');
                                                $(row).css('background-color', JValue.TextColor);
                                            }
                                        });
                                       
                                    });
                                }else{
                                    $.each(ColumnNameColor, function (JsonKey, JsonValue) {
                                        var actualData = data[JsonKey] ;
                                        $.each(JsonValue, function (JKey, JValue) {
                                            if(ColorSettingType == 2)
                                            {
                                                
                                                actualData =   parseFloat(data[JsonKey].replace(/[.\s]/g, '').replace(/[,]/g, '.') * 1);
                                            }
                                            else if(ColorSettingType == 4)
                                            {
                                                actualData = new Date(data[JsonKey]);
                                                JValue.SecondParameter=new Date(JValue.SecondParameter);
                                            }
                                            
                                            if(JValue.Condition == '='){

                                                if ( actualData  == JValue.SecondParameter ) {
                                                    $(row).addClass('columnColor');
                                                    $(row).css('background-color', JValue.TextColors);
                                                }
                                            }else if(JValue.Condition == '!='){
                                                if ( actualData  != JValue.SecondParameter ) {
                                                    $( row).addClass('columnColor');
                                                    $( row).css('background-color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '>'){
                                                if ( actualData  > JValue.SecondParameter ) {
                                                    $( row).addClass('columnColor');
                                                    $(row).css('background-color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '<'){
                                                if ( actualData < JValue.SecondParameter ) {
                                                    $(row).addClass('columnColor');
                                                    $( row).css('background-color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '>='){
                                                if ( actualData  >= JValue.SecondParameter ) {
                                                    $( row).addClass('columnColor');
                                                    $(row).css('background-color', JValue.TextColors);
                                                }
                                            }else if(JValue.Condition == '<='){
                                                if ( actualData  <= JValue.SecondParameter ) {
                                                    $(row).addClass('columnColor');
                                                    $( row).css('background-color', JValue.TextColors);
                                                }
                                            }else if(JValue.Condition == 'InBetween'){
                                                if ( actualData >= JValue.FirstParameter  && actualData  <= JValue.SecondParameter ) {
                                                    $(row).addClass('columnColor');
                                                    $(row).css('color', JValue.TextColors);
                                                }
                                            }
                                            
                                            
                                        });
                                   
                                    });
                                   
                                }
                                

                            }else if (ColoringType == '2'){

                             
                                if(ColoringJsonText){
                                    $.each(ColoringJsonText, function (JsonKey, JsonValue) {
                                        var className = 'columnColor';
                                        //$('td:eq('+JsonKey+')',row).addClass('columnColor-'+JsonValue.TextColor);
                                        $('td:eq('+JsonKey+')',row).addClass('columnColor');
                                        $('td:eq('+JsonKey+')',row).css('background-color', JsonValue.TextColor);
                                    });
                                }
                                else{
                                    $.each(ColumnNameColor, function (JsonKey, JsonValue) {
                                        //var actualData = data[JsonKey] ;
                                    $.each(JsonValue, function (JKey, JValue) {
                                        $('td:eq('+JsonKey+')',row).addClass('columnColor');
                                        $('td:eq('+JsonKey+')',row).css('background-color', JValue.TextColors);
                                        
                                    });
                                   
                                    });

                                }
                                
                            }else  if(ColoringType == '4'){
                                if(ColoringJsonText){
                                    $.each(ColoringJsonText, function (JsonKey, JsonValue) {
                                    
                                        $.each(JsonValue, function (JKey, JValue) {
                                            
                                            if ( data[JsonKey] == JValue.ColumnText ) {
                                                $('td:eq('+JsonKey+')', row).addClass('columnColor');
                                                $('td:eq('+JsonKey+')', row).css('background-color', JValue.TextColor);
                                            }
                                        });
                                       
                                    });
                                }else{
                                    
                                    $.each(ColumnNameColor, function (JsonKey, JsonValue) {
                                            var actualData = data[JsonKey] ;
                                        $.each(JsonValue, function (JKey, JValue) {
                                         
                                            if(ColorSettingType == 2)
                                            {
                                                 
                                                actualData =   parseFloat(data[JsonKey].replace(/[.\s]/g, '').replace(/[,]/g, '.') * 1);
                                            }
                                            else if(ColorSettingType == 4)
                                            {
                                                actualData = new Date(data[JsonKey]);
                                                JValue.SecondParameter=new Date(JValue.SecondParameter);
                                            }
                                            
                                          
                                            if(JValue.Condition === '='){
                                                
                                                if ( actualData  === String(JValue.SecondParameter) ) {
                                                   
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                    
                                                }else if (actualData  == 'Bråskande'){
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }else if(JValue.Condition == '!='){
                                                if ( actualData  != JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '>'){
                                                if ( actualData  > JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '<'){
                                                if ( actualData < JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '>='){
                                                if ( actualData  >= JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }else if(JValue.Condition == '<='){
                                                if ( actualData  <= JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == 'InBetween'){
                                               
                                                if ( parseInt(actualData) >=  parseInt(JValue.FirstParameter)  &&  parseInt(actualData)  <=  parseInt(JValue.SecondParameter)  ) {
                                                    
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }
                                            
                                        });
                                       
                                    });
                                }
                                
                            }
                            
                        }
                        
                    }    
                });
            } else{
                var DataTable = $("#" + Table_ID).DataTable({
            
                    columnDefs: [
                        {
                            targets: ['_all'],
                            className: 'mdc-data-table__cell'
                        }
                    ],
    
                    language: {
                        "decimal": ",",
                        "thousands": ".",
                        "info":           "_START_ to _END_ of _TOTAL_ entries",
                        "infoEmpty":      "",
                        "infoFiltered":   "(_MAX_  Total entries)",
                        "search": "_INPUT_",
                        "searchPlaceholder": "Global Search",
                            "lengthMenu":     "_MENU_",
                    },
                        
                   
                    "ajax": url , 
                    "colReorder": {
                        "realtime": true, 
                        //"order": columnOrder
                    },
                    "rowId": rowId,
                    
                    "deferRender": true, 
                    "fixedColumns": false,
                    "fixedHeader": {
                            header: true,
                            footer: false,
                        },
                    "autoFill": false,
                                
                                dom:
                                "<'row'<'col-sm-12 table-controls'fBli>>" +  "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-3'><'col-sm-12'p>>" ,
                                
                                buttons: [
                                    {extend: "copy", className: "buttonsToHide" , attr:  {
                                        title: 'Copy',
                                        id: 'copyBtn_'+ButtonName
                                    }},
                                    {extend: 'csv',
                                        className: "buttonsToHide",
                            charset: 'UTF-32',
                        fieldSeparator: ';',
                            bom: true, },
                        
                    // {
                    //         extend: 'excel',
                    //         className: "buttonsToHide",
                    //         title: '',
                    //         exportOptions: {
                    //         columns: ':visible',
                    //         format: {
                                    
                    //             body: function(data, row, column, node) {
                                   
                    //                 var title= headerExcel[column];  
                    //                 var d =  data;
                    //                 if(excludeZeroCol != undefined && excludeZeroCol.includes(title) )
                    //                 {
                                        
                    //                 }else{
                                    
                    //                     var d = data.toString().replace(/\./g, "").replace(/,/, ".");
                    //                     if(d.charAt(1) != '.')
                    //                     {
                    //                     d = d.replace(/^0+/, '');
                    //                     }
                                    
                    //                 }
    
                    //                 return $.isNumeric(d) ? d : data;
    
                    //             }
                    //             }
                    //         }
                    // },
                    { 
                        extend: 'excelHtml5',
                        className: "buttonsToHide",
                        title: '',
                        exportOptions: {
                        columns: ':visible',
                        format: {
                                
                            body: function(data, row, column, node) {
                               
                                var title= headerExcel[column];  
                                var d =  data;
                                if(excludeZeroCol != undefined && excludeZeroCol.includes(title) )
                                {
                                    
                                }else{
                                
                                    var d = data.toString().replace(/\./g, "").replace(/,/, ".");
                                    if(d.charAt(1) != '.')
                                    {
                                    d = d.replace(/^0+/, '');
                                    }
                                
                                }

                                return $.isNumeric(d) ? d : data;

                            }
                            }
                        },
                        customize: function( xlsx ) {
                            
                            if((EnableChildRows == 1 || EnableChildRowsRunTym == 1) && ExcelCheck == '0'){
                                var table = $('#'+Table_ID).DataTable();
                                tdata = table.rows({search: 'applied'}).data();
                                tcnt = table.rows({search: 'applied'}).count();
                                // Get number of columns to remove last hidden index column.
                                var numColumns = table.columns().header().count();
                                
                                // Get sheet.
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        
                                var col = $('col', sheet);
                                // Set the column width.
                                $(col[1]).attr('width', 20);
                        
                                // Get a clone of the sheet data.        
                                var sheetData = $('sheetData', sheet).clone();
                                
                                // Clear the current sheet data for appending rows.
                                $('sheetData', sheet).empty();
                        
                                // Row index from last column.
                                var DT_row;        // Row count in Excel sheet.
                        
                                var rowCount = 1;
                                var testrowCount= 1;
                                // Itereate each row in the sheet data.
                                $(sheetData).children().each(function(index) {
                        
                                    // Used for DT row() API to get child data.
                                    var rowIndex = index - 1;
                                    
                                    // Don't process row if its the header row.
                                    if (index > 0) {
                                    
                                    // Get row
                                    var row = $(this.outerHTML);
                                    
                                    // Set the Excel row attr to the current Excel row count.
                                    row.attr('r', rowCount);
                                    
                                    // var colCount = 1;
                                    row.children().each(function(index) {
                                        var cell = $(this);
                                        
                                        // Set each cell's row value.
                                        var rc = cell.attr('r');
                                        rc = rc.replace(/\d+$/, "") + rowCount;
                                        cell.attr('r', rc);         
                                        // //console.log(cell.text());
                                        if (colCount === numColumns) {
                                        
                                        cell.html('');
                                        }
                                        
                                        colCount++;
                                    });
                                    
                                    // Get the row HTML and append to sheetData.
                                    row = row[0].outerHTML;
                                
                                    $('sheetData', sheet).append(row);
                                    rowCount = rowCount + 1 ;
                                
                                    if( rowIndex  <= tcnt){
                                        // Get the child data - could be any data attached to the row.
                                        var childData = tdata[rowIndex];
                                        var childLen = childData.length-1;
                                        
                                        //console.log(childData[childLen][0]);
                                        if (childData[childLen][0] != undefined) {
                                            
                                            if(EnableChildRowsRunTym == 1 && runtymDownload == 0)
                                            {
                                                var tesstrow = table.row(rowIndex);
                                                var className  = $('#'+Table_ID+" tbody tr:eq("+rowIndex+")").attr('class');
                                                if( className != undefined && className.includes("shown")){
                                          
                                                    // Prepare Excel formated row
                                                    headerRow = '<row r="' + rowCount + 
                                                            '" s="2">' ;
        
                                                    var PacKey =  Object.keys(childData[childLen][0]);
                                                    
                                                    var abc = ["A", "B", "C" ,"D", "E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W",]; 
                                                    var c = 0;
                                                    for (var ki in PacKey) {
                                                        headerRow +='<c t="inlineStr" r="'+abc[c] + rowCount + 
                                                        '" s="2"><is><t>'+PacKey[ki] + 
                                                        '</t></is></c>';
                                                        c = c+1;
                                                    }
                                                    headerRow += '</row>';
                                                    
                                                    // Append header row to sheetData.
                                                    $('sheetData', sheet).append(headerRow);
                                                    rowCount++; // Inc excelt row counter.
                                                    
                                                    for(var ids in childData[childLen]){
                                                        var abc = ["A", "B", "C" ,"D", "E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W"]; 
                                                        var c = 0;
                                                        childRow = '<row r="' + rowCount + 
                                                        '" >' ;
                                                        for(var k in childData[childLen][ids]){
                                                            childRow +='<c t="inlineStr" r="'+abc[c] + rowCount + 
                                                            '" ><is><t>'+childData[childLen][ids][k] + 
                                                            '</t></is></c>';
                                                            c = c+1;
                                                        }
                                                        childRow += '</row>';
                                                        // Append row to sheetData.
                                                        $('sheetData', sheet).append(childRow);
                                                        rowCount++; // Inc excelt row counter.
                                                        
                                                    }
                                                }
                                            }else{
                                                // Prepare Excel formated row
                                                headerRow = '<row r="' + rowCount + 
                                                        '" s="2">' ;

                                                var PacKey =  Object.keys(childData[childLen][0]);
                                                
                                                var abc = ["A", "B", "C" ,"D", "E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W",]; 
                                                     
                                                var c = 0;
                                                for (var ki in PacKey) {
                                                    headerRow +='<c t="inlineStr" r="'+abc[c] + rowCount + 
                                                    '" s="2"><is><t>'+PacKey[ki] + 
                                                    '</t></is></c>';
                                                    c = c+1;
                                                }
                                                headerRow += '</row>';
                                                
                                                // Append header row to sheetData.
                                                $('sheetData', sheet).append(headerRow);
                                                rowCount++; // Inc excelt row counter.
                                                
                                                for(var ids in childData[childLen]){
                                                    var abc = ["A", "B", "C" ,"D", "E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W",]; 
                                                    
                                                    var c = 0;
                                                    childRow = '<row r="' + rowCount + 
                                                    '" >' ;
                                                    for(var k in childData[childLen][ids]){
                                                        childRow +='<c t="inlineStr" r="'+abc[c] + rowCount + 
                                                        '" ><is><t>'+childData[childLen][ids][k] + 
                                                        '</t></is></c>';
                                                        c = c+1;
                                                    }
                                                    childRow += '</row>';
                                                    // Append row to sheetData.
                                                    $('sheetData', sheet).append(childRow);
                                                    rowCount++; // Inc excelt row counter.
                                                    
                                                }
                                            
                                            
                                            }
                                        }
                                    }  
                                    // Just append the header row and increment the excel row counter.
                                    } else {
                                    var row = $(this.outerHTML);
                                    
                                    var colCount = 1;
                                    
                                    // Remove the last header cell.
                                    row.children().each(function(index) {
                                        var cell = $(this);
                                    
                                        if (colCount === numColumns) {
                                        cell.html('');
                                        }
                                        
                                        colCount++;
                                    });
                                    row = row[0].outerHTML;
                                    $('sheetData', sheet).append(row);
                                    rowCount++;
                                    }
                                });        
                            }
                        }
                    },
                    
                    {extend: "pdf",footer:true, className: "buttonsToHide"  ,              
                     customize: function(doc, config) { 
                        var tableNode;
                        for (i = 0; i < doc.content.length; ++i) {
                          if(doc.content[i].table !== undefined){
                            tableNode = doc.content[i];
                            break;
                          }
                        }
       
                        var rowIndex = 0;
                        var tableColumnCount = tableNode.table.body[rowIndex].length;
						var rowCount = doc.content[1].table.body.length;
						// console.log(doc.content[1].table.body);
						 for (i = 1; i < rowCount; i++) {
							for (j = 0; j < tableColumnCount; j++) {
								if(doc.content[1].table.body[i][j].text == parseInt(doc.content[1].table.body[i][j].text)){
									doc.content[1].table.body[i][j].alignment = 'right';
								}
								else{
									var pop = doc.content[1].table.body[i][j].text;
									if(pop.includes(".") || pop.includes(",")) {
										pop1 = pop.split(".").join("").split(",").join("");
										if(pop1 == parseInt(pop1)){
											pop = pop.split(".").join("").split(",").join(".");
											doc.content[1].table.body[i][j].text = pop;
											doc.content[1].table.body[i][j].alignment = 'right';
										}else{
											doc.content[1].table.body[i][j].alignment = 'left';
										}
									}else{
										doc.content[1].table.body[i][j].alignment = 'left';
									}
								
								}
							 	
							}
						}
                        //console.log(doc.content[1].table.body[1]);
                        
                        if(tableColumnCount >= 47){
                           
                            doc.pageOrientation = 'landscape';
                            doc.pageSize = 'A0';
                            
                            
                         } else if(tableColumnCount > 8){
                           //
                           doc.pageOrientation = 'landscape';
                           doc.pageSize = 'A0';
                           doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                         
                           
                        }
                        }
                    }  ,
                    { extend: 'create', editor: editor , className: "buttonsToHide"  },
                    {extend: 'edit', editor: editor ,  action: function () {
                        editRow.edit( {
                            title: 'Edit'
                            }  );
                        } , className: "buttonsToHide" },
                    { extend: 'remove' , className: "buttonsToHide" , editor: editor}, 
                    {
                    text: 'Import CSV'
                        , className: "buttonsToHide"
                    },
                    {
                        extend: 'selectAll',
                        className: 'btn-space buttonsToHide'
                    },{
                        extend: 'selectNone',
                        
                        className: 'btn-space buttonsToHide'
                    }
                    
    
                    ],
    
                    "search": {
                        "regex": true
                    },
                    "pageLength": rowsCount,
                    "processing": true,
                    "magicGoFaster": true,
    
                    searchCols: predefineSearch,
                    columnDefs: [
                        { "visible": false, "targets": hideColumn , "searchable": true },
                        { targets: columnAlignment, className: 'td-right' },
                        { targets: '_all', className: 'td-left'},
                        { targets: 0,  'checkboxes': EnableAllUpdates == '1' ?{'selectRow': true } : false}  
                    ],
                    
                    'select': {
                       'style': 'multi'
                    },
                    orderCellsTop: true,
                    order: SortLevels,
                    paging : EnablerowGroup == '1' ? false : true,
                    rowGroup: {

                        enable: EnablerowGroup == '1' ? true : false,
                        dataSrc: EnableRowGroupColumn,
                        startRender: function(rows, group , level) {
                           
                            if(EnableRowGroupLevel == '1'){
                                groupParent[level] = group;

                                var groupAll = '';     
                                var count = 0;
                                for (var i = 0; i < level; i++) {
                                groupAll += groupParent[i]; 
                                
                                if (collapsedGroups[groupAll]) 
                                    {
                                    return;
                                    }
                                }
                                groupAll += group;

                               if(level == '0' ){
                                    const resultCount =  rows
                                    .data()
                                    .pluck(EnableRowGroupColumn[1])
                                    .reduce((acc, curr) => (acc[curr] = (acc[curr] || 0) + 1, acc), {});
                                    
                                    count = Object.keys(resultCount).length;
                                }
                                if(level == '1'){
                                    
                                    if(Object.keys(EnableRowGroupColumn).length == 2){
                                        count = rows.count();
                                    }else{
                                        const resultCount =  rows
                                        .data()
                                        .pluck(EnableRowGroupColumn[2])
                                        .reduce((acc, curr) => (acc[curr] = (acc[curr] || 0) + 1, acc), {});
                                        
                                        count = Object.keys(resultCount).length;
                                    }
                                }
                                if(level == '2'){
                                    if(Object.keys(EnableRowGroupColumn).length == 3){
                                        count = rows.count();
                                    }else{
                                        const resultCount =  rows
                                        .data()
                                        .pluck(EnableRowGroupColumn[3])
                                        .reduce((acc, curr) => (acc[curr] = (acc[curr] || 0) + 1, acc), {});
                                        
                                        count = Object.keys(resultCount).length;
                                    }

                                }

                                if(level == '3'){
                                    count = rows.count() ;
                                   
                                }
                                
                                
                                if ((typeof(collapsedGroups[groupAll]) == 'undefined') || (collapsedGroups[groupAll] === null)) {collapsedGroups[groupAll] = false;} //True = Start collapsed. False = Start expanded.
    
                                var collapsed = collapsedGroups[groupAll];
                               
                                rows.nodes().each(function(r) {
                                    //r.style.display = (collapsed ? 'none' : '');
                                    r.style.display =  'none';
                                    //if(level == '3'){
                                        $(r).addClass(groupAll+' leveldata-'+level);
                                        $(r).attr('id', groupAll );
                                    //}
                                });
                                //  return $('<tr/>').append('<td> ' + group + '</td>').append('<td></td>')
                                // .attr('data-name', groupAll).attr('id', groupAll).toggleClass('collapsed', collapsed);
                                 var columnTotal = 0;
                                var mainArr = {};
                                var customSum = {};
                                var valArr = {};
                               

                                $.each(footerColumn, function( index, value ) {
                                    
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
                                    
                                    if(value['perform_custom_sum'] == 0 || value['footer_sum_only'] !== undefined)
                                    {   
        
                                        columnTotal = rows
                                                    .data()
                                                    .pluck(index)
                                                    .reduce( function (a, b) {
                                                var resultValue = intVal(a) + intVal(b);
                                                return resultValue;
                                            }, 0 );
                                        
                                        mainArr[value['column_name']] = columnTotal;
                                        if(value.decimal != undefined)
                                        {
                                                valArr[index]   = columnTotal.toFixed(value.decimal).toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                                            
                                        }else{
                                                valArr[index] = columnTotal.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        
                                        }
                                        
                                    }
                                    else if(value['perform_custom_sum'] == 1){
                                        columnTotal = rows
                                                    .data()
                                                    .pluck(index)
                                                    .reduce( function (a, b) {
                                                var resultValue = intVal(a) + intVal(b);
                                                return resultValue;
                                            }, 0 );
                                        
                                        mainArr[value['column_name']] = columnTotal;
                                        customSum[index] = value['custom_sum'];
                                    }
                                });
                                
                                
                                $.each(customSum, function( index, value ){
                                    
                                    
                                    var formula = value;
                                    $.each(mainArr, function( indexs, values ){
                                    
                                        formula = formula.replace(indexs+")", values+")");
                                    });
                                
                                    formula = eval(formula);
                                    
                                    if(formula != '' && formula != undefined ){
                                        formula = formula.toFixed(2);
                                        formula = formula.split('.').join(',');
                                        //formula = formula.replace(/(\d)(?=(\d{2})+(?!\d))/g, '$1,');    
                                    }
        
                                    valArr[index]=formula;
                                });
                                
                                
                                var entry = $('<tr/>');
                                var k = 0 , cnt = 0  , n = 0;
                                var newArr = [];

                                var len = DataTable.columns().header().length;
                               
                                $.each(valArr, function( ke, va ){
                                    newArr.push(parseInt(ke));
                                    
                                });
                               
                                // var newRow = '';
                                // if(level == 1 && check1 == 0 ){
                                   
                                //     //newRow = '<tr style="backgroud-color:skyblue;">';
                                //     for(n ; n < len; n++){
                                //         if(n== 0){
                                //             entry.append('<td class="td-right">'+columnTitle[EnableRowGroupColumn[1]]+' </td>');
                                //         }else{
                                //             entry.append( '<td class="td-right"></td>');
                                //         }
                                       
                                //     }
                                //     entry.append( $('<tr/>'));
                                //     //newRow += '</tr>';
                                //     check1 = 1;
                                    
                                   
                                //    // $( newRow ).insertBefore( entry );
                                //    // entry.insertBefore(newRow);
                                // }else if (level == '0' && check1 == 1){
                                //     check1 = 0;
                                // }
                                if(jsonData.HideColumn == undefined ){
                                    var hideColumn = [];
                                    hideColumn[0] = 1000;
                                }else{
                                    var hideColumn = [];
                                    hideColumn = jsonData.HideColumn;
                                }
                                rowGroupArrNew[group] =valArr;
                                var toggleClass = collapsed ?'<span class="material-symbols-outlined" id="expand_more">expand_more</span>':'<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>';
                                
                                
                
                                for(k ; k < len; k++){
                                    var pass = 0 ;
                                    if(cnt == 0 && !(hideColumn.includes(k))){
                                        
                                            entry.append('<td class="rowGroupie"><span class="material-symbols-outlined"' + toggleClass + ' ' + group +' (' + count + ') </td>');
                                            cnt = cnt +1;
                                            
                                    }else if((newArr.includes(k)) && !(hideColumn.includes(k))  ){
                                        
                                        entry.append('<td class="td-right rowGroupie">'+valArr[k]+'</td>');
                                        
                                    }else if(k != 0 && !(hideColumn.includes(k)) ){
                                        
                                        entry.append('<td class="td-right"></td>');
                                        
                                    }
                                }
                                
                                if(level != 0){
                                    entry .attr('data-name', groupAll).attr('id', groupAll+"-level"+level).css('display','none')
                                    .toggleClass('collapsed', collapsed);
                                }else{
                                    entry .attr('data-name', groupAll).attr('id',  groupAll+"-level"+level)
                                    .toggleClass('collapsed', collapsed);
                                }
                               
                                      
                                        //return  $('<tr/>').append($('<tr/>').append('<td>tester<td><br>')).append(entry);        
                                return  entry;
                                
                                    

                            }else if (groupRowsFlag == '1'){
                                
                                if(closeAll == 'closeall'){
                                    var collapsed = false;
                                }else if(openAll == 'openall'){
                                    var collapsed = true;
                                }else{
                                    var collapsed = !!collapsedGroups[group];
                                }
                                //console.log(EnableRowGroupColumn);
                                // Code for making it collapse
                                rows.nodes().each(function (r) {
                                    r.style.display = 'none';
                                    if (collapsed) {
                                    r.style.display = '';
                                    }});
                                var columnTotal = 0;
                                var mainArr = {};
                                var customSum = {};
                                var valArr = {};
                            
                                $.each(footerColumn, function( index, value ) {
                                    
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
                                    
                                    if(value['perform_custom_sum'] == 0 || value['footer_sum_only'] !== undefined)
                                    {   
        
                                        columnTotal = rows
                                                    .data()
                                                    .pluck(index)
                                                    .reduce( function (a, b) {
                                                var resultValue = intVal(a) + intVal(b);
                                                return resultValue;
                                            }, 0 );
                                        
                                        mainArr[value['column_name']] = columnTotal;
                                        if(value.decimal != undefined)
                                        {
                                                valArr[index]   = columnTotal.toFixed(value.decimal).toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                                            
                                        }else{
                                                valArr[index] = columnTotal.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        
                                        }
                                        
                                    }
                                    else if(value['perform_custom_sum'] == 1){
                                        columnTotal = rows
                                                    .data()
                                                    .pluck(index)
                                                    .reduce( function (a, b) {
                                                var resultValue = intVal(a) + intVal(b);
                                                return resultValue;
                                            }, 0 );
                                        
                                        mainArr[value['column_name']] = columnTotal;
                                        customSum[index] = value['custom_sum'];
                                    }
                                });
                                
                                
                                $.each(customSum, function( index, value ){
                                    
                                    
                                    var formula = value;
                                    $.each(mainArr, function( indexs, values ){
                                    
                                        formula = formula.replace(indexs+")", values+")");
                                    });
                                
                                    formula = eval(formula);
                                    
                                    if(formula != '' && formula != undefined ){
                                        formula = formula.toFixed(2);
                                        formula = formula.split('.').join(',');
                                        //formula = formula.replace(/(\d)(?=(\d{2})+(?!\d))/g, '$1,');    
                                    }
        
                                    valArr[index]=formula;
                                });
        
                                // Add category name to the <tr>. NOTE: Hardcoded colspan
                                
                                var entry = $('<tr/>');
                                var k = 0 , cnt = 0 ;
                                var newArr = [];
                                var len = DataTable.columns().header().length;
                                $.each(valArr, function( ke, va ){
                                    newArr.push(parseInt(ke));
                                    
                                });
                                
                                if(jsonData.HideColumn == undefined ){
                                    var hideColumn = [];
                                    hideColumn[0] = 1000;
                                }else{
                                    var hideColumn = [];
                                    hideColumn = jsonData.HideColumn;
                                }
                                rowGroupArrNew[group] =valArr;
                                // //console.log(rowGroupArrNew);
                                for(k ; k < len; k++){
                                    var pass = 0 ;
                                    if(cnt == 0 && !(hideColumn.includes(k))){
                                        
                                            entry.append('<td class="rowGroupie"><i class="fas fa-chevron-circle-down"></i>'+group+ ' (' + rows.count() + ' entries) </td>');
                                            cnt = cnt +1;
                                            
                                    }else if((newArr.includes(k)) && !(hideColumn.includes(k))  ){
                                        
                                        entry.append('<td class="td-right rowGroupie">'+valArr[k]+'</td>');
                                        
                                    }else if(k != 0 && !(hideColumn.includes(k)) ){
                                        
                                        entry.append('<td class="td-right"></td>');
                                        
                                    }
                                }
                                
                                
                                entry .attr('data-name', group)
                                        .toggleClass('collapsed', collapsed);
                                return entry;
                            }
                           
                            
                           
    
                        }
                            
                        
                    },
    
                    initComplete: function () {
                         /* part for new toool on top one 
                        // $("."+ Table_ID ).append($('#'+Table_ID+'_filter'));
                        // $("#copyBtn_"+Table_ID).parent().attr('id', 'Buttons'+Table_ID);
                        // $("."+ Table_ID ).append($('#Buttons'+Table_ID));
                        */
                        if(EnableSideBar == '1' && TableType == '5'){
                            var path = TableSideBar+'&silderActionId='+TabAction;
                            //console.log(TableType);
                            SliderDesign2Call(path);
                        }
                        count = 0;
                        var selectFlag = 0;
                       
                        // this part of code is for setting the default mulitple seletion that's been set from the Admin side
                        if(window[Table_ID + 'AllowMultipleSelectionColumn']){
                            
                            for (var k in window[Table_ID + 'AllowMultipleSelectionColumn']){ 
                                
                                this.api().columns(k).every( function () {
                                    var title = this.header();
                                    var tempTitle = $(title).text();
                                    // if(tempTitle.includes('Normal'))  {
                                    //      tempTitle =$(title).children('span').text(); 
                                    // }
                                   
                                    tempTitle = tempTitle.replace('#' , '_');
                                    tempTitle = tempTitle.replace('%' , '_');
                                    tempTitle = tempTitle.trim();
                                    //replace spaces with dashes
                                    title = $(title).html().replace(/[\W]/g, '-');
                                    title = title + Table_ID;
                                    var column = this;
                                    
                                   
                                    if(multipleSearchSelectorFlag != 0){
                                       
                                        $('#mainS_'+Table_ID+tempTitle).hide();
                                        $('#searchDiv_'+Table_ID+tempTitle).show();
                                    }
                                    
                                   
                                    var select = $('<select id="' + title + '" class="select2 search_by" style="width:100%"></select>')
                                    .appendTo( "#searchDiv_"+Table_ID+tempTitle)
                                    .on( 'change', function () {
                                        //Get the "text" property from each selected data 
                                        //regex escape the value and store in array
                                       
                                        if($('#'+title).val()) {
                                           
                                            $("#close"+Table_ID+tempTitle).show();
                                        }else{
                                            $("#close"+Table_ID+tempTitle).hide();
                                        }
                                    
                                        var data = $.map( $(this).select2('data'), function( value, key ) {
                                        return value.text ? '^' + $.fn.dataTable.util.escapeRegex(value.text) + '$' : null;
                                                    });
    
                                        
                                        //if no data selected use ""
                                        if (data.length === 0) {
                                        data = [""];
                                        }
                                    var val = data.join('|');
                                    
                                    if(val != '' ||  selectFlag == 1){
                                        
                                        column
                                            .search( val ? val : '', true, false )
                                            .draw();
                                        }
                                    });
                                   
                                    column.data().unique().sort().each( function ( d, j ) {
                                        select.append( '<option value="'+d+'">'+d+'</option>' );
                                    } );
                                    
                                        //use column title as selector and placeholder
                                    $('#' + title).select2({
                                    multiple: true,
                                    closeOnSelect: false,
                                    placeholder: "Search "
                                    });
                                
                                    //initially clear select otherwise first option is selected
                                    //console.log(predefineSearch);
                                    if(typeof predefineSearch === 'undefined' ){
                                        $('#'+title).val('').trigger('change');
                                }else{
                                    var defValue = predefineSearch[k].sSearch;
                                        defValue = defValue.replace(/\W_/g,"");
                                        defValue = defValue.split('|');
                                        $('#'+title).val(defValue).trigger('change'); 
                                }                        
                                });
    
                                };
    
                            }
                            selectFlag = 1;
                        // this part of code is for setting the default Range filter that's been set from the Admin side
                        var api = this.api();
                        //console.log(rangePredefineSearchFlag);
                        if(rangePredefineSearchFlag)
                        {
                            //console.log(predefineSearchForRange);
                            $.each(predefineSearchForRange , function(key, value){
                                
                                //console.log(key);
                                var k = '';
                                var title = api.column(key).header();
                                var tempTitle = $(title).text(); 
                                // if(tempTitle.includes('Normal'))  {
                                //      tempTitle =$(title).children('span').text(); 
                                // }  
                                tempTitle = tempTitle.replace('#' , '_');
                                tempTitle = tempTitle.replace('%' , '_');
                                tempTitle = tempTitle.trim();
                                // var column = this;
                                var getToValue = '';
                                var getFromValues = '';
                                
                                $('#mainS_'+Table_ID+tempTitle).hide();
                                $('#fromTo_'+Table_ID+tempTitle).show();
                            
                                //tab = Table_ID+"_"+tempTitle;
                                
                                $.fn.dataTable.ext.search.push(
                                    function( settings, data, dataIndex ) {
                                            if(ColumnIndexRange != '')
                                            {
                                                title = api.column(ColumnIndexRange).header();
                                                tempTitle = $(title).text(); 
                                                tempTitle = tempTitle.trim();
                                                // if(tempTitle.includes('Normal'))  {
                                                //      tempTitle =$(title).children('span').text(); 
                                                // }        
                                            }
                                            tab = Table_ID+"_"+tempTitle;
                                            var tabID = tab.split('_');
                                            tabID = tabID[0]+'_'+tabID[1];
                                            
                                            if(settings.nTable.id == tabID){
        
                                            if(Object.keys(rangePredefineSearchFlag).length != 0 && ColumnIndexRange != ''){
        
                                                var min = parseInt( value['from'], 10 ) ;
                                                var max = parseInt( value['to'], 10 ) ;
                                                
                                                }else{
                                                    
                                                    var min = parseInt( $('#'+tab+'fromRange').val(), 10 ) ;
                                                    var max = parseInt( $('#'+tab+'toRange').val(), 10 ) ;
                                                }
                                                if(ColumnIndex != -1)
                                                {
                                                    key = ColumnIndex;
                                                }
                                                
                                                var temp_data = data[key].split(' ').join('');
                                                var cntComma = 0;
                                                var cntDot = 0;
                                                var str = temp_data;
        
                                                for (var t = 0;  t <= str.length; t++) {
                                                    
                                                    if (str[t] === ".") 
                                                        {
                                                            cntDot = t;
                                                        }
                                                        else if(str[t] === ".")
                                                        {
                                                            cntComma = t;
                                                        }
                                                }
                                                if(cntComma > 0)
                                                {
                                                    temp_data = temp_data.split(',').join('');
                                                }else if (cntDot > 0){
                                                    temp_data = temp_data.split('.').join('');
                                                }
                                                temp_data = parseInt(temp_data);
                                                temp_data = Math.round(temp_data);
                                                var columnFromTo = parseFloat(temp_data) || 0;
                                                
                                                    if ( ( isNaN( min ) && isNaN( max ) ) ||
                                                        ( isNaN( min ) && columnFromTo <= max ) ||
                                                        ( min <= columnFromTo   && isNaN( max ) ) ||
                                                        ( min <= columnFromTo   && columnFromTo <= max ) )
                                                    {
                                                        return true;
                                                    }
                                                    return false;
                                                }
                                                else
                                                {
                                                    return true;
                                                }
                                            
                                            
    
                                        
                                    });
                                    
                                    DataTable.draw();
                                    
                                    
                                
                            });
                        }
                        rangePredefineSearchFlag = {};
                        // This Part of code is for column order set at Admin Side
                        DataTable.colReorder.order(columnOrder);
                        
                        api.columns().eq(0).each( function (ind) {
                            var title= api.column(ind).header();
                            if(api.column(ind).visible()){
                                if(headerExcel.includes(title.getAttribute("id")) != true){
                                    headerExcel.push(title.getAttribute("id"));
                                }
                            }       
                        });
                        
                        // this part of code is for new design template
                        var tbody = document.getElementById( Table_ID +"_tbody");
                        if(tbody){
                            $("#"+ Table_ID +"_tbody").append($('#'+Table_ID+' > tbody'));
                        } 
                        var tpage = document.getElementById( Table_ID +"_pagination ");
                        if(tpage){
                                $("#"+ Table_ID +"_pagination ").append($('#'+Table_ID+'_paginate'));
                        }
                        var doc=document.getElementById( Table_ID +"_wrapper");
                        var parentDoc =  doc.closest('.table-scrollable');
                        
                        let styling = doc.querySelector('.dataTables_filter');
                        styling.style.display = 'inline';
                        styling.style.padding = '26px';
                        $(doc.firstElementChild).attr('id', Table_ID +"_wrapper");
                        $(doc.firstElementChild).insertBefore(parentDoc);
                        $(doc.lastElementChild).insertAfter(parentDoc);
                        
                        $('select').on("click keyup keydown change", function(e) { 
                            
                            var val = $(this).val();
                           
                            var newId = $(this).attr('id') ;
                            newId = newId.split('--Table_1coluumnName');
                            newId = newId[1].split('--aria-hidden');
                            newId = newId[0];
                            var FilterName  = Table_ID+'_FilterData_'+newId.trim() ;
                                    
                            if(document.getElementById(FilterName) === null){
                                $('#'+Table_ID+'_FilterDataDiv').show();
                                $("<li  id ='Li_"+FilterName+"' ><a class='FilterData' id ='"+FilterName+"'  data-tableId='" + Table_ID + "'>"+newId+" =  "+val+"</a></li>").insertAfter('#'+Table_ID+'_FilterData');
                            }else{
                                
                                if(val === '' || val === null){
                                  
                                    $('#Li_'+FilterName).remove();
                                    const element1 = document.querySelectorAll('[id^="Li_"]');     
                                    if(element1.length == 0){
                                        $('#'+Table_ID+'_FilterDataDiv').hide();
                                    }
                                }else{
                                    $('#'+Table_ID+'_FilterDataDiv').show();
                                    document.getElementById(FilterName).innerText  =newId +" =  "+val;
                                }
                            }
                            filterBtnCheck = 1;
                            
                        
                        });
                        //console.log(parentDoc);
                       
                    },
                   
                    "drawCallback": function( settings ) {
                        //console.log($("."+ Table_ID ).text());
                        var api = this.api();
                        var filterBtnCheck = 0;
                        //Object.keys(data).length;
                        var testDatta = api.row(0).data();
                        //console.log("Tester Here");
                        //console.log( api.row(0).html() );
                        $('select').on("click keyup keydown change", function(e) { 
                           
                            var val = $(this).val();
                           
                            var newId = $(this).attr('id') ;
                            newId = newId.split('--Table_1coluumnName');
                            newId = newId[1].split('--aria-hidden');
                            newId = newId[0];
                            var FilterName  = Table_ID+'_FilterData_'+newId.trim() ;
                                    
                            if(document.getElementById(FilterName) === null){
                                $('#'+Table_ID+'_FilterDataDiv').show();
                                $("<li  id ='Li_"+FilterName+"' ><a class='FilterData' id ='"+FilterName+"'  data-tableId='" + Table_ID + "'>"+newId+" =  "+val+"</a></li>").insertAfter('#'+Table_ID+'_FilterData');
                            }else{
                                
                                if(val === '' || val === null){
                                  
                                    $('#Li_'+FilterName).remove();
                                    const element1 = document.querySelectorAll('[id^="Li_"]');     
                                    if(element1.length == 0){
                                        $('#'+Table_ID+'_FilterDataDiv').hide();
                                    }
                                }else{
                                    $('#'+Table_ID+'_FilterDataDiv').show();
                                    document.getElementById(FilterName).innerText  =newId +" =  "+val;
                                }
                            }
                            filterBtnCheck = 1;
                            
                        
                        });
                        if(sessionsearchVarMulti !== undefined && sessionsearchVarMulti.length > 2 && filterBtnCheck == 0)
                        {
                           
                            var sData = JSON.parse(sessionsearchVarMulti);
                            
                            predefineSearchBtn = sData[Table_ID]['PredefineSearch'];
                           // api.columns().search('').draw();
                           
                            $.each(predefineSearchBtn, function (keys, valus) {
                               
                                if(valus != null){
                                    var FilterName  = Table_ID+'_FilterData_'+api.column(keys).header().textContent.trim() ;
                                    
                                    valus['sSearch'] = valus['sSearch'].split('|').join(',');
                                    
                                        if(document.getElementById(FilterName) === null){

                                            $('#'+Table_ID+'_FilterDataDiv').show();
                                            
                                            $("<li  id ='Li_"+FilterName+"' ><a class='FilterData' id ='"+FilterName+"'  data-tableId='" + Table_ID + "'>"+api.column(keys).header().textContent+" =  "+valus['sSearch']+"</a></li>").insertAfter('#'+Table_ID+'_FilterData');
                                        }else{
                                            if(valus['sSearch'] === '' || valus['sSearch'] == null){
        
                                                $('#Li_'+FilterName).remove();
                                                const element1 = document.querySelectorAll('[id^="Li_"]');
                                                
                                                if(element1.length == 0){
                                                    $('#'+Table_ID+'_FilterDataDiv').hide();
                                                }
                                                
                                                
        
                                            }else{
                                                $('#'+Table_ID+'_FilterDataDiv').show();
                                                document.getElementById(FilterName).innerText  = api.column(keys).header().textContent+" =  "+valus['sSearch'];
                                            }
                                        }
                                }
                                    
                  
                            });
                            
                        }
                        
                        
                        var myEle =  document.getElementById('Öppen');
                        if(myEle){
                            if (document.getElementById('Low')){
                                document.getElementById('Low').innerHTML = 0;
                            }
                            if (document.getElementById('Medium')){
                                document.getElementById('Medium').innerHTML = 0;
                            }
                            if (document.getElementById('High')){
                                document.getElementById('High').innerHTML = 0;
                            }
                            if (document.getElementById('Urgent')){
                                document.getElementById('Urgent').innerHTML = 0;
                            }
                                                                                
                            document.getElementById('Öppen').innerHTML = 0;
                            document.getElementById('Väntad').innerHTML = 0;
                            document.getElementById('Löst').innerHTML = 0;
                            document.getElementById('Avslutat').innerHTML = 0;
                            document.getElementById('Brådskande').innerHTML = 0;
                        
                            $.each(api.rows( {search:'applied'}).data(), function( dataKey, dataValue ) {
                               
                                    if(dataValue[4] == 'Låg'){
                                        if (document.getElementById('Low')){
                                            var val = parseInt(document.getElementById('Low').innerHTML);
                                            document.getElementById('Low').innerHTML = val + 1;
                                        }

                                    }else if(dataValue[4] == 'Medium'){
                                        if (document.getElementById('Medium')){
                                            var val = parseInt(document.getElementById('Medium').innerHTML);
                                            document.getElementById('Medium').innerHTML = val + 1;
                                        }
                                    }else if(dataValue[4] == 'Hög'){
                                        if (document.getElementById('High')){
                                            var val = parseInt(document.getElementById('High').innerHTML);
                                            document.getElementById('High').innerHTML = val + 1;
                                        }
                                    }else if(dataValue[4] == 'Bråskande'){
                                        if (document.getElementById('High')){
                                            var val = parseInt(document.getElementById('Urgent').innerHTML);
                                            document.getElementById('Urgent').innerHTML = val + 1;
                                        }
                                        var val = parseInt(document.getElementById('Brådskande').innerHTML);
                                        document.getElementById('Brådskande').innerHTML = val + 1;
                                    }
                                    if(dataValue[6] == 'Öppna'){
                                      
                                        var val = parseInt(document.getElementById('Öppen').innerHTML);
                                        document.getElementById('Öppen').innerHTML = val + 1;
                                    
                                    }else if(dataValue[6] == 'Väntad'){
                                        var val = parseInt(document.getElementById('Väntad').innerHTML);
                                        document.getElementById('Väntad').innerHTML = val + 1;
                                    
                                    }else if(dataValue[6] == 'Löst'){
                                        var val = parseInt(document.getElementById('Löst').innerHTML);
                                        document.getElementById('Löst').innerHTML = val + 1;
                                    
                                    }else if(dataValue[6] == 'Avslutat'){
                                        var val = parseInt(document.getElementById('Avslutat').innerHTML);
                                        document.getElementById('Avslutat').innerHTML = val + 1;
                                    
                                    }
                                   
                            });
                        }
                       
                        if(api.rows( {page:'current'} ).data()[0] != 'undefined'   ){
                            //console.log("knjnsjk");
                                    
                            if (pieDiscription != '' && pieDiscription != null) {
                                
                                $.each(JSON.parse(pieDiscription), function( key, pieValue ) {
                                
                                    
                                    if(pieValue.TableId == placeholderId){
                                        var pieId = pieValue.pie_id;
                                        var calType = pieValue.CalculationType;
                                        var displayType = pieValue.DisplayType;
                                        var pieType = pieValue.pieType;
                                        var showLabelPie = pieValue.ShowPieLabel;
                                        if(base_url != 'http://www.babcnew.com')
                                        {
                                            base_url = absPath[0]+'public';
                                        }   
                                        $.getScript(base_url + '/assets/Custome_Code/Highsofts/customHighPieCharts.js', function()
                                        {
                                            //console.log(pieValue.TableId);
                                            //console.log(placeholderId);
                                            setTableEvents(DataTable,'','', '', '', '' , '' , pieChartArray , pieChartLabel , pieChartPresent ,pieId , calType, displayType , pieType, showLabelPie, pieChartArrayDrillDown, pieChartLabelDrillDown);
                                            
                                        });
                                    
                                    }
                                });
                            }
                        }
                        
                    },
                    "footerCallback": function ( row, data, start, end, display ) {
                        
                        var api = this.api();
                        if(base_url != 'http://www.babcnew.com')
                        {
                            base_url = absPath[0]+'public';
                        }
                        //$.getScript(base_url + '/assets/Custome_Code/DataTables/customFooterSum.js', function()
                        //{
                            //console.log(footerColumn);
                            GenerateFooter(api , footerColumn ,  pannelIds , placeholderId , Table_ID , rowGroupArrNew);
                        //});
                    },
                    "rowCallback": function( row, data , displayNum , displayIndex , dataIndex ) {
                       
                        var length_ = $('#'+Table_ID).find("tr:first th").length;
                        var array_length = Object.keys(data).length;
                        var tabletest = $('#'+Table_ID).DataTable();
                        if(EnableOnclickBtn == '0'  && array_length > length_ ){
                               
                            var links = data[Object.keys(data).length-1];
                            var names = data[Object.keys(data).length-2];
                            
                            var colName = '';
                            var namesNew = names.split('%').join('') ;
                        
                          if(EnableAllUpdates == 1 && EnableCheckBoxes == 0){
                                if(data[1].includes(namesNew) ){
                                    colName =data[1];
                                    colName = colName.replace(namesNew , '');
                                }else {
                                
                                    colName = data[1];
                                }
                               
                                var temp1 = tableSubActionsButtonRows(Table_ID, links,names , colName , data[1]  );
                                
                                $('td:eq(1)', row).html( temp1);
                            }else{
                                
                                if(data[0].includes(namesNew) ){
                                    colName =data[0];
                                    colName = colName.replace(namesNew , '');
                                }else {
                                
                                    colName = data[0];
                                }
                                
                                var temp1 = tableSubActionsButtonRows(Table_ID, links,names , colName , data[0] );
                                $('td:eq(0)', row).html( temp1);
                            }
                             
                            
                            

                           
                            //api.cell(dataKey,0).data(temp1); 
                            
                            
                         }
                         //console.log(row);
                        if(EnableSideBar == '1' && TableType == '4'){
                            var path = TableSideBar+data[RouteColumnIndex]+'&silderActionId='+TabAction;
                            //console.log(TableType);
                            if(TableSideBar2 != ''){
                                var path2 = TableSideBar2+data[RouteColumnIndex2]+'&silderActionId='+TabAction2;
                                $(row).attr('onClick', "toggleNav('"+path+"' , '"+TableType+"' ,'"+path2+"')");
                            }else{
                                $(row).attr('onClick', "toggleNav('"+path+"' ,'"+TableType+"')");
                            }
                        }

                        if(AllowColumnRowMarking == '1'){
                            var api = this.api();
                            if(ColoringType == '1'){
                                if(ColoringJsonText){
                                    $.each(ColoringJsonText, function (JsonKey, JsonValue) {
                                    
                                        $.each(JsonValue, function (JKey, JValue) {
                                            
                                            if ( data[JsonKey] == JValue.ColumnText ) {
                                                $('td:eq('+JsonKey+')', row).addClass('columnColor');
                                                $('td:eq('+JsonKey+')', row).css('color', JValue.TextColor);
                                            }
                                        });
                                       
                                    });
                                }else{
                                  
                                    $.each(ColumnNameColor, function (JsonKey, JsonValue) {
                                        var newstr = JsonKey ;
                                       
                                        var actualData = data[newstr] ;
                                        $.each(JsonValue, function (JKey, JValue) {
                                            
                                            if(ColorSettingType == 2)
                                            {
                                                 
                                                actualData =   parseFloat(data[newstr].replace(/[.\s]/g, '').replace(/[,]/g, '.') * 1);
                                            }
                                            else if(ColorSettingType == 4)
                                            {
                                                actualData = new Date(data[newstr]);
                                                JValue.SecondParameter=new Date(JValue.SecondParameter);
                                            }
                                            
                                            
                                            if(JValue.Condition === '='){
                                              
                                                if ( actualData  === String(JValue.SecondParameter) ) {
                                                   
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }else if (actualData  == 'Bråskande'){
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }else if(JValue.Condition == '!='){
                                                if ( actualData  != JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '>'){
                                                if ( actualData  > JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '<'){
                                                if ( actualData < JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '>='){
                                                if ( actualData  >= JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }else if(JValue.Condition == '<='){
                                                if ( actualData  <= JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == 'InBetween'){
                                                if ( actualData >= JValue.FirstParameter  && actualData  <= JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('color', JValue.TextColors);
                                                }
                                            }
                                            
                                        });
                                       
                                    });
                                }
                                
                            }else if(ColoringType == '3'){
                               
                                if(ColoringJsonText){
                                    $.each(ColoringJsonText, function (JsonKey, JsonValue) {
                                    
                                        $.each(JsonValue, function (JKey, JValue) {
                                            if ( data[JsonKey] == JValue.ColumnText ) {
                                                $(row).addClass('columnColor');
                                                $(row).css('background-color', JValue.TextColor);
                                            }
                                        });
                                       
                                    });
                                }else{
                                    var NotiCheck  = 0;
                                    var NotiOuter =  Object.keys(ColumnNameColor).length;
                                    var NotiCheckColor  = '';
                                    $.each(ColumnNameColor, function (JsonKey, JsonValue) {
                                        var newstr = JsonKey ;
                                        var NotiInner =  Object.keys(JsonValue).length;
                                        var NotiCheckInner  = 0;
                                      
                                        var actualData = data[newstr] ;
                                        $.each(JsonValue, function (JKey, JValue) {
                                            if(ColorSettingType == 2)
                                            {
                                                
                                                actualData =   parseFloat(data[newstr].replace(/[.\s]/g, '').replace(/[,]/g, '.') * 1);
                                            }
                                            else if(ColorSettingType == 4)
                                            {
                                                actualData = new Date(data[newstr]);
                                                JValue.SecondParameter=new Date(JValue.SecondParameter);
                                            }
                                            
                                            if(JValue.Condition == '='){

                                                if ( actualData  == JValue.SecondParameter ) {
                                                    if(NotiColumnMarking != '1'){
                                                        $(row).addClass('columnColor');
                                                        $(row).css('background-color', JValue.TextColors);
                                                    }
                                                    NotiCheckInner = NotiCheckInner+ 1;
                                                    NotiCheckColor = JValue.TextColors;
                                                }
                                            }else if(JValue.Condition == '!='){
                                                if ( actualData  != JValue.SecondParameter ) {
                                                    if(NotiColumnMarking != '1'){
                                                        $( row).addClass('columnColor');
                                                        $( row).css('background-color', JValue.TextColors);
                                                    }
                                                    NotiCheckInner = NotiCheckInner+ 1;
                                                }
                                            }
                                            else if(JValue.Condition == '>'){
                                                if ( actualData  > JValue.SecondParameter ) {
                                                    if(NotiColumnMarking != '1'){
                                                        $( row).addClass('columnColor');
                                                        $(row).css('background-color', JValue.TextColors);
                                                    }
                                                    NotiCheckInner = NotiCheckInner+ 1;
                                                }
                                            }
                                            else if(JValue.Condition == '<'){
                                                if ( actualData < JValue.SecondParameter ) {
                                                    if(NotiColumnMarking != '1'){
                                                        $(row).addClass('columnColor');
                                                        $( row).css('background-color', JValue.TextColors);
                                                    }
                                                    NotiCheckInner = NotiCheckInner+ 1;
                                                }
                                            }
                                            else if(JValue.Condition == '>='){
                                                if ( actualData  >= JValue.SecondParameter ) {
                                                    if(NotiColumnMarking != '1'){
                                                        $( row).addClass('columnColor');
                                                        $(row).css('background-color', JValue.TextColors);
                                                    }
                                                    NotiCheckInner = NotiCheckInner+ 1;
                                                }
                                            }else if(JValue.Condition == '<='){
                                                if ( actualData  <= JValue.SecondParameter ) {
                                                    if(NotiColumnMarking != '1'){
                                                        $(row).addClass('columnColor');
                                                        $( row).css('background-color', JValue.TextColors);
                                                    }
                                                    NotiCheckInner = NotiCheckInner+ 1;
                                                }
                                            }else if(JValue.Condition == 'InBetween'){
                                                if ( actualData >= JValue.FirstParameter  && actualData  <= JValue.SecondParameter ) {
                                                    $(row).addClass('columnColor');
                                                    $(row).css('color', JValue.TextColors);
                                                    NotiCheckInner = NotiCheckInner+ 1;
                                                }
                                            }
                                           
                                            
                                        });
                                        if(NotiColumnMarking == '1' ){
                                            if (NotiCheckInner == 1 ){
                                                NotiCheck = NotiCheck + 1;
                                            }
                                        }
                                   
                                    });
                                    
                                    if(NotiColumnMarking == '1' && NotiCheck == NotiOuter ){
                                        $(row).addClass('columnColor');
                                        $(row).css('background-color', NotiCheckColor);
                                    }
                                   
                                }
                                

                            }else if (ColoringType == '2'){


                                if(ColoringJsonText){
                                    $.each(ColoringJsonText, function (JsonKey, JsonValue) {
                                        var className = 'columnColor';
                                        //$('td:eq('+JsonKey+')',row).addClass('columnColor-'+JsonValue.TextColor);
                                        $('td:eq('+JsonKey+')',row).addClass('columnColor');
                                        $('td:eq('+JsonKey+')',row).css('background-color', JsonValue.TextColor);
                                    });
                                }
                                else{
                                    $.each(ColumnNameColor, function (JsonKey, JsonValue) {
                                        //var actualData = data[JsonKey] ;
                                    $.each(JsonValue, function (JKey, JValue) {
                                        $('td:eq('+JsonKey+')',row).addClass('columnColor');
                                        $('td:eq('+JsonKey+')',row).css('background-color', JValue.TextColors);
                                        
                                    });
                                   
                                    });

                                }
                                
                            }else  if(ColoringType == '4'){
                                if(ColoringJsonText){
                                    $.each(ColoringJsonText, function (JsonKey, JsonValue) {
                                    
                                        $.each(JsonValue, function (JKey, JValue) {
                                            
                                            if ( data[JsonKey] == JValue.ColumnText ) {
                                                $('td:eq('+JsonKey+')', row).addClass('columnColor');
                                                $('td:eq('+JsonKey+')', row).css('background-color', JValue.TextColor);
                                            }
                                        });
                                       
                                    });
                                }else{
                                    
                                    $.each(ColumnNameColor, function (JsonKey, JsonValue) {
                                       
                                        var newstr = JsonKey ;
                                        
                                        var actualData = data[newstr] ;
                                        $.each(JsonValue, function (JKey, JValue) {
                                         
                                            if(ColorSettingType == 2)
                                            {
                                                 
                                                actualData =   parseFloat(data[newstr].replace(/[.\s]/g, '').replace(/[,]/g, '.') * 1);
                                            }
                                            else if(ColorSettingType == 4)
                                            {
                                                actualData = new Date(data[newstr]);
                                                JValue.SecondParameter=new Date(JValue.SecondParameter);
                                            }
                                            
                                          
                                            if(JValue.Condition === '='){
                                                
                                                if ( actualData  === String(JValue.SecondParameter) ) {
                                                   
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                    
                                                }else if (actualData  == 'Bråskande'){
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }else if(JValue.Condition == '!='){
                                                if ( actualData  != JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '>'){
                                                if ( actualData  > JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '<'){
                                                if ( actualData < JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == '>='){
                                                if ( actualData  >= JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }else if(JValue.Condition == '<='){
                                                if ( actualData  <= JValue.SecondParameter ) {
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }
                                            else if(JValue.Condition == 'InBetween'){
                                               
                                                if ( parseInt(actualData) >=  parseInt(JValue.FirstParameter)  &&  parseInt(actualData)  <=  parseInt(JValue.SecondParameter)  ) {
                                                    
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).addClass('columnColor');
                                                    $('td:eq('+ColorTextMatchKey[JsonKey]+')', row).css('background-color', JValue.TextColors);
                                                }
                                            }
                                            
                                        });
                                       
                                    });
                                }
                                
                            }
                           
                            
                        }
                        if(AllowDataGrouping == '1'){
                            var api = this.api();
                            $.each(DataGroupingJson, function (JKey, JValue) {
                              
                                $('td:eq('+JValue.start+')', row).css('border-left', '2px solid');
                                $('td:eq('+JValue.End+')', row).css('border-right', '2px solid');
                                // $('td:eq('+JValue.start+')', row).css('box-shadow', '-2px 0px 0px 0px black');
                                // $('td:eq('+JValue.End+')', row).css('box-shadow', '2px 0px 0px 0px black');
                                
                            });
                            Flagcol = 1;
                            
                        }

                        //console.log("here");
                        
                    } 
                });
            }
           
            if(base_url != 'http://www.babcnew.com')
            {
                base_url = absPath[0]+'public';
            }
            //$.getScript(base_url + '/assets/Custome_Code/DataTables/customButton.js', function()
                //{
                    // $.each(columnTitle, function (i, title) {
                        
                    //     $('#coluumnName'+Table_ID+title).append(tableFilterButtonCol(Table_ID,title));
                    // });
                    
                    if(EnableXMLdownload == 1){

                        
                        // $("." + Table_ID).append(tableButtonXML(Table_ID, placeholderId));
                        // $("." + Table_ID).append(tableXMLButton(Table_ID, placeholderId , AllowDynamicForm ));
                        // over here using the dt btton clas  and appending the button design  .
                        $("#" + Table_ID + "_wrapper .dt-buttons").append(tableButtonXML(Table_ID, placeholderId)); // download button

                        $("#" + Table_ID + "_wrapper .dt-buttons").append(tableXMLButton(Table_ID, placeholderId , AllowDynamicForm ));
                    }
                    if(AllowDynamicForm == 1 && LiveReportSync != 1 && EnableFormOnActionBTN != 1 && EnableXMLdownload == 0){
                        //$("." + Table_ID).append(tableDynamicFormButton(Table_ID, placeholderId,AllowDynamicForm ));
                        $("#" + Table_ID + "_wrapper .dt-buttons").append(tableDynamicFormButton(Table_ID, placeholderId,AllowDynamicForm ));
                    }
                    
                    if( TableType == '2' && EnableXMLdownload != 1 && EnableFormOnActionBTN != 1){
                        // over here using the dt btton clas  and appending the button design  .
                        //$("." + Table_ID).append(tableButton(Table_ID, groupRowsColumnArr, sort, predefineSearchFlag, groupRowsFlag , EnableCrud));
                        $("#" + Table_ID + "_wrapper .dt-buttons").append(tableButton(Table_ID, groupRowsColumnArr, sort, predefineSearchFlag, groupRowsFlag , EnableCrud));
                       
                        
                    }
                    // $("#" + Table_ID + "_wrapper .dt-buttons").append(tableButton(Table_ID, groupRowsColumnArr, sort, predefineSearchFlag, groupRowsFlag));
                
                    $("#" + Table_ID + "_wrapper .dt-buttons").append(tableToolsButton(Table_ID , EnableCrud, EnableExcelBtn , pageId , pageName , SaveFilterBTN , AllowPDFImport , AllowExcelImport , columnTitle ));
                    $("#" + Table_ID + "_wrapper .dt-buttons").append(tableFiltersButton(Table_ID ));
                    if(EnableAllUpdates == 1){
                       
                        $("#" + Table_ID + "_wrapper .dt-buttons").append(predefinedUpdateButton(Table_ID , PredefinedUpdateName , PredefinedUpdateId , SelectPredefinedNames));
                    }
                   
                    
                    //$("." + Table_ID).append(tableToolsButton(Table_ID , EnableCrud, EnableExcelBtn));
                   
                   
                    //$("#" + Table_ID + "_wrapper .dt-buttons").append(tableFilterButton(Table_ID,columnTitle));
                    //$("." + Table_ID).append(tableFilterButton(Table_ID,columnTitle));
                    if(EnableLiveImgSync == 1){
                        //$("." + Table_ID).append(tableLiveSyncButton(Table_ID));
                        $("#" + Table_ID + "_wrapper .dt-buttons").append(tableLiveSyncButton(Table_ID));
                    }
                    if(LiveReportSync == 1){
                        //console.log(DesignType);
                        //$("." + Table_ID).append(tableLiveReportSyncButton(Table_ID ,placeholderId , DesignType , OldDesignBtnTitle , NewDesignBtnTitle , NameOrgBtn , NameLastBtn , EnableLastSearchDF));
                        $("#" + Table_ID + "_wrapper .dt-buttons").append(tableLiveReportSyncButton(Table_ID ,placeholderId , DesignType , OldDesignBtnTitle , NewDesignBtnTitle , NameOrgBtn , NameLastBtn , EnableLastSearchDF));
                    }
                    
                    
                    if(groupRowsFlag == 1)
                    {
                       //console.log(columnTitle);
                        //$("." + Table_ID).append(tableRowGroupButton(Table_ID, groupRowsColumnArr, sort, predefineSearchFlag, groupRowsFlag, footerColumn , jsonData.HideColumn ,groupRowsColumn ,columnTitle));
                        
                        $("#" + Table_ID + "_wrapper .dt-buttons").append(tableRowGroupButton(Table_ID, groupRowsColumnArr, sort, predefineSearchFlag, groupRowsFlag, footerColumn , jsonData.HideColumn ,groupRowsColumn ,columnTitle));
                        $( "#"+ Table_ID +"_sortInfo" ).remove();
                        $( "#"+ Table_ID +"_infoGroupBy" ).remove();
                        $( "#"+ Table_ID +"_infoSearch" ).remove();
                        $neText = '<div class="dataTables_info sortStatus" id="'+ Table_ID +'_sortInfo" role="status" aria-live="polite" style = "float:right;">Sorted By : '+setGlobal+' Rows </div>' ;
                        $("#"+Table_ID+"_info").after($neText);
                        if( typeof groupRowsColumnArr[groupRowsColumn] !== "undefined")
                        {
                            var groupName = temp[groupRowsColumn];
                        }else{
                            
                          
                            var groupName = columnTitle[groupRowsColumn];
                        }
                        $neText = '<div class="dataTables_info groupbyStatus" id="'+ Table_ID +'_infoGroupBy" role="status" aria-live="polite" style = "float:right;">Group By : '+groupName+'  </div>' ;
                        $("#"+Table_ID+"_sortInfo").after($neText);
                        $neText = '<div class="dataTables_info searchStatus" id="'+ Table_ID +'_infoSearch" role="status" aria-live="polite" style = "float:right;">Searched By : Inner Rows </div>' ;
                        $( "#"+ Table_ID +"_sortInfo" ).before($neText);
                        
                        if( typeof groupRowsColumnArr[groupRowsColumn] !== "undefined")
                        {
                            //$("." + Table_ID).append(tableHeaderRowInnerSort(Table_ID, groupRowsColumnArr, sort, predefineSearchFlag, groupRowsFlag, footerColumn , jsonData.HideColumn ,groupRowsColumn , columnTitle  ));
                        
                            $("#" + Table_ID + "_wrapper .dt-buttons").append(tableHeaderRowInnerSort(Table_ID, groupRowsColumnArr, sort, predefineSearchFlag, groupRowsFlag, footerColumn , jsonData.HideColumn ,groupRowsColumn , columnTitle  ));
                        }
                        
                      
                    }
                    if(EnableChildRows == 1){
                        //$("." + Table_ID).append(chilRowButton(Table_ID));
                        $("#" + Table_ID + "_wrapper .dt-buttons").append(chilRowButton(Table_ID));
                    }
                    if(EnableChildRowsRunTym == 1){
                        //$("." + Table_ID).append(chilRowButtonRunTym(Table_ID));                      
                        $("#" + Table_ID + "_wrapper .dt-buttons").append(chilRowButtonRunTym(Table_ID));
                    }
                    
                //});
            
           
            $('body').on("click",  "#"+Table_ID+"_CopyData", function () {
                var tableId = $(this).attr("data-tableId");
                $("#" + tableId + '_wrapper  button.buttons-copy').click();
                //$("." + tableId + ' button.buttons-copy').click();
            });
            $('body').on('click', "#"+Table_ID+"_buttons-create", function (e) {
                  // Regular editor for the table
                    editor = new $.fn.dataTable.Editor( {
                        ajax: function ( method, url, data, success, error ) {
                            $.ajax( {
                                type: "POST",
                                url:  CSVURL,
                                data: data,
                                dataType: "json",
                                success: function (json) {
                                   
                                    if(data.action == 'create'){
                                        //console.log(json);
                                        
                                        if(json){
                                            $('#'+Table_ID).DataTable().ajax.reload(); 
                                           
                                            editor.close();
                                        }else{
                                             editor.close();
                                        }
                                    }
                                    else if(data.action =='remove'){
                                        //console.log(json);
                                        
                                        if(json){
                                            
                                           $('#'+Table_ID).DataTable().ajax.reload();
                                            editor.close();
                                        }else{
                                             editor.close();
                                        }
                                    }
                                },
                                error: function (xhr, error, thrown) {
                                    //console.log(xhr, error, thrown);
                                    editor.close();
                                }
                            } );
                        },
                        table: "#" + Table_ID,
                        fields:  mainArr
                    } );
                editor.field( 'ID' ).hide();
                editor.buttons('Save').create();
                //console.log("create");
            });
             
             $('body').on('click', "#"+Table_ID+"_ImportCSV", function (e) {

                 // Display an Editor form that allows the user to pick the CSV data to apply to each column
                function selectColumns ( editor, csv, header ) {
                    var selectEditor = new $.fn.dataTable.Editor();
                    var fields = editor.order();
                 
                    for ( var i=0 ; i<fields.length ; i++ ) {
                        var field = editor.field( fields[i] );
                 
                        selectEditor.add( {
                            label: field.label(),
                            name: field.name(),
                            type: 'select',
                            options: header,
                            def: header[i]
                        } );
                    }
                 
                    selectEditor.create({
                        title: 'Map CSV fields',
                        buttons: 'Import '+csv.length+' records',
                        message: 'Select the CSV column you want to use the data from for each field.'
                    });
                 
                    selectEditor.on('submitComplete', function (e, json, data, action) {
                        // Use the host Editor instance to show a multi-row create form allowing the user to submit the data.
                        editor.create( csv.length, {
                            title: 'Confirm import',
                            buttons: 'Submit',
                            message: 'Click the <i>Submit</i> button to confirm the import of '+csv.length+' rows of data. Optionally, override the value for a field to set a common value by clicking on the field below.'
                        } );
                 
                        for ( var i=0 ; i<fields.length ; i++ ) {
                            var field = editor.field( fields[i] );
                            var mapped = data[ field.name() ];
                 
                            for ( var j=0 ; j<csv.length ; j++ ) {
                                field.multiSet( j, csv[j][mapped] );
                            }
                        }
                    } );
                    }
                    var mainArr = [];
                    var editMainArr = [];
                    $.each(jsonData.columnTitle, function (i, title) {
                        objArr = {};
                        objArr['label'] = title; 
                        objArr['name'] = title
                        mainArr.push(objArr);
                        editMainArr.push(objArr);
                     });
                    
                    //editMainArr.push({label:'ID', name:'ID'});

                    // Upload Editor - triggered from the import button. Used only for uploading a file to the browser
                    var uploadEditor = new $.fn.dataTable.Editor( {
                        fields: [ {
                            label: 'CSV file:',
                            name: 'csv',
                            type: 'upload',
                          
                            ajax: function ( files ) {
                                // Ajax override of the upload so we can handle the file locally. Here we use Papa
                                // to parse the CSV.
                                Papa.parse(files[0], {
                                    header: true,
                                    skipEmptyLines: true,
                                    complete: function (results) {
                                        if ( results.errors.length ) {
                                            //console.log( results );
                                            uploadEditor.field('csv').error( 'CSV parsing error: '+ results.errors[0].message );
                                        }
                                        else {
                                            uploadEditor.close();
                                            selectColumns( editor, results.data, results.meta.fields );
                                        }
                                    }
                                });
                            }
                        } ]
                    } );
                   
                                      // Regular editor for the table
                    editor = new $.fn.dataTable.Editor( {
                        ajax: function ( method, url, data, success, error ) {
                            tstData =  JSON.stringify(data);
                            tstData = data;
                            $.ajax( {
                                type: "POST",
                                url:  CSVURL,
                                data:  tstData,
                                dataType: "json",
                                success: function (json) {
                                   
                                    if(data.action == 'create'){
                                        //console.log(json);
                                        
                                        if(json){
                                            
                                            $('#'+Table_ID).DataTable().ajax.reload();
                                            editor.close();
                                        }else{
                                             editor.close();
                                        }
                                    }
                                    else if(data.action =='remove'){
                                        //console.log(json);
                                        
                                        if(json){
                                            
                                            $('#'+Table_ID).DataTable().ajax.reload();
                                            editor.close();
                                        }else{
                                             editor.close();
                                        }
                                    }
                                },
                                error: function (xhr, error, thrown) {
                                    //console.log(xhr, error, thrown);
                                    editor.close();
                                }
                            } );
                        },
                        table: "#" + Table_ID,
                        fields:  mainArr
                    } );
                     uploadEditor.create( {
                        title: 'CSV file import'
                        } );
            });
            $('body').on('click', "#"+Table_ID+"_buttons-select-all", function (e) {
                var tableServ = $('#'+Table_ID).DataTable();
                tableServ.rows({search:'applied'}).select();
                rowIdx = 'undefined';
             });
            $('body').on('click', "#"+Table_ID+"_buttons-select-none", function (e) {
                var tableServ = $('#'+Table_ID).DataTable();
                tableServ.rows().deselect();
             });
             
            $('body').on('click', "#"+Table_ID+"_buttons-edit", function (e) {
                var table = $('#'+Table_ID).DataTable();
                rowCom = table.rows('.selected').data().length;
               
                if(rowIdx == undefined || rowIdx == 'undefined' || rowCom > 1)
                {
                    
                    editor.title( 'Edit record' )
                    .buttons( 'Update' )
                    .edit();
                    var table = $('#'+Table_ID).DataTable();
                    var j = 0;
                    if(rowCom > 1)
                    {
                        var data = table.rows('.selected').data();
                        var idRow = table.rows('.selected').ids();
                        
                        for ( var j=0 ; j<rowCom ; j++ ) {
                                
                                var fields = editor.order();

                                for ( var i=0 ; i<fields.length ; i++ ) {

                                    var field = editor.field( fields[i] );
                                  
                                    editor.field(field.label()).multiSet(idRow[j], data[j][i] );
                                    ////console.log(editor.field(field.label()).multiGet());
                                        
                                }
                        }
                       
                    }
                    //editRow.field( 'ID' ).hide();

                   
                }else{

                
                //console.log('Index: ' + rowIdx + ", " + rowVal );
                rowVal = table.rows('.selected').data();
                rowVal = rowVal[0];
                rowIdx = table.rows('.selected').ids();
                rowIdx = rowIdx[0];
                
                 var editRow = new $.fn.dataTable.Editor( {
                  ajax: function ( method, url, data, success, error ) {
                        $.ajax( {
                            type: "POST",
                            url:  CSVURL,
                            data: data,
                            dataType: "json",
                            success: function (json) {
                               
                                if(data.action == 'edit'){
                                    //console.log(json);
                                    
                                    if(json){
                                        
                                        $('#'+Table_ID).DataTable().ajax.reload();
                                        editRow.close();
                                        //$(this).modal('hide');
                                    }else{
                                         editRow.close();
                                    }
                                }
                                
                            },
                            error: function (xhr, error, thrown) {
                                //console.log(xhr, error, thrown);
                                editRow.close();
                                
                            }
                        } );

                    },

                  fields: editMainArr
                    
                });
                editRow.field( 'ID' ).hide();
                var fields = editRow.order();
                
                for ( var i=0 ; i<fields.length ; i++ ) {
                    var field = editRow.field( fields[i] );
             
                    editRow.field(field.label()).def(rowVal[i]);
                }
                editRow.field('ID').def(rowIdx);
                
                editRow
                    .title( 'Edit record' )
                    .buttons( 'Update' )
                    .edit();

                }

                
            });
            $('body').on('click', "#"+Table_ID+"_buttons-remove", function (e) {

                var table = $('#'+Table_ID).DataTable();
                rowCom = table.rows('.selected').data().length;
                
                if(rowIdx == undefined || rowIdx == 'undefined' || rowCom > 1)
                {
                    var totalrow  = table.rows().data().length;
                   
                    if(rowCom >= 1 && rowCom != totalrow)
                    {
                       
                        editor = new $.fn.dataTable.Editor( {
                            ajax: function ( method, url, data, success, error ) {
                                $.ajax( {
                                    type: "POST",
                                    url:  CSVURL,
                                    data: data,
                                    dataType: "json",
                                    success: function (json) {
                                       
                                        if(data.action == 'create'){
                                            //console.log(json);
                                            
                                            if(json){
                                                
                                                $('#'+Table_ID).DataTable().ajax.reload();
                                                editor.close();
                                            }else{
                                                 editor.close();
                                            }
                                        }
                                        else if(data.action =='remove'){
                                            //console.log(json);
                                            
                                            if(json){
                                                
                                                $('#'+Table_ID).DataTable().ajax.reload();
                                                editor.close();
                                            }else{
                                                 editor.close();
                                            }
                                        }
                                    },
                                    error: function (xhr, error, thrown) {
                                        //console.log(xhr, error, thrown);
                                        editor.close();
                                    }
                                } );
                            },
                            table: "#" + Table_ID,
                            fields:  mainArr
                        } );
                        var ids = '';
                        var table = $('#'+Table_ID).DataTable();
                        //console.log(table.rows().data());
                        table.rows('.selected').every( function () {
                            var datat = this.data();
                            ids = ids+','+datat[0];
                        });
                        
                        //console.log(ids);
                       
                        ids = ids.substring(1);
                        CSVURL = CSVURL +'&ID='+ids;
                        editor.message( "Are you sure you want to remove these rows?" );
                    }else{
                        CSVURL = CSVURL +'&ID=all';
                        editor.message( "Are you sure you want to remove all rows?" );
                    }

                    //console.log("lkfmdlkvmdlkfm");
                    //console.log(this);

                    editor.remove( $(this).closest('tr'), {
                    title: "Delete ",
                        buttons: [
                            {
                                label: 'Cancel', fn: function() {
                                    this.close();
                                }
                            },
                            {
                                label: 'Delete', fn: function() {
                                    this.submit();
                                }
                            }
                        ]
                    } );
                    
                }else{
                     // Regular editor for the table
                    
                     rowIdx = table.rows('.selected').ids();
                     rowIdx = rowIdx[0];
                    editor = new $.fn.dataTable.Editor( {
                    ajax: function ( method, url, data, success, error ) {
                        $.ajax( {
                            type: "POST",
                            url:  CSVURL,
                            data: data,
                            dataType: "json",
                            success: function (json) {
                               
                                if(data.action == 'create'){
                                    //console.log(json);
                                    
                                    if(json){
                                        
                                        $('#'+Table_ID).DataTable().ajax.reload();
                                        editor.close();
                                    }else{
                                         editor.close();
                                    }
                                }
                                else if(data.action =='remove'){
                                    //console.log(json);
                                    
                                    if(json){
                                        
                                        $('#'+Table_ID).DataTable().ajax.reload();
                                        editor.close();
                                    }else{
                                         editor.close();
                                    }
                                }
                            },
                            error: function (xhr, error, thrown) {
                                //console.log(xhr, error, thrown);
                                editor.close();
                            }
                        } );
                    },
                    table: "#" + Table_ID,
                    fields:  mainArr
                } );
                //console.log("remove");
                var rowID = rowIdx;
                CSVURL = CSVURL +'&ID='+rowID;
                
                editor.message( "Are you sure you want to remove this row?" );
                editor.remove( $(this).closest('tr'), {
                title: "Delete ",
                    buttons: [
                        {
                            label: 'Cancel', fn: function() {
                                this.close();
                            }
                        },
                        {
                            label: 'Delete', fn: function() {
                                this.submit();
                            }
                        }
                    ]
                } );
            
                }
            });   
            $('body').on("click", "#"+Table_ID+"_ExportReporttoCSV", function () {
                var tableId = $(this).attr("data-tableId");
                //$("." + tableId + ' button.buttons-csv').click();   
                //console.log(tableId);   
                $("#" + tableId + '_wrapper  button.buttons-csv').click();
            });

            $('body').on("click", "#"+Table_ID+"_ExportReporttoExcelPivot", function () {
                var tableId = $(this).attr("data-tableId");
                var table1_ = $('#'+tableId).DataTable();
                var Maindata = table1_.rows( { search: 'applied' }).data();
                var url = "generateExcelPivotTable";
                var tempArr = [];
                for (let index = 0; index < Maindata.length ; index++) {
                    tempArr.push(Maindata[index]);
                    
                }
                if (tempArr === undefined || tempArr.length == 0) {
                    tempArr='';
                }
                $.ajax({
                        type: "POST",
                        url: url,
                        timeout: 1000000000,
                        data :{data:JSON.stringify(tempArr) , columnName : columnTitle},
                        beforeSend: function(){
                            $('#'+tableId+'_processing').show();
                        },
                        complete: function(){
                            $('#'+tableId+'_processing').hide();
                        },
                        success: function(response)
                        {
                            response = JSON.parse(response);
                            if(response.op == 'ok'){
                                
                                var link = document.createElement('a');
                                link.href = response.file;
                                link.download = 'GC Solutions AB BABC PORTAL.xlsx';
                        
                                document.body.appendChild(link);
                        
                                link.click();
                                document.body.removeChild(link);
                            }
                        }
                     });
               
            });

            $('body').on("click", "#"+Table_ID+"_ExportReporttoExcel" , function () {
                var tableId = $(this).attr("data-tableId");
                ExcelCheck = '1';
                $("#" + tableId + '_wrapper button.buttons-excel').click();
                //$("." + tableId + ' button.buttons-excel').click();
                
               
            });
            $('body').on("click", "#"+Table_ID+"_ExportReporttoExcelPAC" , function () {
                var tableId = $(this).attr("data-tableId");
                ExcelCheck = '0';
                $("#" + tableId + '_wrapper button.buttons-excel').click();
                //$("." + tableId + ' button.buttons-excel').click();
                
               
            });
           
            $('body').on("click", "#"+Table_ID+"_openAllChildRows" , function () {
                var table1 = $('#'+Table_ID).DataTable();
                // Enumerate all rows
                table1.rows().every(function(){
                    // If row has details collapsed
                    if(!this.child.isShown()){
                        // Open this row
                        this.child(format(this.data())).show();
                        $(this.node()).addClass('shown');
                    }
                });

            });
            $('.coluumnName').click(function(event){
                
                event.stopPropagation();
                id = event.target.id;
               
                title = id.split("coluumnName");
               
                
                var DIvName   = "div"+title[0]+title[1];
                if(document.getElementById(DIvName) !== null)
                {
                  
                    $("#"+DIvName).remove();
                    $('#'+id).append(tableFilterButtonCol(title[0],title[1]));
                    $('#filterBtn'+id).dropdown("toggle");
                }else{
                   
                    $('#'+id).append(tableFilterButtonCol(title[0],title[1]));
                    $('#filterBtn'+id).dropdown("toggle");
                }
               
                
                             
              });
              
           
            $('body').on("click", "#"+Table_ID+"_closeAllChildRows" , function () {
                var table1 = $('#'+Table_ID).DataTable();
                // Enumerate all rows
                table1.rows().every(function(){
                    // If row has details expanded
                    if(this.child.isShown()){
                        // Collapse row details
                        this.child.hide();
                        $(this.node()).removeClass('shown');
                    }
                });
                
               
            });
            tableTestId  = Table_ID;
            // $.getScript(base_url + '/assets/Custome_Code/DataTables/onClickFile.js', function()
            // {

            // });
            $('body').on("click", "#"+Table_ID+"_ExportReporttoPdf" , function () {
               
                var tableId = $(this).attr("data-tableId");
                $("#" + tableId + '_wrapper button.buttons-pdf').click();
                //$("." + tableId + ' button.buttons-pdf').click();
            });

            $('body').on("click", ".RefreshPage", function () {
                var tableId = '';
                var columnName = '';
                var searchArray = [];
                var searchValueParam = '';
                var obj = {};
                var searchStr = "";
                var searchValue = '';
                var url = $(location).attr('href');
                $(".search_by").each(function(index ) {

                    searchValue = $( this ).val();

                    if(searchValue != '' && searchValue != null){
                        searchStr += (searchValue + '~');
                        columnName = $(this).attr("data-columnname");
                        tableId = $(this).attr("data-placeholderId");
                        obj[columnName] = searchValue;
                    }
                });

                //return false;
                searchArray.push(obj);
                JSON.stringify(searchArray);
                searchValueParam = JSON.stringify(searchArray);
                url = removeUrlParameter(url, 'pholderid');
                url = removeUrlParameter(url, 'searchvalue');
                url = url + '&pholderid=' + tableId + '&searchvalue=' + searchValueParam;
                window.location.href = url;
            });

            $('.test_act').find('*').prop('disabled',true);

            var table1 = $('#'+Table_ID).DataTable();
         
             $('#'+Table_ID+' thead').on( 'click', 'th', function () {
                  sortFlag = 1;
            });

           
            $('#'+Table_ID+' tbody').on( 'click', 'tr', function () {

                if(EnableRowGroupLevel == '1'){
                    closeAll = '';
                    openAll = '';
                    var name = $(this).data('name');
                    var Clasname = $(this).attr('class');
                    Clasname = Clasname.split('level-');
                    Clasname = Clasname[1];
                  
                    if(Clasname == '0' || Clasname == '0 selected'){
                        // const nodeList = document.querySelectorAll("*[id^='"+name+"']");
                        const nodeList = document.querySelectorAll("[id^='"+name+"'][id$='-level1']");
                        
                        var cnt  = 1;
                        for (let i = 0; i < nodeList.length; i++) {
                           
                            //if(nodeList[i].className.includes('level-0') ){
                                if(cnt){
                                   var elm = document.getElementById(name+'-level0');
                                    
                                    var innerHtml4  = elm.innerHTML;
                                   
                                    if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>'))
                                    {
                                        innerHtml4 = innerHtml4.replace('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' , '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' );
                                        
                                    }else if (innerHtml4.includes('<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>')){
                                        innerHtml4 = innerHtml4.replace( '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' , '<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' );
                                    }else if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="chevron_right">chevron_right</span>')){
                                        innerHtml4 = innerHtml4.replace(  '<span class="material-symbols-outlined" <span="" id="chevron_right">chevron_right</span>' , '<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' );
                                    }
                                    
                                   elm.innerHTML  = innerHtml4;
                                    cnt =0;
                                }
                           // }else{
                               
                                if((nodeList[i].style.display != 'none'))
                                {
                                    if(nodeList[i].id.startsWith(name) ){
                                       var checkName = nodeList[i].id.split('-level1');
                                        checkName = checkName[0];
                                        var innernode =  document.querySelectorAll("tr:not([style*='display:none']):not([style*='display: none'])[id^='"+checkName+"'][id$='-level2']");
                                        if(innernode.length >= 1){
                                            for (let j = 0; j < innernode.length; j++) {
                                                var innerHtml4  =  innernode[j].innerHTML;
                                   
                                                if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>'))
                                                {
                                                    innerHtml4 = innerHtml4.replace('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' , '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' );
                                                    
                                                }
                                                
                                                innernode[j].innerHTML  = innerHtml4;
                                                innernode[j].style.display ="none";
                                                var checkName1 = innernode[j].id.split('-level2');
                                                checkName1 = checkName1[0];
                                                var innernode1 =  document.querySelectorAll("tr:not([style*='display:none']):not([style*='display: none'])[id^='"+checkName1+"']");
                                                if(innernode1.length >= 1){
                                                    for (let k = 0; k < innernode1.length; k++) {
                                                        var innerHtml4  =  innernode1[k].innerHTML;
                                   
                                                        if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>'))
                                                        {
                                                            innerHtml4 = innerHtml4.replace('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' , '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' );
                                                            
                                                        }
                                                        
                                                        innernode1[k].innerHTML  = innerHtml4;
                                                        innernode1[k].style.display ="none";
                                                        
                                                    }
                                                }

                                            }
                                           
                                            
                                           
                                        }
                                        var innerHtml4  =  nodeList[i].innerHTML;
                                   
                                        if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>'))
                                        {
                                            innerHtml4 = innerHtml4.replace('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' , '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' );
                                            
                                        }
                                        
                                        nodeList[i].innerHTML  = innerHtml4;
                                        nodeList[i].style.display ="none";
                                    }
                                
                                    
                                   
                                }else{
                                   
                                    if(nodeList[i].className.includes('level-1') && nodeList[i].id.startsWith(name) ){
                                        nodeList[i].style.display = "";
                                    }    
                                }
                               
                            //}
                        }
                        
                       
                    }else if(Clasname == '1' || Clasname == '1 selected'){
                        var cnt = 1;
                        const nodeList = document.querySelectorAll("[id^='"+name+"'][id$='-level2']");
                        const nodeListOther = document.querySelectorAll("*[id^='"+name+"']");
                        
                        if(nodeList.length > 0){
                           
                            for (let i = 0; i < nodeList.length; i++) {
                                //if(nodeList[i].className.includes('level-1') ){
                                    if(cnt){
                                        var elm = document.getElementById(name+'-level1');
            
                                        var innerHtml4  = elm.innerHTML;
                                        if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>'))
                                        {
                                            innerHtml4 = innerHtml4.replace('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' , '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' );
                                            
                                        }else if (innerHtml4.includes('<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>')){
                                            innerHtml4 = innerHtml4.replace( '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' , '<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' );
                                        }else if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="chevron_right">chevron_right</span>')){
                                            innerHtml4 = innerHtml4.replace(  '<span class="material-symbols-outlined" <span="" id="chevron_right">chevron_right</span>' , '<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' );
                                        }
                                        
                                        elm.innerHTML = innerHtml4;
                                        cnt =0;
                                    }
                                //}else{
                                    if((nodeList[i].style.display != 'none'))
                                    {
                                        
                                        if(nodeList[i].id.startsWith(name) )
                                        {
                                            
                                            nodeList[i].style.display ="none";
                                            var checkName = nodeList[i].id.split('-level2');
                                            checkName = checkName[0];
                                            var innernode =  document.querySelectorAll("tr:not([style*='display:none']):not([style*='display: none'])[id^='"+checkName+"']");
                                            if(innernode.length >= 1){
                                                for (let j = 0; j < innernode.length; j++) {
                                                    innernode[j].style.display ="none";
                                                    
                                                    
                                                }
                                            }
                                            
                                        }
                                        
                                        
                                        
                                    }else{
                                        if(nodeList[i].className.includes('level-2') && nodeList[i].id.startsWith(name) ){
                                            nodeList[i].style.display = "";
                                        }    
                                    }
                                    
                                //}
                            }
                        }else {
                            
                            for (let i = 0; i < nodeListOther.length; i++) {
                                if(nodeListOther[i].className.includes('level-1') ){
                                    if(cnt){
                                        var innerHtml4  = nodeListOther[i].innerHTML;
                                        if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>'))
                                        {
                                            innerHtml4 = innerHtml4.replace('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' , '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' );
                                            
                                        }else if (innerHtml4.includes('<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>')){
                                            innerHtml4 = innerHtml4.replace( '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' , '<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' );
                                        }else if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="chevron_right">chevron_right</span>')){
                                            innerHtml4 = innerHtml4.replace(  '<span class="material-symbols-outlined" <span="" id="chevron_right">chevron_right</span>' , '<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' );
                                        }
                                       
                                        nodeListOther[i].innerHTML = innerHtml4;
                                        cnt =0;
                                    }
                                }else{
                                    
                                    if(nodeListOther[i].style.display != 'none')
                                    {
                                        nodeListOther[i].style.display = "none";
                                    }else{
                                        nodeListOther[i].style.display = "";    
                                    }
                                }
                               
                                
                            }
                        }
                    
                        
                        
                        
                       
                    }else if (Clasname == '2' || Clasname == '2 selected'){
                        var cnt = 1;
                        const nodeList = document.querySelectorAll("[id^='"+name+"'][id$='-level3']");
                        const nodeListOther = document.querySelectorAll("*[id^='"+name+"']");
         
                        if(nodeList.length > 0){
                            for (let i = 0; i < nodeList.length; i++) {
                                if(nodeList[i].className.includes('level-2') ){
                                    if(cnt){
                                        //var elm = document.getElementById(name+'-level2');
            
                                        var innerHtml4  = nodeList[i].innerHTML;
                                        if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>'))
                                        {
                                            innerHtml4 = innerHtml4.replace('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' , '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' );
                                            
                                        }else if (innerHtml4.includes('<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>')){
                                            innerHtml4 = innerHtml4.replace( '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' , '<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' );
                                        }else if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="chevron_right">chevron_right</span>')){
                                            innerHtml4 = innerHtml4.replace(  '<span class="material-symbols-outlined" <span="" id="chevron_right">chevron_right</span>' , '<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' );
                                        }
                                    
                                        nodeList[i].innerHTML = innerHtml4;
                                        cnt =0;
                                    }
                                }else{
                                    
                                    if((nodeList[i].style.display != 'none'))
                                    {
                                        if(nodeList[i].id.startsWith(name) ){
                                            
                                            nodeList[i].style.display = "none";
                                        }
                                        
                                    
                                    }else{
                                        if(nodeList[i].className.includes('level-3') && nodeList[i].id.startsWith(name) ){
                                            nodeList[i].style.display = "";
                                        } 
                                        
                                             
                                    }
                                    //$('.leveldata-3').hide();
                                }
                            }
                        }else {
                            
                            for (let i = 0; i < nodeListOther.length; i++) {
                                if(nodeListOther[i].className.includes('level-2') ){
                                    if(cnt){
                                        var innerHtml4  = nodeListOther[i].innerHTML;
                                        if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>'))
                                        {
                                            innerHtml4 = innerHtml4.replace('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' , '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' );
                                            
                                        }else if (innerHtml4.includes('<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>')){
                                            innerHtml4 = innerHtml4.replace( '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' , '<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' );
                                        }else if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="chevron_right">chevron_right</span>')){
                                            innerHtml4 = innerHtml4.replace(  '<span class="material-symbols-outlined" <span="" id="chevron_right">chevron_right</span>' , '<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' );
                                        }
                                       
                                        nodeListOther[i].innerHTML = innerHtml4;
                                        cnt =0;
                                    }
                                }else{
                                    
                                    if(nodeListOther[i].style.display != 'none')
                                    {
                                        nodeListOther[i].style.display = "none";
                                    }else{
                                        nodeListOther[i].style.display = "";    
                                    }
                                }
                               
                                
                            }
                        }
                        
                    }else if (Clasname == '3' || Clasname == '3 selected'){
                        var cnt =1;
                        const nodeList = document.querySelectorAll("*[id^='"+name+"']");
                        //console.log(nodeList);
                       
                        for (let i = 0; i < nodeList.length; i++) {
                            if(nodeList[i].className.includes('level-3') ){
                                if(cnt){
                                    var innerHtml4  = nodeList[i].innerHTML;
                                    if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>'))
                                    {
                                        innerHtml4 = innerHtml4.replace('<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' , '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' );
                                        
                                    }else if (innerHtml4.includes('<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>')){
                                        innerHtml4 = innerHtml4.replace( '<span class="material-symbols-outlined" id="chevron_right">chevron_right</span>' , '<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' );
                                    }else if(innerHtml4.includes('<span class="material-symbols-outlined" <span="" id="chevron_right">chevron_right</span>')){
                                        innerHtml4 = innerHtml4.replace(  '<span class="material-symbols-outlined" <span="" id="chevron_right">chevron_right</span>' , '<span class="material-symbols-outlined" <span="" id="expand_more">expand_more</span>' );
                                    }
                                   
                                    nodeList[i].innerHTML = innerHtml4;
                                    cnt =0;
                                }
                            }else{
                                
                                if(nodeList[i].style.display != 'none')
                                {
                                    nodeList[i].style.display = "none";
                                }else{
                                    nodeList[i].style.display = "";    
                                }
                            }
                           
                            
                        }
                        
                    }

                   // collapsedGroups[name] = !collapsedGroups[name];
                    //table1.draw(false);
                } else if(EnablerowGroup == 1 ){
                    closeAll = '';
                    openAll = '';
                    var name = $(this).data('name');
                    collapsedGroups[name] = !collapsedGroups[name];
                    table1.draw(false);
                }
               
                var status_ = false;
                
                if(EnableCrud && EnableXMLdownload == 0)
                {
                    if ($(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                        status_ = false;
                    }else{
                        $(this).addClass('selected');
                        status_ = true;
                    }
                    
                        var data_row = 0;
                    $('#'+Table_ID).find('tr:last').children().each(function(){
                        var cs = $(this).attr('colspan');
                        if(cs > 0){ data_row += Number(cs); }
                        else{ data_row++; }
                    });
                    
                    var idx =table1.row( this ) .index();
                    var row_data = table1.row( this ).data();

                    var rowIdxtemp  = table1.row( this ).id();
                    rowCom = table1.rows('.selected').data().length;
                    ////console.log('Index: ' + idx + ", " + row_data );
                    
                    var array = Object.keys(row_data).map(item => row_data[item]);
                    //console.log(array);
                    
                    rowIdx = rowIdxtemp ;
                    rowVal = array;
                    
                    
                    //console.log('Array: ' + rowVal);
                    var length_ = $('#'+Table_ID).find("tr:first th").length;
                    array_length = array.length;
                    
                    //table1.buttons().enable();
                    var names = array[array.length-2];
                    var links = array[array.length-1];
                    
                }else{

                    if ( EnableAllUpdates == 1 ) {
                        if ( $(this).hasClass('selected') ) {
                            $(this).removeClass('selected');
                        }
                        else {
                            $(this).addClass('selected');
                        }
                    }else{

                            if ( $(this).hasClass('selected') ) {
                                $(this).removeClass('selected');
                                status_ = false;
                            }
                            else {
                                    
                                    table1.$('tr.selected').removeClass('selected');
                                    $(this).addClass('selected');
                                    status_ = true;
                            
                            }
                    }
                        
                    var data_row = 0;
                    $('#'+Table_ID).find('tr:last').children().each(function(){
                        var cs = $(this).attr('colspan');
                        if(cs > 0){ data_row += Number(cs); }
                        else{ data_row++; }
                    });
                    
                    
                    var idx =table1.row( this ) .index();
                    var row_data = table1.row( this ).data();
                    rowIdx = table1.row( this ).id();
                    rowCom = table1.row( this );
                    //console.log('Index: ' + idx + ", " + row_data );
                    if(row_data){
                        var array = Object.keys(row_data).map(item => row_data[item]);
                        rowVal = array;
                        //console.log('Array: ' + array);
                        var length_ = $('#'+Table_ID).find("tr:first th").length;
                        array_length = array.length;
                        
                        //table1.buttons().enable();
                        var names = array[array.length-2];
                        var links = array[array.length-1];
                        
                        links = links.split('%20').join(' ');
                    }else{
                        var length_ = $('#'+Table_ID).find("tr:first th").length;
                        array_length = 0;
                        var names = [];
                        var links = [];
                        
                        links = "";
                    }
                    
                }
                checkVal12 = array;
                //console.log(checkVal12);
                if (array_length > length_  && EnableOnclickBtn == 1) {
                    if(base_url != 'http://www.babcnew.com')
                    {
                        base_url = absPath[0]+'public';
                    }
                    //$.getScript(base_url + '/assets/Custome_Code/DataTables/customButton.js', function()
                    //{
                        //console.log(base_url + '/assets/Custome_Code/DataTables/customButton.js');
                        var temp1 = tableSubActionsButton(Table_ID, links, names, 'ACTIONS',status_,queryString);
                        $('#actions_'+Table_ID).replaceWith(temp1);
                    //});
                    
                }
                
                if(base_url != 'http://www.babcnew.com')
                {
                    base_url = absPath[0]+'public';
                }
                //$.getScript(base_url + '/assets/Custome_Code/DataTables/customButton.js', function()
                //{
                        var temp2 = tableAddMoreInfoSub(Table_ID, array);
                        $('#product_'+Table_ID).replaceWith(temp2);
                //});
                   

                $('.test_act_'+Table_ID).find('*').prop('disabled',false);
                $('.test_product_'+Table_ID).find('*').prop('disabled',false);
                
                    
            } ); 
            // Code Part for HighCharts 
            //console.log(mapArray);
            if (graphDiscription.trim() != '' && graphDiscription.trim() != null) {
                graphDiscription = JSON.parse(graphDiscription);
                if(base_url != 'http://www.babcnew.com')
                {
                    base_url = absPath[0]+'public';
                }
                $.getScript(base_url + '/assets/Custome_Code/DataTables/customRelatedHighSofts.js', function()
                    {
                        //console.log("here22sssss222");
                        generateGraphs(graphDiscription , chartColumn , DataTable , searchFlag , mapArray , mapLabel  , Table_ID , placeholderId , conArray);
                        
                    });
            }
            // will change it for Maps
            if(mapArray.code != undefined && mapPresent != 0){
                if(base_url != 'http://www.babcnew.com')
                {
                    base_url = absPath[0]+'public';
                }
                $.getScript(base_url + '/assets/Custome_Code/Highsofts/customHighMaps.js', function()
                {   var MapTypes = '' ;
                    if(mapDiscription != '' && mapDiscription != null){
                        //console.log(placeholderId);
                            //console.log(mapDiscription); 
                        $.each(JSON.parse(mapDiscription), function( mapkey, mapValue ) {
                            
                            if(mapValue.TableId == placeholderId){

                                MapTypes = mapValue.MapType;
                                    //console.log(MapTypes); 
                            }
                           
                            setTableEvents(DataTable,'','', '', '', mapArray , mapLabel ,mapArrayNew , mapLabelNew , MapTypes , mapDisplayLabelNew );
                
                        });
                    }

                });
            }
            
        }, 2000);
    });
}





function updateFilter(tableId ,value , columnNo){
   
    if( $('#-span-class--filter-datatable-label--Prioritet--span-Table_1').val() == value){
        $('#-span-class--filter-datatable-label--Prioritet--span-Table_1').val('').trigger('change'); 
    }else{
        $('#-span-class--filter-datatable-label--Prioritet--span-Table_1').val(value).trigger('change'); 
    }
   // $('#-span-class--filter-datatable-label--priority--span-Table_1').val(value).trigger('change'); 
}

//RLevels click error ? 

function removeUrlParameter(url, parameter) {
    var urlParts = url.split('?');

    if (urlParts.length >= 2) {
        // Get first part, and remove from array
        var urlBase = urlParts.shift();

        // Join it back up
        var queryString = urlParts.join('?');

        var prefix = encodeURIComponent(parameter) + '=';
        var parts = queryString.split(/[&;]/g);

        // Reverse iteration as may be destructive
        for (var i = parts.length; i-- > 0;) {
            // Idiom for string.startsWith
            if (parts[i].lastIndexOf(prefix, 0) !== -1) {
                parts.splice(i, 1);
            }
        }

        url = urlBase + '?' + parts.join('&');
    }

    return url;
}



