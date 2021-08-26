<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-sm-12">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-6">
					<h5>List of <?= ucwords($title) ?></h5>
				</div>
				<div class="col-md-6">
					<?= form_open_multipart("$url/add") ?>
					<?= form_label('<i class="fa fa-upload" ></i>Upload Banner', 'banner', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-6']) ?>
					<?= form_input([
					'style' => "display: none;",
					'type' => "file",
					'id' => "banner",
					'name' => "banner",
					'accept' => "image/png, image/jpg, image/jpeg",
					'onchange' => "bulkUpload(this.form)"
					]) ?>
					<?= form_close() ?>
				</div>
			</div>
		</div>
		<div class="card-block">
			<div class="dt-responsive table-responsive">
				<table class="datatable table table-striped table-bordered nowrap">
					<thead>
						<th class="target">Sr.</th>
						<th>Banner</th>
						<th class="target">Action</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>