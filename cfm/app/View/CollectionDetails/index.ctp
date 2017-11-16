<div class="x_panel">    
    <div class="x_content">    
        <?php echo $this->Form->create('CollectionDetail', array('controller' => 'collection_details', 'action' => '/ ', 'class' => 'form-horizontal form-label-left','id'=>'CollectionDetail')); ?>
        <div class="form-group">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Collection/Type:</label>
                <?php echo $this->Form->input("collection_type", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Date From(Payment Received)</label>
                <?php echo $this->Form->input("date_from", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_from', 'required' => false)) ?>                
           </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Date To (Payment Received)</label>
                <?php echo $this->Form->input("date_to", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_to', 'required' => false)) ?>                
           </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Invoice Ref. No:</label>
                <?php echo $this->Form->input("invoice_ref_no", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Contract/PO.No:</label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false)) ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Currency</label>
                <?php echo $this->Form->input("currency", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'currency', 'required' => false)) ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>&nbsp;</label>
                <?php echo $this->Form->submit('Show Report', array('class' => 'btn btn-success', 'id' => 'Show_Report')); ?>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-12  form-group">
                <label>&nbsp;</label>
                <?php echo $this->Form->hidden("showreport", array("type" => "text", 'value' =>"showReport",'id'=>'showreport'));?>
                <?php echo $this->Form->button('Download Report', array('class' => 'btn btn-success', 'id' => 'Download')); ?>                
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
    <div class="x_content">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('contract_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('product_category_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('collection_type'); ?></th>
                    <th><?php echo $this->Paginator->sort('invoice_ref_no'); ?></th>
                    <th><?php echo $this->Paginator->sort('cheque_amount'); ?></th>
                    <th><?php echo $this->Paginator->sort('amount_received'); ?></th>
                    <th><?php echo $this->Paginator->sort('ajust_adv_amount'); ?></th>
                    <th><?php echo $this->Paginator->sort('ait'); ?></th>
                    <th><?php echo $this->Paginator->sort('vat'); ?></th>
                    <th><?php echo $this->Paginator->sort('ld'); ?></th>
                    <th><?php echo $this->Paginator->sort('other_deduction'); ?></th>
                    <th><?php echo $this->Paginator->sort('currency'); ?></th>
                    <th><?php echo $this->Paginator->sort('cheque_or_payment_certification_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('actual_payment_certificate_or_cheque_collection_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('forecasted_payment_collection_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('payment_credited_to_bank_date'); ?></th>			
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($collectionDetails as $collectionDetail): ?>
                    <tr>
                        <td><?php echo $collectionDetail['Contract']['contract_no']; ?></td>
                        <td><?php echo $collectionDetail['ProductCategory']['name']; ?></td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['collection_type']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['invoice_ref_no']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['cheque_amount']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['amount_received']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['ajust_adv_amount']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['ait']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['vat']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['ld']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['other_deduction']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['currency']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['cheque_or_payment_certification_date']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['actual_payment_certificate_or_cheque_collection_date']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['forecasted_payment_collection_date']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['payment_credited_to_bank_date']); ?>&nbsp;</td>

                        <td class="actions">
                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $collectionDetail['CollectionDetail']['id']),array('target'=>'_blank')); ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>
            <?php
            echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
            ));
            ?>	</p>
        <div class="paging">
            <?php
            echo $this->Paginator->prev('< ' . __(' previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ' | '));
            echo $this->Paginator->next(__(' next') . ' >', array(), null, array('class' => 'next disabled'));
            ?>
        </div>
    </div>
</div>
<script>
    window.onload = function() {
        document.getElementById('Download').onclick = function() {
        document.getElementById('showreport').value="download";    
        document.getElementById('CollectionDetail').submit();
        document.getElementById('showreport').value="showreport"; 
        return false;
    };
};
</script>