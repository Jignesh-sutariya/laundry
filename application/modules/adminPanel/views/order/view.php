<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card-block">
	<div class="row invoive-info">
		<div class="col-md-8 invoice-client-info">
			<h6>User Information :</h6>
			<h6 class="m-0"><?= $data['name'] ?></h6>
			<p class="m-0 m-t-10"><?= $data['address'] ?></p>
			<p class="m-0"><?= $data['mobile'] ?></p>
		</div>
		<div class="col-md-4">
			<h6>Order Information :</h6>
			<table
				class="table table-responsive invoice-table invoice-order table-borderless">
				<tbody>
					<tr>
						<th>Date</th>
						<td>: &nbsp
							<?= date('d-m-Y', strtotime($data['created_at'])) ?>
						</td>
					</tr>
					<tr>
						<th>Status</th>
						<td>: &nbsp
							<span class="label label-warning"><?= $data['orders_status'] ?></span>
						</td>
					</tr>
					<tr>
						<th>Ref ID</th>
						<td>: &nbsp
							#<?= $data['id'] ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table invoice-detail-table">
					<thead>
						<tr class="thead-default">
							<th>Sr No.</th>
							<th>Category</th>
							<th>Sub Category</th>
							<th>Item</th>
							<th>Quantity</th>
							<th>Price</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data['details'] as $k => $v): ?>
						<tr>
							<td style="width: 5%"><?= ++$k ?></td>
							<td style="width: 25%"><?= $v['cat_name'] ?></td>
							<td style="width: 25%"><?= $v['sub_cat_name'] ?></td>
							<td style="width: 25%"><?= $v['item_name'] ?></td>
							<td style="width: 10%"><?= $v['quantity'] ?></td>
							<td style="width: 10%"><?= $v['price'] ?></td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table
				class="table table-responsive invoice-table invoice-total">
				<tbody>
					<tr>
						<th>Delivery Charge :</th>
						<td>₹ <?= $data['delivery_charge'] ?></td>
					</tr>
					<tr>
						<th>Total :</th>
						<td>₹ <?= $data['total_bill'] ?></td>
					</tr>
					<tr class="text-info">
						<td>
							<hr />
							<h5 class="text-primary">Grand Total :</h5>
						</td>
						<td>
							<hr />
							<h5 class="text-primary">₹ <?= $data['delivery_charge'] + $data['total_bill'] ?></h5>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>