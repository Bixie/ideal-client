<?php
/**\
 * @var string $title
 * @var string $issuerlist
 * @var string $html
 * @var string $order_id
 * @var string $transaction_amount
 * @var string $transaction_description
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
	<?php if ($transaction_description && $transaction_amount) : ?>
		<p><?= $transaction_description ?>, € <?= number_format($transaction_amount, 2, ',', '.') ?></p>
	<?php endif; ?>

	<?= $issuerlist ?>

	<?= $html ?>

</div>
