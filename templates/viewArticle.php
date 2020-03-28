<?php include "include/header.php" ?>
<div id="headlines">
  <h1><?php echo htmlspecialchars($results['article']->title) ?></h1>
  <h4><?php echo htmlspecialchars($results['article']->summary) ?></h4>
  <p><?php echo htmlspecialchars($results['article']->content) ?></p>
  <p class="pubDate"><i><?php echo date('m-d-Y', $results['article']->publicationDate) ?></i></p>
</div>

<p><a href="./">На главную</a></p>

<?php include "include/footer.php" ?>