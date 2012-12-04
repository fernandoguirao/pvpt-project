/* CAROUSEL */
	
$('.carousel').carousel({
  interval: 500000
})

	$(".nav-carousel > div").click(function(){	 
	var item = $(this).attr('class').replace("thumb car-", "");
	var itemnum = parseInt(item) - 1;
	$('.carousel').carousel(itemnum);	
	return false;	
	});

/* THUMBNAILS */

 function pinterestthumbs()
  {
  	if ($('body').hasClass('th9')) {
  	
 	var posicionfooter = $('.footer').offset();
/*
 	var posicionth5 = $('.th5').offset();
 	var posicionth6 = $('.th6').offset();
 	var posicionth7 = $('.th7').offset();
 	var posicionth8 = $('.th8').offset();
 	var tamanoth5 = posicionth5.top + $('.th5').height();
 	var tamanoth6 = posicionth6.top + $('.th6').height();
 	var tamanoth7 = posicionth7.top + $('.th7').height();
 	var tamanoth8 = posicionth8.top + $('.th8').height();
 	
 	var arrayth = [tamanoth5, tamanoth6, tamanoth7, tamanoth8];
 	var largest = Math.max.apply(Math, arrayth);
 	var 
 	alert(largest);
*/
 	
 	var posicionth9 = $('.th9').offset();
 	var posicionth10 = $('.th10').offset();
 	var posicionth11 = $('.th11').offset();
 	var nueva9 = parseInt(posicionfooter.top) - parseInt(posicionth9.top) -23;
 	var nueva10 = parseInt(posicionfooter.top) - parseInt(posicionth10.top) -23;
 	var nueva11 = parseInt(posicionfooter.top) - parseInt(posicionth11.top) -23;
 	$('.th9').height(nueva9);
 	$('.th10').height(nueva10);
 	$('.th11').height(nueva11);
 	$('.th9,.th10,.th11').html('<img src="img/degradadoth.png" width="100%" height="100%" alt="">');
 	$('.th11 img').height(nueva11);
 	$('.th10 img').height(nueva10);
 	$('.th9 img').height(nueva9);
 	
 	}
 }

/*
	var claseabajosin = $(nombrethumb).attr('class').replace("thumbnail th","");
	var claseabajonum = parseInt(claseabajosin);
	var clasearribanum = claseabajonum - 4;
	var clasearriba = '.' + 'th' + clasearribanum;
	
	var positionth = $(clasearriba).offset();
	var tamanoth = $(clasearriba).height();
	var positionfin = $(nombrethumb).offset();
	
	var diferencia = - ((positionfin.top - 20) - (positionth.top + tamanoth));
	
	$(nombrethumb).css({
		'margin-top':diferencia + 'px'
	});
*/

pinterestthumbs();


/* FOOTER */

var tamanofooter = $('.footer').height();
$('.fondo-footer,.footer-textura,.contiene-bckg-foot').height(tamanofooter);
/* 	$('.footbckg').width(tamanofooter*8); */


/* MENÚ DE SCROLL */

$('.menuscrollsi').hide();
var $document = $(document),
$element = $('.menuscrollsi'),
className = 'menuscroll hidden-phone hidden-tablet';

$document.scroll(function() {
	if ($document.scrollTop() >= 150) {
		// user scrolled 50 pixels or more;
		// do stuff
		$('.menuscrollsi').show(function(){
			 $element.addClass(className);
		});
	} else {
		$('.menuscrollsi').fadeOut(function(){
			$element.removeClass(className);
		});
	}
});

