//Index 
// (1) This function Add the Filters and you can see that its has its own custom Divs in it on which the filters are change when slected from Filter menu .
//This function set the predefined  serach set at the admin side .
//This function is Also includeed on thead as it appeneded after the column Name 


//-----------------------------------(1)-----------------------------------------------------
function generateFilter(val , title , searchValue ,  predefineSearch , predefineSearchForRange , Table_ID , titleId , i , titleDbColumn)
{
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
        val = ('<div id="mainDiv"><div class="input-group" id ="mainS_'+Table_ID+titleId +'"><input  style="padding-right: 16px;" id ="test" name="test" type="text" '+inpputValue+' class="form-control form-control-sm search_by" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="Search ' + '" value="'+ defValue +'" /><span class="close-icon">x</span></div><div class="input-group" id ="fromTo_'+Table_ID+titleId +'" style="display:none" ><div style="width: 100px;"><input id ="'+Table_ID+"_"+titleId +'fromRange" value="" type="text" '+inpputValue+' style="width: 50px; height: 37px;" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="from" /><input id ="'+Table_ID+"_"+titleId +'toRange" type="text" '+inpputValue+' style="width: 50px; height: 37px;" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="To" /></div><span class="close-icon">x</span></div><div class="input-group" id = "exc_div'+Table_ID+titleId+'" style="display: none;"  ><input  id = "exc_'+Table_ID+titleId +'"  type="text" '+inpputValue+' class="form-control form-control-sm search_by exc" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder=" Exclude ' + title[0] + '"/><span class="close-icon">x</span></div><div id ="searchDiv_'+Table_ID+titleId +'" style = "display:none; position: relative;"><span class="close-icon-select">x</span></div></div>');
    }else if(predefineSearchForRange != undefined && predefineSearchForRange[i] != null){
        var defValueFrom = predefineSearchForRange[i].from;
        var defValueTo = predefineSearchForRange[i].to;
        val =('<div id="mainDiv"><div class="input-group" id ="mainS_'+Table_ID+titleId +'"><input  style="padding-right: 16px;" id ="test" name="test" type="text" '+inpputValue+' class="form-control form-control-sm search_by" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="Search ' + '" value="'+ defValue +'" /><span class="close-icon">x</span></div><div class="input-group" id ="fromTo_'+Table_ID+titleId +'" style="display:none" ><div style="width: 100px;"><input id ="'+Table_ID+"_"+titleId +'fromRange" value="'+defValueFrom+'" type="text" '+inpputValue+' style="width: 50px; height: 37px;" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="from" /><input id ="'+Table_ID+"_"+titleId +'toRange"  value="'+defValueTo+'" type="text" '+inpputValue+' style="width: 50px; height: 37px;" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="To" /></div><span class="close-icon">x</span></div><div class="input-group" id = "exc_div'+Table_ID+titleId+'" style="display: none;"  ><input  id = "exc_'+Table_ID+titleId +'"  type="text" '+inpputValue+' class="form-control form-control-sm search_by exc" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder=" Exclude ' + title[0] + '"/><span class="close-icon">x</span></div><div id ="searchDiv_'+Table_ID+titleId +'" style = "display:none; position: relative;"><span class="close-icon-select">x</span></div></div>');
    
    }
    else{
        val = ( '<div id="mainDiv"><div class="input-group" id ="mainS_'+Table_ID+titleId +'"><input  style="padding-right: 16px;" id ="test" name="test" type="text" '+inpputValue+' class="form-control form-control-sm search_by" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="Search ' + '" value="" /><span class="close-icon">x</span></div><div class="input-group" id ="fromTo_'+Table_ID+titleId +'" style="display:none" ><div style="width: 100px;"><input id ="'+Table_ID+"_"+titleId +'fromRange" value="" type="text" '+inpputValue+' style="width: 50px; height: 37px;" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="from" /><input id ="'+Table_ID+"_"+titleId +'toRange" type="text" '+inpputValue+' style="width: 50px; height: 37px;" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder="To" /></div><span class="close-icon">x</span></div><div class="input-group" id = "exc_div'+Table_ID+titleId+'" style="display: none;"  ><input  id = "exc_'+Table_ID+titleId +'"  type="text" '+inpputValue+' class="form-control form-control-sm search_by exc" data-placeholderId="' + placeholderId + '" data-columnName="' + titleDbColumn + '" placeholder=" Exclude ' + title[0] + '"/><span class="close-icon">x</span></div><div id ="searchDiv_'+Table_ID+titleId +'" style = "display:none; position: relative;"><span class="close-icon-select">x</span></div></div>');
    }
    return  val ;
    console.log(val);
}