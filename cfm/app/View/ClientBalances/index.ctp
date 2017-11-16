<div class="x_panel"> 
    <div class="x_title">
        <h2>Direct Sale Client Balance List:</h2>         
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
        <table cellpadding="0" cellspacing="0"class="table table-striped table-bordered" id="headerTable">
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('client_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('balance'); ?></th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientBalances as $clientBalance): ?>
                    <tr>
                        <td><?php echo h($clientBalance['ClientBalance']['id']); ?>&nbsp;</td>
                        <td>
                            <?php echo $this->Html->link($clientBalance['Client']['name'], array('controller' => 'clients', 'action' => 'view', $clientBalance['Client']['id'])); ?>
                        </td>
                        <td><?php echo h($clientBalance['ClientBalance']['balance']); ?>&nbsp;</td>

                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3">
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>	</p>

                        <?php
                        echo $this->Paginator->prev('< ' . __('previous '), array(), null, array('class' => 'prev disabled'));
                        echo $this->Paginator->numbers(array('separator' => '|'));
                        echo $this->Paginator->next(__(' next') . ' >', array(), null, array('class' => 'next disabled'));
                        ?></td>
                </tr>    
            </tbody>
        </table>
    </div>
</div>
