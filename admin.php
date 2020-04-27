<?php
require('config.php');
session_start();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

if( $action != 'login' && $action != 'logout'&& !$username ) {
  login();
  exit;
}

switch ( $action ) {
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
  $results['pageTitle'] = 'Введите логин и пароль';
  if( isset( $_POST['login'] ) ) {

    // Пользователь получает форму входа: попытка авторизировать пользователя
    if( $_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD ) {

      // Вход прошел успешно: создаем сессию и перенаправляем на страницу администратора
      $_SESSION['username'] = ADMIN_USERNAME;
      header( 'Location: admin.php' );
    } else {

      // Ошибка входа: выводим сообщение об ошибке для пользователя
      $results['errorMessage'] = 'Неверные имя пользователя и/или пароль. Попробуйте снова.';
      require('admin/loginForm.php');
    }
  } else {

    // Пользователь еще не получил форму: выводим её
    require(TEMPLATE_PATH . '/admin/loginForm.php');
  }
}

function logout() {
  unset( $_SESSION['username'] );
  header( 'Location: admin.php' );
}

function newArticle() {
  $results = array();
  $results['pageTitle'] = 'Новая статья';
  $results['formAction'] = 'newArticle';
  
  if( isset( $_POST['saveChanges'] ) ) {

    // Пользователь получает форму редактирования статьи: сохраняем новую статью
    $article = new Article;
    $article->storeFormValues( $_POST );
    $article->insert();
    header('Location: admin.php?status=newArticleSaved');
  } elseif( isset( $_POST['cancel'] ) ) {

    // Пользователь сбросил результаты редактирования: возвращаемся к списку статей
    header( 'Location: admin.php' );
  } else {
    
    // Пользователь еще не получил форму редактирования: выводим форму
    $results['article'] = new Article;
    require(TEMPLATE_PATH . '/admin/editArticle.php');
  }
}

function editArticle() {
  $results = array();
  $results['pageTitle'] = 'Редактирование статьи';
  $results['formAction'] = 'editArticle';

  if(isset($_POST['saveChanges'])) {
  // if( isset( $_GET['status'] ) && $_GET['status'] == 'newArticleSaved') {
      echo 'Changes saved successfully';
    // пользователь получил форму редактирования статьи: сохраняем изменения
    if( !$article = Article::getById( (int) $_POST['articleId']) ) {
      header( 'Location: admin.php?error=articleNotFound' );
      return;
    }
    // $article = new Article();
    $article->storeFormValues( $_POST );
    $article->update();
    header( 'Location: admin.php?status=changesSaved' );
  } elseif ( isset($_POST['cancel'] ) ) {
    // пользователь отказался от редактирования: возвращаемся к списку статей
    header( 'Location: admin.php' );
  } else {
    // форма редактирования ещё не выводилась: выводим
    $results['article'] = Article::getById( (int)$_GET['articleId'] );
    require( TEMPLATE_PATH . '/admin/editArticle.php' );
  }
}

function deleteArticle() {
  if( !$article = Article::getById( (int)$_GET['articleId'] ) ) {
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
  $results['pageTitle'] = 'Список статей';

  if(isset($_GET['error'])) {
    if( $_GET['error'] == 'articleNotFound' ) $results['errorMessage'] = 'Ошибка: статья не найдена.';
  }

  if( isset( $_GET['status'] ) ) {
    if($_GET['status'] == 'changesSaved' ) $results['statusMessage'] = 'Изменения сохранены.';
    if( $_GET['status'] == 'articleDeleted' ) $results['statusMessage'] = 'Статья удалена.';
  }
  require(TEMPLATE_PATH . '/admin/listArticles.php');
}
?>