<ul id="wrapper-messages">

	<?php
	foreach ($chatroom as $chatroom_message) {

		if( $chatroom_message["UTIL_ID"] == $login_actif['idUtilisateur'] ) {

	      $type_message = 'send';
	      $text_message = '<b>Vous</b>';
	  }
	  else {
	      $type_message = 'received';
	      $text_message = '<b>'.$chatroom_message["UTIL_LOGIN"].'</b>';
	  }

	  echo "<li class='".$type_message."'>";

	      echo $text_message.'<br>';

	      echo '<div class="message">'.$chatroom_message['chat_msg'].'</div>';

	  echo "</li>";
	}
	?>
	
</ul>