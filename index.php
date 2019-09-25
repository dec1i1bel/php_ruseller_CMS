<?php
/** TODO:
 * создать на хостинге пустую бд
 * дописать в конфиг пользователя и пароль бд
 * посмотреть, как конфиг сам создаст бд по инструкции IF NOT EXISTS
 */
require("config.php");
$action = isset($_GET['action']) ? $_GET['action'] : "";
// phpinfo();
?>
<ul>
  <li>$_GET :: <?php var_dump($_GET) ?></li>
<?php
switch($action) {
  case 'archive':
    archive();
    break;
  case 'viewArticle':
    viewArticle();
    break;
  default:
    homepage();
}

function archive() {
  $results = array();
  $data = Article::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Articles Archive | Widget News";
  require(TEMPLATE_PATH . "/archive.php");
}

function viewArticle() {
  if(!isset($_GET['articleId']) || !$_GET['articleId']) {
    homepage();
    return;
  }
  $results = array();
  $results['article'] = Article::getById((int)$_GET['articleId']);
  $results['pageTitle'] = $results['article']->title . " | Widget News";
  require(TEMPLATE_PATH . '/viewArticle.php');
}

function homepage() {
  $results = array();
  $data = Article::getList(HOMEPAGE_NUM_ARTICLES);
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = 'Widget News';
  require(TEMPLATE_PATH . '/homepage.php');
}
?>
