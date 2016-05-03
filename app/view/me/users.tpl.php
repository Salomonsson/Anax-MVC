<div id="user">
	<h1><?=$title?></h1>
	 

	<?php foreach ($users as $user) : ?>
	 
	<!-- <pre><?=var_dump($user->getProperties())?></pre> -->
	<pre>
		<?=$user->id?>: <?=$user->name?> , <?=$user->email?>  - <a href='<?=$this->url->create('users/id/' . $user->id )?>'>Visa Användare</a>
	</pre>
	 
	<?php endforeach; ?>

	<p><a href='<?=$this->url->create('redovisning')?>'>Tillbaka</a></p>
</div>