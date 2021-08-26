<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?= form_open(admin('checkOtp'), 'class="md-float-material form-material"') ?>
<div class="auth-box card">
	<div class="card-block">
		<div class="row m-b-20">
			<div class="col-md-12">
				<h3 class="text-center"><?= ucfirst($title) ?></h3>
			</div>
		</div>
		<div class="form-group form-primary">
			<?= form_input('otp', set_value('otp'), [
			'class' => "form-control",
			'required' => "",
			'maxlength' => 4,
			'placeholder' => "Enter OTP"
			]); ?>
			<?= form_error('otp') ?>
		</div>
		<div class="row m-t-30">
			<div class="col-md-12">
				<?= form_submit('', 'OTP Verify', 'class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20"'); ?>
			</div>
		</div>
	</div>
</div>
<?= form_close(); ?>