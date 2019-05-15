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

    $(".resizeble-font").each(function ()
    {
      var $numWords = $(this).text().length;
    
      if (($numWords >= 1) && ($numWords < 10)) {
        $(this).css("font-size", "2em");
      }
      else if (($numWords >= 10) && ($numWords < 20)) {
        $(this).css("font-size", "2em");
      }
      else if (($numWords >= 20) && ($numWords < 30)) {
        $(this).css("font-size", "1.7em");
      }
      else if (($numWords >= 30) && ($numWords < 40)) {
        $(this).css("font-size", "1.4em");
      }
      else {
        $(this).css("font-size", "1.2em");
      }  

    });

    
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


