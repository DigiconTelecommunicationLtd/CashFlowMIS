<?php 
    $user = $this->Session->read('UserAuth');
    $UserGroup=$user['UserGroup']['alias_name'];
    
?>
<div class="x_panel">
    <div class="x_content">
        <?php echo $this->Form->create('CollectionDetail', array('action' => 'edit', 'class' => 'form-horizontal form-label-left','id'=>'CollectionDetail')); ?>       
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Invoice Ref. No:<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">    
                <?php echo $this->Form->input("id");?>
                <?php echo $this->Form->hidden("collection_id");?>
                <?php echo $this->Form->input("invoice_ref_no", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required','id'=>'invoice_ref_no')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Cheque Amount<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("cheque_amount", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'step' => 'any','id'=>'cheque_amount')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Received Amount<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("amount_received", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'step' => 'any','style'=>'border-color:green','onchange' => "calculation_balance(this.value)",'id'=>'amount_received')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Adust Adv. Amount</label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("ajust_adv_amount", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'step' => 'any','id'=>'ajust_adv_amount')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">AIT</label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("ait", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'step' => 'any','id'=>'ait','onchange' => "calculation_balance(this.value)")) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">VAT</label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("vat", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'step' => 'any','id'=>'vat','onchange' => "calculation_balance(this.value)")) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">LD</label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("ld", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'id'=>'ld','onchange' => "calculation_balance(this.value)")) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Other Deduction</label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("other_deduction", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'id'=>'other_deduction','onchange' => "calculation_balance(this.value)")) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Balance</label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("balance", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'id'=>'balance','value'=>$this->request->data['CollectionDetail']['cheque_amount']-($this->request->data['CollectionDetail']['amount_received']+$this->request->data['CollectionDetail']['ait']+$this->request->data['CollectionDetail']['vat']+$this->request->data['CollectionDetail']['ld']+$this->request->data['CollectionDetail']['other_deduction']))) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Bank Credit(Payment Receive)Date<span class="required">*</span> 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("payment_credited_to_bank_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'aria-describedby' => "inputSuccess2Status3", 'id' => 'forecasted_payment_collection_date', 'required' =>false,'style'=>'border-color:green')) ?>                
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>

        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Remarks</label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("remarks", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12")) ?>
            </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-6">                                    
                <?php echo $this->Form->submit('Submit', array('class' => 'btn btn-success disabled_btn', 'style' => 'text-align:right')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div> 
    </div>
</div>
<script>
    
    document.getElementById("invoice_ref_no").disabled = true;   
    document.getElementById("balance").disabled = true;
    
</script>
<script>
function calculation_balance() {
    var cheque_amount = document.forms["CollectionDetail"]["cheque_amount"].value;     
    var amount_received = document.forms["CollectionDetail"]["amount_received"].value;
    if(!amount_received||isNaN(amount_received))
    {
        amount_received=0;
    }
    var ait = document.forms["CollectionDetail"]["ait"].value;
     if(!ait||isNaN(ait))
    {
        ait=0;
    }
    var vat = document.forms["CollectionDetail"]["vat"].value;
     if(!vat||isNaN(vat))
    {
        vat=0;
    }
    var ld = document.forms["CollectionDetail"]["ld"].value;
     if(!ld||isNaN(ld))
    {
        ld=0;
    }
    var other_deduction = document.forms["CollectionDetail"]["other_deduction"].value;
     if(!other_deduction||isNaN(other_deduction))
    {
        other_deduction=0;
    }
   var balance=parseInt(cheque_amount)-(parseInt(amount_received)+parseInt(ait)+parseInt(vat)+parseInt(ld)+parseInt(other_deduction));
    if(!balance||isNaN(balance))
    {
        balance=0;
    }
    document.getElementById("balance").value=balance;
}
</script>