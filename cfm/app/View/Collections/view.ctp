<div class="collections view">
<h2><?php echo __('Collection'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contract'); ?></dt>
		<dd>
			<?php echo $this->Html->link($collection['Contract']['contract_no'], array('controller' => 'contracts', 'action' => 'view', $collection['Contract']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Progressive Payment Detail'); ?></dt>
		<dd>
			<?php echo $this->Html->link($collection['ProgressivePaymentDetail']['id'], array('controller' => 'progressive_payment_details', 'action' => 'view', $collection['ProgressivePaymentDetail']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Collection Type'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['collection_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice Ref No'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['invoice_ref_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Billing Percent'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['billing_percent']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice Amount'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['invoice_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Amount Received'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['amount_received']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ait'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['ait']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vat'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['vat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ld'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['ld']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Other Deduction'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['other_deduction']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Currency'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['currency']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Planned Submission Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['planned_submission_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Actual Submission Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['actual_submission_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Planned Invoice Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['planned_invoice_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Actual Invoice Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['actual_invoice_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Forecasted Invoice Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['forecasted_invoice_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Planned Collection Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['planned_collection_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Forecasted Collection Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['forecasted_collection_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Planned Receive Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['planned_receive_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Forecasted Receive Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['forecasted_receive_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cheque Payment Certification Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['cheque_payment_certification_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Receive Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['payment_receive_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Credited To Bank Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['payment_credited_to_bank_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Remarks'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['remarks']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Added By'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['added_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Added Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['added_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified By'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['modified_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified Date'); ?></dt>
		<dd>
			<?php echo h($collection['Collection']['modified_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Collection'), array('action' => 'edit', $collection['Collection']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Collection'), array('action' => 'delete', $collection['Collection']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $collection['Collection']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Collections'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Collection'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contracts'), array('controller' => 'contracts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contract'), array('controller' => 'contracts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Progressive Payment Details'), array('controller' => 'progressive_payment_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Progressive Payment Detail'), array('controller' => 'progressive_payment_details', 'action' => 'add')); ?> </li>
	</ul>
</div>
