<div class="x_panel">
    <div class="x_content">
        <?php echo $this->Form->create('Collection', array('class' => 'form-horizontal form-label-left')); ?>
          <?php if ($this->Session->check('Message.flash')): ?> 
                            <div role="alert" class="alert alert-success alert-dismissible fade in">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                </button>
                                <strong><?php echo $this->Session->flash(); ?></strong>
                            </div> 
                        <?php endif; ?>       
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Invoice Ref. No:<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input('id'); ?>
                <?php echo $this->Form->input("invoice_ref_no", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Billing Percent<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("billing_percent", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Invoice Amount<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("invoice_amount", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required')) ?>
            </div>
        </div> 
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Planned Submission Date<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("planned_submission_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'aria-describedby' => "inputSuccess2Status3", 'id' => 'planned_submission_date', 'value' => ($this->request->data['Collection']['planned_submission_date'] != '0000-00-00') ? $this->request->data['Collection']['planned_submission_date'] : '')) ?>                
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>

        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Actual Submission Date<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("actual_submission_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'required' => 'required', 'aria-describedby' => "inputSuccess2Status3", 'id' => 'actual_submission_date', 'value' => ($this->request->data['Collection']['actual_submission_date'] != '0000-00-00') ? $this->request->data['Collection']['actual_submission_date'] : '')) ?>                
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Planned Payment Certification/Cheque Collection Date 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("planned_payment_certificate_or_cheque_collection_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'aria-describedby' => "inputSuccess2Status3", 'id' => 'planned_payment_certificate_or_cheque_collection_date', 'value' => ($this->request->data['Collection']['planned_payment_certificate_or_cheque_collection_date'] != '0000-00-00') ? $this->request->data['Collection']['planned_payment_certificate_or_cheque_collection_date'] : '')) ?>                
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
       
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Planned Payment Collection Date 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("planned_payment_collection_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'aria-describedby' => "inputSuccess2Status3", 'id' => 'planned_payment_collection_date', 'value' => ($this->request->data['Collection']['planned_payment_collection_date'] != '0000-00-00') ? $this->request->data['Collection']['planned_payment_collection_date'] : '')) ?>                
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Remarks<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("remarks", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12")) ?>
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3"> 
                <?php echo $this->Form->hidden('contract_id'); ?>
                <?php echo $this->Form->hidden('collection_type'); ?>
                <?php echo $this->Form->hidden('currency'); ?>                 
                <?php echo $this->Form->submit('Edit Invoice', array('class' => 'btn btn-success disabled_btn', 'style' => 'text-align:right')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>                    
    </div>
    <div class="item form-group">
        <div class="col-md-6 col-md-offset-8">          
            <?php echo $this->Form->postLink(__('Delete This Invoice'), array('action' => 'delete', $this->Form->value('Collection.id')), array('class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to delete # %s? All product(Progressive Payment) of this invoice will be deleted.', $this->Form->value('Collection.invoice_ref_no')))); ?>
        </div>
    </div>
</div>
