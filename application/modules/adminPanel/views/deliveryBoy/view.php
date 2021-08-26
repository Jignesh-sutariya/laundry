<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input('name', $data['name'], 'class="form-control form-control-round" readonly=""') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input('mobile', $data['mobile'], 'class="form-control form-control-round" readonly=""') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input([
			'class' => "form-control form-control-round",
			'readonly' => "",
			'value' => $data['email']
			]) ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input('licenceno', $data['licenceno'], ['class' => "form-control form-control-round", 'readonly' => ""]); ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_input('address', $data['address'], ['class' => "form-control form-control-round", 'readonly' => ""]); ?>
		</div>
	</div>
</div>