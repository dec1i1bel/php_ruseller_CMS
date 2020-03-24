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
<h2>My Site Admin</h2>
<p>You are logged in as <b><?php echo htmlspecialchars($_SESSION['username']) ?></b><a href="admin.php?action=logout">Logout</a></p>
</div>
<h1>All Articles</h1>
<?php if(isset($resuls['errorMessage'])) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

<?php if(isset($results['statusMessage'])) { ?>
  <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>

<table>
  <tr>
    <th>Publication Date</th>
    <th>Article</th>
  </tr>

  <?php foreach($results['articles'] as $article) { ?>
    <tr onclick="location=admin.php?action=editArticle&amp;articleId=<?php echo $article->id ?>">
      <td><?php echo date('j M Y', $article->publicationDate) ?></td>
      <td><?php echo $article->title ?></td>
    </tr>
  <?php } ?>
</table>
<p><?php echo $results['totalRows'] ?>article<?php echo($results['totalRows'] != 1) ? 's' : '' ?> in total.</p>

<p><a href="admin.php?action=newArticle">Add new article</a></p>
</body>
</html>