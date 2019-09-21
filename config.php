<?php
ini_set('display_errors', true);
date_default_timezone_set('Europe/Moscow');
define('DB_DSN', 'mysql:host=localhost; dbname=ruseller_cms');
define('DB_USERNAME', 'user1');
define('DB_PASSWORD', 'Vkshmuk:0707');
define('CLASS_PATH', 'classes');
define('TEMPLATE_PATH', 'templates');
define('HOMEPAGE_NUM_ARTICLES', 5);
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin');
require(CLASS_PATH ."/article.php");

function handleException($exception) {
  echo '<p>Sorry, a problem occured. Please try later</p>';
}

set_exception_handler('handleException');
?>
