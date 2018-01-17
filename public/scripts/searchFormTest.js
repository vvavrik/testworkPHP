var $form = $('#searchForm');
var $string = $('#searchString');
var $label = $('#searchForm label');
var $minlength = $string.attr('minlength');
var $searchLablAsAButton = $form.find("label");

$string.click(   // select all search term on click on it
  function(){
    $string.select();
  }
);

function testSearchForm() {
  if ($string.val().length < $minlength) {
    $label.attr("style", "background-color:#b74e00; color:#f5ecec");
    $string.val("");
    $string.blur();
    // do not focus- it will erase placeholder
    $string.attr('placeholder', 'що шукаємо?');
    return false;
  }
  else {
    $label.attr("style", "");
    return false;
  }
}

$form.submit(function(){
  testSearchForm();
  return false;
});

$searchLablAsAButton.click(function(){
  testSearchForm();
  return false;
});
