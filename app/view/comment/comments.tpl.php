<hr>

<h2>Commentsss</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $comment) : ?>
	<h4>Comment #<?=$id?> (<?=$comment['name'] ?>)</h4>
	<p><?=dump($comment['content'])?></p>
<?php endforeach; ?>
</div>
<?php endif; ?>