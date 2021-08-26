<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open_multipart($url . '/add') ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input('cat_name', '', 'class="form-control form-control-round" id="cat_name" placeholder="Category Name" required="true" maxLength="50"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<?= form_label('<i class="fa fa-image" ></i>Select Image', 'image', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block col-md-6']) ?>
		<?= form_input([
		'style' => "display: none;",
		'type' => "file",
		'id' => "image",
		'name' => "image",
		'accept' => "image/png, image/jpg, image/jpeg"
		]) ?>
	</div>
</div>
<?= form_close() ?>