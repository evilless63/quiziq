// $(document).ready(function(){
//     $(document).scrollTop($('body').height());
//             $('html, body').animate({scrollTop: 0},10000);
//             return false;

// });

$(document).ready(function() {

    $(document).scrollTop($('body').height());

    $("tr[tabindex=0]").focus();   
    $("tr[tabindex=0]").addClass("tr_hover"); 
    document.onkeydown = checkKey;
});

function checkKey(e) {
    var event = window.event ? window.event : e;
    if(event.keyCode == 38){ //down
      var idx = $("tr:focus").attr("tabindex");
      idx++;
    //   if(idx > 6){
    //     idx = 0;
    //   }
      $("tr[tabindex="+idx+"]").focus();
      $("tr").removeClass("tr_hover");
      $("tr[tabindex="+idx+"]").addClass("tr_hover");
    }
    if(event.keyCode == 40){ //up
      var idx = $("tr:focus").attr("tabindex");
      idx--;
    //   if(idx < 0){
    //     idx = 6;
    //   }
      $("tr[tabindex="+idx+"]").focus();  
      $("tr").removeClass("tr_hover");
      $("tr[tabindex="+idx+"]").addClass("tr_hover");    
    }
}


