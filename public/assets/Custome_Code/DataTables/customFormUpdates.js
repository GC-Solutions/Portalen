function SaveFilterInternal( plId , uid, pT, pN){

    var url = "SaveFilter";
    table1 = $('#'+pN).DataTable();
    var newArr = [];
    for (var i = 0; i < table1.columns().count(); i++) {
       newArr.push(table1.column(i).search());
    }
    $.ajax({
            type: "POST",
            url: url,
            data: { placeholderId:plId , userId:uid , pageName:pT , holderValue:pN , value:newArr}, // serializes the form's elements.
            success: function(data)
            {
               // alert("Searched Values has been Saved ");
                console.log(data);
                
                
            }
            });
}
function getUpdatePredefined(paramValue){

    if (paramValue != null) {
     // console.log(JSON.stringify(table));
       // alert("getUpdatePredefined for param: " +JSON.stringify(paramValue));
       console.log("getUpdatePredefined started");
        var url = "updatePredefined";
        const inputString = paramValue['curLoc'];
        const dataSourceIdParam = paramValue['dataSourceId'];
       // alert(dataSourceIdParam);
if(dataSourceIdParam==="1796"||dataSourceIdParam==="1763"||dataSourceIdParam==="1701") {

    table = $('#'+'Table_1').DataTable();
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
SaveFilterInternal(id,"0",pageText,"Table_1");

 // Your specific value to search for in the "Ordernr" column
 var orderNostring = paramValue['orderNoValue'];

 // Split the string by "||" to create an array of values
 
// Split the string by the "|" delimiter
var values = orderNostring.split('||');
var i = 0;
for (var value of values) {

    if(i>0) {
        if(values.length>1) {
            if(values[i-1] === values[i]) {
            break;
            }
        }
    }
    if(value.length<6) {
        console.log("Order number to short, no update will be done for this order: "+value);
            if(i===0) {
                var tempOrder = paramValue['orderNoValue'];
                var substringToReplace = value;
                // Use the replace method to replace "220894||" with an empty string
                paramValue['orderNoValue'] = tempOrder.split(substringToReplace + "||").join("");

            } 
            else if((i+1)===values.length){
                var tempOrder = paramValue['orderNoValue'];
                var substringToReplace = value;
                // Use the replace method to replace "220894||" with an empty string
                paramValue['orderNoValue'] = tempOrder.split("||"+substringToReplace).join("");

            }
            else {
                var tempOrder = paramValue['orderNoValue'];
                var substringToReplace = value;
                // Use the replace method to replace "220894||" with an empty string
                paramValue['orderNoValue'] = tempOrder.split(substringToReplace + "||").join("");
            }

            i++;
        break;
    }
    i++;
   // alert(value);
// Get the first value (at index 0)
var orderNo = value;
// Define the target orderNo and new PL value
var targetOrderNo = orderNo; // Replace with the orderNo you're searching for
var newPLValue;

var columnIndex = table.column(':contains("PL")').index();

if (columnIndex !== -1) {
  // Find the row with the specified 'orderNo' value in the 'orderNo' column
  var rowToUpdate = table.rows().eq(0).filter(function (rowIdx) {
    return table.cell(rowIdx, table.column(':contains("Ordernr")').index()).data() === orderNo;
  });

}
if(dataSourceIdParam==="1763"||dataSourceIdParam==="1701") {
    newPLValue = 3;
    if (rowToUpdate.length > 0) {
       var rowIndex = rowToUpdate[0];
       console.log(rowIndex);
   table.cell(rowIndex, columnIndex).data(newPLValue);
  table.draw();
   }


}
else if(dataSourceIdParam==="1796") {
    newPLValue = 2;
   if (rowToUpdate.length > 0) {
       var rowIndex = rowToUpdate[0];
        console.log(rowIndex);
    table.cell(rowIndex, columnIndex).data(newPLValue);
    table.draw();
}
    
}


}

}

$.ajax({
    type: "POST",
    url: url,
    data: {
        "params": paramValue
    }, 
    success: function(data)
    {
 
       // alert("hello");
        console.log("getPredefined completed successfully.");
        return false;

    }
    });

    }
    
}

// update predefined data Redis
function getUpdatePredefinedRedis(TableId){
    
    var url = "generateTable";
    if(url!=null) {

        $.ajax({
            type: "POST",
            url: url,
            data: {
                "placeholderId": TableId , 
                "DeleteRedis" : 1
            }}).done(function (data) {
                console.log("getPredefinedRedis completed successfully.");
            
                return false;
            })
            .fail(function (data) {
             
              console.log("getPredefinedRedis failed: "+data);
                return false;
            });
    }

    
}
// update dataSource Call
function getUpdateDataSourceCall(paramValue){
    if (paramValue != null) {
        console.log("getUpdateDataSourceCall Started.");
    
        var url = "updateDataSourceCall";

        var orderNostring = paramValue['orderNoValue'];
        var values = orderNostring.split('||');
        var i = 0;

        for (var value of values) {

            if(i>0) {
                if(values.length>1) {
                    if(values[i-1] === values[i]) {
                    break;
                    }
                }
            }
            if(value.length<6) {
                console.log("Order number to short, no update will be done for this order: "+value);
                    if(i===0) {
                        var tempOrder = paramValue['orderNoValue'];
                        var substringToReplace = value;
                        // Use the replace method to replace "220894||" with an empty string
                        paramValue['orderNoValue'] = tempOrder.split(substringToReplace + "||").join("");
        
                    } 
                    else if((i+1)===values.length){
                        var tempOrder = paramValue['orderNoValue'];
                        var substringToReplace = value;
                        // Use the replace method to replace "220894||" with an empty string
                        paramValue['orderNoValue'] = tempOrder.split("||"+substringToReplace).join("");
        
                    }
                    else {
                        var tempOrder = paramValue['orderNoValue'];
                        var substringToReplace = value;
                        // Use the replace method to replace "220894||" with an empty string
                        paramValue['orderNoValue'] = tempOrder.split(substringToReplace + "||").join("");
                    }
        
                    i++;               
            }
         
        
        }
        var orderNostringCheck = paramValue['orderNoValue'];
        var valuesCheck = orderNostringCheck.split('||');
      if(valuesCheck.length>0) {
        $.ajax({
            url: url,
            data: {
                "params": paramValue
            },
            type: 'POST',
            async: true
        }).done(function (data) {
                //var resonseObj = $.parseJSON(data);
                // if(resonseObj.status == true) {
                //      alert('hello');
                //  }
                console.log("getUpdateDataSourceCall completed successfully.");
            })
            .fail(function (data) {
                console.log("getUpdateDataSourceCall failed: "+data);
                return false;
            });
       }

    }
    
}