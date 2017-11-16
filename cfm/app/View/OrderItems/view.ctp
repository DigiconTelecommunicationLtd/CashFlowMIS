<div class="orderItems view">
<h2><?php echo __('Order Item'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order'); ?></dt>
		<dd>
			<?php echo $this->Html->link($orderItem['Order']['id'], array('controller' => 'orders', 'action' => 'view', $orderItem['Order']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice No'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['invoice_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Product Name'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['product_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Product'); ?></dt>
		<dd>
			<?php echo $this->Html->link($orderItem['Product']['name'], array('controller' => 'products', 'action' => 'view', $orderItem['Product']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Unit Price'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['unit_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount Percent'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['discount_percent']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount Amount'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['discount_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Net Amount'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['net_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Currency'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['currency']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client'); ?></dt>
		<dd>
			<?php echo $this->Html->link($orderItem['Client']['name'], array('controller' => 'clients', 'action' => 'view', $orderItem['Client']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Name'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['client_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Added By'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['added_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Added Date'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['added_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order Item'), array('action' => 'edit', $orderItem['OrderItem']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Order Item'), array('action' => 'delete', $orderItem['OrderItem']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $orderItem['OrderItem']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Items'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Item'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products'), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product'), array('controller' => 'products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> </li>
	</ul>
</div>
