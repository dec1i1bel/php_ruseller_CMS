<?php include "include/header.php" ?>
<ul id="headlines">
  <?php
    foreach($results['articles'] as $article) {
      ?>
        <li>
          <h2>
            <a href=".?action=viewArticle&amp;articleId=<?php echo $article->id ?>"><?php echo htmlspecialchars($article->title) ?></a>
          </h2>
          <span class="pubDate">
              <?php echo date ('Y-m-d', $article->publicationDate) ?>
            </span>
          <p class="summary"><?php echo htmlspecialchars($article->summary) ?></p>
        </li>
      <?php } ?>
</ul>
<p><a href="./?action=archive">Архив статей</a></p>
<?php include "include/footer.php" ?>