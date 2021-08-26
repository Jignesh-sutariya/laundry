<!DOCTYPE>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?= APP_NAME ?> | Invoice</title>
		<?= link_tag('assets/images/favicon.png', 'png', 'image/x-icon') ?>
		<?= link_tag('assets/invoice/style.css', 'stylesheet', 'text/css') ?>
		<?= link_tag('assets/invoice/print.css', 'stylesheet', 'text/css') ?>
	</head>
	<body>
		<div class="card">
			<div class="card-block">
				<div id="page-wrap">
					<p id="header">INVOICE</p>
					<div id="identity">
						<div class="logo-image">
							<img class="im" id="image" src="<?= base_url('assets/images/logo.png') ?>" alt="logo" />
						</div>
						<div id="address1">
							<p class="mr-b-p">
								Tragad Ahmedabad
							</p>
						</div>
					</div>
					<div style="clear:both"></div>
					<div id="customer">
						<table id="meta" class="meta-width mr-r">
							<tr>
								<td class="meta-head">Name</td>
								<td><?= $data['name'] ?></td>
							</tr>
							<tr>
								<td class="meta-head">Mobile No</td>
								<td><?= $data['mobile'] ?></td>
							</tr>
						</table>
						<table id="meta" class="meta-width">
							<tr>
								<td class="meta-head">Invoice No.</td>
								<td># <?= $data['id'] ?></td>
							</tr>
							<tr>
								<td class="meta-head">Date</td>
								<td><?= date('d-m-Y', strtotime($data['created_at'])) ?></td>
							</tr>
						</table>
					</div>
					<table id="items">
						<tr>
							<th>Sr. No.</th>
							<th>Category</th>
							<th>Sub Category</th>
							<th>Item</th>
							<th>Quantity</th>
							<th>Price</th>
						</tr>
						<?php foreach ($data['details'] as $k => $v): ?>
						<tr>
							<td style="width: auto;"><?= ++$k ?></td>
							<td style="width: auto;"><?= $v['cat_name'] ?></td>
							<td style="width: auto;"><?= $v['sub_cat_name'] ?></td>
							<td style="width: auto;"><?= $v['item_name'] ?></td>
							<td style="width: auto;"><?= $v['quantity'] ?></td>
							<td style="width: auto;"><?= $v['price'] ?></td>
						</tr>
						<?php endforeach ?>
						<tr>
							<td colspan="5"  class="total-line grandtotal">Delivery Charge</td>
							<td class="total-value grandtotal"><div class="due"> ₹ <?= $data['delivery_charge'] ?></div></td>
						</tr>
						<tr>
							<td colspan="5"  class="total-line grandtotal">Grand Total</td>
							<td class="total-value grandtotal"><div class="due"> ₹ <?= $data['delivery_charge'] + $data['total_bill'] ?></div></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<script>
			window.print();
		</script>
	</body>
</html>