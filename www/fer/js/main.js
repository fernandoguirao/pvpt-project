/* Carousel: scripts */


	
$('.carousel').carousel({
  interval: 500000
})

    $(".nav-carousel > div").click(function(){   
    var item = $(this).attr('class').replace("thumb car-", "");
    var itemnum = parseInt(item) - 1;
    $('.carousel').carousel(itemnum);   
    return false;   
    });

 function pinterestthumbs(nombrethumb)
  {
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
}

pinterestthumbs('.th5');
pinterestthumbs('.th6');
pinterestthumbs('.th7');
pinterestthumbs('.th8');

	var tamanofooter = $('.footer').height();
	$('.fondo-footer,.footer-textura').height(tamanofooter);