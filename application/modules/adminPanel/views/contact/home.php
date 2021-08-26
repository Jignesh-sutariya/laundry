<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h5 class="title">Update <?= $title ?></h5>
		</div>
		<div class="card-body">
			<?= form_open($url, '', ['lat' => $data['lat'], 'lng' => $data['lng']]) ?>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<?= form_label('Address', 'address') ?>
						<?= form_input('address', $data['address'], [
						'class' => "form-control form-control-round",
						'placeholder' => "Address",
						'id' => "address"
						]) ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Mobile No.', 'mobile') ?>
						<?= form_input('mobile', $data['mobile'], [
						'class' => "form-control form-control-round",
						'placeholder' => "Mobile No.",
						'id' => "mobile",
						'maxLength' => "10"
						]) ?>
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
						'maxLength' => "255",
						'value' => $data['email']
						]) ?>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<?= form_label('About Us', 'about') ?>
						<?= form_textarea('about', $data['about'], 'class="form-control ckeditor" id="about" placeholder="About Us"') ?>
					</div>
				</div>
				<div class="col-md-12">
					<?= form_button([ 'content' => 'Update About',
					'type'  => 'submit',
					'class' => 'btn btn-outline-info btn-round col-md-3']) ?>
					<?= anchor($url, 'Go back', ['class' => 'btn btn-outline-danger btn-round col-md-3']) ?>
				</div>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>