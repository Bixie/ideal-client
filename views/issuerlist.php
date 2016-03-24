<?php
/**\
 * @var string $action
 * @var array $issuers
 */

?>

<form class="uk-form" action="<?=$action?>" method="post">

	<label for="issuer_id">Please select your bank</label><br>

	<select name="issuer_id" id="issuer_id">
		<?php foreach ($issuers as $value => $label) : ?>
			<option value="<?= $value ?>"><?= $label ?></option>
		<?php endforeach; ?>
	</select><br>

	<button class="uk-button uk-margin">Continue<i class="uk-icon-angle-double-right uk-margin-small-left"></i></button>
</form>
