<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?= form_open(admin('login'), 'class="md-float-material form-material" name="login"') ?>
<div class="auth-box card">
	<div class="card-block">
		<div class="row m-b-20">
			<div class="col-md-12">
				<h3 class="text-center"><?= ucfirst($title) ?></h3>
			</div>
		</div>
		<div class="form-group form-primary">
			<?= form_input('mobile', set_value('mobile'), [
			'class' => "form-control",
			'required' => "",
			'maxlength' => 10,
			'placeholder' => "Your Mobile"
			]); ?>
		</div>
		<div class="form-group form-primary">
			<?= form_input([
			'name' => 'password',
			'class' => "form-control",
			'type' => "password",
			'required' => "",
			'placeholder' => "Your Password"
			]); ?>
		</div>
		<div class="row m-t-25 text-left">
			<div class="col-md-12">
				<div class="forgot-phone text-right f-right">
					<?= anchor(admin('forgot-password'), 'Forgot Password?', 'class="text-right f-w-600"'); ?>
				</div>
			</div>
		</div>
		<div class="row m-t-30">
			<div class="col-md-12">
				<?= form_submit('', 'Sign In', 'class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20"'); ?>
			</div>
		</div>
	</div>
</div>
<?= form_close(); ?>