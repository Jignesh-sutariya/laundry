<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-sm-12">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-2">
					<button class="btn btn-outline-primary btn-round btn-block" onclick="changeStatus('New order')">New</button>
				</div>
				<div class="col-md-2">
					<button class="btn btn-warning btn-outline-warning btn-round btn-block" onclick="changeStatus('Pickup')">Pick up</button>
				</div>
				<div class="col-md-2">
					<button class="btn btn-outline-info btn-round btn-block" onclick="changeStatus('In wash')">In Wash</button>
				</div>
				<div class="col-md-3">
					<button class="btn btn-outline-success btn-round btn-block" onclick="changeStatus('In delivery')">Deliver To Customer</button>
				</div>
				<div class="col-md-3">
					<button class="btn btn-outline-danger btn-round btn-block" onclick="changeStatus('Completed')">Completed</button>
				</div>
			</div>
		</div>
		<div class="card-block">
			<div class="dt-responsive table-responsive">
				<table class="datatable table table-striped table-bordered nowrap">
					<thead>
						<th>Ref ID</th>
						<th>Name</th>
						<th>Mobile</th>
						<th>Address</th>
						<th>Delivery Boy</th>
						<th class="target">Action</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="order-status" value="New order" />