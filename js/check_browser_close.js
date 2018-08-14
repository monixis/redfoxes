/**
 * This javascript file checks for the brower/browser tab action.
 * It is based on the file menstioned by Daniel Melo.
 * Reference: http://stackoverflow.com/questions/1921941/close-kill-the-session-when-the-browser-or-tab-is-closed
 */
var validNavigation = false;

function wireUpEvents() {
  /**
   * For a list of events that triggers onbeforeunload on IE
   * check http://msdn.microsoft.com/en-us/library/ms536907(VS.85).aspx
   *
   * onbeforeunload for IE and chrome
   * check http://stackoverflow.com/questions/1802930/setting-onbeforeunload-on-body-element-in-chrome-and-ie-using-jquery
   */

  window.onbeforeunload = function() {
       if (!validNavigation) {
          endSession();
       }
   }

     function endSession() {
         $.ajax({
             url : "https://login.marist.edu/cas/logout",
             type : "GET",
             async: false,
             success : function(response) {},
             error: function(response) {}
           });
         }

  // Attach the event keypress to exclude the F5 refresh
  $(document).bind('keydown', function(e) {
    if (e.keyCode == 116){
      validNavigation = true;
    }
  });

  // Attach the event click for all links in the page
  $("a").bind("click", function() {
    validNavigation = true;
  });

  // Attach the event submit for all forms in the page
  $("form").bind("submit", function() {
    validNavigation = true;
  });

  // Attach the event click for all inputs in the page
  $("input[type=submit]").bind("click", function() {
    validNavigation = true;
  });

}



// Wire up the events as soon as the DOM tree is ready
$(document).ready(function() {
  window.onload = function CallbackFunction(event) {

      if(window.event){

                if (window.event.clientX < 40 && window.event.clientY < 0) {

                   validNavigation = true;


                }else{

                    validNavigation = true;
                }

      }else{

          if (event.currentTarget.performance.navigation.type == 2) {

             validNavigation = true;

          }
          if (event.currentTarget.performance.navigation.type == 1){

             validNavigation = true;
           }
      }
  }
  wireUpEvents();
});
