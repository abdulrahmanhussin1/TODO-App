<?php 
require_once '../../App.php';

$session->remove("loggedIn");

$request->redirect("../../index.php");

?>
