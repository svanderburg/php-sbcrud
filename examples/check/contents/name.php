<p>
	You can provide your name as a path parameter to receive a greeting.
	You can use the <strong>greeting</strong> GET parameter to change the default value to something else.
	Keep in mind that strings and names are not allowed to be longer than 10 characters.
</p>
<p>
	<?php
	$url = $_SERVER["PHP_SELF"]."/sander?greeting=Hi";
	?>
	An example: <a href="<?= $url ?>"><?= $url ?></a>
</p>
