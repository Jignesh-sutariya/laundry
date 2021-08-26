<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open($url."/assign/$id") ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<select name="del_boy" class="form-control form-control-round">
				<option selected="" disabled="" >Select Delivery Boy</option>
				<?php foreach ($boys as $c): ?>
				<option value="<?= e_id($c['id']) ?>"><?= $c['name'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_input('admin_note', '', 'class="form-control form-control-round" placeholder="Remarks (if any)"') ?>
		</div>
	</div>
</div>
<?= form_close() ?>