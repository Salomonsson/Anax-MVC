<article class="article1">
 
 <h4>Detta är redovisning view</h4>
<?=$content?>
 
<?php if(isset($byline)) : ?>
<footer class="byline">
<?=$byline?>
</footer>
<?php endif; ?>
 
</article>