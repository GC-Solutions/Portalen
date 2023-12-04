function SliderDesign2Call(path){
  fetch(path)
  .then(response => response.json())

  .then(function(data) {
      path = path.replace("generateTable", "getTableColumns");
      
      fetch(path)
      .then(response => response.json())
  
      .then(function(data1) {
          silderDesign1(data ,data1 );
      })
      .catch(error => console.log('error', error));
    
  })
  .catch(error => console.log('error', error));
}
  function silderDesign1(data , ColNames) {
   
    $(".side-bar").show();
    var totalCnt = ColNames.columnTitle.length;

    var mainContainer = document.getElementById("side-bar-box");  
   // var mainContainer = document.getElementById("mySidenav"); 
    mainContainer.innerHTML = '';
    $.each(data.data, function (key, value) {

        var sideBar1 = document.createElement("div");
        sideBar1.className = "row side-box-style";
        var ActionUrl = ``;
      
        var innerData = '';  
        $.each(value, function (k, v) {
          if(k < totalCnt){
            innerData += `<div class="side-bar-list"><p class="side-bar-start">`+ColNames.columnTitle[k]+` :</p><p class="side-bar-value notDelivered"> `+v+`</p></div><br>`;
 
          }else{

            if(v.includes("/public/page") !== false){
              v = v.split('/public/page');
              v=  '/public/page' +v[1];
              v = v.slice(0, -1);

              ActionUrl = ` <div class="side-bar-list"><a href= "`+v+`"><i class=" fas fa-info-circle side-bar-1-i"></i></a></div>`;
            
        
            }
          }
        });
       

     
        innerData = innerData+ActionUrl;
        sideBar1.innerHTML = innerData;
        //document.getElementById("side-bar-box").insertAdjacentHTML("afterbegin", innerData);
        mainContainer.appendChild(sideBar1);
      
    });

  }

  //Side bar nav funktion 

  var sideBarBtn = document.getElementsByClassName("side-bar-btn");
  var navClose = document.getElementsByClassName("nav-close");

  function toggleNav(path , silderDesign, path2) {
   console.log(path2);
    //Fetch Data from here for Tab 1 

    var dataTab= {};
    var dataTabCOl= {};
     // Tab 2 
     if(path2 !== undefined){
      fetch(path2)
      .then(response => response.json())
      .then(function(dataTab) {
          path2 = path2.replace("generateTable", "getTableColumns");
          console.log(path2);
          fetch(path2)
          .then(response => response.json())
      
          .then(function(dataTabCOl) {
            fetch(path)
            .then(response => response.json())
        
            .then(function(data) {
                path = path.replace("generateTable", "getTableColumns");
                
                fetch(path)
                .then(response => response.json())
            
                .then(function(data1) {
                  console.log(dataTab);
                   
                    silderDesign2(data ,data1 , dataTab  , dataTabCOl );
                    
                   
                })
                .catch(error => console.log('error', error));
              
            })
            .catch(error => console.log('error', error));
          })
          .catch(error => console.log('error', error));
        
      })
      .catch(error => console.log('error', error));
    }else{
      fetch(path)
      .then(response => response.json())
  
      .then(function(data) {
          path = path.replace("generateTable", "getTableColumns");
          
          fetch(path)
          .then(response => response.json())
      
          .then(function(data1) {
          
              silderDesign2(data ,data1  );
   
          })
          .catch(error => console.log('error', error));
        
      })
      .catch(error => console.log('error', error));
    }
   console.log("hello");
    document.body.classList.toggle("nav-open");
   }



  function silderDesign2(data , ColNames , dataTab2 , dataTabCol) {
   
    var totalCnt = ColNames.columnTitle.length;

    var mainContainer = document.getElementById("mySidenav");

    if($(".sideBar2").length != 0) {
        $('.sideBar2').remove();
    }

   
    var sideBar2 = document.createElement("div");
    sideBar2.Id = "sideBar2"; 
    sideBar2.className = "sideBar2"; 
    var innerDataStart= `  <div class="tab-wrapper">
          <div class="tabs"><div class="tab">
          <input type="radio" name="css-tabs" id="tab-1" checked class="tab-switch"></input>
          <label for="tab-1" class="tab-label">Tab One</label>
          <div class="tab-content">
   `;
   // Tab 1 Code 
   var innerDataMain = ``;
    $.each(data.data, function (key, value) {

        var ActionUrl = ``;
        var innerDataStart1 = '<ul class="sideBarUl"><li class="top-li"></li>';  
        var innerData = ``;
        $.each(value, function (k, v) {
          if(k < totalCnt){
            innerData += `<li>`+ColNames.columnTitle[k]+`                        `+v+`</li>`;
          }else{

            if(v.includes("/public/page") !== false){
              v = v.split('/public/page');
              v=  '/public/page' +v[1];
              v = v.slice(0, -1);
              ActionUrl = `<a href= "`+v+`"><i class=" fas fa-info-circle side-bar-2-i"></i></a> <li class="top-li"></li>`;
            }
          }
        });
       
        innerData +=  `</ul>`; 
        console.log(ActionUrl);
        innerDataMain += innerDataStart1+ActionUrl+innerData;
        //sideBar2.innerHTML = innerData;
        //mainContainer.appendChild(sideBar2);
    });
    innerDataStart +=innerDataMain + ` </div>
    </div><div class="tab">
    <input type="radio" name="css-tabs" id="tab-2" class="tab-switch">
      <label for="tab-2" class="tab-label">Tab Two</label>
      <div class="tab-content">  `;
  
      var innerDataMain = ``;
      if(dataTab2){
          var totalCnt = dataTabCol.columnTitle.length;
          var innerDataStart1 = '';
          $.each(dataTab2.data, function (key1, value1) {
      
              var ActionUrl = '';
              innerDataStart1 = '<ul class="sideBarUl">';  
              var innerData = '';
              $.each(value1, function (k1, v1) {
                if(k1 < totalCnt){
                  innerData += `<li>`+dataTabCol.columnTitle[k1]+`                        `+v1+`</li>`;
                }else{
      
                  if(v1.includes("/public/page") !== false){
                    v1 = v1.split('/public/page');
                    v1=  '/public/page' +v1[1];
                    v1 = v1.slice(0, -1);
                    ActionUrl = `<a href= "`+v1+`"><i class=" fas fa-info-circle side-bar-2-i"></i></a> <li class="top-li"></li>`;
                  }
                }
              });
            
              innerData +=  `</ul>`; 
              console.log(ActionUrl);
              innerDataMain += innerDataStart1+ActionUrl+innerData;
          });
      }

    innerDataStart +=innerDataMain + `   </div>
      </div>
    </div>
    </div>`;

      sideBar2.innerHTML = innerDataStart;
      mainContainer.appendChild(sideBar2);


   

    // document.getElementById("side-bar-2").insertAdjacentHTML("afterbegin", sideBar2);
  }

 

