<?php

/**
 *  Cette page PHP détruit une session utilisateur et redirige vers la page principale.
 */

	session_start();
	session_destroy();
	header('Location:  ../page_principale.php');
	exit;

?>