<?php
/**\
 * @var string $title
 * @var string $issuerlist
 * @var string $html
 * @var array $messages
 */

?>

<div class="uk-panel uk-panel-box uk-text-center">

	<?php if ($title) : ?>
		<h1><?= $title ?></h1>
	<?php endif; ?>

	<div class="uk-flex uk-flex-center">
		<?php foreach ($messages as $message) : ?>
			<div class="uk-alert uk-width-medium-2-3"><?= $message ?></div>
		<?php endforeach; ?>
	</div>

	<?= $issuerlist ?>

	<?= $html ?>

</div>
