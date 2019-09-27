<?php
ini_set('display_errors', true);
date_default_timezone_set('Europe/Moscow');
define('DB_DSN', 'mysql:host=localhost; port=3306; dbname=ruseller_cms');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('CLASS_PATH', 'classes');
define('TEMPLATE_PATH', 'templates/default');
define('HOMEPAGE_NUM_ARTICLES', 5);
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin');
require(CLASS_PATH ."/article.php");

function handleException($exception) {
  echo '<p>Sorry, a problem occured. Please try later</p>';
}

set_exception_handler('handleException');
?>