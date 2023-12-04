$(document).ready(function () {

    let nav = document.querySelector(".table-scrollable");
    //let navNew =  document.getElementsByClassName("table-scrollable");
    let left = document.querySelector(".arrow-container .left");
    let right = document.querySelector(".arrow-container .right");
    // let leftNew =  document.getElementsByClassName("left");
    // let rightNew =  document.getElementsByClassName("right");

    let idx;
    if(nav){
        //for(var i = 0; i < navNew.length; i++){
           
            // nav = navNew[i];
            // left = leftNew[i];
            // right =rightNew[i];
            
            left.addEventListener("mouseenter", function(){
                idx = setInterval(() => nav.scrollLeft -= 3, 10);
            });

            left.addEventListener("mouseleave", function(){
                clearInterval(idx);
            });

            right.addEventListener("mouseenter", function(){
                idx = setInterval(() => nav.scrollLeft += 3, 10);
            });

            right.addEventListener("mouseleave", function(){
                clearInterval(idx);
            });
            
        //}
    }
    
    $('.card-box').bind('DOMNodeInserted DOMSubtreeModified DOMNodeRemoved', function(event) {
        this.style.display='block';
        if(this.style.display != 'block')
        {
            console.log(this);
        }
        
    });

    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });

    
    
    // $('a.mdl-tabs__tab').on("click",  function (event) {
    //     var ID  = $(this).attr('id');
    //     ID = ID.split('Tab_').join('');
        
    //     $(".ToolsDiv > *").css('display','none');
    //     $("#Btn_"+ID).css('display','block');

    // });
  
    $('body').on("change", ".UserCompanyName", function () {
        var selectedDataSource = '';
        $('.UserCompanyName option:selected').each(function() {
            if(selectedDataSource == '')
            {
                selectedDataSource = $(this).val();
            }
        });
        
        if (selectedDataSource.trim() != '') {
            var url = baseUrl + 'getCompanyUser'
            $.ajax({
                url: url,
                data: {dataSourceId: selectedDataSource  },
                type: 'POST'
            }).done(function (data) {
                    SetDropDownToEmpty('UserColumns');
                    var resonseObj = $.parseJSON(data);
                    if ((resonseObj.data).trim() != '') {
                        var columnsString = (resonseObj.data).toString();
                        var columnsList = columnsString.split(",");
                        $.each(columnsList, function (index, value) {
                            $(".UserColumns").append('<option value="' + (value).trim() + '">' + (value).trim() + '</option>');
                        });
                    } else {
                        SetDropDownToEmpty('UserColumns');
                    }
                })
                .fail(function (data) {
                    SetDropDownToEmpty('UserColumns');
                });
        } else {
            SetDropDownToEmpty('UserColumns');
        }
        return false;
    });

    $('body').on("change", ".DataSourceId", function () {
        var selectedDataSource = '';
        $('.DataSourceId option:selected').each(function() {
            if(selectedDataSource == '')
            {
                selectedDataSource = $(this).val();
            }else
            {
                selectedDataSource = selectedDataSource+','+$(this).val();
            }
        });
        
        // if(selectedDataSource.constructor === Array )
        // {
        //     selectedDataSource = selectedDataSource['0'];
        // }
        var tab = $('.TableType').val();

        if (selectedDataSource.trim() != '') {
            var url = baseUrl + 'getDataSourceColumns'
            $.ajax({
                url: url,
                data: {dataSourceId: selectedDataSource , TableType : tab },
                type: 'POST'
            }).done(function (data) {
                    SetDropDownToEmpty('dataSourceColumns');
                    var resonseObj = $.parseJSON(data);
                    if ((resonseObj.data).trim() != '') {
                        var columnsString = (resonseObj.data).toString();
                        var columnsList = columnsString.split(",");
                        $.each(columnsList, function (index, value) {
                            $(".dataSourceColumns").append('<option value="' + (value).trim() + '">' + (value).trim() + '</option>');
                        });
                    } else {
                        SetDropDownToEmpty('dataSourceColumns');
                    }
                })
                .fail(function (data) {
                    SetDropDownToEmpty('dataSourceColumns');
                });
        } else {
            SetDropDownToEmpty('dataSourceColumns');
        }
        return false;
    });

    $('body').on("change", ".DataTableId", function () {
        var selectedDataTable = jQuery(this).val();

        if(selectedDataTable.constructor === Array )
        {
            selectedDataTable = selectedDataTable['0'];
        }
        if (selectedDataTable.trim() != '') {
            var url = baseUrl + 'getDataTableColumns'
            $.ajax({
                url: url,
                data: {dataTableId: selectedDataTable},
                type: 'POST'
            }).done(function (data) {
                    SetDropDownToEmpty('dataTableColumns');
                    var resonseObj = $.parseJSON(data);
                    if ((resonseObj.data).trim() != '') {
                        var columnsString = (resonseObj.data).toString();
                        var columnsList = columnsString.split(",");
                       
                        $.each(columnsList, function (index, value) {
                            $(".dataTableColumns").append('<option value="' + (value).trim() + '">' + (value).trim() + '</option>');
                        });
                    } else {
                        SetDropDownToEmpty('dataTableColumns');
                    }
                })
                .fail(function (data) {
                    SetDropDownToEmpty('dataTableColumns');
                });
        } else {
            SetDropDownToEmpty('dataTableColumns');
        }
        return false;
    });

    $('body').on("change", ".DataSourceIdTableAction", function () {
        var selectedDataSource = jQuery(this).val();
         if(selectedDataSource.constructor === Array )
        {
            selectedDataSource = selectedDataSource['0'];
        }
        if (selectedDataSource.trim() != '') {
            SetDropDownToEmpty('TableTemplateId');
            SetDropDownToEmpty('TableParameterColumn');
            populateDataSourceTableTemplates(selectedDataSource);
        } else {
            SetDropDownToEmpty('TableTemplateId');
            SetDropDownToEmpty('TableParameterColumn');
        }
    });

    $('body').on("change", ".DataSourceIdPanelAction", function () {
        var selectedDataSource = jQuery(this).val();

         if(selectedDataSource.constructor === Array )
        {
            selectedDataSource = selectedDataSource['0'];
        }
        if (selectedDataSource.trim() != '') {
            SetDropDownToEmpty('PanelTemplateId');
            SetDropDownToEmpty('PanelParameterColumn');
            populateDataSourcePanelTemplates(selectedDataSource);
        } else {
            SetDropDownToEmpty('PanelTemplateId');
            SetDropDownToEmpty('PanelParameterColumn');
        }
    });
    $('body').on("click", ".LoadForm", function () {
        var formLink = $(this).attr('data-href');
        $.fancybox({
            width: 600,
            autoSize: false,
            href: formLink,
            type: 'ajax'
        });
    });


    $('body').on("change", ".TableTemplateId", function () {
        SetDropDownToEmpty('TableParameterColumn');
        var optionSelected = $(this).find('option:selected').attr('data');
        if (optionSelected != null || optionSelected.length !== 0) {
            var columnsString = (optionSelected).toString();
            var columnsList = columnsString.split(",");
            $.each(columnsList, function (index, value) {
                $(".TableParameterColumn").append('<option value="' + (value).trim() + '">' + (value).trim() + '</option>');
            });
        }
        return false;
    });

    $('body').on("change", ".PanelTemplateId", function () {
        SetDropDownToEmpty('PanelParameterColumn');
        var optionSelected = $(this).find('option:selected').attr('data');
        if (optionSelected != null || optionSelected.length !== 0) {
            var columnsString = (optionSelected).toString();
            var columnsList = columnsString.split(",");
            $.each(columnsList, function (index, value) {
                $(".PanelParameterColumn").append('<option value="' + (value).trim() + '">' + (value).trim() + '</option>');
            });
        }
        return false;
    });

    $('body').on("change", ".dataSourceColumns", function () {
        jQuery(".dataSourceColumns").each(function(){
            $this = jQuery(this);
            if($this.attr('data-reorder')){
                $this.on('select2:select', function(e){
                    var elm = e.params.data.element;
                    $elm = jQuery(elm);
                    $t = jQuery(this);
                    $t.append($elm);
                    $t.trigger('change.select2');
                });
            }
            $this.select2();
        });
    });
});

function populateDataSourcePanelTemplates(selectedDataSource) {
    var url = baseUrl + 'getDataSourcePanelTemplates'
    $.ajax({
        url: url,
        data: {dataSourceId: selectedDataSource},
        type: 'POST'
    }).done(function (data) {
            SetDropDownToEmpty('PanelTemplateId');
            SetDropDownToEmpty('PanelParameterColumn');
            var resonseObj = $.parseJSON(data);
            if ((resonseObj.data).trim() != '') {
                var panelsString = (resonseObj.data).toString();
                var getPanelsData = panelsString.split("_###_");
                $.each(getPanelsData, function (index, value) {
                    if (value.trim() != '') {
                        var getPanelData = value.split("_##_");
                        $(".PanelTemplateId").append('<option data="' + (getPanelData[2]).trim() + '" value="' + (getPanelData[0]).trim() + '">' + (getPanelData[1]).trim() + '</option>');
                    }
                });
            } else {
                SetDropDownToEmpty('PanelTemplateId');
                SetDropDownToEmpty('PanelParameterColumn');
            }
        })
        .fail(function (data) {
            SetDropDownToEmpty('PanelTemplateId');
            SetDropDownToEmpty('PanelParameterColumn');
        });
}

function populateDataSourceTableTemplates(selectedDataSource) {
    var url = baseUrl + 'getDataSourceTableTemplates'
    $.ajax({
        url: url,
        data: {dataSourceId: selectedDataSource},
        type: 'POST'
    }).done(function (data) {
            SetDropDownToEmpty('TableTemplateId');
            SetDropDownToEmpty('dataSourceColumns');
            var resonseObj = $.parseJSON(data);
            if ((resonseObj.data).trim() != '') {
                var tablesString = (resonseObj.data).toString();
                var getTablesData = tablesString.split("_###_");
                $.each(getTablesData, function (index, value) {
                    if (value.trim() != '') {
                        var getTablesData = value.split("_##_");
                        $(".TableTemplateId").append('<option data="' + (getTablesData[2]).trim() + '" value="' + (getTablesData[0]).trim() + '">' + (getTablesData[1]).trim() + '</option>');
                    }
                });
            } else {
                SetDropDownToEmpty('TableTemplateId');
                SetDropDownToEmpty('TableParameterColumn');
            }
        })
        .fail(function (data) {
            SetDropDownToEmpty('TableTemplateId');
            SetDropDownToEmpty('TableParameterColumn');
        });
}


var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
        if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }

            if (!blnValid) {
                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}

function SetDropDownToEmpty(className) {
    $('.' + className).find('option').remove().end().append('<option value="">Select</option>');
}




