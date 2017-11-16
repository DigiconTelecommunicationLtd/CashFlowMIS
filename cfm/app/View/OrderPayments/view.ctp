<div class="orderPayments view">
<h2><?php echo __('Order Payment'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order'); ?></dt>
		<dd>
			<?php echo $this->Html->link($orderPayment['Order']['id'], array('controller' => 'orders', 'action' => 'view', $orderPayment['Order']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice No'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['invoice_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client'); ?></dt>
		<dd>
			<?php echo $this->Html->link($orderPayment['Client']['name'], array('controller' => 'clients', 'action' => 'view', $orderPayment['Client']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Name'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['client_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Bank Name'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['bank_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Type'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['payment_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Branch Name'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['Branch_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Received Amount'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['received_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ait'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['ait']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vat'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['vat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ld'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['ld']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Other Deduction'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['other_deduction']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Currency'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['currency']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Received Date'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['received_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Added By'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['added_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Remarks'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['remarks']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Added Date'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['added_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified By'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['modified_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified Date'); ?></dt>
		<dd>
			<?php echo h($orderPayment['OrderPayment']['modified_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order Payment'), array('action' => 'edit', $orderPayment['OrderPayment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Order Payment'), array('action' => 'delete', $orderPayment['OrderPayment']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $orderPayment['OrderPayment']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Payments'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Payment'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> </li>
	</ul>
</div>
