<div class="x_panel">    
    <div class="x_content">    
        <?php echo $this->Form->create('Report', array('controller' => 'reports', 'action' => 'cheque_payment_received_report/ ', 'class' => 'form-horizontal form-label-left','id'=>'CollectionDetail')); ?>
        <div class="form-group">
            <div class="col-md-2 col-sm-2 col-xs-12">
                <label>Collection/Type:</label>
                <?php echo $this->Form->input("collection_type", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false,'options'=>$collection_types)) ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <label>Date From:</label>
                <?php echo $this->Form->input("date_from", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_from', 'required' => false)) ?>                
           </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <label>Date To:</label>
                <?php echo $this->Form->input("date_to", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_to', 'required' => false)) ?>                
           </div>            
           <div class="col-md-2 col-sm-2 col-xs-12">
                <label>Date Type:</label>
                <?php echo $this->Form->input("date_type", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '','options'=>$date_types)) ?>
            </div> 
            <div class="col-md-2 col-sm-2 col-xs-12">
                <label>Invoice Ref. No:</label>
                <?php echo $this->Form->input("invoice_ref_no", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false,'options'=>$invoice_ref_nos)) ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <label>Contract/PO.No:</label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false)) ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Currency</label>
                <?php echo $this->Form->input("currency", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'currency', 'required' => false)) ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Unit</label>
                <?php echo $this->Form->input("unit_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'unit_id', 'required' => false)) ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Client</label>
                <?php echo $this->Form->input("client_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'client_id', 'required' => false)) ?> 
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Category</label>
                <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'product_category_id', 'required' => false,'options'=>$product_categories)) ?>
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
                    <th>PO/Contract No.</th>
                    <th>Client</th>
                    <th>Product/Category</th>
                    <th>Collection Type</th>
                    <th>Invoice Ref. No:</th>
                    <th>Cheque Amount</th>
                    <th>Received Amount</th>
                    <th>Adj. Adv Amount</th>
                    <th>AIT</th>
                    <th>VAT</th>
                    <th>L.D</th>
                    <th>Other Deduction</th>
                    <th>Currency</th>
                    <th>Planned Certificate/Cheque Collection Date</th>
                    <th>Payment Certification/Cheque Date</th>
                    <th>Actual Certification/Cheque Collection Date</th>
                    <th>Forecasted Payment Collection Date</th>
                    <th>Payment (Credited to Bank) date</th>	
                </tr>
            </thead>
            <tbody>
                <?php foreach ($collectionDetails as $collectionDetail): ?>
                    <tr>
                        <td><?php echo $collectionDetail['Contract']['contract_no']; ?></td>
                        <td><?php echo $clients[$collectionDetail['Contract']['client_id']]; ?></td>
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
                        <td><?php echo h($collectionDetail['Collection']['planned_payment_certificate_or_cheque_collection_date']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['cheque_or_payment_certification_date']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['actual_payment_certificate_or_cheque_collection_date']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['forecasted_payment_collection_date']); ?>&nbsp;</td>
                        <td><?php echo h($collectionDetail['CollectionDetail']['payment_credited_to_bank_date']); ?>&nbsp;</td> 
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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