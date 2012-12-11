/* PRECARGADOR */

$("body").queryLoader2();

/* FUNCIÓN SCROLL HEADER */

$('.menuscroll').css('opacity','1');
$(window).scroll(function() {

        if ($(this).scrollTop() >= 100) {
	      $('.menuscroll').stop().animate({top: '203'});
        } else {
        $('.menuscroll').stop().animate({top: '103'});
  
        }
    });


/* HEADER ACTIVE */


if ($('.cursos').length > 0) {
	$('.licursos').css('border-bottom', '2px solid #D3D3D3');
} else if ($('.quienessomos').length > 0) {
	$('.liquienessomos').css('border-bottom', '2px solid #D3D3D3');
} else if ($('.calendario').length > 0) {
	$('.licalendario').css('border-bottom', '2px solid #D3D3D3');
} else if ($('.noticias').length > 0) {
	$('.linoticias').css('border-bottom', '2px solid #D3D3D3');
} else if ($('.formadores').length > 0) {
	$('.liformadores').css('border-bottom', '2px solid #D3D3D3');
} else if ($('.bolsadetrabajo').length > 0) {
	$('.libolsadetrabajo').css('border-bottom', '2px solid #D3D3D3');
} else if ($('.programa').length > 0) {
	$('.liprograma').css('color', 'white');
} else if ($('.material').length > 0) {
	$('.limaterial').css('color', 'white');
} else if ($('.valoracion').length > 0) {
	$('.livaloracion').css('color', 'white');
} else if ($('.contactoconelprofesor').length > 0) {
	$('.licontactoconelprofesor').css('color', 'white');
} else if ($('.micalendario').length > 0) {
	$('.limicalendario').css('color', 'white');
} else {
	
}


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
  	if ($('#cuerpo').hasClass('index')) {
  	
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


/* THUMBS EN COLUMNAS Y FOTOS CURSOS EN DOS COLUMNAS */

$('.thumbpadre').each(function(indexform) {
	var mitadImg = $('.modal img',this).length / 2;
	$(this).find('img').addClass('valor'+indexform);
	var clase = '.valor' + indexform;
	
	var division = $('.thumbpadre').length / 4;
	
	if(indexform < division) {
		$('.row1').append($(this));
	} else if (indexform < (division * 2)) {
		$('.row2').append($(this));
	} else if (indexform < (division * 3)) {
		$('.row3').append($(this));
	} else { 
		$('.row4').append($(this));
	}
	
	$(this).find('.modal img'+ clase).each(function(index, value) {
		if ((index+1)<=mitadImg) { 
			$(this).parent().find('.modaliz').append($(value));
		} else {
			$(this).parent().find('.modalde').append($(value));
		}
	});
	
});



/* PLACEHOLDER IE */

$('[placeholder]').focus(function() {
  var input = $(this);
  if (input.val() == input.attr('placeholder')) {
    input.val('');
    input.removeClass('placeholder');
  }
}).blur(function() {
  var input = $(this);
  if (input.val() == '' || input.val() == input.attr('placeholder')) {
    input.addClass('placeholder');
    input.val(input.attr('placeholder'));
  }
}).blur();