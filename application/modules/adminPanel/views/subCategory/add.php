<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open_multipart($url . '/add') ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<select name="cat_id" class="form-control form-control-round">
				<option selected="" disabled="" >Select Category</option>
				<?php foreach ($cats as $k => $c): ?>
				<option value="<?= e_id($c['id']) ?>" ><?= $c['cat_name'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input('sub_cat_name', '', 'class="form-control form-control-round" id="sub_cat_name" placeholder="Sub Category Name" required="true" maxLength="50"') ?>
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