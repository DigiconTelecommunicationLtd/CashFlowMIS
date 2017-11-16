<div class="x_panel">
    <table cellpadding="0" cellspacing="0"class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Client</th>
                <th><?php echo $order['Client']['name'];?></th>
            </tr>
            <tr>
                <th>Invoice No</th>
                <th><?php echo h($order['Order']['invoice_no']); ?></th>
            </tr>
            <tr>
                <th>Total Bill</th>
                <th><?php echo h($order['Order']['total_bill']); ?></th>
            </tr>
            <tr>
                <th>Discount</th>
                <th><?php echo h($order['Order']['discount']); ?></th>
            </tr>
            <tr>
                <th>Net Amount</th>
                <th><?php echo h($order['Order']['net_amount']); ?></th>
            </tr>
            <tr>
                <th>Received Amount</th>
                <th><?php echo h($order['Order']['received_amount']); ?></th>
            </tr>
            <tr>
                <th>AIT</th>
                <th><?php echo h($order['Order']['ait']); ?></th>
            </tr>
            <tr>
                <th>Vat</th>
                <th><?php echo h($order['Order']['vat']); ?></th>
            </tr>
            <tr>
                <th>LD</th>
                <th><?php echo h($order['Order']['ld']); ?></th>
            </tr>
            <tr>
                <th>Other Deduction</th>
                <th><?php echo h($order['Order']['other_deduction']); ?></th>
            </tr>
            <tr>
                <th>Balance</th>
                <th><?php echo h($order['Order']['balance']); ?></th>
            </tr>
            <tr>
                <th>Delivery Date</th>
                <th><?php echo h($order['Order']['delivery_date']); ?></th>
            </tr>
            <tr>
                <th>Added By</th>
                <th><?php echo h($order['Order']['added_by']); ?></th>
            </tr>
            <tr>
                <th>Added Date</th>
                <th><?php echo h($order['Order']['added_date']); ?></th>
            </tr>           
        </thead>
    </table>
	<h3><?php echo __('Related Order Items'); ?></h3>
	<?php if (!empty($order['OrderItem'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped table-bordered">
	<tr>    <th><?php echo __('Invoice No'); ?></th>
                <th><?php echo __('Client Name'); ?></th>
		<th><?php echo __('Product Name'); ?></th>		 
		<th><?php echo __('Unit Price'); ?></th>
                <th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Discount Percent'); ?></th>		 	 
		
		<th><?php echo __('Added By'); ?></th>
		<th><?php echo __('Added Date'); ?></th>		 
		<!--<th class="actions"><?php //echo __('Actions'); ?></th> -->
	</tr>
	<?php foreach ($order['OrderItem'] as $orderItem): ?>
		<tr>    <td><?php echo $orderItem['invoice_no']; ?></td>
                        <td><?php echo $orderItem['client_name']; ?></td>
			<td><?php echo $orderItem['product_name']; ?></td>			
			<td><?php echo $orderItem['unit_price']; ?></td>
                        <td><?php echo $orderItem['quantity']; ?></td>
			<td><?php echo $orderItem['discount_percent']; ?></td>
			<td><?php echo $orderItem['added_by']; ?></td>
			<td><?php echo $orderItem['added_date']; ?></td>			 
			<!--<td class="actions">
				<?php //echo $this->Html->link(__('View'), array('controller' => 'order_items', 'action' => 'view', $orderItem['id'])); ?>
				<?php //echo $this->Html->link(__('Edit'), array('controller' => 'order_items', 'action' => 'edit', $orderItem['id'])); ?>
				<?php //echo $this->Form->postLink(__('Delete'), array('controller' => 'order_items', 'action' => 'delete', $orderItem['id']), array('confirm' => __('Are you sure you want to delete # %s?', $orderItem['id']))); ?>
			</td> -->
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
	<h3><?php echo __('Related Order Payments'); ?></h3>
	<?php if (!empty($order['OrderPayment'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped table-bordered">
	<tr>    <th><?php echo __('Invoice No'); ?></th>		 
		<th><?php echo __('Client Name'); ?></th>
		<th><?php echo __('Bank Name'); ?></th>
		<th><?php echo __('Payment Type'); ?></th>
		<th><?php echo __('Branch Name'); ?></th>
		<th><?php echo __('Received Amount'); ?></th>
		<th><?php echo __('Ait'); ?></th>
		<th><?php echo __('Vat'); ?></th>
		<th><?php echo __('Ld'); ?></th>
		<th><?php echo __('Other Deduction'); ?></th>		 
		<th><?php echo __('Received Date'); ?></th>
		<th><?php echo __('Added By'); ?></th>
		<th><?php echo __('Remarks'); ?></th>
		<th><?php echo __('Added Date'); ?></th>		 
		<!--<th class="actions"><?php //echo __('Actions'); ?></th> -->
	</tr>
	<?php foreach ($order['OrderPayment'] as $orderPayment): ?>
		<tr>    <td><?php echo $orderPayment['invoice_no']; ?></td>			 
			<td><?php echo $orderPayment['client_name']; ?></td>
			<td><?php echo $orderPayment['bank_name']; ?></td>
			<td><?php echo $orderPayment['payment_type']; ?></td>
			<td><?php echo $orderPayment['branch_name']; ?></td>
			<td><?php echo $orderPayment['received_amount']; ?></td>
			<td><?php echo $orderPayment['ait']; ?></td>
			<td><?php echo $orderPayment['vat']; ?></td>
			<td><?php echo $orderPayment['ld']; ?></td>
			<td><?php echo $orderPayment['other_deduction']; ?></td>			 
			<td><?php echo $orderPayment['received_date']; ?></td>
			<td><?php echo $orderPayment['added_by']; ?></td>
			<td><?php echo $orderPayment['remarks']; ?></td>
			<td><?php echo $orderPayment['added_date']; ?></td>			 
			<!--<td class="actions">
				<?php //echo $this->Html->link(__('View'), array('controller' => 'order_payments', 'action' => 'view', $orderPayment['id'])); ?>
				<?php //echo $this->Html->link(__('Edit'), array('controller' => 'order_payments', 'action' => 'edit', $orderPayment['id'])); ?>
				<?php //echo $this->Form->postLink(__('Delete'), array('controller' => 'order_payments', 'action' => 'delete', $orderPayment['id']), array('confirm' => __('Are you sure you want to delete # %s?', $orderPayment['id']))); ?>
			</td>-->
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	
</div>
</div>