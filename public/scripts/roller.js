// ПОКАЗАТИ РОЛЛЕР ЗОБРАЖЕНЬ
// ILLUSTR - адреса зображення (номер)
// H2 - заголовок слайду
// H3 - підзаголовок слайду
// TARGET - куди перейти по натисненні на слайд

var slidesNum = PIC.length-1;

var block = $("#illustr");
var h2 = $("#illustr div h2");
var h3 = $("#illustr div h3");

var current = 0;

function roller() {
 	block.css({'background-image' : 'url(/images/roller/' + PIC[current] + '.jpg)', 'margin-left':'0px', 'opacity' : '1', 'z-index' : '0'});
 	h2.html(H2[current]);
 	h3.html(H3[current]);

 	var next = current + 1;
 	if (next > slidesNum) { next = 0; }

 	block.animate({'background-position':'400px 0px'}, 'slow');
 	block.css({ 'background-position':'0px 0px'});
 	current = next;
}

roller();

rollingTimer = setInterval((function(){ roller(); }), 5000);

block.mouseover(function(){ clearInterval(rollingTimer); }); /* if mouse pointer on block - stop roller */

block.mouseout(function(){ rollingTimer = setInterval((function(){ roller(); }), 5000); }); /* start animation when mouse leave the block */
