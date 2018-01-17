/*asside multilevel menu as accordion*/

$(function(){

  $multilevelMenuArea = $('aside').find('li');
  
  $multilevelMenuArea.click(function(e){

    $(e.target).parent().find('li').not(e.target).removeClass('active');
    $(e.target).addClass('active');
    //~ return false;

  });

});
