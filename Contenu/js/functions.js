$( document ).ready(function() {

	/*function test_testfdgfg() { 

		alert('fonction automatisée --> test_testfdgfg');

	}

	test_testfdgfg();*/



	$('#reload-iframe').click(function() {

    $('.loading-preview').removeClass('hidden');

    $('#iframe-preview').html('');

    createIframe();

    // document.getElementById('view_edit').contentWindow.location.reload();

    // $('.loading-preview').addClass('hidden');
  });

  Symplycode();


  var height_window = $(window).height();

  var calc_height_content = height_window - 270;

  $('#wrapper-content').css('min-height',calc_height_content+'px');

  var trigger = $('.hamburger'),
      overlay = $('.overlay'),
     isClosed = false;

    trigger.click(function () {
      hamburger_cross();      
    });

    function hamburger_cross() {

      if (isClosed == true) {          
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
      } else {   
        overlay.show();
        trigger.removeClass('is-closed');
        trigger.addClass('is-open');
        isClosed = true;
      }
  }
  
  $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper-content').toggleClass('toggled');
  });



	var timeOutId = 0;
	var ajaxFn = function () {
    $.ajax({
        url: 'utilisateurs/getListtUtilisateursActif',
        success: function (response) {
            if (response == 'True') {
                clearTimeout(timeOutId);
            } else {
                timeOutId = setTimeout(ajaxFn, 3000);

    						$('#liste-utilisateurs').html(response);

    						var nb_user_actif = $('#liste-utilisateurs').find('li').length;

    						$('#nb-user-actif').html(nb_user_actif);
            }
        }
    });
	}
	ajaxFn();


  /*var logBackup = console.log;
	var logMessages = [];

	console.log = function() {
	    logMessages.push.apply(logMessages, arguments);
	    logBackup.apply(console, arguments);
	};*/

	// alert(logMessages);
});



//doesn't block the load event
function createIframe() {
    var i = document.createElement("iframe");
    i.src = "/appeditor/Games/projet_1/index.php";
    i.id  = "view_edit";
    i.scrolling = "auto";
    i.frameborder = "0";
    i.width = "100%";
    i.height = "605";
    
    document.getElementById("iframe-preview").appendChild(i);


    // alert('ok iframe loaded');

    $('.loading-preview').addClass('hidden');
};


// Check for browser support of event handling capability
if (window.addEventListener) window.addEventListener("load", createIframe, false);
else if (window.attachEvent) window.attachEvent("onload", createIframe);
else window.onload = createIframe;