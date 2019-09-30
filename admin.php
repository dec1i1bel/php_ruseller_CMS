<?php
error_reporting(0);
require('config.php');
session_start();
$action = isset($_GET['action']) ? $_GET['action'] : "";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";

if($action != 'login' && $action != 'logout'&& !$username) {
  login();
  exit;
}

switch ($action) {
  case 'login':
    login();
    break;
  case 'logout':
    logout();
    break;
  case 'newArticle':
    newArticle();
    break;
  case 'editArticle':
    editArticle();
    break;
  case 'deleteArticle':
    deleteArticle();
    break;
  default:
    listArticles();
}

function login() {
  $results = array();
  $results['pageTitle'] = 'Adminlogin | Widget News';

  if(isset($_POST)) {

    // Пользователь получает форму входа: попытка авторизировать пользователя
    if($_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD) {

      // Вход прошел успешно: создаем сессию и перенаправляем на страницу администратора
      $_SESSION['username'] = ADMIN_USERNAME;
      header('Location: admin.php');
    } else {

      // Ошибка входа: выводим сообщение об ошибке для пользователя
      $results['errorMessage'] = 'Incorrect username or password. Please try again.';
      require('admin/loginForm.php');
    }
  } else {

    // Пользователь еще не получил форму: выводим её
    require('admin/loginForm.php');
  }
}

function logout() {
  unset($_SESSION['username']);
  header('Location: admin.php');
}

function newArticle() {
  $results = array();
  $results['pageTitle'] = 'NewArticle';
  $reuslts['formAction'] = 'newArticle';
  
  if(isset($_POST['saveChanges'])) {

    // Пользователь получает форму редактирования статьи: сохраняем новую статью
    $article = new Article;
    $article->storeFormValues($_POST);
    $article->insert();
    header('Location: admin.php?status=changeSaved');
  } elseif(isset($_POST['cancel'])) {

    // Пользователь сбросил результаты редактирования: возвращаемся к списку статей
    header('Location: admin.php');
  } else {
    
    // Пользователь еще не получил форму редактирования: выводим форму
    $results['article'] = Article::getById((int)$_GET['articleId']);
    require(TEMPLATE_PATH . '/admin/editArticle.php');
  }
}

function deleteArticle() {
  if(!$article = Article::getById((int)$_GET['articleId'])) {
    header('Location: admin.php?error=articleNotFound');
    return;
  }

  $article->delete();
  header('Location: admin.php?status=articleDeleted');
}

function listArticles() {
  $results = array();
  $data = Article::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = 'All articles';

  if(isset($_GET['error'])) {
    if($_GET['error'] == 'articleNotFound') $results['errorMessage'] = 'Error: Articlenot found.';
  }

  if(isset($_GET['status'])) {
    if($_GET['status'] == 'changesSaved') $results['statusMessage'] = 'You changes have been saved.';
    if($_GET['status'] == 'articleDeleted') $results['statusMessage'] = 'Article deleted.';
  }
  require(TEMPLATE_PATH . '/admin/listArticles.php');
}
?>