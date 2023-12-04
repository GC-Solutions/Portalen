//Index
//(1) this Function dd the columnin thead of the table as its being placed as the first thing in table before filters . as you can see the append function it adds the column in thead tr .


//--------------------------------(1)-------------------------------------
function getColumnName(tHead , columnTitle , columnDb , Table_ID ){
  
    if(tHead){
        $.each(columnTitle, function (i, title) {
            var titleValue = title.trim() +'/'+columnDb[i].trim();
            $("#"+ Table_ID +"_thead tr").append("<th data-dbcolumn="+columnDb[i].trim()+" id = '"+title.trim()+"'>" + '<span class="filter-datatable-label">'+title.trim() +'</span>'+ "</th>");
        });
    }else{
        $.each(columnTitle, function (i, title) {
            var titleValue = title.trim() +'/'+columnDb[i].trim();
            $("#" + Table_ID + " thead tr").append("<th data-dbcolumn="+columnDb[i].trim()+" id = '"+title.trim()+"'>" + '<span class="filter-datatable-label">'+title.trim() +'</span>'+ "</th>");
        });

    }
}