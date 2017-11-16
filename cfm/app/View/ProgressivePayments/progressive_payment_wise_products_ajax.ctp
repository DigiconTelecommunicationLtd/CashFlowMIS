<div class="x_content">
        <?php if ($this->Session->check('Message.flash')): ?> 
            <div class="x_title">       
                <div role="alert" class="alert alert-success alert-dismissible fade in">
                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                    </button>
                    <strong><?php echo $this->Session->flash(); ?></strong>
                </div>        
                <div class="clearfix"></div>
            </div>
        <?php endif; ?>
        <div  class="col-md-12 col-sm-12 col-xs-12" id="lotProductUpdate">
            <?php if ($productions): ?>
                <table  class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Contract/PO.No</th>
                            <th>Lot No.</th>
                            <th>Product</th>
                            <th>Invoice Quantity</th>
                            <th>Unit Weight</th>
                            <th>Total Weight</th>
                            <th>Unit Price</th>
                            <th>Currency</th>                        
                            <th>Billing Percent</th>
                            <th>Invoice Value</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_invoice_value=0.00;
                        foreach ($productions as $production): ?>
                            <tr>

                                <td> <?php echo $production['Contract']['contract_no']; ?> </td>
                                <td> <?php echo $production['ProgressivePayment']['lot_id']; ?> </td>
                                <td> <?php echo $production['Product']['name']; ?> </td>
                                <td><?php echo h($production['ProgressivePayment']['quantity']); ?>&nbsp;<?php echo h($production['ProgressivePayment']['uom']); ?></td>
                                <td><?php echo h($production['ProgressivePayment']['unit_weight']); ?>&nbsp;</td>
                                <td><?php echo ($production['ProgressivePayment']['unit_weight'] != 'N/A') ? h($production['ProgressivePayment']['unit_weight'] * $production['ProgressivePayment']['quantity']) . ' ' . $production['ProgressivePayment']['uom'] : 'N/A'; ?>&nbsp;</td>
                                <td> <?php echo $production['ProgressivePayment']['unit_price']; ?> </td> 
                                <td> <?php echo $production['ProgressivePayment']['currency']; ?> </td> 
                                <td> <?php echo $production['ProgressivePayment']['billing_percent']; ?> </td> 
                                <td> <?php echo $production['ProgressivePayment']['invoice_amount'];$total_invoice_value+=($production['ProgressivePayment']['invoice_amount'])?$production['ProgressivePayment']['invoice_amount']:0.00; ?> </td> 
                                <td> <?php echo $production['ProgressivePayment']['remarks']; ?> </td> 
                                <td class="actions">
                                    <button onclick="delete_progressive_payment_product('<?php echo $production['ProgressivePayment']['id']; ?>', '<?php echo $production['ProgressivePayment']['contract_id']; ?>', '<?php echo $production['ProgressivePayment']['lot_id']; ?>', 'progressive_payments');"><i class="fa fa-remove"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>       
                <div class="x_content">
                    <?php echo $this->Form->create('Collection', array('action' => 'SaveCollection', 'class' => 'form-horizontal form-label-left', 'id' => 'Collection')); ?>

                    <?php echo $this->Form->hidden("collection_type", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'id' => 'collection_type', 'value' => 'Progressive Collection')) ?>
                    <?php echo $this->Form->hidden("contract_id", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'value' => $contract_id, 'readOnly' => true)) ?>
                    <?php echo $this->Form->hidden("currency", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'value' => $currency, 'readOnly' => true)) ?>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Invoice Ref. No: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("invoice_ref_no", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'id' => 'invoice_ref_no')) ?>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Invoice Value <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("invoice_amount", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'id' => 'invoice_amount', 'readOnly' => true,'value'=>$total_invoice_value)) ?>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Planned Invoice Date<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">                
                            <?php echo $this->Form->input("planned_invoice_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'id' => 'planned_submission_date', 'id' => 'planned_invoice_date')) ?>
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Forecasted Invoice Date<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("forecasted_invoice_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'id' => 'forecasted_invoice_date')) ?>
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Actual Invoice Date<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">                
                            <?php echo $this->Form->input("actual_invoice_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'id' => 'planned_submission_date', 'id' => 'actual_invoice_date')) ?>
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Remaining Days
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("reaming_days", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'id' => 'reaming_days', 'readOnly' => true)) ?>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Planned Collection Date<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("planned_collection_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'id' => 'forecasted_collection_date')) ?>
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Forecasted Collection Date<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("forecasted_collection_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'id' => 'forecasted_collection_date')) ?>
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>       
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Cheque/Payment Certificate Date<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("cheque_payment_certification_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'id' => 'cheque_payment_certification_date')) ?>
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Payment Receive Date<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("payment_receive_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'id' => 'payment_receive_date')) ?>
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Bank Credit (Payment Receive )Date<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("payment_credited_to_bank_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'id' => 'payment_credited_to_bank_date')) ?>
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Amount Received<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("amount_received", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 balance", 'id' => 'amount_received')) ?>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">AIT
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("ait", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 balance", 'id' => 'ait')) ?>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">VAT
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("vat", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 balance", 'id' => 'vat')) ?>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">L.D
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("ld", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 balance", 'id' => 'ld')) ?>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Other Deduction
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("other_deduction", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 balance", 'id' => 'other_deduction')) ?>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Amount Receivable/Balance
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $this->Form->input("balance", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'id' => 'balance')) ?>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3"> 
                            <?php echo $this->Form->submit('Submit', array('class' => 'btn btn-success', 'id' => 'CollectionSubmit')); ?>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>  
                </div>
            <?php endif; ?>             
        </div>
    </div> 
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('fast');
        }, 1500); // <-- time in milliseconds
    });
</script>
