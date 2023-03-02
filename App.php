<?php
require_once 'inc/connection.php';
require_once 'classes/Request.php';
require_once 'classes/Session.php';
require_once 'classes/DB.php';
require_once 'classes/validation/Required.php';
require_once 'classes/validation/Email.php';
require_once 'classes/validation/maxLength.php';
require_once 'classes/validation/minLength.php';
require_once 'classes/validation/Str.php';
require_once 'classes/Validation.php';

$request = new Request;
$session = new Session;
$validation = new Validation;
