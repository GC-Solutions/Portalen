// This function is used for  custom Table   its contain all the logic for rowgroup close , open and clear all  option 

function tableButton(tableId) {

    // var tableToolsButton = "<div class='btn-group pull-left table_action_buttons' >" +
    var tableToolsButton = "<div class='btn-group table_action_buttons' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Table" +
        "<i class='fa fa-angle-down'></i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right'>";

    tableToolsButton = tableToolsButton +
        "<li><a id ='" + tableId + "_buttons-create' class ='newEntry'> New </a></li>" +
        "<li><a id ='" + tableId + "_buttons-edit' > Edit</a></li>" +
        "<li><a id ='" + tableId + "_buttons-remove' > Delete </a></li>" +
        "<li><a id ='" + tableId + "_buttons-remove' > Delete All </a></li>" +
        "<li><a id ='" + tableId + "_buttons-select-all' > Select ALL </a></li>" +
        "<li><a id ='" + tableId + "_buttons-select-none' > De Select ALL </a></li>";

    tableToolsButton = tableToolsButton + "</ul>" +
        "</div>";
    return tableToolsButton;
}

function tableXMLButton(tableId, placeholderId, AllowDynamicForm) {

    // var tableToolsButton = "<div class='btn-group pull-left table_action_buttons' >" +
    var tableToolsButton = "<div class='btn-group table_action_buttons' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Table" +
        "<i class='fa fa-angle-down'></i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right'>";

    tableToolsButton = tableToolsButton +
        "<li><a  class ='newEntry' onclick='callPaymentForm(\"create\" , " + placeholderId + " , " + AllowDynamicForm + ")' > New </a></li>"
        +
        // "<li><a onclick='callPaymentForm(\"edit\" , "+placeholderId +")' > Edit</a></li>"+
        // "<li><a id ='"+tableId+"_buttons-remove' > Delete </a></li>"+
        // "<li><a id ='"+tableId+"_buttons-remove' > Delete All </a></li>"+
        "<li><a id ='" + tableId + "_buttons-select-all' > Select ALL </a></li>" +
        "<li><a id ='" + tableId + "_buttons-select-none' > De Select ALL </a></li>";

    tableToolsButton = tableToolsButton + "</ul>" +
        "</div>";
    return tableToolsButton;
}
function tableDynamicFormButton(tableId, placeholderId, AllowDynamicForm) {

    // var tableToolsButton = "<div class='btn-group pull-left table_action_buttons' >" +
    var tableToolsButton = "<div class='btn-group table_action_buttons' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Table" +
        "<i class='fa fa-angle-down'></i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right'>";

    tableToolsButton = tableToolsButton +
        "<li><a  class ='newEntry' onclick='callPaymentForm(\"create\" , " + placeholderId + "," + AllowDynamicForm + ")' > New </a></li>"
        +
        "<li><a onclick='callPaymentForm(\"edit\" , " + placeholderId + "," + AllowDynamicForm + ")' > Edit</a></li>" +
        "<li><a id ='" + tableId + "_buttons-remove' > Delete </a></li>" +
        "<li><a id ='" + tableId + "_buttons-remove' > Delete All </a></li>" +
        "<li><a id ='" + tableId + "_buttons-select-all' > Select ALL </a></li>" +
        "<li><a id ='" + tableId + "_buttons-select-none' > De Select ALL </a></li>";

    tableToolsButton = tableToolsButton + "</ul>" +
        "</div>";
    return tableToolsButton;
}

// this function helps to open the form for products
function callPaymentForm(op, pId, AllowForm) {
    dt = '';
    if (op == 'edit') {
        dt = checkVal12;
    }
    var url = "AddPayment";
    $.ajax({
        type: "POST",
        url: url,
        data: { action: op, placeholderId: pId, data: dt }, // serializes the form's elements.
        success: function (data) {
            if (AllowForm == '1') {
                $('.modal-body').html(data);

                // Display Modal
                $('#empModal').modal('show');
            } else {
                $.fancybox(data);
            }



        }
    });
}

function tableButtonXML(tableId, placeholderId) {

    // var tableToolsButton = "<div class='btn-group pull-left table_action_buttons' >" +
    var tableToolsButton = "<div class='btn-group table_action_buttons' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' onclick='downloadXML(" + tableId + " , " + placeholderId + ")' >Download XML File" +
        "</a></div>";
    return tableToolsButton;
}

// This function is used for DT  its contain all the logic for childrow  close , open  option 

function chilRowButton(tableId) {

    var tableToolsButton = "<div class='btn-group pull-left table_action_buttons' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Child Rows" +
        "<i class='fa fa-angle-down'></i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right'>";

    tableToolsButton = tableToolsButton +
        "<li><a  id ='" + tableId + "_openAllChildRows' data-tableId='" + tableId + "'>Open All</a></li>" +
        "<li><a  id ='" + tableId + "_closeAllChildRows' data-tableId='" + tableId + "'>Close All </a></li>";

    tableToolsButton = tableToolsButton + "</ul>" +
        "</div>";
    return tableToolsButton;
}
function chilRowButtonRunTym(tableId) {

    var tableToolsButton = "<div class='btn-group pull-left table_action_buttons' >" +
        "<a class='btn deepPink-bgcolor  btn-outline ' onclick='setval()' id ='" + tableId + "_openAllChildRows' data-tableId='" + tableId + "'>Download ChildRow Data" +
        "</a>" +
        "</div>";
    return tableToolsButton;
}
function setval() {
    runtymDownload = 1;
    setTimeout(function () {
        alert("Data Downloaded");
    }, 8000);

}
// function for 

function tableHeaderRowInnerSort(tableId, groupRowsColumnA, sort, predefineSearchFlag, groupRowsFlag, footerColumn, hiddenColumn, groupRowsColumnId, column_title) {
    var tableToolsButton = "<div class='btn-group pull-left table_action_buttons' id='" + tableId + "headerBtn' style='display:none;'  >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown' id='" + tableId + "headerBtnss' >Inner Row Sort" +
        "</a>" +
        "<ul class='dropdown-menu pull-right' >";
    //console.log(column_title);
    $.each(column_title, function (i, title) {
        var titleValue = column_title[i];
        var sndName = tableId + titleValue;
        tableToolsButton = tableToolsButton + "<li class='dropdown-item dropdown-submenu'>"
            + "<p class='test123' onclick='testtFTN(event);' >" + titleValue + "</p>" +
            "<ul class=' example12 dropdown-menu' >" +
            "<li class='dropdown-item' id='AscSort'>" +
            "<a   onclick='rowGroupShifting(  \"" + tableId + "\" , \"sortBy\" , \"" + groupRowsColumnId + "\", \"Header\" ,\"" + sort + "\" ,\"" + predefineSearchFlag + "\"  ,\"" + footerColumn + "\" ,\"" + hiddenColumn + "\" ,\"\"  ,\"\"  ,\"" + groupRowsColumnA + "\"  , \"asc\" , \"" + i + "\" )'>Asc</a></li>" +
            "<li class='dropdown-item'>" +
            "<a   id='DescSort' onclick='rowGroupShifting(  \"" + tableId + "\" , \"sortBy\" , \"" + groupRowsColumnId + "\", \"Header\" ,\"" + sort + "\" ,\"" + predefineSearchFlag + "\"  ,\"" + footerColumn + "\" ,\"" + hiddenColumn + "\" ,\"\"  ,\"\"  ,\"" + groupRowsColumnA + "\"  , \"desc\" , \"" + i + "\" )'>Desc</a></li>";

        tableToolsButton = tableToolsButton + "</ul></li>";

    });
    tableToolsButton = tableToolsButton +
        "</ul>" +
        "</div>";
    return tableToolsButton;
}
function activateSort(sortDirection, columnIndex) {
    sortVariable = sortDirection;
    sortColumnID = columnIndex;
}

function tableRowGroupButton(tableId, groupRowsColumnA, sort, predefineSearchFlag, groupRowsFlag, footerColumn, hiddenColumn, groupRowsColumnId, column_title) {


    // var tableToolsButton = "<div class='btn-group pull-left table_action_buttons' >" +
    var tableToolsButton = "<div class='btn-group table_action_buttons' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Row Group " +
        "<i class='fa fa-angle-down'></i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right'>";

    if (groupRowsColumnA != undefined && groupRowsColumnA.length != 0 && groupRowsFlag == 1) {
        tableToolsButton = tableToolsButton + "<li class='dropdown-item dropdown-submenu'><p onclick='rowGroupShifting(  \"" + tableId + "\" , \"OpenAll\" )'>Open All</p></li>" +
            "<li class='dropdown-item dropdown-submenu'><p onclick='rowGroupShifting(  \"" + tableId + "\" , \"CloseAll\" )'>Close All</p></li>";
        tableToolsButton = tableToolsButton + "<li class='dropdown-item dropdown-submenu'>"
            + "<p class='test123' onclick='testtFTN(event);' >Group By</p>" +
            "<ul class=' example12 dropdown-menu' >";
        var defaultCol = '';
        var defaultColName = '';

        $.each(groupRowsColumnA, function (i, title) {
            defaultCol = i;
            defaultColName = title;
            return false;
        });
        $.each(groupRowsColumnA, function (i, title) {
            var titleValue = groupRowsColumnA[i];
            var columnKey = i;


            $.each(column_title, function (colKey, Colti) {

                if (Colti == titleValue) {
                    columnKey = colKey;
                    return false;
                }
            });

            tableToolsButton = tableToolsButton +
                "<li class='dropdown-item'>" +
                "<a onclick='rowGroupShifting(  \"" + tableId + "\" , \"groupBy\" ,\"" + columnKey + "\", event ,\"" + sort + "\" ,\"" + predefineSearchFlag + "\",\"" + titleValue + "\"  )'>Group BY " + titleValue + "</a></li>" +
                "</li>";


        });

        tableToolsButton = tableToolsButton + "</ul>";
        tableToolsButton = tableToolsButton + "<li class='dropdown-item dropdown-submenu'>"
            + "<p class='test123' onclick='testtFTN(event);' >Sort By</p>" +
            "<ul class=' example12 dropdown-menu' >";

        tableToolsButton = tableToolsButton +
            "<li class='dropdown-item'>" +
            "<a onclick='rowGroupShifting(  \"" + tableId + "\" , \"sortBy\" , \"" + groupRowsColumnId + "\", \"Inner\" ,\"" + sort + "\" ,\"" + predefineSearchFlag + "\" ,\"" + footerColumn + "\" ,\"" + hiddenColumn + "\"  ,\"\"  ,\"\"    ,\"" + groupRowsColumnA + "\"   )'>Inner Rows </a></li>" +
            "</li>" + "<li class='dropdown-item'>" +
            "<a onclick='rowGroupShifting(  \"" + tableId + "\" , \"sortBy\" , \"" + groupRowsColumnId + "\", \"InnerAll\" ,\"" + sort + "\" ,\"" + predefineSearchFlag + "\"  ,\"" + footerColumn + "\" ,\"" + hiddenColumn + "\" ,\"\"  ,\"\"   ,\"" + groupRowsColumnA + "\"  )'>InnerAll Rows </a></li>" +
            "</li>" + "<li class='dropdown-item dropdown-submenu'>" +
            "<a onclick='rowGroupShifting(  \"" + tableId + "\" , \"sortBy\" , \"" + groupRowsColumnId + "\", \"Header\" ,\"" + sort + "\" ,\"" + predefineSearchFlag + "\"  ,\"" + footerColumn + "\" ,\"" + hiddenColumn + "\" ,\"\"  ,\"\"  ,\"" + groupRowsColumnA + "\"   )'> Header Rows </a>" +
            "</li>" +
            "</li>";
        tableToolsButton = tableToolsButton + "</ul>";
        tableToolsButton = tableToolsButton + "<li class='dropdown-item dropdown-submenu'>"
            + "<p class='test123' onclick='testtFTN(event);' >Search By</p>" +
            "<ul class=' example12 dropdown-menu' >";

        tableToolsButton = tableToolsButton +
            "<li class='dropdown-item'>" +
            "<a onclick='rowGroupShifting(  \"" + tableId + "\" , \"searchBy\" , \"" + groupRowsColumnId + "\", \"innerSearch\" ,\"" + sort + "\" ,\"" + predefineSearchFlag + "\" )'>Inner Rows </a></li>" +
            "</li>"
            // + "<li class='dropdown-item'>"+ 
            // "<a onclick='rowGroupShifting(  \""+tableId+"\" , \"searchBy\" , \""+groupRowsColumnId+"\", \"allSearch\" ,\""+sort+"\" ,\""+predefineSearchFlag+"\" )'>All Rows </a></li>"+
            // "</li>"  + "<li class='dropdown-item'>"+ 
            // "<a onclick='rowGroupShifting(  \""+tableId+"\" , \"searchBy\" , \""+groupRowsColumnId+"\", \"outerSearch\" ,\""+sort+"\" ,\""+predefineSearchFlag+"\" )'>Outer Rows </a></li>"+
            // "</li>"
            ;
        tableToolsButton = tableToolsButton + "</ul>";
        tableToolsButton = tableToolsButton + "<li class='dropdown-item dropdown-submenu'><p onclick='rowGroupShifting(  \"" + tableId + "\" , \"reset\" , \"" + defaultCol + "\" ,  \"" + defaultColName + "\" )'>Reset</p></li>";

    }

    tableToolsButton = tableToolsButton + "</ul>" +
        "</div>";
    return tableToolsButton;
}
// This function is used for performing row group shifting
function rowGroupShifting(tableId, name, columnId, event1, sort, predefineSearchFlag, groupRowsFlag, footerColumn, hiddenColumn, prevSort, groupRowsColumnA, sortDirection, columnSortIndex) {

    if (name == 'OpenAll') {
        var table1 = $('#' + tableId).DataTable();
        openAll = 'openall';
        closeAll = '';

        table1.draw(false);
    } else if (name == 'CloseAll') {
        var table1 = $('#' + tableId).DataTable();
        closeAll = 'closeall';
        openAll = '';
        table1.draw(false);
    } else if (name == 'groupBy') {


        var table = $('#' + tableId).DataTable();
        event.preventDefault();
        closeAll = '';
        openAll = '';
        tempGlobal = setGlobal;
        setGlobal = '';


        groupRowsColumn = columnId;


        table.rowGroup().dataSrc(columnId);
        $("#" + tableId + "_infoGroupBy").remove();

        $neText = '<div class="dataTables_info groupbyStatus" id="' + tableId + '_infoGroupBy" role="status" aria-live="polite" style = "float:right;">Group By : ' + groupRowsFlag + '  </div>';
        $("#" + tableId + "_info").after($neText);

        // console.log(predefineSearchFlag);
        // console.log(sort);
        // if(predefineSearchFlag != 0){
        //     table.order.fixed({pre: [[sort, 'asc']]}).draw();
        // }
        // else{
        table.order.fixed({ pre: [[columnId, 'asc']] }).draw();
        //}
        setGlobal = tempGlobal;
    } else if (name == 'sortBy') {
        var table = $('#' + tableId).DataTable();

        var url = 'setSession';
        var text = '';

        if (sortDirection == 'asc' || sortDirection == 'desc') {
            sortVariable = sortDirection;
            sortColumnID = columnSortIndex;
            CheckFlagg = '1';
            //console.log(lastOrder);

        }


        setGlobal1[tableId + 'setGlobal'] = tableId + event1;

        if (tableId + event1 == tableId + 'Header') {
            $('#' + tableId + 'headerBtn').show();
            setGlobalPrevious1[tableId + 'setGlobalPrevious'] = tableId + 'Inner';
            setGlobalPrevious = tableId + 'Inner';
            event1 = tableId + 'Header';
            text = 'Header and Inner';

        } else {
            $('#' + tableId + 'headerBtn').hide();
            setGlobalPrevious1[tableId + 'setGlobalPrevious'] = '';
            setGlobalPrevious = '';
            text = event1;
        }

        $.ajax({
            type: "POST",
            url: url,
            data: { data: event1 }, // serializes the form's elements.
            success: function (data) {
                setGlobal = tableId + event1;


            }
        });


        setGlobal = '';
        var ord = table.order();
        //console.log(groupRowsColumnA);
        if (ord[0][0] == groupRowsColumn) {
            lastOrdeState = ord[0][1];
        }



        table.order.fixed({ pre: [[groupRowsColumn, lastOrdeState]] }).draw();


        $("#" + tableId + "_sortInfo").remove();


        $neText = '<div class="dataTables_info sortStatus" id="' + tableId + '_sortInfo" role="status" aria-live="polite" style = "float:right;">Sorted By : ' + text + ' Rows </div>';
        $("#" + tableId + "_info").after($neText);

        setGlobal = tableId + event1;
    } else if (name == 'searchBy') {
        var table = $('#' + tableId).DataTable();

        var url = 'setSession';

        $.ajax({
            type: "POST",
            url: url,
            data: { data: event1 }, // serializes the form's elements.
            success: function (data) {
                setGlobal = event1;


            }
        });
        $(".searchStatus").remove();
        if ($("#" + tableId + "_sortInfo").length) {

            var val = event1.replace('Search', '');
            $neText = '<div class="dataTables_info searchStatus" id="' + tableId + '_infoSearch" role="status" aria-live="polite" style = "float:right;">Searched By : ' + val + ' Rows </div>';
            $(".sortStatus").before($neText);
        } else {

            var val = event1.replace('Search', '');
            $neText = '<div class="dataTables_info searchStatus" id="' + tableId + '_infoSearch" role="status" aria-live="polite" style = "float:right;">Searched By : ' + val + ' Rows </div>';
            $("#" + tableId + "_info").after($neText);
        }


        setGlobal = event1;
    } else if (name == 'reset') {

        var table = $('#' + tableId).DataTable();
        event.preventDefault();
        closeAll = '';
        openAll = '';

        setGlobal = '';


        groupRowsColumn = columnId;


        table.rowGroup().dataSrc(columnId);
        table.order.fixed({ pre: [[columnId, 'asc']] }).draw();

        $(".groupbyStatus").remove();
        $(".sortStatus").remove();
        $(".searchStatus").remove();
        $neText = '<div class="dataTables_info groupbyStatus" id="' + tableId + '_infoGroupBy" role="status" aria-live="polite" style = "float:right;">Group By : ' + event1 + '  </div>';
        $("#" + tableId + "_info").after($neText);

        $neText = '<div class="dataTables_info sortStatus" id="' + tableId + '_sortInfo" role="status" aria-live="polite" style = "float:right;">Sorted By : Inner Rows </div>';
        $("#" + tableId + "_info").after($neText);
        $neText = '<div class="dataTables_info searchStatus" id="' + tableId + '_infoSearch" role="status" aria-live="polite" style = "float:right;">Searched By : Inner Rows </div>';
        $(".sortStatus").before($neText);


        setGlobal = 'Inner';


    }
}
// this function is used to clear all the values present in the filter 
function testftn(id) {
    $('.select2-selection__rendered').empty();
    $(':input').val('');
    $.fn.dataTable.ext.search.pop();
    var table = $('#Table_1').DataTable();

    table
        .search('')
        .columns().search('')
        .draw();
}
// End of Table Button and its realted function
//----------------------------------------------------------------------------------------------------
// this function is used for tools button 
function tableToolsButton(tableId, EnableCsvImport, EnableExcelBtn, placeholderId, PageName, SaveFilterBTN, AllowPDFImport, AllowExcelImport, columnTitle) {

    // var tableToolsButton = "<div class='btn-group pull-left table_action_buttons' >" +
    var tableToolsButton = "<div class='btn-group table_action_buttons' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Tools" +
        "<i class='fa fa-gear'></i>" + "<i class='fa fa-angle-down'></i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right'>" +
        "<li><a class='CopyData' id ='" + tableId + "_CopyData' data-tableId='" + tableId + "'><i class='fa fa-clipboard'></i>Copy</a></li>";

    if (EnableCsvImport != undefined && EnableCsvImport == 1) {
        tableToolsButton = tableToolsButton +
            "<li><a class='ImportReporttoCSV'  id ='" + tableId + "_ImportCSV' data-tableId='" + tableId + "'><i class='fa fa-file-excel-o'></i>Import CSV</a></li>" +
            "<li><a class='ExportReporttoCSV'  id ='" + tableId + "_ExportReporttoCSV' data-tableId='" + tableId + "'><i class='fa fa-file-excel-o'></i>Export to CSV</a></li>" +
            "<li><a class='ExportReporttoExcel' id ='" + tableId + "_ExportReporttoExcel' data-tableId='" + tableId + "'><i class='fa fa-file-excel-o'></i>Export to Excel</a></li>" +
            "<li><a class='ExportReporttoPdf' id ='" + tableId + "_ExportReporttoPdf' data-tableId='" + tableId + "'><i class='fa fa-file-pdf-o'></i> Export to PDF </a></li>";

    } else {

        tableToolsButton = tableToolsButton +
            "<li><a class='ExportReporttoCSV'  id ='" + tableId + "_ExportReporttoCSV' data-tableId='" + tableId + "'><i class='fa fa-file-excel-o'></i>Export to CSV</a></li>" +
            "<li><a class='ExportReporttoExcel' id ='" + tableId + "_ExportReporttoExcel' data-tableId='" + tableId + "'><i class='fa fa-file-excel-o'></i>Export to Excel</a></li>" +
            "<li><a class='ExportReporttoExcelPivot' id ='" + tableId + "_ExportReporttoExcelPivot'  data-tableId='" + tableId + "'><i class='fa fa-file-excel-o'></i>Export to Excel with pivot Table</a></li>" +
            "<li><a class='ExportReporttoPdf' id ='" + tableId + "_ExportReporttoPdf' data-tableId='" + tableId + "'><i class='fa fa-file-pdf-o'></i> Export to PDF </a></li>";
        //console.log(tableToolsButton);
    }
    if (EnableExcelBtn != undefined && EnableExcelBtn == 1) {
        tableToolsButton = tableToolsButton +
            "<li><a class='ExportReporttoExcelPAC' id ='" + tableId + "_ExportReporttoExcelPAC' data-tableId='" + tableId + "'><i class='fa fa-file-excel-o'></i>Export to Excel + PAC </a></li>";
    }

    if (SaveFilterBTN == 1) {
        tableToolsButton = tableToolsButton +
            "<li><a class='ClearAllFilters'  onclick='ClearFilter( \"" + placeholderId + "\" , \"0\" ,  \"" + PageName + "\" ,  \"" + tableId + "\")' id ='" + tableId + "_ClearAllFilters' data-tableId='" + tableId + "'><i class='fa fa-file-excel-o'></i>Clear All Filters </a></li>";
        tableToolsButton = tableToolsButton +
            "<li><a class='SaveAllFilters'  onclick='SaveFilter( \"" + placeholderId + "\" , \"0\" ,  \"" + PageName + "\" ,  \"" + tableId + "\")' id ='" + tableId + "_SaveAllFilters' data-tableId='" + tableId + "'><i class='fa fa-file-excel-o'></i>Save All Filters </a></li>";
    }

    if (AllowExcelImport == 1) {
        tableToolsButton = tableToolsButton +
            "<li><a class='ImportExcel'  id ='" + tableId + "_ImporExcel' data-tableId='" + tableId + "' onclick = 'OpenPopUP()' ><i class='fa fa-file-excel-o'></i>Import Excel</a></li>";
    }
    if (AllowPDFImport == 1) {
        tableToolsButton = tableToolsButton +
            "<li><a class='ImportPDF'  id ='" + tableId + "_ImporPDF' data-tableId='" + tableId + "' onclick = 'OpenPopUPPDF()' ><i class='fa fa-file-pdf-o'></i>Import PDF</a></li>";
    }
    tableToolsButton = tableToolsButton +
        "<li><a class='DeletePDFFile'  id ='" + tableId + "_DelImportPDF' data-tableId='" + tableId + "' onclick = 'OpenPopUPDeletePDF(\"" + tableId + "\")' ><i class='fa fa-file-pdf-o'></i>Delete Files </a></li>";
    tableToolsButton = tableToolsButton +
        "<li><a class='ExportReporttoExcelLarge' id ='" + tableId + "_ExportReporttoExcelLarge' data-tableId='" + tableId + "' onclick = 'SaveExcelFile( \"" + tableId + "\" ,  \"" + columnTitle + "\" )'><i class='fa fa-file-excel-o'></i>Export to Excel Large</a></li>";


    tableToolsButton = tableToolsButton + "</ul>" +
        "</div>";

    return tableToolsButton;
}
// End of Table Tools button
//----------------------------------------------------------------------------------------------------

function toChunks(arr, chunkSize = 20000) {
    let chunkToSend = [];
    for (let i = 0; i < arr.length; i++) {
        chunkToSend.push(arr[i])
        arr.shift();
        if (chunkToSend.length >= chunkSize) {
            break;
        }
    }

    return {
        chunkToSend,
        arr
    };
}


function sendAjaxToSaveExcel(tableId, arr, columnName, id, lastCall = false, part_number = 0) {
    let chunkResults = toChunks(arr);
    let finalData = {};
    if (lastCall) {
        finalData = {
            close: true,
            id: id,
            columnName: columnName
        };
        $.ajax({
            url: "SaveExcel",
            type: "post",
            timeout: 10000000000,
            data: finalData,
            success: function (res) {
                // console.log("response from success");
                // $('#' + tableId + '_processing').hide();
            }
        });
        return false;
    } else {
        finalData = {
            data: JSON.stringify(chunkResults.chunkToSend),
            columnName: columnName,
            id: id,
            close: false,
            part_number: part_number
        }
        $.ajax({
            url: "SaveExcel",
            type: "post",
            timeout: 10000000000,
            data: finalData,
            beforeSend: function () {
                $('#' + tableId + '_processing').show();
            },
            success: function (res) {
                // console.log("response from success");
                if (chunkResults.arr.length > 0) {
                    // console.log("we are making another call");
                    part_number = part_number + 1;
                    sendAjaxToSaveExcel(tableId, chunkResults.arr, columnName, id, false, part_number);
                } else {
                    // console.log("finally we reached the end");
                    sendAjaxToSaveExcel(tableId, chunkResults.arr, columnName, id, true, part_number);
                    $('#' + tableId + '_processing').hide();
                    alert('Excel file will be Send to you in 15-20 minutes');
                }
            }
        });
    }
};

function SaveExcelFile(tableId, columnTitle) {
    var table1_ = $('#' + tableId).DataTable();
    var randomId = Math.floor(Math.random() * 288277)
    var Maindata = table1_.rows({ search: 'applied' }).data();
    var tempArr = [];
    for (let index = 0; index < Maindata.length; index++) {
        tempArr.push(Maindata[index]);
    }

    sendAjaxToSaveExcel(tableId, tempArr, columnTitle, randomId);

}

function OpenPopUPDeletePDF(Table_ID) {
    var table = $('#' + Table_ID).DataTable();
    rowCom = table.rows('.selected').data().length;
    var NewData = table.rows('.selected').data()[0][0];

    data = '<div>' +
        '<form action="" method="post" enctype="multipart/form-data">' +
        '<div class="form-group">' +
        '<p> Uploaded File value ' + NewData + '</p>' +
        ' </div>' +
        "<input type='button' class='btn btn-default' value='Delete File' id='btn_upload' onclick ='DeleteFileUpload(\"" + NewData + "\" , \"" + Table_ID + "\")'>" +
        '</form>' +
        '</div>';
    $('.modal-body').html(data);

    // Display Modal
    $('#empModal').modal('show');
}
function DeleteFileUpload(NewData, tableId) {

    $.ajax({
        url: 'FileDelete',
        type: 'post',
        data: { Data: NewData },
        success: function (response) {
            if (response) {
                $('#empModal').modal('hide');
                alert(response);
                $('#'.tableId).DataTable().ajax.reload();
            }
        }
    });
}

function OpenPopUPPDF() {
    data = '<div>' +
        '<form action="" method="post" enctype="multipart/form-data">' +
        '<div class="form-group">' +
        '<label for="file">PDF file:</label>' +
        '<input type="file" class="form-control" id="file" name="file" required>' +
        ' </div>' +
        "<input type='button' class='btn btn-default' value='Upload' id='btn_upload' onclick ='PDFUpload()'>" +
        '</form>' +
        '</div>';
    $('.modal-body').html(data);

    // Display Modal
    $('#empModal').modal('show');
}
function PDFUpload() {
    var fd = new FormData();
    var files = $('#file')[0].files[0];
    //console.log(files);
    fd.append('file', files);

    // AJAX request
    $.ajax({
        url: 'PDFUpload',
        type: 'post',
        data: fd,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response) {
                $('#empModal').modal('hide');
                alert(response);
            }
        }
    });
}
function OpenPopUP() {
    data = '<div>' +
        '<form action="" method="post" enctype="multipart/form-data">' +
        '<div class="form-group">' +
        '<label for="file">Excel file:</label>' +
        '<input type="file" class="form-control" id="file" name="file" required>' +
        ' </div>' +
        "<input type='button' class='btn btn-default' value='Upload' id='btn_upload' onclick ='ExcelUpload()'>" +
        '</form>' +
        '</div>';
    $('.modal-body').html(data);

    // Display Modal
    $('#empModal').modal('show');
}
function ExcelUpload() {
    var fd = new FormData();
    var files = $('#file')[0].files[0];
    //console.log(files);
    fd.append('file', files);

    // AJAX request
    $.ajax({
        url: 'ExcelUpload',
        type: 'post',
        data: fd,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response) {
                $('#empModal').modal('hide');
                alert(response);
            }
        }
    });
}
function SaveFilterNoAlert( plId , uid, pT, pN){
    
    var url = "SaveFilter";
    table = $('#'+pN).DataTable();
    var newArr = [];
    for (var i = 0; i < table.columns().count(); i++) {
       newArr.push(table.column(i).search());
    }
    $.ajax({
            type: "POST",
            url: url,
            data: { placeholderId:plId , userId:uid , pageName:pT , holderValue:pN , value:newArr}, // serializes the form's elements.
            success: function(data)
            {
               // alert("Searched Values has been Saved ");
                console.log("Filters saved.");
                
                
            }
            });
}
function SaveFilter(plId, uid, pT, pN) {

    var url = "SaveFilter";
    table = $('#' + pN).DataTable();
    var newArr = [];
    for (var i = 0; i < table.columns().count(); i++) {
        newArr.push(table.column(i).search());
    }
    $.ajax({
        type: "POST",
        url: url,
        data: { placeholderId: plId, userId: uid, pageName: pT, holderValue: pN, value: newArr }, // serializes the form's elements.
        success: function (data) {
            alert("Searched Values has been Saved ");
            console.log(data);


        }
    });
}

//----------------------------------------------------------------------------------------------------
function ClearFilter(plId, uid, pT, pN) {

    var url = "ClearFilter";
    $.ajax({
        type: "POST",
        url: url,
        data: { placeholderId: plId, userId: uid, pageName: pT, holderValue: pN, value: '' }, // serializes the form's elements.
        success: function (data) {
            location.reload();
            console.log(data);


        }
    });
}


function predefinedUpdateButton(tableId, Name, Id, selectedNames) {

    var predefinedUpdateButton = "<div class='btn-group table_action_buttons' id ='" + tableId + "_UpdateValDiv' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'   onclick='UpdateData(\"" + tableId + "\" ,\"" + Id + "\" , \"" + selectedNames + "\" )' > MULTIPLE UPDATE " +
        "<i class='fa fa-gear'></i>" + "<i class='fa fa-angle-down'></i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right' id ='" + tableId + "_UpdateVal' >" +
        "</ul></div>";
    return predefinedUpdateButton;
}

function UpdateData(Table_ID, PredefinedUpdateId, selectedNames) {

    var table1 = $('#' + Table_ID).DataTable();
    SelectedRow = table1.rows('.selected').data();
    var orderVal = '';
    $.each(SelectedRow, function (selectedKey, selectedValue) {
        orderVal = selectedValue[PredefinedUpdateId] + '||' + orderVal;

    });

    $('#' + Table_ID + "_UpdateVal li").remove();
    var testDatta = table1.row(0).data();

    var links = testDatta[testDatta.length - 1];
    var names = testDatta[testDatta.length - 2];
    links = links.replaceAll('%20', '');
    var link2_ = String(links).split('%');
    var link_ = link2_.filter(v => v != '');

    if (typeof names === 'string') {
        var names2_ = names.split('%');
    } else {
        var names2_ = names;
    }

    var names_ = names2_.filter(v => v != '');
    console.log(selectedNames);
    if (selectedNames) {
        selectedNames = selectedNames.split(',');
    }
    else {
        selectedNames = names_;
        console.log(selectedNames);
    }
    for (i = 0; i < link_.length; ++i) {

        if (link_[i].indexOf("getUpdatePredefined") >= 0 && selectedNames.includes(names_[i])) {

            link_[i] = link_[i].replace('})', ', "curLoc" : "' + window.location.href + '" , "Allupdate":"1" })');
            var newLink = link_[i].split('orderNoValue":"');
            var newLink1 = newLink[1].split('","baseUrl"');

            console.log(orderVal);
            if (orderVal.slice(-2) === "||") {
                // Remove the last two characters
                orderVal = orderVal.slice(0, -2);

            } else {

            }
            newLink = newLink[0] + 'orderNoValue":"' + orderVal + '","baseUrl"' + newLink1[1];

            console.log(newLink);
            var tempLi = "<li>" +
                "<a href='#' onclick='" + newLink + "' id ='" + Table_ID + "_" + names_[i] + "' >" +
                names_[i] +
                "</a>" +
                "</li>";
            $('#' + Table_ID + "_UpdateVal").append($(tempLi));

        }
    }
}
// this function is used for New Filters  button 
function tableFiltersButton(tableId) {

    // var tableToolsButton = "<div class='btn-group pull-left table_action_buttons' >" +
    var tableFiltersButton = "<div class='btn-group table_action_buttons' style='display:none' id ='" + tableId + "_FilterDataDiv' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Filters" +
        "<i class='fa fa-gear'></i>" + "<i class='fa fa-angle-down'></i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right'>" +
        "<li id ='" + tableId + "_FilterData'><a class='FilterData'  data-tableId='" + tableId + "'></a></li>";
    tableFiltersButton = tableFiltersButton + "</ul>" +
        "</div>";
    return tableFiltersButton;
}
// End of Table Tools button
//----------------------------------------------------------------------------------------------------
// this function is used to change the filter type of different columns
function tableFilterButton(tableId, column_title) {

    // var tableFilterButton = "<div class='btn-group pull-left table_action_buttons ' >" +
    var tableFilterButton = "<div class='btn-group table_action_buttons' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Filter" + "<i class='fa fa-filter'></i>" +
        "<i class='fa fa-angle-down'></i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right' >" +
        "<li ><a onclick='testftn(" + tableId + ")'>Clear All </a></li>";

    $.each(column_title, function (i, title) {
        var titleValue = column_title[i];
        var sndName = tableId + titleValue;
        tableFilterButton = tableFilterButton + "<li class='dropdown-item dropdown-submenu'>"
            + "<p class='test123' onclick='testtFTN(event);' >" + titleValue + "</p>" +
            "<ul class=' example12 dropdown-menu' >" +
            "<li class='dropdown-item' >" +
            "<a onclick='rangeFtn(  \"" + sndName + "\" , \"mainS_\" )'>Normal</a></li>" +
            "<li class='dropdown-item' >" +
            "<a onclick='rangeFtn(  \"" + sndName + "\" , \"fromTo_\" )'>Range </a></li>" +
            "<li class='dropdown-item'>" +
            "<a onclick='rangeFtn(  \"" + sndName + "\" , \"exc_div\" )'>Exclude</a></li>";

        $.each(window[tableId + 'AllowMultipleSelectionColumn'], function (k, v) {

            if (titleValue == v) {
                tableFilterButton = tableFilterButton + "<li class='dropdown-item' >" +
                    "<a onclick='rangeFtn(  \"" + sndName + "\" , \"searchDiv_\" )'>Multiple Search</a></li>";
            }
        });
        tableFilterButton = tableFilterButton + "</ul></li>";

    });
    tableFilterButton = tableFilterButton +
        "</ul>" +
        "</div>";

    return tableFilterButton;
}
function tableFilterButtonCol(tableId, column_title) {


    var tableFilterButton =
        "<div id ='div" + tableId + column_title + "'><a class='dropdown-toggle' data-toggle='dropdown' id ='filterBtn" + tableId + 'coluumnName' + column_title + "'>" +
        "</a>" +
        "<ul class='dropdown-menu ' >";

    var titleValue = column_title;
    var sndName = tableId + titleValue;
    tableFilterButton = tableFilterButton +
        "<li class='dropdown-item'  id='filtermainS_" + sndName + "'>" +
        "<a onclick='rangeFtn(  \"" + sndName + "\" , \"mainS_\" )'>Normal</a></li>" +
        "<li class='dropdown-item'  id='filterfromTo_" + sndName + "'>" +
        "<a onclick='rangeFtn(  \"" + sndName + "\" , \"fromTo_\" )'>Range </a></li>" +
        "<li class='dropdown-item'  id='filterexc_div" + sndName + "'>" +
        "<a onclick='rangeFtn(  \"" + sndName + "\" , \"exc_div\" )'>Exclude</a></li>";

    $.each(window[tableId + 'AllowMultipleSelectionColumn'], function (k, v) {

        if (column_title == v) {
            tableFilterButton = tableFilterButton + "<li class='dropdown-item' id='filtersearchDiv_" + sndName + "'>" +
                "<a onclick='rangeFtn(  \"" + sndName + "\" , \"searchDiv_\" )'>Multiple Search</a></li>";
        }
    });

    tableFilterButton = tableFilterButton + "</ul> </div>";

    return tableFilterButton;
}
function testtFTN(event) {
    event.stopPropagation();
}
// this function is ued to change the filter type to range one 
function rangeFtn(dropDown, type) {
    dropDown = dropDown.replace('#', '_');
    dropDown = dropDown.replace('%', '_');
    if (type == 'fromTo_') {

        $('#mainS_' + dropDown).hide();
        $('#fromTo_' + dropDown).show();
        $('#exc_div' + dropDown).hide();
        $('#searchDiv_' + dropDown).hide();
        $("#div" + dropDown).remove();

    } else if (type == 'mainS_') {

        $('#mainS_' + dropDown).show();
        $('#fromTo_' + dropDown).hide();
        $('#exc_div' + dropDown).hide();
        $('#searchDiv_' + dropDown).hide();
        $("#div" + dropDown).remove();
    } else if (type == 'searchDiv_') {


        $('#mainS_' + dropDown).hide();
        $('#fromTo_' + dropDown).hide();
        $('#exc_div' + dropDown).hide();
        $('#searchDiv_' + dropDown).show();
        $("#div" + dropDown).remove();
    } else if (type == 'exc_div') {
        var val = $('#exc_div' + dropDown).attr("style");
        if (val == 'display: none;') {

            $('#mainS_' + dropDown).hide();
            $('#fromTo_' + dropDown).hide();
            $('#exc_div' + dropDown).show();
            $('#searchDiv_' + dropDown).hide();
            $("#div" + dropDown).remove();
        } else {

            $('#mainS_' + dropDown).show();
            $('#exc_div' + dropDown).hide();
            $('#searchDiv_' + dropDown).hide();
            $("#div" + dropDown).remove();
        }

    }

}
// End of Table Filter Button
//----------------------------------------------------------------------------------------------------
// this function is used for Action Button

function tableActionsButton(tableId) {

    //console.info('tableActionsButton: ' + tableId );
    //console.log("heredd");
    if (!document.getElementById("actions_" + tableId)) {
        // var tableActionsButton = "<div class='btn-group pull-left table_action_buttons test_act_"+tableId+"' id='actions_"+tableId+"'>"+
        var tableActionsButton = "<div class='btn-group table_action_buttons test_act_" + tableId + "' id='actions_" + tableId + "'>" +
            "<a class='btn dimGray-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>" +
            "Actions" +
            "<i class='fa fa-angle-down'>" +
            "</i>" +
            "</a>" +
            "</div>";

        return tableActionsButton;
    }
}
// This function add all the action button link to Acton button

function tableSubActionsButton(tableId, links, names, action_name, status, queryString) {
    // console.info('tableSubActionsButton1 =>', tableId, links, names, action_name);

    var t = "";
    links = links.replaceAll('%20', '');
    var link2_ = String(links).split('%');
    if (typeof names === 'string') {
        var names2_ = names.split('%');
    } else {
        var names2_ = names;
    }

    var tabTest = $('#' + tableId).DataTable();

    var tableIdss = tableId;
    var link_ = link2_.filter(v => v != '');
    var names_ = names2_.filter(v => v != '');
    var color_ = status ? "deepPink-bgcolor" : "dimGray-bgcolor";

    var tableActionsButton = "<div class='btn-group pull-left table_action_buttons test_act_" + tableId + "' id='actions_" + tableId + "'>" +
        "<button class='btn dimGray-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>" +
        "Actions" +
        "<i class='fa fa-angle-down'>" +
        "</i>" +
        "</button>" +
        "</div>";

    var tableSubActionsButton = "<div class='btn-group pull-left table_action_buttons test_act_" + tableId + "' id='actions_" + tableId + "'>" +
        "<a class='btn " + color_ +
        " btn-outline dropdown-toggle' data-toggle='dropdown'>" +
        action_name +
        "<i class='fa fa-angle-down'>" +
        "</i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right'>";

    for (i = 0; i < link_.length; ++i) {


        if (link_[i].indexOf("getUpdatePredefined") >= 0) {

            link_[i] = link_[i].replace('})', ', "curLoc" : "' + window.location.href + '" })');
            //console.log(link_[i]);
        }

        if (link_[i].indexOf("LiveAPISyncReport") >= 0 || link_[i].indexOf("getUpdateDataSourceCall") >= 0 || link_[i].indexOf("getUpdatePredefined") >= 0) {
            t = "<li>" +
                "<a href='#' onclick='" + link_[i] + "'>" +
                names_[i] +
                "</a>" +
                "</li>";

        }
        else {
            //console.log('overhere');

            var testVar = link_[i].split('&');
            //console.log(testVar);

            $.each(testVar, function (k, v) {
                //console.log(v.indexOf('columnValue='));
                if (v.indexOf('columnValue=') != -1) {


                    if (typeof testVar[k + 1] != "undefined" && testVar[k + 1].indexOf('=') < 1) {
                        var check = testVar[k + 1].indexOf('=');
                        testVar[k] = v + 'and' + testVar[k + 1];
                        testVar.splice(k + 1);
                        return false;
                    }
                }
            });
            t = "";
            var tempLoc = testVar[0].split('/');
            //console.log(tempLoc);
            var last = tempLoc[tempLoc.length - 1]
            //console.log(last);
            var location = last + '&' + testVar[1];

            if (testVar.length > 1) {
                if (typeof testVar[2] != 'undefined' && typeof testVar[3] != 'undefined') {
                    var columnName = testVar[2].split('=');
                    var columnValue = testVar[3].split('=');
                    var FIDs = testVar[1].split('=');
                    var formId = columnName[1] + FIDs[1] + columnValue[1];
                    console.log("lnlj");
                    console.log(formId);
                }
                else {
                    var columnName = [];
                    var columnValue = [];
                    if (testVar[1].indexOf("InvoiceNo") != '-1') {
                        var tempIn = testVar[1].split('=');
                        var formId = tempIn[1];
                    } else {
                        var formId = "form1";
                    }


                }
                if (typeof testVar[4] != 'undefined' && typeof testVar[5] != 'undefined') {
                    var pageId = testVar[4].split('=');
                    var tableId = testVar[5].split('=');

                } else {
                    var pageId = [];
                    var tableId = [];

                }

                // form creation for 
                var form = $('<form></form>');
                form.attr("method", "post");
                form.attr("id", formId);
                form.attr("action", location);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", 'backbutton');
                field.attr("value", link_[i]);

                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", 'currLoc');
                var locCurr = window.location.href + queryString;
                //console.log(locCurr);
                field.attr("value", locCurr);

                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", columnName[0]);
                field.attr("value", columnName[1]);

                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", columnValue[0]);
                field.attr("value", columnValue[1]);
                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", 'focusPage');
                field.attr("value", '1');
                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", 'TableId');
                field.attr("value", tableIdss);
                form.append(field);

                var sortOrder = tabTest.order();
                var title = tabTest.column(sortOrder[0][0]).header();
                var tempTitle = $(title).text();
                tempTitle = tempTitle.trim();

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", tempTitle + 'Sort');
                field.attr("value", sortOrder[0]);
                form.append(field);

                tabTest.columns().every(function (index) {
                    var serachval = tabTest.column(index).search();
                    var title = tabTest.column(index).header();
                    var tempTitle = $(title).text();
                    tempTitle = tempTitle.trim();
                    tempTitle = tempTitle.replace('#', '_');
                    tempTitle = tempTitle.replace('%', '_');
                    if ($('#fromTo_' + tableIdss + tempTitle).css('display') != 'none') {
                        var toForName = tableIdss + '_' + tempTitle;
                        var toVal = $('#' + toForName + 'toRange').val();
                        var fromVal = $('#' + toForName + 'fromRange').val();

                        var field = $('<input></input>');
                        field.attr("type", "hidden");
                        field.attr("name", tempTitle + 'ToFromRangeFilter');
                        field.attr("value", "from:" + toVal + ",to:" + fromVal);
                        form.append(field);

                    } else {
                        var field = $('<input></input>');
                        field.attr("type", "hidden");
                        field.attr("name", tempTitle + 'Filter');
                        field.attr("value", serachval);
                        form.append(field);
                    }



                });

                if (typeof pageId != 'undefined') {

                    var field = $('<input></input>');
                    field.attr("type", "hidden");
                    field.attr("name", pageId[0]);
                    field.attr("value", pageId[1]);
                    form.append(field);
                }

                if (typeof tableId != 'undefined') {

                    var field = $('<input></input>');
                    field.attr("type", "hidden");
                    field.attr("name", tableId[0]);
                    field.attr("value", tableId[1]);
                    form.append(field);
                }


                $(form).appendTo('body');

                ////NEW CODE over Here
                var form = 'document.getElementById("' + formId + '")';
                //console.log(formId);
                if (typeof pageId !== 'undefined' && pageId.length > 0) {
                    t += "<li>" +
                        // Added line http://"+ SA
                        "<a href='#' onclick='ftnCall(" + form + ")'>" +
                        names_[i] +
                        "</a>" +
                        "</li>";
                } else {
                    t += "<li>" +
                        // Added line http://"+ SA
                        "<a href='#' onclick='" + form + ".submit();'>" +
                        names_[i] +
                        "</a>" +
                        "</li>";
                }
            }
            //console.log(t);
        }

        tableSubActionsButton += t;
    }
    tableSubActionsButton += "</ul></div>";
    //console.info('tableSubActionsButton =>', tableSubActionsButton);

    return status ? tableSubActionsButton : tableActionsButton;
}




function tableSubActionsButtonRows(tableId, links, names, action_name, status, queryString) {
    // console.info('tableSubActionsButton1 =>', tableId, links, names, action_name);

    var t = "";
    links = links.replaceAll('%20', '');
    var link2_ = String(links).split('%');
    if (typeof names === 'string') {
        var names2_ = names.split('%');
    } else {
        var names2_ = names;
    }

    var tabTest = $('#' + tableId).DataTable();

    var tableIdss = tableId;
    var link_ = link2_.filter(v => v != '');
    var names_ = names2_.filter(v => v != '');
    var color_ = "dimGray-bgcolor";

    //  var tableActionsButton = "<div class='btn-group pull-left table_action_buttons test_act_"+tableId+"' id='actions_"+tableId+"'>"+
    //  "<button class='btn dimGray-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>"+
    //  "Actions"+
    //  "<i class='fa fa-angle-down'>"+
    //  "</i>"+
    //  "</button>"+
    //  "</div>";

    var tableSubActionsButton = "<div class='btn-group pull-left table_action_buttons_col test_act_" + tableId + "' id='actionNew_" + tableId + "' >" +
        "<a  class='btn " + color_ +
        " btn-outline dropdown-toggle' data-toggle='dropdown'>" +
        action_name +
        "<i class='fa fa-angle-down colum-arrow'>" +
        "</i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right'>";

    for (i = 0; i < link_.length; ++i) {


        if (link_[i].indexOf("getUpdatePredefined") >= 0) {

            link_[i] = link_[i].replace('})', ', "curLoc" : "' + window.location.href + '" })');
            //console.log(link_[i]);
        }

        if (link_[i].indexOf("LiveAPISyncReport") >= 0 || link_[i].indexOf("getUpdateDataSourceCall") >= 0 || link_[i].indexOf("getUpdatePredefined") >= 0) {
            t = "<li>" +
                "<a href='#' onclick='" + link_[i] + "'>" +
                names_[i] +
                "</a>" +
                "</li>";

        }
        else {
            //console.log('overhere');

            var testVar = link_[i].split('&');
            //console.log(testVar);

            $.each(testVar, function (k, v) {
                //console.log(v.indexOf('columnValue='));
                if (v.indexOf('columnValue=') != -1) {


                    if (typeof testVar[k + 1] != "undefined" && testVar[k + 1].indexOf('=') < 1) {
                        var check = testVar[k + 1].indexOf('=');
                        testVar[k] = v + 'and' + testVar[k + 1];
                        testVar.splice(k + 1);
                        return false;
                    }
                }
            });
            t = "";
            var tempLoc = testVar[0].split('/');
            //console.log(tempLoc);
            var last = tempLoc[tempLoc.length - 1]
            //console.log(last);
            var location = last + '&' + testVar[1];

            if (testVar.length > 1) {
                if (typeof testVar[2] != 'undefined' && typeof testVar[3] != 'undefined') {
                    var columnName = testVar[2].split('=');
                    var columnValue = testVar[3].split('=');
                    var FIDs = testVar[1].split('=');

                    var formId = columnName[1] + FIDs[1] + columnValue[1];

                }
                else {
                    var columnName = [];
                    var columnValue = [];
                    if (testVar[1].indexOf("InvoiceNo") != '-1') {
                        // console.log("ghere");
                        // console.log(testVar);
                        var NewTempIn = testVar[0].split('=');
                        var tempIn = testVar[1].split('=');
                        var formId = NewTempIn[1] + 'Invoice' + tempIn[1];
                    } else {
                        var formId = "form1";
                    }


                }
                if (typeof testVar[4] != 'undefined' && typeof testVar[5] != 'undefined') {
                    var pageId = testVar[4].split('=');
                    var tableId = testVar[5].split('=');

                } else {
                    var pageId = [];
                    var tableId = [];

                }
                var element = document.getElementById(formId);

                //If it isn't "undefined" and it isn't "null", then it exists.
                if (typeof (element) != 'undefined' && element != null) {
                    //alert('Element exists!');
                    element.remove();
                }
                // form creation for 
                var form = $('<form></form>');
                form.attr("method", "post");
                form.attr("id", formId);
                form.attr("action", location);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", 'backbutton');
                field.attr("value", link_[i]);

                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", 'currLoc');
                var locCurr = window.location.href + queryString;
                locCurr = locCurr.replace('undefined', '');
                //console.log(locCurr);
                field.attr("value", locCurr);

                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", columnName[0]);
                field.attr("value", columnName[1]);

                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", columnValue[0]);
                field.attr("value", columnValue[1]);
                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", 'focusPage');
                field.attr("value", '1');
                form.append(field);

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", 'TableId');
                field.attr("value", tableIdss);
                form.append(field);

                var sortOrder = tabTest.order();
                var title = tabTest.column(sortOrder[0][0]).header();
                var tempTitle = $(title).text();
                tempTitle = tempTitle.trim();

                var field = $('<input></input>');
                field.attr("type", "hidden");
                field.attr("name", tempTitle + 'Sort');
                field.attr("value", sortOrder[0]);
                form.append(field);

                tabTest.columns().every(function (index) {
                    var serachval = tabTest.column(index).search();
                    var title = tabTest.column(index).header();
                    var tempTitle = $(title).text();
                    tempTitle = tempTitle.trim();
                    tempTitle = tempTitle.replace('#', '_');
                    tempTitle = tempTitle.replace('%', '_');
                    if ($('#fromTo_' + tableIdss + tempTitle).css('display') != 'none') {
                        var toForName = tableIdss + '_' + tempTitle;
                        var toVal = $('#' + toForName + 'toRange').val();
                        var fromVal = $('#' + toForName + 'fromRange').val();

                        var field = $('<input></input>');
                        field.attr("type", "hidden");
                        field.attr("name", tempTitle + 'ToFromRangeFilter');
                        field.attr("value", "from:" + toVal + ",to:" + fromVal);
                        form.append(field);

                    } else {
                        var field = $('<input></input>');
                        field.attr("type", "hidden");
                        field.attr("name", tempTitle + 'Filter');
                        field.attr("value", serachval);
                        form.append(field);
                    }



                });

                if (typeof pageId != 'undefined') {

                    var field = $('<input></input>');
                    field.attr("type", "hidden");
                    field.attr("name", pageId[0]);
                    field.attr("value", pageId[1]);
                    form.append(field);
                }

                if (typeof tableId != 'undefined') {

                    var field = $('<input></input>');
                    field.attr("type", "hidden");
                    field.attr("name", tableId[0]);
                    field.attr("value", tableId[1]);
                    form.append(field);
                }


                $(form).appendTo('body');

                ////NEW CODE over Here
                var form = 'document.getElementById("' + formId + '")';
                //console.log(formId);
                if (typeof pageId !== 'undefined' && pageId.length > 0) {
                    t += "<li>" +
                        // Added line http://"+ SA
                        "<a href='#' onclick='ftnCall(" + form + ")'>" +
                        names_[i] +
                        "</a>" +
                        "</li>";
                } else {
                    t += "<li>" +
                        // Added line http://"+ SA
                        "<a href='#' onclick='" + form + ".submit();'>" +
                        names_[i] +
                        "</a>" +
                        "</li>";
                }
            }
            //console.log(t);
        }

        tableSubActionsButton += t;
    }
    tableSubActionsButton += "</ul></div>";
    //console.info('tableSubActionsButton =>', tableSubActionsButton);
    return tableSubActionsButton;
    // return status ? tableSubActionsButton : tableActionsButton;
}

// this function allows to open the form in fancy box
function ftnCall(formId) {

    var form = formId;
    var data_string = $(form).serializeArray();
	    const inputString = data_string[1].value;

    const tableIdParam = data_string[5].value


// Extract the value of 'id' using a regular expression
const idMatch = inputString.match(/id=(\d+)/);
const id = idMatch ? idMatch[1] : null;

// Extract the value of 'page_text' using a regular expression
const pageTextMatch = inputString.match(/page_text=([^&]+)/);
var pageText = pageTextMatch ? decodeURIComponent(pageTextMatch[1]) : null;

// Remove the '#' character if it exists in 'page_text'
if (pageText && pageText.includes('#')) {
pageText = pageText.replace('#', '');
}
//alert(JSON.stringify(paramValue));
SaveFilterNoAlert(id,"0",pageText,tableIdParam);
	
    var url = formId.action;
    $.ajax({
        type: "POST",
        url: url,
        data: data_string, // serializes the form's elements.
        success: function (data) {
            //console.log(data);
            $('.modal-body').html(data);

            // Display Modal
            $('#empModal').modal('show');
            //$.fancybox(data);

        }
    });
}

// End of Table Action Button
//----------------------------------------------------------------------------------------------------
// this function is used for Action Button for Products that will add more info 

function tableAddMoreInfo(tableId) {

    var tableAddMoreInfo = "<div class='btn-group pull-left table_action_buttons test_product_" + tableId + "' id='product_" + tableId + "'>" +
        "<a class='btn dimGray-bgcolor  btn-outline '> Add More Info </a></div>";

    return tableAddMoreInfo;
}


// this function helps to open the form for products
function tableAddMoreInfoSub(tableId, datarow) {
    proRowData = datarow;
    var tableAddMoreInfo = "<div class='btn-group pull-left table_action_buttons test_product_" + tableId + "' id='product_" + tableId + "'>" +
        "<a class='btn deepPink-bgcolor  btn-outline ' onclick='callForm(" + tableId + ")'> Add More Info </a></div>";

    return tableAddMoreInfo;
}
// this function helps to open the form for products
function callForm(rowdata) {

    var tableIdPro1 = tableIdPro[rowdata.id];
    var data_string = {};
    var hea = proRowDataheader[rowdata.id];
    $.each(hea, function (i, title) {
        data_string[title] = proRowData[i];

    });

    data_string['TableId'] = tableIdPro1;

    var url = "AddMoreInfo";
    $.ajax({
        type: "POST",
        url: url,
        data: { data: data_string }, // serializes the form's elements.
        success: function (data) {
            $.fancybox(data);

        }
    });
}

//----------------------------------------------------------------------------------------------------
// this function is used to Live Sync Images 
function tableLiveSyncButton(tableId) {

    var tableFilterButton = "<div class='btn-group pull-left table_action_buttons ' >" +
        "<a class='btn deepPink-bgcolor  btn-outline' onclick='LiveSync(" + tableId + ")' >Live Sync" +
        "</a>" +
        "</div>";

    return tableFilterButton;
}
function LiveSync(tableId) {

    var url = "LiveImgSync";
    $.ajax({
        type: "POST",
        url: url,
        data: { data: 'sync' }, // serializes the form's elements.
        success: function (data) {
            // alert(data);
            $('#'.tableId).DataTable().ajax.reload();

        }
    });
}
function downloadXML(tableId, pId) {

    var url = "DownloadXML";

    $.ajax({
        type: "POST",
        url: url,

        data: { data: checkVal12 }, // serializes the form's elements.
        success: function (data) {
            window.location = 'DownloadXML';
        }
    });
}
// this function is used to Live Sync Report 
function tableLiveReportSyncButton(tableId, placeholderId, DesignType, OldDesignBtnTitle, NewDesignBtnTitle, NameOrgBtn, NameLastBtn, EnableLastSearchDF) {

    // var tableFilterButton = "<div class='btn-group pull-left table_action_buttons ' >" +
    //     "<a class='btn deepPink-bgcolor  btn-outline' onclick='LiveAPISyncReport(\"create\" , "+ placeholderId +")' >Get Data " +
    //     "</a>" +
    //     "</div>";

    if (NameOrgBtn == '') {
        NameOrgBtn = 'Original selection';
    }
    if (NameLastBtn == '') {
        NameLastBtn = 'Make selection';
    }

    // var tableFilterButton = "<div class='btn-group pull-left table_action_buttons' >" +
    var tableFilterButton = "<div class='btn-group table_action_buttons' >" +
        "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Get Data" +
        "<i class='fa fa-angle-down'></i>" +
        "</a>" +
        "<ul class='dropdown-menu pull-right'>";


    if (DesignType == '1') {
        if (EnableLastSearchDF == '2' || EnableLastSearchDF == '12') {
            tableFilterButton = tableFilterButton +
                "<li><a class='ImportReporttoCSV'  onclick='LiveAPISyncReport(\"create\" , " + placeholderId + " , \"1\" , \"0\" )'>" + NameOrgBtn + "</a></li>";
        }
        if (EnableLastSearchDF == '1' || EnableLastSearchDF == '' || EnableLastSearchDF == '12') {
            tableFilterButton = tableFilterButton +
                "<li><a class='ExportReporttoCSV'  onclick='LiveAPISyncReport(\"create\" , " + placeholderId + " , \"1\" , \"1\")'>" + NameLastBtn + " </a></li>";
        }

    } else if (DesignType == '2') {
        if (EnableLastSearchDF == '2' || EnableLastSearchDF == '12') {
            tableFilterButton = tableFilterButton +
                "<li><a class='ExportReporttoCSV'  onclick='LiveAPISyncReport(\"create\" , " + placeholderId + " , \"2\", \"1\")'>" + NameOrgBtn + " </a></li>";
        }
        if (EnableLastSearchDF == '1' || EnableLastSearchDF == '' || EnableLastSearchDF == '12') {
            tableFilterButton = tableFilterButton +
                "<li><a class='ExportReporttoCSV' onclick='LiveAPISyncReport(\"create\" , " + placeholderId + " , \"2\" , \"1\")'>" + NameLastBtn + " </a></li>";
        }

    } else if (DesignType == '1,2') {
        tableFilterButton = tableFilterButton +
            "<li><a class='ImportReporttoCSV'  onclick='LiveAPISyncReport(\"create\" , " + placeholderId + " , \"1\" , \"0\")'>Old Design </a></li>" +
            "<li><a class='ExportReporttoCSV'  onclick='LiveAPISyncReport(\"create\" , " + placeholderId + ", \"2\" , \"1\")'>New Design </a></li>";

    }


    tableFilterButton = tableFilterButton + "</ul>" +
        "</div>";

    return tableFilterButton;
}
// Not Used
function LiveSyncReport(tableId) {
    //console.log(tableId);
    var url = "LiveReportSync";
    $.ajax({
        type: "POST",
        url: url,
        data: { PID: tableId }, // serializes the form's elements.
        success: function (data) {
            alert("request has been Sent ");

        }
    });
}
// this function helps to open the form for products
function LiveAPISyncReport(op, pId, DesignId, LastSearch, ActionButonURL, ActionBTN, columnName, columnValue) {
    dt = '';
    if (op == 'edit') {
        dt = checkVal12;
    }
    var url = "AddPayment";
    $.ajax({
        type: "POST",
        url: url,
        data: { action: op, placeholderId: pId, data: dt, DID: DesignId, LSearch: LastSearch, actionButon: ActionButonURL, actionBTN: ActionBTN, columnNames: columnName, columnValues: columnValue }, // serializes the form's elements.
        success: function (data) {
            //console.log(data);
            $('.modal-body').html(data);

            // Display Modal
            $('#empModal').modal('show');
            //$.fancybox(data);


        }
    });
}

// this function helps to open the form for products
function SaveFilterData(tableId, Href) {
    window.location = Href;
    // var table1_ = $('#'+tableId).DataTable();
    // var Maindata = table1_.rows( { search: 'applied' }).data();

    // var tempArr = [];
    // for (let index = 0; index < Maindata.length ; index++) {
    //    tempArr.push(Maindata[index][0]);
    // }
    // if (tempArr === undefined || tempArr.length == 0) {
    //    tempArr='';
    // }
    // console.log(tempArr);
    // var url = "SaveFilterSession";
    // $.ajax({
    //     type: "POST",
    //     url: url,
    //     timeout: 1000000000,
    //     data :{data:tempArr},
    //     success: function(response)
    //     {
    //         window.location = Href;

    //     }
    //  });

}