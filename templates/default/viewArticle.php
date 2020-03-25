<?php include "include/header.php" ?>
<h1><?php echo htmlspecialchars($results['article']->title) ?></h1>
<h4><?php echo htmlspecialchars($results['article']->summary) ?></h4>
<p><?php echo htmlspecialchars($results['article']->content) ?></p>
<p class="pubDate"><i>Дата публикации: <?php echo date('m-d-Y', $results['article']->publicationDate) ?></i></p>

<p><a href="./">На главную</a></p>

<?php include "include/footer.php" ?>