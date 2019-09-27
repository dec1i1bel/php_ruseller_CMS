<?php include "include/header.php" ?>
<h1><?php echo htmlspecialchars($results['article']->title) ?></h1>
<div><?php echo htmlspecialchars($results['article']->summary) ?></div>
<div><?php echo htmlspecialchars($results['article']->content) ?></div>
<p class="pubDate">Published on <?php echo date('Y-m-d', $results['article']->publicationDate) ?></p>

<p><a href="./">Return to Homepage</a></p>

<?php include "include/footer.php" ?>