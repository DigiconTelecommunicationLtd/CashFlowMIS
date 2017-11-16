<div class="x_panel"> 
    <div class="x_title">
        <h2>Direct Sale Payment Entry List:</h2>         
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
        <table cellpadding="0" cellspacing="0"class="table table-striped table-bordered" id="headerTable">
            <thead>
                <tr>

                    <th><?php echo $this->Paginator->sort('client_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('amount'); ?></th>
                    <th><?php echo $this->Paginator->sort('payment_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('bank'); ?></th>
                    <th><?php echo $this->Paginator->sort('branch'); ?></th>
                    <th><?php echo $this->Paginator->sort('added_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('added_date'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paymentHistories as $paymentHistory): ?>
                    <tr>

                        <td> <?php echo h($paymentHistory['Client']['name']); ?> &nbsp;</td>
                        <td><?php echo h($paymentHistory['PaymentHistory']['amount']); ?>&nbsp;</td>
                        <td><?php echo h($paymentHistory['PaymentHistory']['payment_date']); ?>&nbsp;</td>
                        <td><?php echo h($paymentHistory['PaymentHistory']['bank']); ?>&nbsp;</td>
                        <td><?php echo h($paymentHistory['PaymentHistory']['branch']); ?>&nbsp;</td>
                        <td><?php echo h($paymentHistory['PaymentHistory']['added_by']); ?>&nbsp;</td>
                        <td><?php echo h($paymentHistory['PaymentHistory']['added_date']); ?>&nbsp;</td>
                        <td class="actions">
                            <?php if(substr($paymentHistory['PaymentHistory']['added_date'],0,10)==date('Y-m-d')): ?>
                            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $paymentHistory['PaymentHistory']['id']), array('confirm' => __('If you delete this, '.$paymentHistory['PaymentHistory']['amount'].' TK will be add to the '.$paymentHistory['Client']['name'].'\'s Balance'))); ?>
                            <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="8">
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>	</p>

                        <?php
                        echo $this->Paginator->prev('< ' . __('previous '), array(), null, array('class' => 'prev disabled'));
                        echo $this->Paginator->numbers(array('separator' => ' | '));
                        echo $this->Paginator->next(__(' next') . ' >', array(), null, array('class' => 'next disabled'));
                        ?></td>
                </tr>    
            </tbody>
        </table>
    </div>
</div>



