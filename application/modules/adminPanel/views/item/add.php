<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open($url . '/add') ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<select name="cat_id" class="form-control form-control-round" id="cat_id" data-dependent="sub_cat_id" data-value="" onchange="getSubCats(this)">
				<option selected="" disabled="" >Select Category</option>
				<?php foreach ($cats as $k => $c): ?>
				<option value="<?= e_id($c['id']) ?>" ><?= $c['cat_name'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<select name="sub_cat_id" id="sub_cat_id" class="form-control form-control-round" >
				<option selected="" disabled="" >Select Sub Category</option>
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input('item_name', '', 'class="form-control form-control-round" id="item_name" placeholder="Item Name" required="true" maxLength="50"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input('price', '', 'class="form-control form-control-round" id="price" placeholder="Item Price" required="true" maxLength="10"') ?>
		</div>
	</div>
</div>
<?= form_close() ?>