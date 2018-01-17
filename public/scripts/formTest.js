// do not test search form $('#searchForm')
// process only form with no "processor" attribute
// for forms with <_processor="special"_> attribute must be separate processors

var WARNING = 1;
var NO_WARNING = 0;

var errorMsg = 'Будь ласка перевірте введені дані: ';
var errorKey = NO_WARNING;

var $form = $('form:not([processor=special])');

function initVal() {                                 // set initial values
  errorMsg = 'Будь ласка перевірте введені дані: ';
  errorKey = NO_WARNING;
  return true;
}

function showErrorBlock($element) {
  $element.parent().find('div.formErrorMessage').remove();
  var $label = $element.parent().find('label');
  $label.after('<div class="formErrorMessage">'); // insert div for error message
  $element.parent().find('div.formErrorMessage').html(errorMsg);
  $element.focus();
  initVal();
  return false;
}

function minLengthTest($obj) {
  var $minlength = $obj.attr('minlength');
  var currentInputMinLength = Number($minlength);
  if (currentInputMinLength > 0) {                   // minlength attribute is set - test min length
    var currentInputData = $obj.val();
    var currentInputDataLength = currentInputData.length;
    if (currentInputDataLength < currentInputMinLength) {
      errorMsg = errorMsg + ' мінімальна довжина поля "' + $obj.parent().find('label').html() + '" ' + currentInputMinLength + ' символів;';
      errorKey = WARNING;
    }
    else {
      errorKey = NO_WARNING;
    }
  }
  return errorKey;
}

function maxLengthTest($obj) {
  var $maxlength = $obj.attr('maxlength');
  var currentInputMaxLength = Number($maxlength);
  if (currentInputMaxLength > 0) {                   // minlength attribute is set - test min length
    var currentInputData = $obj.val();
    var currentInputDataLength = currentInputData.length;
    if (currentInputDataLength > currentInputMaxLength) {
      errorMsg = errorMsg + ' максимальна довжина поля "' + $obj.parent().find('label').html() + '" ' + currentInputMaxLength + ' символів;';
      errorKey = WARNING;
    }
    else {
      errorKey = NO_WARNING;
    }
  }
  return errorKey;
}

function passwordConfirmTest($obj) {
  var $passwordConfirmVal = $obj.val();
  var $passwordObj = $obj.parent().parent().find('input[name=password]');
  if ($passwordObj.length) {
    if ($passwordObj.val() != $passwordConfirmVal) {
      errorMsg = errorMsg + ' поля "Пароль" і "Підтвердження паролю" не співпадають!';
      errorKey = WARNING;

      showErrorBlock($obj);

      $obj.removeClass('valid');
      $obj.addClass('error');

      $passwordObj.removeClass('valid');
      $passwordObj.addClass('error');
    }
    else {
      if ($passwordObj.val() != '') {
        $obj.removeClass('error');
        $obj.addClass('valid');

        $passwordObj.removeClass('error');
        $passwordObj.addClass('valid');
      }
    }
  }
}

function $elementTest($obj) {
  initVal();

  $minLengthTestKey = minLengthTest($obj);
  $maxLengthTestKey = maxLengthTest($obj);

  if ($minLengthTestKey + $maxLengthTestKey == NO_WARNING) {
    $obj.addClass('valid');
    $obj.removeClass('error');
    var $errorBlock = $obj.parent().find('div.formErrorMessage');
    if ($errorBlock.length) { // if error block was added- remove it
      $errorBlock.remove();
    }
  }
  else {
    $obj.addClass('error');
    $obj.removeClass('valid');
    errorKey = WARNING;
    showErrorBlock($obj);
  }

  var $name = $obj.attr('name');
  if ($name == 'passwordConfirm') {
    passwordConfirmTest($obj);
  }
}

$form.find('input[required]').change(function(){
  $elementTest($(this));
});

$('label').click(function(){                                     // if click on label - set focus on input
  var $inputName = $(this).attr('for');
  var $inputElement = $(this).parent().find('input[name=' + $inputName + ']');
  if ($inputElement.length) {                                    // if can find this element
    $inputElement.focus();
  }
});

$form.submit(function() {
  
  $(this).find('input[required]:not([type=submit])').each(function(){
    $elementTest($(this));
  });

  $(this).submit();

  return false;
});