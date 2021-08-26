<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open($url . '/add') ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input('name', '', 'class="form-control form-control-round" id="name" placeholder="User Name" required="true" maxLength="255"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input('mobile', '', 'class="form-control form-control-round" id="mobile" placeholder="User Mobile" required="true" maxLength="10"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input([
			'type' => 'email',
			'name' => 'email',
			'class' => "form-control form-control-round",
			'placeholder' => "Email Address",
			'id' => "email",
			'required' => "true",
			'maxLength' => "255"
			]) ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input([
			'type' => 'password',
			'name' => 'password',
			'class' => "form-control form-control-round",
			'placeholder' => "Password",
			'id' => "password",
			'required' => "true",
			'maxLength' => "255"
			]) ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<select class="select2" name="sub_role" id="sub_role" data-placeholder="Role">
				<option selected="" disabled="">Select Role</option>
				<?php foreach ($roles as $role): ?>
				<option value="<?= e_id($role['id']) ?>"><?= ucwords($role['role']) ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
</div>
<?= form_close() ?>