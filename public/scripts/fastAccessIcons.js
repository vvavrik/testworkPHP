/* show fast access buttons */
/* paste here <section id="illustr"> <ul> -> */

/* incomin data:
var FAST_ACCESS_TITLE = [];  //title for the button
var FAST_ACCESS_SYMBOL = []; //symbol
var FAST_ACCESS_TARGET = []; //link target */


var $fastAccessButtonsContainer = $('#illustr').find('ul');  // where to place buttons



$(function(){

  // show fast access buttons
  var num = FAST_ACCESS_TARGET.length;                           // the number of buttons

  if (num > 0) {

    for (var i=0; i<num; i++) {
      var $fastAccessButton = $('<li>', {'title':FAST_ACCESS_TITLE[i]}).html(FAST_ACCESS_SYMBOL[i]).attr('href',FAST_ACCESS_TARGET[i]);  // forming the button
      var $var = $fastAccessButtonsContainer.append($fastAccessButton).css('opacity','0').fadeTo(2000, 1);     // insert button in the end of the container ul
    }

    var $fastAccessButtons = $fastAccessButtonsContainer.find('li');
    $fastAccessButtons.animate({'margin-left':'.5em'},1500);
  }


  // process click on fast access button
  var $fastAccessButtonsClick = $('#illustr').find('ul').find('li');
  $fastAccessButtonsClick.click(function(e){
    $clickedButton = $(e.target);
    alert($clickedButton.attr('href'));
  });

});
