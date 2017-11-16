<div class="clientBalances view">
<h2><?php echo __('Client Balance'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($clientBalance['ClientBalance']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientBalance['Client']['name'], array('controller' => 'clients', 'action' => 'view', $clientBalance['Client']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Balance'); ?></dt>
		<dd>
			<?php echo h($clientBalance['ClientBalance']['balance']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Client Balance'), array('action' => 'edit', $clientBalance['ClientBalance']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Client Balance'), array('action' => 'delete', $clientBalance['ClientBalance']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $clientBalance['ClientBalance']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Balances'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Balance'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> </li>
	</ul>
</div>
