// update predefined data 
function getUpdatePredefined(paramValue){
    if (paramValue != null) {
       
        var url = "updatePredefined";
        // $.ajax({
        //     url: url,
        //     data: {
        //         "params": paramValue
        //     },
        //     type: 'POST',
        //     async: true
        // }).done(function (data) {
        //         var resonseObj = $.parseJSON(data);
        //         window.location.href = resonseObj.url;
        //     })
        //     .fail(function (data) {
        //         alert(data);
        //         return false;
        //     });
        $.ajax({
            type: "POST",
            url: url,
            data: {
                "params": paramValue
            }, // serializes the form's elements.
            success: function(data)
            {
                //window.location.href = data.url;
                alert("hello");
                console.log(data);
                return false;
                // console.log("Success");
                // location.reload();
                // return false;
            }
            });

    }
}
// update predefined data Redis
function getUpdatePredefinedRedis(TableId){
     
        var url = "generateTable";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                "placeholderId": TableId , 
                "DeleteRedis" : 1
            }}).done(function (data) {
                
                alert(data);
                return false;
            })
            .fail(function (data) {
                alert("hello");
                console.log(data);
                return false;
            });

    
}
// update dataSource Call
function getUpdateDataSourceCall(paramValue){
    if (paramValue != null) {
       
        var url = "updateDataSourceCall";
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
            })
            .fail(function (data) {
                alert(data);
                return false;
            });

    }
}