<?php
function message_alert($message, $state_alert) {
	
	if( empty($state_alert) ) {
		
		$state_alert = 'success';
	}

	echo '<div class="alert alert-'.$state_alert.' fixed">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					'.$message.'
				</div>';
}