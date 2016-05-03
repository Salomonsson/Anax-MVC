/* 
*   about me Box
*
* Peter Salomonsson
*
*/
user = (function($)
{

  var $userInit = $('#user');
  function init() {

    if ( $userInit.length === 0 )
     return;    

    checker();
    listen();  
  }
   

  /*
   * Listerner
   *
   */
  function listen() {

    console.log('USER from listen');
  }
    

  function checker()
  {
    console.log('checker USER function, alright. ');
  }  


  init();

})(window.jQuery);  