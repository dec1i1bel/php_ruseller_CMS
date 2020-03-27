<?php include(TEMPLATE_PATH . '/include/header.php') ?>

<div id="adminHeader">
<!-- <h2>Список статей</h2> -->
<p>Пользователь: <b><?php echo htmlspecialchars($_SESSION['username']) ?></b>. <a href="admin.php?action=logout">Выйти</a></p>
</p>
</div>
<h2><?php echo htmlspecialchars($results['pageTitle']) ?></h2>
<?php if(isset($resuls['errorMessage'])) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

<?php if(isset($results['statusMessage'])) { ?>
  <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>

<table>
  <tr>
    <th>ID статьи</th>
    <th>Дата публикации</th>
    <th>Заголовок</th>
  </tr>

  <?php foreach($results['articles'] as $article) { ?>
    <tr onclick="location='admin.php?action=editArticle&amp;articleId=<?php echo $article->id ?>'">
      <td><?php echo $article->id ?></td>
      <td><?php echo date('j M Y', $article->publicationDate) ?></td>
      <td><?php echo $article->title ?></td>
    </tr>
  <?php } ?>
</table>
<p>Количество статей: <?php echo $results['totalRows'] ?></p>

<p><a href="admin.php?action=newArticle">Добавить</a></p>

<?php include(TEMPLATE_PATH . '/include/footer.php') ?>