<?php
foreach ($pages as $page): 
?>
  <li>
  	<div class='content-page'>

  		<?php
      $is_logged = true;
      
  		if( $is_logged == true )  {
  		?>

	  		<form id="form_updatePage" method="post" action="index.php?p_action=updatePage">
	  			<textarea class="form-control" name="content-page"><?php echo $page["content"];?></textarea>
	  			<input type="hidden" name="id-page" value="<?php echo $page["id"]; ?>">
	  			<input type="submit" name="updatePage" value="modifier la page" class="btn btn-default">
	  		</form>

  		<?php
  		} 
  		else 
  		{
  		?>

  			<p><?php echo $page["content"];?></p>

  		<?php
  		}
  		?>
  	</div>
  </li>
<?php 
endforeach;
?>