/* === JS du menu principal ============
 * @description :
 *  Ce script gère tout le fonctionnement
 *  du menu, selon la taille d'écran.
 *
 * @Dépendance :
 * - Jquery >= 1.9
 * - Bootstrap ( pour la structure html du menu )
 *
 * @Sommaire :
 * - OPTIONS DU MENU
 * - Fonctionnement du menu
 *   - Comportement du 1er niveau
 *   - Comportement du 2ème niveau
 *   - Changement de taille d'écran en temps réel
 *   - Clic de l'icone de retour
 *   - Menu en version mobile fixé en haut de l'écran au scroll
 * - Actions du menu au scroll
 * - Ouverture du 2ème niveau
 * - Ouverture du 3ème niveau
 * - Ouverture auto du 1er niveau
 * - Comportement des niveaux du menu
 *   - Fermeture du menu au clic à l'extérieur
 * - Execution du menu
 * - Breadcrumb menu
 * ---------------------------------- */

var menu_offset;
var thiS;
var first_level;         // 1er niveau
var first_level_lien;	 	 // titre de 1er niveau
var second_level;		 		 // 2ème niveau
var second_level_lien;   // titre de 2ème niveau
var third_level;		 		 // 3ème niveau
var element;
var element2;
var element_parent_level;
var parent_level;
var id_menu;
var class_menu;
var posScroll;


function Menu(menu) {

	// On définit le $
	(function(factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports !== 'undefined') {
        module.exports = factory(require('jquery'));
    } else {
        factory(jQuery);
    }

	}(function($) {

    'use strict';

		/* -- [ OPTIONS MOBILES DU MENU ] ------------------------------------------------- */
		if( $(window).width() <= parseInt(menu.screen_mobile) ) {

			menu.is_mobile  		= true;
		}

		menu_offset = menu.offset_menu_sticky;

		// Si on est en version mobile
		if( menu.is_mobile == true ) {

			menu.mouse_comportment  = menu.mobile.mouse_comportment;
			menu.mouse_comportment2 = menu.mobile.mouse_comportment2;
			menu_offset 						= menu.mobile.offset_menu_mobile;
		}


		/* -- [ Fonctionnement du menu ] ------------------------------------------ */
		if( $(menu.selector).find('.menu-block-wrapper').length ) {

			id_menu    = menu.selector;
			class_menu = '.menu-block-wrapper';
		}

		if( menu.position == 'vertical' ) {

			$(id_menu).addClass('vertical');
		}


		if( menu.burger_menu_desktop == true ) {

			$('#navbar').addClass('burger-menu');

			if( menu.is_mobile == false ) {

				$('<span class="close-menu glyphicon glyphicon-remove-circle"></span>').prependTo('.navbar-collapse');

				var width_menu = parseInt($(window).width()) - 300;

				$('.navbar-collapse').css({
					'width':width_menu+'px',
					'left':'-'+width_menu+'px'
				});

				$('.close-menu').click(function() {
					
					$('.navbar-burger').removeClass('in');

					$('.navbar-collapse').stop().animate({left:'-'+width_menu+'px'}, "slow");
				});
			}

			$('.navbar-burger').click(function() {

				if( menu.animation_menu_vertical == 'fade' ) {

					if( !$('.navbar-collapse').hasClass('in') ) {
						$(id_menu).stop().fadeIn();
					}
					else {
						$(id_menu).stop().fadeOut();
					}
				}

				if( menu.animation_menu_vertical == 'animate' ) {

					if( menu.is_mobile == true ) {

						if( !$(this).hasClass('in') ) {
							$('.navbar-collapse').removeClass('hidden').stop().addClass('show');

							$(this).addClass('in');
						}
						else {

		          $(".navbar-collapse").removeClass('show');

						 	$(this).removeClass('in');
						}

					}
					else {

						if( !$(this).hasClass('in') ) {
							$('.navbar-collapse').removeClass('hidden').stop().animate({left:'85px'}, "slow");

							$(this).addClass('in');
						}
						else {

						 	$('.navbar-collapse').stop().animate({
						 		left:'-'+width_menu+'px'
						 	}, function(){
		             $(".navbar-collapse").addClass('hidden');
			        });

						 	$(this).removeClass('in');
						}
					}
				}
			});
		}

		// On définit les niveaux de menu dans des variables
		first_level 	  	= $('#block-menu-block-3 '+class_menu+' > ul.menu.nav > li');
		first_level_lien  = $('#block-menu-block-3 '+class_menu+' > ul.menu.nav > li > a');
		second_level 	  	= $('#block-menu-block-3 '+class_menu+' > ul.menu.nav > li > ul.menu.nav > li');
		second_level_lien = $('#block-menu-block-3 '+class_menu+' > ul.menu.nav > li > ul.menu.nav > li > a');
		third_level 	  	= $('#block-menu-block-3 '+class_menu+' > ul.menu.nav ul.menu.nav ul.menu.nav');

		// On ajoute les classes des niveaux
		first_level.addClass('first-level');
		second_level.addClass('second-level');

		first_level_lien.find('span').addClass('titre-first-level');
		second_level_lien.find('span').addClass('titre-second-level');

		// On créé l'icone de retour aux premiers niveaux
		first_level.prepend( $('<span class="icon-return"></span>') );

		if( $('#block-menu-block-2').length ) {

			create_breadcrumb_menu();
		}

		element  = first_level_lien;
		element2 = second_level_lien;

		// Si on est en version mobile
		if( menu.is_mobile == true ) {

			element  = first_level_lien;
			element2 = second_level_lien;
		}

		// Comportement du 1er niveau
		level_active(element, menu.opening_2nd_level, '1', menu.mouse_comportment);

	  // Comportement du 2ème niveau
		level_active(element2, menu.opening_third_level, '2', menu.mouse_comportment2);

		// Changement de taille d'écran en temps réel
	  $(window).on('resize', function() {

			var win = $(this); //this = window

			// Si on est en version mobile
			if( win.width() <= menu.screen_mobile ) {

				/* -- [ Ouverture auto du 1er niveau ] ------ */
				open_auto_first_level(first_level);

			} else {

				// Fix de l'affichage du 1er et 2ème niveau du menu
				second_level.removeAttr('style');
				first_level.removeAttr('style');
			}
		});

		
		// Si on est en version mobile
		if( menu.is_mobile == true ) {

			$('.navbar-toggle').before( $('#block-search-form') );

			/* -- [ Ouverture auto du 1er niveau ] ------ */
		  open_auto_first_level(first_level);


			/* -- [ Clic de l'icone de retour ] --------------------------------------- */
			$('.icon-return').click(function() {

				var first_level_parent = $(this).closest('li');
				var titre_clone 	   	 = first_level_parent.find('.titre-second-level-clone');

				$(this).removeClass('on');

				if( titre_clone.length > 0) {	// si on est dans un 3ème niveau

					second_level.find('ul.menu.nav').hide(); // on referme le 3ème niveau
					titre_clone.remove();					 // on efface le titre de 2ème niveau cloné
					second_level.removeClass('open');		 // on cache les 2èmes niveaux
					$('.second-level-open li').show();		 // on affiche tout le 2ème niveau
				}

				$(this).parent('li').find('.second-level-open').hide().removeClass('second-level-open');

				$('.titre-first-level.active').removeClass('active');

				first_level.show();	// on affiche tous les 1ers niveaux
			});


			// Menu en version mobile fixé en haut de l'écran au scroll
			actions_scroll();

		} else {

			if( menu.menu_sticky == true ) {

	    	actions_scroll();
	    }
		}


		/* -- [ Actions du menu au scroll ] --------------------------------------- */
		function actions_scroll() {

			$(window).scroll(function(){

      	posScroll = $(document).scrollTop();

      	if(posScroll >= menu_offset) {

      		if( menu.is_mobile == true ) {

      			$('.navbar-toggle, #block-search-form').css({'top':'0'});

						$(id_menu).css({'top':'48px'});
      		}
      		else {
					
						$(id_menu).addClass('fixed');

						$('.navbar .logo').addClass('show');
					}
					
				} else {

					if( menu.is_mobile == true ) {

						$('.navbar-toggle, #block-search-form').css({'top':'0'});

						$(id_menu).css({'top':'0'});
					}
					else {
					
						$(id_menu).removeClass('fixed');

						$('.navbar .logo').removeClass('show');
					}
				}
    	});
		}


		/* -- [ Ouverture du 2ème niveau ] ------------------------------------------- */
		function open_second_level(thiS, parent_level, num_level) {

			var titre_clone = parent_level.find('.titre-second-level-clone');

			// si on est dans un 3ème niveau
			if( num_level == 1 ) {

				first_level.hide();						  // on cache les 1ers niveaux

				var second_level_open = parent_level.show().addClass('on').find('ul.menu.nav').first();

				second_level_open.removeAttr('style').addClass('second-level-open'); // on affiche le 2ème niveau dans lequel on est

				parent_level.find('.icon-return').addClass('on'); // on affiche le bouton de retour

				thiS.find('.titre-first-level').addClass('active');

				$('.second-level-open').find('li').removeAttr('style');
			}
			else {

				$('.second-level-open li').fadeIn(700);	  // on affiche le 2ème niveau

				second_level.find('ul.menu.nav').hide();  // on cache les 3èmes niveaux

				titre_clone.remove();					  					// on efface le titre de 2ème niveau cloné

				second_level.removeClass('open');		  		// on cache les 2èmes niveaux
			}
		}


		/* -- [ Ouverture du 3ème niveau ] ----------------------------------------- */
		function open_third_level(thiS, parent_level) {

			$('.second-level-open > li').stop().hide(); 		// on cache le 2ème niveau

			parent_level.removeAttr('style').show().addClass('open'); // on affiche son 3ème niveau

			var parent_level_on 		 	 	 = thiS.closest('.first-level.on');
			var titre_first_level_open 	 = parent_level_on.find('.titre-first-level');
			var titre_second_level 		 	 = thiS.find('.titre-second-level').text();
			var titre_second_level_clone = '<span class="titre-second-level-clone">\
																				- '+titre_second_level+'\
																			</span>';

			titre_first_level_open.after( titre_second_level_clone ); // on copie le titre à côté du 1er niveau

			parent_level.find('ul.menu.nav').slideDown(700); // on déplie son 3ème niveau;
		}


		/* -- [ Ouverture auto du 1er niveau ] ------------------------------------ */
		function open_auto_first_level(first_level) {

		  first_level.each(function() {

		  	if( $(this).hasClass('active-trail') ) {

		  		thiS  		 	 = $(this);
					parent_level = thiS;

		  		open_second_level(thiS, parent_level, '0');
				}
		  });
		}


		/* -- [ Comportement des niveaux du menu ] ------------------------------- */
		function level_active(level_active, to_open_level_children, num_level, comportment) {

			if( comportment == 'mouseover' ) {

				level_active.on('mouseover', function (e) {

					thiS 	 = $(this);

					element_parent_level = thiS;

					// Si on est en version mobile
					if( menu.is_mobile == true ) {

						element_parent_level = thiS.parent('li');
					}


					if( to_open_level_children == true ) {

			    	first_level.removeClass('hover-in');

			  		if( !element_parent_level.hasClass('hover-in') ) {

			  			element_parent_level.addClass('hover-in');
			  			
			  		}
			  		else {

			  			element_parent_level.removeClass('hover-in');
			  		}
			  	}


			  	// Si on est en version mobile
			  	if( menu.is_mobile == true ) {

						parent_level = thiS.parent('li');

				  	if( num_level == 1 ) {

				  		e.preventDefault();
							e.stopPropagation();

							open_second_level(thiS, parent_level, '1');
				  	}

				  	if( num_level == 2 ) {

				  		if( parent_level.hasClass('expanded') ) {	// si il contient un 3ème niveau

								if( !parent_level.hasClass('open') ) {						// si le 3ème niveau est fermé

									e.preventDefault();															// on bloque le lien

				  				open_third_level(thiS, parent_level, e);
				  			}
				  		}
				  	}
					}

				}).mouseleave(function() {

			    if( to_open_level_children == true ) {

					  level_active.removeClass('hover-in');
					}
			  });

			}

			if( comportment == 'click' ) {

			  level_active.on('click', function (e) {

					thiS 	 = $(this);

					element_parent_level = thiS.parent('li');

					if( element_parent_level.hasClass('first-level') ) {
			  		
				  	e.preventDefault();
						e.stopPropagation();
					}
					
					// Si on est en version mobile
					if( menu.is_mobile == true ) {

						element_parent_level = thiS.parent('li');
					}


					if( to_open_level_children == true ) {

			    	first_level.removeClass('hover-in');

			  		if( !element_parent_level.hasClass('hover-in') ) {

			  			element_parent_level.addClass('hover-in');
			  			
			  		}
			  		else {

			  			element_parent_level.removeClass('hover-in');
			  		}
			  	}


			  	// Si on est en version mobile
			  	if( menu.is_mobile == true ) {

						console.log(num_level);

						parent_level = thiS.parent('li');

				  	if( num_level == 1 ) {

				  		e.preventDefault();
							e.stopPropagation();

							open_second_level(thiS, parent_level, '1');
				  	}

				  	if( num_level == 2 ) {

				  		if( parent_level.hasClass('expanded') ) {						// si il contient un 3ème niveau

				  			console.log('ok 3eme niveau');

								if( !parent_level.hasClass('open') ) {						// si le 3ème niveau est fermé

									e.preventDefault();															// on bloque le lien

				  				open_third_level(thiS, parent_level, e);
				  			}
				  		}
				  	}
					}

				});
			}

			if( menu.is_mobile == false ) {

				// Fermeture du menu au clic à l'extérieur
			  $('body').click(function(event) {

					if( $('.hover-in').length ) {

						event.stopPropagation();
						first_level.removeClass('hover-in');
					}
				});
			}
		}



		/* -- [ Breadcrumb menu ] ----------------------------------------- */
		function create_breadcrumb_menu() {

			// On créé le wrapper du 1er niveau
			$('<ul class="wrapper-first-level"></ul>').prependTo('#block-menu-block-2');

			// On créé le wrapper du 2ème niveau
			$('<ul class="wrapper-third-level"></ul>').prependTo('#block-menu-block-2');

			// On copie le titre de 2ème niveau actif
			$('#block-menu-block-2 .menu-block-wrapper > ul.menu.nav > li.active-trail').clone().prependTo('#block-menu-block-2');

			// On copie le titre de 1er niveau actif
			$('.menu-title').clone().removeClass('hidden').prependTo('#block-menu-block-2');


			// Ouverture du block des 1ers niveaux frères
			$('#block-menu-block-2').find('h2.menu-title').click(function(e) {

				e.preventDefault();

				if( !$(this).hasClass('on') ) {

					$('#block-menu-block-2').find('.menu-title + li.active-trail').removeClass('on');
					$('#block-menu-block-2 .menu-block-wrapper').hide();
					$('#block-menu-block-2').find('li.third-level-clone').removeClass('on');
					$('#block-menu-block-2 .wrapper-third-level').hide();
					$('#block-menu-block-2 .wrapper-first-level').fadeIn();
					$(this).addClass('on');
				}
				else {

					$('#block-menu-block-2 .wrapper-first-level').fadeOut();
					$(this).removeClass('on');
				}

				body_click();
			});

			// Ouverture du block des 2èmes niveaux frères
			$('#block-menu-block-2').find('.menu-title + li.active-trail').click(function(e) {

				e.preventDefault();

				if( !$(this).hasClass('on') ) {

					$('#block-menu-block-2').find('h2.menu-title').removeClass('on');
					$('#block-menu-block-2 .wrapper-first-level').hide();
					$('#block-menu-block-2').find('li.third-level-clone').removeClass('on');
					$('#block-menu-block-2 .wrapper-third-level').hide();
					$('#block-menu-block-2 .menu-block-wrapper').fadeIn();
					$(this).addClass('on');
				}
				else {

					$('#block-menu-block-2 .menu-block-wrapper').fadeOut();
					$(this).removeClass('on');
				}

				body_click();
			});


			// On remplit le block des 1ers niveaux frères
			$('#block-menu-block-3').find(class_menu+' > ul.menu.nav > li.first-level').each(function() {

				var titre_first_level = $(this).find('a:first').text();
				var lien_first_level = $(this).find('a:first').attr('href');

				$('<li><a href="'+lien_first_level+'">'+titre_first_level+'</a></li>').prependTo('.wrapper-first-level');
			});


			var content_third_level = $('#block-menu-block-2').find('.menu-block-wrapper > ul > li.active-trail > ul').html();

			if( $('.wrapper-third-level').length ) {

				$(content_third_level).prependTo('.wrapper-third-level');
			}

			if( $('#block-menu-block-2').find('.menu-block-wrapper ul > li.active-trail > ul > li.active').length ) {

				var first_third_level = $('#block-menu-block-2').find('.menu-block-wrapper ul > li.active-trail > ul > li.active > a').text();
				var lien_first_third_level = $('#block-menu-block-2').find('.menu-block-wrapper ul > li.active-trail > ul > li.active > a').attr('href');
			}
			else {

				var first_third_level = $('#block-menu-block-2').find('.menu-block-wrapper ul > li.active-trail > ul > li:first > a').text();
				var lien_first_third_level = $('#block-menu-block-2').find('.menu-block-wrapper ul > li.active-trail > ul > li:first > a').attr('href');
			}


			if( typeof(content_third_level) != 'undefined' ) {

				$('#block-menu-block-2 .menu-title + li.active-trail').after('<li class="third-level-clone"><a href="'+lien_first_third_level+'">'+first_third_level+'</a></li>');
			}

			$('#block-menu-block-2').find('li.third-level-clone').click(function(e) {

				e.preventDefault();

				if( !$(this).hasClass('on') ) {

					$('#block-menu-block-2').find('h2.menu-title').removeClass('on');
					$('#block-menu-block-2 .wrapper-first-level').hide();
					$('#block-menu-block-2').find('.menu-title + li.active-trail').removeClass('on');
					$('#block-menu-block-2 .menu-block-wrapper').hide();
					$('#block-menu-block-2 .wrapper-third-level').fadeIn();
					$(this).addClass('on');
				}
				else {

					$('#block-menu-block-2 .wrapper-third-level').fadeOut();
					$(this).removeClass('on');
				}

				body_click();
			});

			setTimeout(function() {

				$('#block-menu-block-2').animate({bottom: '0'});

			}, 2000 );

		}


		function body_click() {

			$(document).click(function(e) {

				if( $('#block-menu-block-2 > .menu-title.on').length ||
						$('#block-menu-block-2 > .menu-title + .active-trail.on').length ||
						$('#block-menu-block-2 > .third-level-clone.on').length ) {

					// alert('oki click body');

					// e.stopPropagation();

					if (!$(e.target).is('#block-menu-block-2 *')) {

						$('#block-menu-block-2 .wrapper-first-level').hide();
						$('#block-menu-block-2 .menu-block-wrapper').hide();
						$('#block-menu-block-2 .wrapper-third-level').hide();
					}
				}
			});

			return false;
		}

	}));
}