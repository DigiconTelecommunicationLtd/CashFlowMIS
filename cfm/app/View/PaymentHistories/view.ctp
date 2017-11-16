<div class="paymentHistories view">
<h2><?php echo __('Payment History'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($paymentHistory['PaymentHistory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client'); ?></dt>
		<dd>
			<?php echo $this->Html->link($paymentHistory['Client']['name'], array('controller' => 'clients', 'action' => 'view', $paymentHistory['Client']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Amount'); ?></dt>
		<dd>
			<?php echo h($paymentHistory['PaymentHistory']['amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Bank'); ?></dt>
		<dd>
			<?php echo h($paymentHistory['PaymentHistory']['bank']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Branch'); ?></dt>
		<dd>
			<?php echo h($paymentHistory['PaymentHistory']['branch']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Added By'); ?></dt>
		<dd>
			<?php echo h($paymentHistory['PaymentHistory']['added_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Added Date'); ?></dt>
		<dd>
			<?php echo h($paymentHistory['PaymentHistory']['added_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Payment History'), array('action' => 'edit', $paymentHistory['PaymentHistory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Payment History'), array('action' => 'delete', $paymentHistory['PaymentHistory']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $paymentHistory['PaymentHistory']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Payment Histories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Payment History'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> </li>
	</ul>
</div>
