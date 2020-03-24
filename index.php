<?php
require("config.php");
$action = isset($_GET['action']) ? $_GET['action'] : "";
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
  $results_arch = array();
  $data_arch = Article::getList(HOMEPAGE_NUM_ARTICLES);
  $results_arch['articles'] = $data_arch['results'];
  $results_arch['totalRows'] = $data_arch['totalRows'];
  $results_arch['pageTitle'] = "Articles Archive | My Site";
  require(TEMPLATE_PATH . "/archive.php");
}

function viewArticle() {
  if(!isset($_GET['articleId']) || !$_GET['articleId']) {
    homepage();
    return;
  }
  $results = array();
  $results['article'] = Article::getById((int)$_GET['articleId']);
  $results['pageTitle'] = $results['article']->title . " | My Site";
  require(TEMPLATE_PATH . '/viewArticle.php');
}

function homepage() {
  $results = array();
  $data = Article::getList(HOMEPAGE_NUM_ARTICLES);
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = 'My Site';
  require(TEMPLATE_PATH . '/homepage.php');
}
?>
