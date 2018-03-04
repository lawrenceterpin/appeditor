<?php
function control_json($json) {

	foreach ($json as $string) {
	  echo 'Décodage : ' . $string;
	  json_decode($string);

	  switch (json_last_error()) {
	      case JSON_ERROR_NONE:
	          echo ' - Aucune erreur';
	      break;
	      case JSON_ERROR_DEPTH:
	          echo ' - Profondeur maximale atteinte';
	      break;
	      case JSON_ERROR_STATE_MISMATCH:
	          echo ' - Inadéquation des modes ou underflow';
	      break;
	      case JSON_ERROR_CTRL_CHAR:
	          echo ' - Erreur lors du contrôle des caractères';
	      break;
	      case JSON_ERROR_SYNTAX:
	          echo ' - Erreur de syntaxe ; JSON malformé';
	      break;
	      case JSON_ERROR_UTF8:
	          echo ' - Caractères UTF-8 malformés, probablement une erreur d\'encodage';
	      break;
	      default:
	          echo ' - Erreur inconnue';
	      break;
	  }

	  echo PHP_EOL;
	}
}