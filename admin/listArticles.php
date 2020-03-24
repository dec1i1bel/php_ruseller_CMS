<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Articles</title>
</head>
<body>
<div id="adminHeader">
<h2>Панель управления || My Site</h2>
<p>Вы вошли как <b><?php echo htmlspecialchars($_SESSION['username']) ?></b></p> <p><a href="admin.php?action=logout">Сменить пользователя</a></p>
</div>
<h1>Все статьи</h1>
<?php if(isset($resuls['errorMessage'])) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

<?php if(isset($results['statusMessage'])) { ?>
  <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>

<table>
  <tr>
    <th>Дата публикации</th>
    <th>Заголовок</th>
  </tr>

  <?php foreach($results['articles'] as $article) { ?>
    <tr onclick="location=admin.php?action=editArticle&amp;articleId=<?php echo $article->id ?>">
      <td><?php echo date('j M Y', $article->publicationDate) ?></td>
      <td><?php echo $article->title ?></td>
    </tr>
  <?php } ?>
</table>
<p>Количество статей: <?php echo $results['totalRows'] ?></p>

<p><a href="admin.php?action=newArticle">Добавить</a></p>
</body>
</html>