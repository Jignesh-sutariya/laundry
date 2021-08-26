<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open($url."/update/$id") ?>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<?= form_input('address', $data['address'], 'class="form-control form-control-round" id="address" placeholder="Shop Address"') ?>
		</div>
	</div>
</div>
<?= form_close() ?>