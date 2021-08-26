<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open($url."/updateOrder/$id") ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('User Name', 'name') ?>
			<?= form_input('name', $data['name'], 'class="form-control form-control-round" readonly=""') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Mobile Number', 'mobile') ?>
			<?= form_input('mobile', $data['mobile'], 'class="form-control form-control-round" readonly=""') ?>
		</div>
	</div>
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th>Sr No.</th>
					<th>Category</th>
					<th>Sub Category</th>
					<th>Item</th>
					<th>Price</th>
					<th>Quantity</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data['details'] as $k => $v): ?>
				<tr>
					<td style="width: 5%"><?= ++$k ?></td>
					<td style="width: 25%"><?= $v['cat_name'] ?></td>
					<td style="width: 25%"><?= $v['sub_cat_name'] ?></td>
					<td style="width: 25%"><?= $v['item_name'] ?></td>
					<td style="width: 10%">
						<?= form_input('sub_order['.$v['id'].'][quantity]', $v['quantity'], 'class="form-control form-control-round"') ?>
					</td>
					<td style="width: 10%">
						<?= form_input('sub_order['.$v['id'].'][price]', $v['price'], 'class="form-control form-control-round"') ?>
					</td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<?= form_close() ?>