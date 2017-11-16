<div class="orderPayments form">
<?php echo $this->Form->create('OrderPayment'); ?>
	<fieldset>
		<legend><?php echo __('Edit Order Payment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('order_id');
		echo $this->Form->input('invoice_no');
		echo $this->Form->input('client_id');
		echo $this->Form->input('client_name');
		echo $this->Form->input('bank_name');
		echo $this->Form->input('payment_type');
		echo $this->Form->input('Branch_name');
		echo $this->Form->input('received_amount');
		echo $this->Form->input('ait');
		echo $this->Form->input('vat');
		echo $this->Form->input('ld');
		echo $this->Form->input('other_deduction');
		echo $this->Form->input('currency');
		echo $this->Form->input('received_date');
		echo $this->Form->input('added_by');
		echo $this->Form->input('remarks');
		echo $this->Form->input('added_date');
		echo $this->Form->input('modified_by');
		echo $this->Form->input('modified_date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('OrderPayment.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('OrderPayment.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Order Payments'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> </li>
	</ul>
</div>
