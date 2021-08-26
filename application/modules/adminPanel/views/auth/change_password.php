<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?= form_open(admin('changePassword'), 'class="md-float-material form-material"') ?>
<div class="auth-box card">
	<div class="card-block">
		<div class="row m-b-20">
			<div class="col-md-12">
				<h3 class="text-center"><?= ucfirst($title) ?></h3>
			</div>
		</div>
		<div class="form-group form-primary">
			<?= form_input([
			'name' => 'password',
			'class' => "form-control",
			'type' => "password",
			'required' => "",
			'placeholder' => "New Password"
			]); ?>
			<?= form_error('password') ?>
		</div>
		<div class="form-group form-primary">
			<?= form_input([
			'name' => 'confirm_password',
			'class' => "form-control",
			'type' => "password",
			'required' => "",
			'placeholder' => "Confirm Password"
			]); ?>
			<?= form_error('confirm_password') ?>
		</div>
		<div class="row m-t-30">
			<div class="col-md-12">
				<?= form_submit('', 'Change Password', 'class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20"'); ?>
			</div>
		</div>
	</div>
</div>
<?= form_close(); ?>