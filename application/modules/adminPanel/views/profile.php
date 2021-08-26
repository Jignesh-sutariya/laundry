<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h5 class="title">Update Profile</h5>
		</div>
		<div class="card-body">
			<?= form_open($url.'profile') ?>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<?= form_label('User Name', 'name') ?>
						<?= form_input('name', auth()->name, [
							'class' => "form-control form-control-round",
							'placeholder' => "User Name",
							'id' => "name",
							'required' => "true",
							'maxLength' => "255"
						]) ?>
						<?= form_error('name') ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Mobile No.', 'mobile') ?>
						<?= form_input('mobile', auth()->mobile, [
							'class' => "form-control form-control-round",
							'placeholder' => "Mobile No.",
							'id' => "mobile",
							'required' => "true",
							'maxLength' => "10",
							'number' => "true"
						]) ?>
						<?= form_error('mobile') ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Email Address', 'email') ?>
						<?= form_input([
							'type' => 'email',
							'name' => 'email',
							'class' => "form-control form-control-round",
							'placeholder' => "Email Address",
							'id' => "email",
							'required' => "true",
							'maxLength' => "255",
							'number' => "true",
							'value' => auth()->email
						]) ?>
						<?= form_error('email') ?>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<?= form_label('Password', 'password') ?>
						<?= form_input([
							'type' => 'password',
							'name' => 'password',
							'class' => "form-control form-control-round",
							'placeholder' => "Password",
							'id' => "password",
							'maxLength' => "255"
						]) ?>
					</div>
				</div>
				<div class="col-md-12">
					<?= form_button([ 'content' => 'Update Profile',
					'type'  => 'submit',
					'class' => 'btn btn-outline-info btn-round col-md-3']) ?>
					<?= anchor($url, 'Go back', ['class' => 'btn btn-outline-danger btn-round col-md-3']) ?>
				</div>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>