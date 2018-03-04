/* === JS de Symply Code ============
 * @description :
 *  Symply code, simplificateur de codage, écriture automatisée du code
 *
 * @DÃ©pendance :
 * -
 *
 * @Sommaire :
 * - Fonction : ExecCodeMirror ( éditeur de code )
 * - Fonction : nom_machine
 * - Fonction : Versioning de fichiers
 * ---------------------------------- */


function Symplycode() {

	// On dÃ©finit le $
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

    console.log('ok symply code');

    if( $('.editeur-d-applications').length ) {

    	// On éxécute CodeMirror
    	var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
          lineNumbers: true,
          mode: "text/javascript",
          styleActiveLine: true,
          renderWhitespace: true,
          matchBrackets: true
      });

      function ExecCodeMirror(editor) {

        var input = document.getElementById("select-themes");

        function loadjscssfile(filename, filetype){

            if (filetype=="js"){ //if filename is a external JavaScript file
                var fileref=document.createElement('script')
                fileref.setAttribute("type","text/javascript")
                fileref.setAttribute("src", filename)
            }
            else if (filetype=="css"){ //if filename is an external CSS file
                var fileref=document.createElement("link")
                fileref.setAttribute("rel", "stylesheet")
                fileref.setAttribute("type", "text/css")
                fileref.setAttribute("href", filename)
            }
            if (typeof fileref!="undefined")
                document.getElementsByTagName("head")[0].appendChild(fileref)
        }

        function selectTheme() {
            var theme = input.options[input.selectedIndex].textContent;
            editor.setOption("theme", theme);
            location.hash = "#" + theme;

        }

        var choice = (location.hash && location.hash.slice(1)) ||
                   (document.location.search &&
                    decodeURIComponent(document.location.search.slice(1)));
        if (choice) {
            input.value = choice;
            editor.setOption("theme", choice);

            // alert(choice);

            loadjscssfile('Contenu/codemirror/theme/'+choice+'.css', 'css') ////dynamically load and add this .css file
        }

        CodeMirror.on(window, "hashchange", function() {
            var theme = location.hash.slice(1);
            if (theme) { 
                input.value = theme;

                // alert(input.value);

                selectTheme();

                loadjscssfile('Contenu/codemirror/theme/'+theme+'.css', 'css') ////dynamically load and add this .css file
            }
        });

        $('#select-themes').change(function() {

            selectTheme();
        });
    	}


      // Fonction : nom_machine
      $('#form-fonctions').find('input[name=name-fonction]').bind('input', function() {

          $('.alert.fixed').remove();

          var val = $(this).val();
          var new_val = val.replace(/ /g,"_");

          $(this).val(new_val);

          console.log($(this).val());
      });


      $(document).on("click", 'input.pub-file', function() {

          if( !$(this).hasClass('on') ) {

              $('input.edit-file').removeClass('on');

              $(this).addClass('on');
          }
      });

      $(document).on("click", 'input.edit-file', function() {

          if( !$(this).hasClass('on') ) {

              $('input.pub-file').removeClass('on');

              $(this).addClass('on');
          }
      });


      // Fonction : Versioning de fichiers
      $(document).on("submit", '.form-file-pub, .form-file-edit', function (event) {

          event.preventDefault();

          editor.setValue("");
          editor.clearHistory();

          $('#arborescence > .loading-files').show();

          var This = $(this);

          // Nom du fichier publié
          var path_fil_pub 	 = This.find('.path-file-pub').attr('value');

          // Nom du fichier publié ( sans extension )
          var split_file1 	 = path_fil_pub.split("/");
          var split_file2 	 = split_file1[split_file1.length-1].split(".");

          // Nom du fichier à éditer
          var nom_file         = This.find('.nom-file').text();

          // Cchemin du fichier publié
          var path_file_pub    = This.find('.path-file-pub').attr('value');

          // Chemin du fichier à éditer
          var path_file_edit   = This.find('.path-file-edit').attr('value');

          var path_folder      = '/volume1/web/appeditor/Games/projet_1/js/'+split_file2[0];

          if( $('input[name=pub-file]').hasClass('on') ) {

              var submit_event = 'pub';
          }

          if( $('input[name=edit-file]').hasClass('on') ) {

              var submit_event = 'edit';
          }
          
          /*if( submit_event == 'edit' ) {*/

          	// On recréé le champ textarea du formulaire de l'éditeur

           	$('#form-editeur').find('#code').next('.CodeMirror').remove();

						$('#form-editeur').find('#code').show();

						$('#form-editeur').find('#code').remove();

						$('<textarea id="code" name="file-edit"></textarea>').prependTo('#form-editeur');
          	
          /*}*/


          if( This.hasClass('form-file-pub') ) {

          	var nb_version_file = This.next('ul').find('li').length;

          	var nb_file         = parseInt(nb_version_file) + 1;

              console.log(This.next('ul').length);

              if( This.next('ul').length == 0 ) {

                  This.after('<ul></ul>');
              }

              if( This.next('ul').length > 0 ) { 

                  This.next('ul').prepend(
                    $('<li class="sub-version clearfix">\
                          <form class="form-file-edit" method="post" action="">\
                              <div class="wrapper-file clearfix">\
                                  <input type="submit" class="pub-file pull-right btn btn-success" name="pub-file" value="publier">\
                                  <span class="nom-file">'+split_file2[0]+'-'+nb_file+'.js</span>\
                                  <input type="hidden" name="path-file-edit" class="path-file-edit" value="/volume1/web/appeditor/Games/projet_1/js/'+split_file2[0]+'/'+split_file2[0]+'-'+nb_file+'.'+split_file2[1]+'">\
                                  <input type="hidden" name="path-file-pub" class="path-file-pub" value="'+path_fil_pub+'">\
                                  <input type="submit" class="edit-file pull-right btn btn-primary" name="edit-file" value="éditer">\
                              </div>\
                          </form>\
                      </li>') 
                  );
              }

              path_file_edit  = '/volume1/web/appeditor/Games/projet_1/js/'+split_file2[0]+'/'+split_file2[0]+'-'+nb_file+'.js';

              nom_file 	    = split_file2[0]+'-'+nb_file+'.'+split_file2[1];
          }


          // get the form data
          // there are many ways to get this data using jQuery (you can use the class or id also)
          var formData = {
              'submit-event'        : submit_event,
              'path-file-edit'      : path_file_edit,
              'path-file-pub'       : path_file_pub,
              'path-folder'         : path_folder,
          };

          // console.log(formData);

          // process the form
          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              url         : 'manage/editFiles',
              // url         : 'Modele/simplycode.php', // the url where we want to POST
              data        : formData, // our data object
              dataType    : 'html', // what type of data do we expect back from the server
              encode      : true
          })
          // using the done promise callback
          .done(function(data) {

              // log data to the console so we can see
              // console.log(data2);

              // alert(data2);
              
              $('input[name=pub-file], input[name=edit-file]').removeClass('on');
              
              /* if( submit_event == 'edit' ) {*/

                $('#form-editeur').find('#code').html(data);

                $('#form-editeur').find('input[name=path-file-editeur]').val(path_file_edit);

                $('#arborescence').removeClass('active in');

                $('#actions-app-edit > ul > li:eq(1)').removeClass('active');

                $('#actions-app-edit > ul > li:eq(0)').find('a').text('Editer le fichier ('+nom_file+')');

                $('#actions-app-edit > ul > li:eq(0)').removeClass('hidden').addClass('active');

                $('#file-source').removeClass('hidden').addClass('active in');
          			
          			// On rééxécute CodeMirror sur le nouveau champ textarea créé
              	editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		                lineNumbers: true,
		                mode: "text/javascript",
		                styleActiveLine: true,
                    renderWhitespace: true,
		                matchBrackets: true
		            });
              /*}*/

              if( submit_event == 'pub' ) {

                $('<div class="alert alert-success fixed">\
                    <button type="button" class="close" data-dismiss="alert">x</button>\
                    <span class="glyphicon glyphicon-ok-circle"></span>\
                    Le fichier <b>'+nom_file+'</b> a bien été publié\
                  </div>').prependTo('body');

                $(".alert").fadeTo(2000, 500).slideUp(500, function(){

                    $("#success-alert").slideUp(500);

										setTimeout(function()
							      {
							        $('.alert.fixed').remove();
							      }, 1000);
                });
              }
              
              // alert(editor.getValue());

							ExecCodeMirror(editor);

              post_application(editor,nom_file);

              $('#arborescence > .loading-files').hide();
          });
      });



      function post_application(editor,nom_file) {

      	// editor.clearHistory();

      	$(document).on("submit", '#form-editeur', function (event) {

          // stop the form from submitting the normal way and refreshing the page
          event.preventDefault();

          // alert(editor.getValue());

          // console.log('content file : '+editor.getValue());

          $('#loading > div').css('width','50%');

          /*if( editor.getValue().length == 0 ) {

          	alert('l\'éditeur est vide');
          }*/

          if( editor.getValue().length > 0 ) {

            // get the form data
            // there are many ways to get this data using jQuery (you can use the class or id also)
            var formData2 = {
                // 'name-fonction'        : $('input[name=name-fonction]').val(),
                // 'list-dependances-js'  : $('select[name=list-dependances-js]').val(),
                // 'list-dependances-css' : $('select[name=list-dependances-css]').val(),
                'path-file-editeur'    : $('input[name=path-file-editeur]').val(),
                // 'copy-file'            : $('input[name=copy-file]').val(),
                // 'path-file-copy'       : $('input[name=path-file-copy]').val(),
                'new-content'          : editor.getValue(),
            };


            // console.log(formData);

            // process the form
            $.ajax({
                type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url         : 'manage/editFiles', // the url where we want to POST
                data        : formData2, // our data object
                dataType    : 'html', // what type of data do we expect back from the server
                encode      : true
            })
            // using the done promise callback
            .done(function(data2) {

              // log data to the console so we can see
              // console.log(data); 

              // $('header nav').html(data2);

              $('<div class="alert alert-success fixed">\
                  <button type="button" class="close" data-dismiss="alert">x</button>\
                  <span class="glyphicon glyphicon-ok-circle"></span>\
                  Le fichier <b>'+nom_file+'</b> a bien été mis à jour\
                  </div>').prependTo('body');

          		$(".alert.fixed").fadeTo(2000, 500).slideUp(500, function(){

              $("#success-alert").slideUp(500);

							setTimeout(function()
					      {
					        $('.alert.fixed').remove();
					      }, 1000);
            	});

            	// $('#loading > div').css('width','100%');
            });
          }

        });
      }
            

		  window.onbeforeunload = function() {
        return "Did you save your stuff?"
      }

      if( $(":file").length > 0 ) {
		
				$(":file").filestyle();
			}


			var auto_refresh = setInterval(
        function() {
            $('#arborescence > #load-block').load('Vue/Manage/arborescence.php').fadeIn("slow");

            $('#arborescence').addClass('loaded');


            /*$('.wrapper-file').each(function() {

              var filename   = $(this).find('.nom-file').text();
              // var fileauteur = $(this).find('.fileauteur').text();

              if( filename == $('#wrapper-infos-files').find('.filename').text() )

              console.log(filename);
            });*/
        }, 3000); // refreshing after every 15000 milliseconds


      $('#delete-file-selected').click(function() {

        var selected = [];
        $('#folder-file input:checked').each(function() {
            selected.push($(this).attr('name'));
        });

        $.ajax({
            type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'Modele/simplycode.php', // the url where we want to POST
            data        : 'file-selected='+selected, // our data object
            dataType    : 'html', // what type of data do we expect back from the server
            encode      : true
        })
        // using the done promise callback
        .done(function(data) {

          console.log(data);

          $('#folder-file input:checked').closest('tr').fadeOut();
        });

        // console.log(selected);
      });


      lazyload();

    }

    var load_room = 1;

    displayResult(load_room);

    var auto_refresh = setInterval(
      function() {

        displayResult();
      }, 3000);
    /* Send Message */  
    
    $('.send_msg').on('click', function(){
      if($(this).parent('form').find('.msg').val() == ""){

        alert('Please write message first');
      } 
      else 
      {
        load_room   = 0;

        var $msg    = $(this).parent('form').find('.msg').val();
        var $id     = $(this).parent('form').find('.id').val();
        var $userid = $(this).parent('form').find('.userid').val();
        $.ajax({
          type: "POST",
          url: "utilisateurs/sendMessage",
          data: {
            msg: $msg,
            id: $id,
            userid: $userid,
            res: 0,
          },
          success: function(){
            displayResult(load_room);
          }
        });
      } 
    });

    function displayResult(load_room){

      $('#chat').find('.room').each(function() {

        var id = $(this).find('.id').attr('value');

        // console.log(id);

        var $this = $(this);

        $.ajax({
          url: 'chatroom',
          type: 'POST',
          data:{
            id: id,
            res: 1,
          },
          success: function(response){

            // console.log($(response).find('#wrapper-messages').html());

            $this.find('.result').html($(response).find('#wrapper-messages').html());

            if( load_room == 1 ) {

              var send_user = $this.find('.result .received:last > b').text();

              $this.closest('li').find('.room-name').text(send_user);
            }
          }
        });
      });
    }

	}));
}