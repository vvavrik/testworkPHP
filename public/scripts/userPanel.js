/* process button for show/hide form for user register, login */

var $panel = $("#userPanel");
var $btn = $panel.find("ul").find("li");
var $fastAccessLink = $btn.find("a");
var $system = $("#system");
var $formContainer = $system.find("div");
var $hideBtn = $("#system").find("a[href=hide]");
var $form = $formContainer.find("form");

function clearForm() {
    var $inputs = $formContainer.find('input:not([type=submit],[name=key])');
    $inputs.removeClass('valid');
    $inputs.removeClass('error');
    $inputs.val('');
    var $errorBlock = $formContainer.find('div.formErrorMessage');
    if ($errorBlock.length) {
        $errorBlock.remove();
    }
}

$btn.click(function (e) {
    $system.css({'height': '100%', 'visibility': 'visible', 'position': 'fixed'}).fadeTo('slow', 1);
    $system.find('a').fadeTo(1500, 1);

    var $activeFormName = $(e.target).attr("name");
    var $activeFormObj = $formContainer.find("form[name='" + $activeFormName + "']");

    if ($activeFormObj.length > 0) {
        $activeFormObj.hide().css("visibility", "visible").slideDown("slow");
    }
    return false;    
});

$fastAccessLink.click(function (e) {
    window.open(($(e.target).attr("href")),'_self');
    return false;
});


$hideBtn.click(function (event) {
    clearForm();
    $system.find("form").slideUp("slow");
    $system.find('a').fadeTo("slow", 0);

    setTimeout((function () {
        $system.fadeTo("slow", 0);
    }), 300);

    setTimeout((function () {
        $system.css("visibility", "hidden");
    }), 800);

    event.preventDefault();
    $hideBtn.fadeTo(200, 0);
});


$formContainer.click(function(){
    return false;
});

$form.click(function(){
    this.submit();
    return false;
});

$system.click(function (event) {
    clearForm();

    $system.find("form").slideUp("slow");
    $system.find('a').fadeTo("slow", 0);

    setTimeout((function () {
        $system.fadeTo("slow", 0);
    }), 300);

    setTimeout((function () {
        $system.css("visibility", "hidden");
    }), 800);

    event.preventDefault();
    $hideBtn.fadeTo(200, 0);

    return false;
});
