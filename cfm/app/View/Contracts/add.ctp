<div class="x_panel">
    <div class="x_title">
        <h2><strong>FIRST STEP (PO. INFORMATION)</strong></h2>         
        <ul class="nav navbar-right panel_toolbox">                      
            <li><a href="javascript:window.history.go(-1);" class="btn btn-primary"><i class="fa fa-arrow-right"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php echo $this->Form->create('Contract', array('action' => 'add', 'class' => 'form-horizontal form-label-left',"onsubmit"=>"return contractFormValidation();")); ?>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Client Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("client_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control", 'required' => 'required', 'tabindex' => -1, 'empty' => '', 'data-placeholder' => 'Choose a Client')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Company/Unit <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("unit_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control", 'required' => 'required', 'tabindex' => -1, 'empty' => '', 'data-placeholder' => 'Choose a Company/Unit')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Type of Contract <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("contracttype", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control", 'required' => 'required', 'tabindex' => -1, 'empty' => '', 'data-placeholder' => 'Choose a Contract Type')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Contract/PO No<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("contract_no", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required')) ?>
            </div>
        </div>
          <div class="item form-group">
             <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Contract Value BDT
             </label>
             <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("contract_value_bdt", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'step'=>'any','id'=>'contract_value_bdt','min'=>0)) ?>
             </div>
         </div>
         <div class="item form-group">
             <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Contract Value USD
             </label>
             <div class="col-md-6 col-sm-6 col-xs-12">
               <?php echo $this->Form->input("contract_value_usd", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'step'=>'any','id'=>'contract_value_usd','min'=>0)) ?>
             </div>
         </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Date of Contract<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("contract_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'aria-describedby' => "inputSuccess2Status3",'id'=>'contract_date')) ?>                
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">LC Ref:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("lc_ref", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12")) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">LC Validity
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("lc_validity", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'aria-describedby' => "inputSuccess2Status3",'id'=>'lc_validity')) ?>                
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>                
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Date of Delivery Start<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("delivery_strat_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'aria-describedby' => "inputSuccess2Status3",'id'=>'delivery_strat_date')) ?>                
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>                
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Contract Deadline<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("contract_deadline", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'aria-describedby' => "inputSuccess2Status3",'id'=>'contract_deadline')) ?>                
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
        <fieldset>
           <legend><h2><strong>ADVANCE/RETENTION/PROGRESSIVE PAYMENT TERM ASSUMPTION (Billing Percent(%))</strong></h2> </legend>
        </fieldset>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Advance Payment<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("billing_percent_adv", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'id'=>'billing_percent_adv','min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name"> Progressive Payment<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("billing_percent_progressive", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'id'=>'billing_percent_progressive','min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name"> 1st Retention Payment<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("billing_percent_first_retention", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'id'=>'billing_percent_first_retention','min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name"> 2nd Retention Payment
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("billing_percent_second_retention", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'id'=>'billing_percent_second_retention','min'=>0)) ?>
            </div>
        </div>
        <fieldset>
           <legend><h2><strong>ADVANCE PAYMENT ASSUMPTION (NO OF DAYS(<span style="color: green">FROM CONTRACT DATE</span>)))</strong></h2> </legend>
        </fieldset>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Invoice Submission [Advance]<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("invoice_submission_adv", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name"> Payment Cheque Collection/EFT [Advance]<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("payment_cheque_collection_adv", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Payment Credited To Bank [Advance]<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("payment_credited_to_bank_adv", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'min'=>0)) ?>
            </div>
        </div>
        <fieldset>
           <legend><h2><strong>PROGRESSIVE PAYMENT ASSUMPTION (NO OF DAYS(<span style="color: green">FROM PRODUCT DELIVERY</span>)))</strong></h2> </legend>
        </fieldset>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">PLI/PAC [Client Inspection]<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("pli_pac", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">PLI Approval [Client Inspection]<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("pli_aproval", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">RR Collection/Bidders PC Receive/FAC [Client Inspection]<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("rr_collection_progressive", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Invoice Submission [Progressive]<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("invoice_submission_progressive", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Payment Certificate/Cheque Collection/EFT [Progressive]<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("payment_cheque_collection_progressive", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Payment Credited To Bank [Progressive]<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("payment_credited_to_bank_progressive", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'min'=>0)) ?>
            </div>
        </div>
         <fieldset>
           <legend><h2><strong>FIRST RETENTION PAYMENT ASSUMPTION (NO OF DAYS (<span style="color: green">FROM CONTRACT DEADLINE</span>))</strong></h2> </legend>
        </fieldset>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Invoice Submission [1st Retention]<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("invoice_submission_retention", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name"> Payment Certificate/Cheque Received [1st Retention]<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("payment_cheque_collection_retention", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Payment Credited to Bank [1st Retention]<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("payment_credited_to_bank_retention", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'required'=>true,'min'=>0)) ?>
            </div>
        </div>
         <fieldset>
             <legend><h2><strong>SECOND RETENTION PAYMENT ASSUMPTION (NO OF DAYS (<span style="color: green">FROM CONTRACT DEADLINE</span>))</strong></h2> </legend>
        </fieldset>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Invoice Submission [2nd Retention]
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("invoice_submission_retention_2nd", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name"> Payment Certificate/Cheque Received [2nd Retention]
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("payment_cheque_collection_retention_2nd", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'min'=>0)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Payment Credited to Bank [2nd Retention]
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("payment_credited_to_bank_retention_2nd", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number",'min'=>0)) ?>
            </div>
        </div>
        
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Product/Category[Adv. Retention Invoice will be generate using this]<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control", 'required' => 'required', 'tabindex' => -1, 'empty' => '', 'data-placeholder' => 'Choose a Product/Category','options'=>$product_categories)) ?>
            </div>
        </div>

        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Remarks
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("remarks", array("type" => "textarea", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'rows' => 2)) ?>
            </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3"> 
                <?php echo $this->Form->submit('ADD CONTRACT', array('class' => 'btn btn-success disabled_btn')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>                    
    </div>
</div>   
