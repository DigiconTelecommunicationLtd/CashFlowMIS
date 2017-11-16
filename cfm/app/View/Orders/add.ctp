<div class="orders form">
<?php echo $this->Form->create('Order'); ?>
	<fieldset>
		<legend><?php echo __('Add Order'); ?></legend>
	<?php
		echo $this->Form->input('client_id');
		echo $this->Form->input('client_name');
		echo $this->Form->input('invoice_no');
		echo $this->Form->input('total_bill');
		echo $this->Form->input('discount');
		echo $this->Form->input('net_amount');
		echo $this->Form->input('received_amount');
		echo $this->Form->input('ait');
		echo $this->Form->input('vat');
		echo $this->Form->input('ld');
		echo $this->Form->input('other_deduction');
		echo $this->Form->input('balance');
		echo $this->Form->input('currency');
		echo $this->Form->input('delivery_date');
		echo $this->Form->input('added_by');
		echo $this->Form->input('added_date');
		echo $this->Form->input('modified_by');
		echo $this->Form->input('modified_date');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Items'), array('controller' => 'order_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Item'), array('controller' => 'order_items', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Payments'), array('controller' => 'order_payments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Payment'), array('controller' => 'order_payments', 'action' => 'add')); ?> </li>
	</ul>
</div>
