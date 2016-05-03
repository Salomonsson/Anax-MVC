/* 
*   about me Box
*
* Peter Salomonsson
*
*/
home = (function($)
{

  var $homeInit = $('#home');
  function init() {

    if ( $homeInit.length === 0 )
     return;    

    checker();
    listen();  
  }
   

  /*
   * Listerner
   *
   */
  function listen() {

    console.log('HOME from listen');
  }
    

  function checker()
  {
    console.log('checker HOME function, alright. ');
  }  


  init();

})(window.jQuery);  