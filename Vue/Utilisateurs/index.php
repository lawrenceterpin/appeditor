<div class="container">
	<div class="row">
	
		<?php 
		$this->titre = "Tous les utilisateurs"; 
		?>
		
		<h1 class="page-header">Tous les utilisateurs</h1>
		
		<?php
		foreach ($utilisateurs as $utilisateur):
		?>
		  <article>
		      <header>
		          <a href="">
		              <h1><?= $this->nettoyer($utilisateur['login']) ?></h1>
		          </a>
		      </header>
		  </article>
		  <hr />
		<?php endforeach; ?>



		<ul id="chat" class="clearfix">
			<?php
				foreach ($chatrooms as $chatroom) {
					?>
					<li class="pull-left">
						<button type="button" class="room-name btn btn-info" data-toggle="collapse" data-target="#room-<?php echo $chatroom['chat_room_id']; ?>">
							...	
						</button>
						<div id="room-<?php echo $chatroom['chat_room_id']; ?>" class="collapse">
							<div class="room">
								<div class="result" style="overflow-y:scroll; height:300px;">

								</div>
								<form class="clearfix">
									<textarea class="msg form-control" placeholder="Tapez votre message..."></textarea>
									<input type="hidden" value="<?php echo $chatroom['chat_room_id']; ?>" class="id">
									<input type="hidden" class="userid" value="<?php echo $login_actif['idUtilisateur'];?>">
									<br>
									<button type="button" class="send_msg btn btn-primary pull-right">Envoyer</button>
								</form>
							</div>
						</div>
					</li>
					<?php
				}
			?>
		</ul>
	
	</div>

</div>