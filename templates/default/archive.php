<?php include "include/header.php" ?>
<h1>Articles Archive</h1>
<ul id="headlines" class="archive">
  <?php
    foreach($results_arch['articles'] as $article) {
    ?>
    <li>
      <h2><span class="pubDate"><?php date('Y-m-d', $article->publicationDate) ?></span><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id ?>"><?php echo htmlspecialchars($article->title) ?></a></h2>
      <p class="summary"><?php echo htmlspecialchars($article->$summary) ?></p>
    </li>
  <?php } ?>
</ul>
<p><?php echo $results_arch['totalRows'] ?> article<?php echo ($results_arch['totalRows'] != 1) ? 's' : '' ?>in total.</p>
<p><a href="/ruseller_CMS">Return to Homepage</a></p>
<?php include "include/footer.php" ?>