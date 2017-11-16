<div class="x_panel">
    <!-- contract added product list -->     
    <div class="x_content">            
        <table  class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Contract/PO.No</th>
                    <th>Lot No.</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Invoice Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>                             
                    <th>Unit Weight</th>
                    <th>Total Weight</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_invoice_value = 0.00;
                foreach ($productions as $production):
                    ?>
                    <tr>

                        <td> <?php echo $production['Contract']['contract_no']; ?> </td>
                        <td> <?php echo $production['ProgressivePayment']['lot_id']; ?> </td>                        
                        <td> <?php echo $product_category_list[$production['ProgressivePayment']['product_category_id']]; ?> </td>
                        <td> <?php echo $production['Product']['name']; ?> </td>
                        <td><?php echo h($production['ProgressivePayment']['quantity']); ?>&nbsp;<?php echo h($production['ProgressivePayment']['uom']); ?></td>
                        <td> <?php echo $production['ProgressivePayment']['unit_price']; ?> </td>
                        <td> <?php echo $production['ProgressivePayment']['quantity'] * $production['ProgressivePayment']['unit_price']; ?> </td>
                        <td><?php echo ($production['ProgressivePayment']['unit_weight'] != 'N/A'&&$production['ProgressivePayment']['unit_weight_uom'] != 'N/A') ? h($production['ProgressivePayment']['unit_weight']) . ' ' . $production['ProgressivePayment']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                        <td><?php echo ($production['ProgressivePayment']['unit_weight'] != 'N/A'&&$production['ProgressivePayment']['unit_weight_uom'] != 'N/A') ? h($production['ProgressivePayment']['unit_weight'] * $production['ProgressivePayment']['quantity']) . ' ' . $production['ProgressivePayment']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>

                        <td class="actions">

                            <?php
                            echo $this->Form->postLink(
                                    $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove')) . " Delete", array('action' => 'delete', $production['ProgressivePayment']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $production['ProgressivePayment']['id']), array('class' => 'btn btn-mini')
                            );

                            //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $production['ProgressivePayment']['id']), array('confirm' => __('Are you sure you want to delete ?')),array('class'=>'btn btn-success')); 
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>     
    </div>
<div class="clearfix"></div>

    <div class="x_content">
        <?php echo $this->Form->create('Collection', array('action' => 'SaveCollection', 'class' => 'form-horizontal form-label-left', 'id' => 'Collection')); ?>

        <?php echo $this->Form->hidden("collection_type", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'id' => 'collection_type', 'value' => 'Progressive')) ?>
        <?php echo $this->Form->hidden("contract_id", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'value' => $contract_id, 'readOnly' => true)) ?>

        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Invoice Value <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("contract_value", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'id' => 'contract_value', 'readOnly' => true, 'value' => $ivoice_amount[0]['invoice_amount'])) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Currency
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("currency", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'value' => $currency, 'readOnly' => true)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Invoice Ref. No: <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label><?php echo $invoice_ref;?></label>
                <?php echo $this->Form->input("invoice_ref", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'id' =>'invoice_ref')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Billing Percent(%) <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("billing_percent", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'value'=>$result['Contract']['billing_percent_progressive'], 'id' =>'billing_percent','onchange'=>"InvoiceValueCalculation(this.value)",'readOnly'=>true)) ?>
            </div>
        </div>
         <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Invoice Value <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("invoice_amount", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'id' =>'invoice_amount','readOnly'=>false,'value'=>$invoice_value)) ?>
            </div>
        </div>
        <?php foreach ($product_category as $value): ?>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"><?php echo $value['ProductCategory']['name']; ?>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" name="data[Collection][product_category_id][<?php echo $value['ProductCategory']['id'] ?>]" class="form-control col-md-7 col-xs-12" value="<?php echo round(($value[0]['amount']*$result['Contract']['billing_percent_progressive'])/100,2); ?>" required="1"  style="border-color: green"/>
                <input type="hidden" name="data[Collection][quantity][<?php echo $value['ProductCategory']['id'] ?>]" class="form-control col-md-7 col-xs-12" value="<?php echo $value[0]['quantity']; ?>" required="1" readonly="1" style="border-color: green"/>
                <?php //echo $this->Form->input("product_category_id", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'id' =>'balance','readOnly'=>true,'value'=>($invoice_value*$value[0]['amount'])/100)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo '('.$value[0]['amount'].' X '.$result['Contract']['billing_percent_progressive'].'%'; ?>
            </div>
        </div>
        <?php endforeach;?>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Balance
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("balance", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'id' =>'balance','readOnly'=>true,'value'=>$balance)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Planned Submission Date<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                 $pli_pac=strtotime($actual_delivery_date)+$result['Contract']['pli_pac']* 86400;
                 $pli_aproval=$pli_pac+$result['Contract']['pli_aproval']* 86400;
                 $rr_collection_progressive=$pli_aproval+$result['Contract']['rr_collection_progressive']* 86400;
                 //Planned Submission Date
                 $planned_submission_date = $rr_collection_progressive+ $result['Contract']['invoice_submission_progressive'] * 86400;
                 $planned_submission_date = date('Y-m-d', $planned_submission_date);
                 //reaming days
                 $reaming_days=strtotime($planned_submission_date)-strtotime(date('Y-m-d'));
                 $reaming_days = $reaming_days/86400;                 
                 //Planned Payment Certificate/Cheque Collection Date
                 $planned_payment_certificate_or_cheque_collection_date=strtotime($planned_submission_date)+$result['Contract']['payment_cheque_collection_progressive'] * 86400;
                 $planned_payment_certificate_or_cheque_collection_date = date('Y-m-d', $planned_payment_certificate_or_cheque_collection_date);
                 //planned payment collection date
                 $planned_payment_collection_date=  strtotime($planned_payment_certificate_or_cheque_collection_date)+$result['Contract']['payment_credited_to_bank_progressive'] * 86400;
                 $planned_payment_collection_date = date('Y-m-d', $planned_payment_collection_date);
                ?>
                <?php echo $this->Form->input("planned_submission_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'id' =>'planned_submission_date','readOnly'=>true,'value'=>$planned_submission_date)) ?>
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Remaining Days
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("reaming_days", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'id' =>'reaming_days','readOnly'=>true,'value'=>$reaming_days)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Actual Submission Date<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("actual_submission_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'id' =>'actual_submission_date')) ?>
                <?php echo $this->Form->hidden("planned_payment_certificate_or_cheque_collection_date", array('label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'value' =>$planned_payment_certificate_or_cheque_collection_date)) ?>
                <?php echo $this->Form->hidden("lot_id", array('label' => false, 'div' => false,'required' => 'required', 'value' =>$lot_id)); ?>
                <?php echo $this->Form->hidden("planned_payment_collection_date", array('label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'value' =>$planned_payment_collection_date)) ?>
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>         
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-8"> 
                <?php echo $this->Form->submit('Submit', array('class' => 'btn btn-success', 'id' => 'CollectionSubmit')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>  
    </div>        
</div>
<script>
strLength =document.getElementById("invoice_ref_no").value.length*2;    
document.getElementById("invoice_ref_no").focus();
document.getElementById("invoice_ref_no").setSelectionRange(strLength, strLength);

function InvoiceValueCalculation(billing_percent)
{
    
   var contract_value=parseInt(document.getElementById("contract_value").value);
   var invoice_value=(contract_value*billing_percent)/100;
   document.getElementById("invoice_amount").value=invoice_value;
   document.getElementById("balance").value=contract_value-invoice_value;
}
</script>