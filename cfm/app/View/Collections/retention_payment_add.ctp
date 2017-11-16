<div class="x_panel">
    <div class="x_title">
        <h2><?php echo $collection_type;?>:</h2>
        <ul class="nav navbar-right panel_toolbox">                      
            <li><a href="javascript:window.history.go(-1);" class="btn btn-primary" title="Back to previous page"><i class="fa fa-arrow-left"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php echo $this->Form->create('Collection', array('action' => 'SaveCollection', 'class' => 'form-horizontal form-label-left', 'id' => 'Collection')); ?>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Contract/PO. No <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                 <?php echo $this->Form->hidden("collection_type", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'id'=>'collection_type', 'value' =>$collection_type)) ?>
                 <?php echo $this->Form->hidden("contract_id", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'value' =>$contract_id,'required' =>'required')) ?>
                <?php echo $this->Form->input("contract_no", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'value' =>$result['Contract']['contract_no'],'readOnly' =>true)) ?>
            </div> 
        </div> 
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Contract Value <?php //echo $currency; ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("contract_value", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'readOnly' =>true, 'id' =>'contract_value','required'=>'required','value'=>$contract_value)) ?>
            </div>
        </div>
        
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Received Amount(include AIT,VAT,LD,OD) <?php //echo $currency; ?>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("receive_amount", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'readOnly' =>true, 'id' =>'receive_amount','readOnly'=>true,'value'=>$previous_payment)) ?>
            </div>
        </div>
         <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Balance in Contract Value <?php //echo $currency; ?>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("balance_in_contract", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'readOnly' =>true, 'id' =>'balance_in_contract','readOnly'=>true,'value'=>$balance_in_contract_value)) ?>
            </div>
        </div>
         
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Currency <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("currency", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'value' => $currency,'readOnly' =>true)) ?>
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
                <?php echo $this->Form->input("billing_percent", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'id' =>'billing_percent', 'value'=>$billing_percent,'onchange'=>"InvoiceValueCalculation(this.value)",'readOnly'=>true)) ?>
            </div>
        </div>
         <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Invoice Value <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("invoice_amount", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'id' =>'invoice_amount','readOnly'=>true,'value'=>$invoice_value)) ?>
            </div>
        </div>
        <?php foreach ($product_category as $value):
            $checkAlreadyPayment=ClassRegistry::init('Collection')->getCollectionCategoryByContract($contract_id,$value['ProductCategory']['id'],$collection_type);
            ?>
        <div class="item form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" style="color:green;font-weight:bold"><?php echo $value['ProductCategory']['name'];if($checkAlreadyPayment){echo '(Taken)';} ?>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" name="data[Collection][product_category_id][<?php echo $value['ProductCategory']['id'] ?>]" class="form-control col-md-7 col-xs-12" value="<?php echo ((!$checkAlreadyPayment)? round(($billing_percent*$value[0]['amount'])/100,2):''); ?>" required="1"style='border-color:green'step="any"/>
                <?php //echo $this->Form->input("product_category_id", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'id' =>'balance','readOnly'=>true,'value'=>($invoice_value*$value[0]['amount'])/100)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $collection_type.'.'.$billing_percent.'% X PO Product Value '.$value[0]['amount'] ; ?>
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
                 if($collection_type=="Retention(1st)"):
                 //Planned Submission Date
                 $planned_submission_date = strtotime($result['Contract']['contract_deadline']) + $result['Contract']['invoice_submission_retention'] * 86400;
                 $planned_submission_date = date('Y-m-d', $planned_submission_date);
                 //reaming days
                 $reaming_days=strtotime($planned_submission_date)-strtotime(date('Y-m-d'));
                 $reaming_days = $reaming_days/86400;                 
                 //Planned Payment Certificate/Cheque Collection Date
                 $planned_payment_certificate_or_cheque_collection_date=strtotime($planned_submission_date)+$result['Contract']['payment_cheque_collection_retention'] * 86400;
                 $planned_payment_certificate_or_cheque_collection_date = date('Y-m-d', $planned_payment_certificate_or_cheque_collection_date);
                 //planned payment collection date
                 $planned_payment_collection_date=  strtotime($planned_payment_certificate_or_cheque_collection_date)+$result['Contract']['payment_credited_to_bank_retention'] * 86400;
                 $planned_payment_collection_date = date('Y-m-d', $planned_payment_collection_date);
                 else:
                 //Planned Submission Date
                 $planned_submission_date = strtotime($result['Contract']['contract_deadline']) + $result['Contract']['invoice_submission_retention_2nd'] * 86400;
                 $planned_submission_date = date('Y-m-d', $planned_submission_date);
                 //reaming days
                 $reaming_days=strtotime($planned_submission_date)-strtotime(date('Y-m-d'));
                 $reaming_days = $reaming_days/86400;                 
                 //Planned Payment Certificate/Cheque Collection Date
                 $planned_payment_certificate_or_cheque_collection_date=strtotime($planned_submission_date)+$result['Contract']['payment_cheque_collection_retention_2nd'] * 86400;
                 $planned_payment_certificate_or_cheque_collection_date = date('Y-m-d', $planned_payment_certificate_or_cheque_collection_date);
                 //planned payment collection date
                 $planned_payment_collection_date=  strtotime($planned_payment_certificate_or_cheque_collection_date)+$result['Contract']['payment_credited_to_bank_retention_2nd'] * 86400;
                 $planned_payment_collection_date = date('Y-m-d', $planned_payment_collection_date);    
                 endif;
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
                <?php echo $this->Form->hidden("planned_payment_certificate_or_cheque_collection_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'value' =>$planned_payment_certificate_or_cheque_collection_date)) ?>
                <?php echo $this->Form->hidden("planned_payment_collection_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'value' =>$planned_payment_collection_date)) ?>
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
    <div class="clearfix"></div>
</div>
<script>
strLength =document.getElementById("invoice_ref_no").value.length*2;    
document.getElementById("invoice_ref_no").focus();
document.getElementById("invoice_ref_no").setSelectionRange(strLength, strLength);

function InvoiceValueCalculation(billing_percent)
{ 
    var balance_in_contract=parseInt(document.getElementById("balance_in_contract").value);  
    var contract_value=parseInt(document.getElementById("contract_value").value);  
   
    var invoice_value=(contract_value*billing_percent)/100;
    document.getElementById("invoice_amount").value=invoice_value;
    document.getElementById("balance").value=balance_in_contract-invoice_value;
}
</script>




