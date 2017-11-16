<div class="clientBalances form">
<?php echo $this->Form->create('ClientBalance'); ?>
	<fieldset>
		<legend><?php echo __('Edit Client Balance'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('client_id');
		echo $this->Form->input('balance');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ClientBalance.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('ClientBalance.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Client Balances'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> </li>
	</ul>
</div>
