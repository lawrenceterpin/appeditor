<?php
if ($handle = opendir('../../Games/projet_1/js')) {

	function formatSizeUnits($bytes)
	{
		if ($bytes >= 1073741824)
		{
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		}
		elseif ($bytes >= 1048576)
		{
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		}
		elseif ($bytes >= 1024)
		{
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		}
		elseif ($bytes > 1)
		{
			$bytes = $bytes . ' bytes';
		}
		elseif ($bytes == 1)
		{
			$bytes = $bytes . ' byte';
		}
		else
		{
			$bytes = '0 bytes';
		}

		return $bytes;
	}

	function scan_dir($dir,$entry) {

    $ignored = array('.', '..');

    $files = array();    
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
    }

    arsort($files);
    $files = array_keys($files);

    $nb_files = count($files);

    if( $nb_files > 0 ) {

	    echo "<ul>";

	    foreach ($files as $file) {

	    	$size_file_b = filesize($dir.'/'.$file);

	    	$size_file = formatSizeUnits($size_file_b);

	    	// $split_file = explode(".", $file);
	    	?>

	    	<li class="sub-version clearfix">
              <form class="form-file-edit" method="post" action="">
                <div class="wrapper-file clearfix">
                    <input type="submit" class="pub-file pull-right btn btn-success" name="pub-file" value="publier">
                  <span class="nom-file"><?php echo $file;?></span>
                  <input type="hidden" name="path-file-edit" class="path-file-edit" value="<?php echo $dir;?>/<?php echo $file;?>">
                  <input type="hidden" name="path-file-pub" class="path-file-pub" value="/volume1/web/appeditor/Games/projet_1/js/<?php echo $entry; ?>">
                  <input type="submit" class="edit-file pull-right btn btn-primary" name="edit-file" value="éditer">
                  <span class="date-modification pull-right"><i>mis à jour le <?php echo date("d/m/Y à H:i",filemtime($dir.'/'.$file));?></i></span>
                  <span class="poids pull-right"><?php echo $size_file; ?></span>
                  <span class="fileauteur"></span>
                </div>
              </form>
            </li>

	    	<?php
	    }

	    echo "</ul>";
	  }
	}

	echo "
	<ul>
		<li>
			<label>&nbsp;&nbsp;&nbsp;js/</label>
			<ul>";

		    while (false !== ($entry = readdir($handle))) {

		        if ($entry != "." && $entry != ".." && strtolower(substr($entry, strrpos($entry, '.') + 1)) == 'js') {

		        	$size_file_b = filesize('/volume1/web/appeditor/Games/projet_1/js/'.$entry);

	    				$size_file = formatSizeUnits($size_file_b);

	    				// $key = array_search('green', $array); // $key = 2;

		          echo '
		          <li class="clearfix">
		          	<form class="form-file-pub" method="post" action="">
		          		<div class="wrapper-file clearfix">
				          	<span class="nom-file">'.$entry.'</span>
				          	<input type="hidden" name="path-file-pub" class="path-file-pub" value="/volume1/web/appeditor/Games/projet_1/js/'.$entry.'">
				          	<input type="submit" class="edit-file new-version pull-right btn btn-default" name="edit-file" value="créer une copie">
			          		<span class="glyphicon glyphicon-duplicate pull-right"></span>
			          		<span class="date-modification pull-right"><i>mis à jour le '.date("d/m/Y à H:i",filemtime('/volume1/web/appeditor/Games/projet_1/js/'.$entry)).'</i></span>
			          		<span class="poids pull-right">'.$size_file.'</span>
			          	</div>
		          	</form>';

		          	$split_entry = explode(".", $entry);

				      	$dirname = '/volume1/web/appeditor/Games/projet_1/js/'.$split_entry[0];

		          	if (file_exists($dirname)) {

		          		// echo 'ok existe';
		          		scan_dir($dirname,$entry);
		          	}

		          echo '</li>';
		        }
		    }

        echo "</ul>
            </li>
        </ul>";

  closedir($handle);
}
?>