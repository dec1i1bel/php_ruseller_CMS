<?php include "include/header.php"; ?>
<h1>Архив статей</h1>
<ul id="headlines" class="archive">
  <?php
    foreach($results['articles'] as $article) {
    ?>
    <li>
      <h2><span class="pubDate"><?php echo date('Y-m-d', $article->publicationDate) ?></span><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id ?>"><?php echo htmlspecialchars($article->title) ?></a></h2>
      <p class="summary"><?php echo htmlspecialchars($article->summary) ?></p>
    </li>
  <?php } ?>
</ul>
<p>Общее количество статей: <?php echo $results['totalRows'] ?></p>
<p><a href="/php_ruseller_CMS">На главную</a></p>
<?php include "include/footer.php" ?>