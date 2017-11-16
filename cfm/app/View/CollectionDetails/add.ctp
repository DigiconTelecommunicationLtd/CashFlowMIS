<div class="x_panel">
    <div class="x_content">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Collection Type</th>
                        <th>Invoice Amount</th>
                        <th>Cheque Amount</th>
                        <th>Received Amount</th>
                        <th>Adv. Adust Amount</th>
                        <th>AIT</th>
                        <th>VAT</th>
                        <th>L.D</th>                  
                        <th>Other Deduction</th>
                        <th>Balance</th>
                        <th>Planned Invoice Submission</th>
                        <th>Actual Invoice Submission Date</th>
                        <th>Planned Payment Certification Collection Date</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    
                        <tr>
                            <td><?php echo h($data['Collection']['collection_type']);?></td>
                            <td><?php echo h($data['Collection']['invoice_amount']);?></td>
                            <td><?php echo h($data['Collection']['cheque_amount']);?></td>
                            <td><?php echo h($data['Collection']['amount_received']);?></td>
                            <td><?php echo h($data['Collection']['ajust_adv_amount']);?></td>
                            <td><?php echo h($data['Collection']['ait']);?></td>
                            <td><?php echo h($data['Collection']['vat']);?></td>
                            <td><?php echo h($data['Collection']['ld']);?></td>
                            <td><?php echo h($data['Collection']['other_deduction']);?></td>
                            <td><?php echo h($data['Collection']['invoice_amount']-($data['Collection']['amount_received']+$data['Collection']['ait']+$data['Collection']['vat']+$data['Collection']['ld']+$data['Collection']['other_deduction']));?></td>
                            <td><?php echo h($data['Collection']['planned_submission_date']);?></td>
                            <td><?php echo h($data['Collection']['actual_submission_date']);?></td>
                            <td><?php echo h($data['Collection']['planned_payment_certificate_or_cheque_collection_date']);?></td>
                            <td><?php echo h($data['Collection']['remarks']);?></td>
                        </tr>
                                  
                </tbody>
            </table>
        </div>
     <?php 
         $user = $this->Session->read('UserAuth');
         $UserGroup=$user['UserGroup']['alias_name'];
         $gp=array('Admin','SM','SMA');
         if(in_array($UserGroup, $gp)): ?>
    <div class="x_content">
        <?php echo $this->Form->create('CollectionDetail', array('class' => 'form-horizontal form-label-left')); ?>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">PO/Contract No:<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">                
                <?php echo $this->Form->input("contract_no", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'value' => $data['Contract']['contract_no'],'id'=>'contract_no')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Invoice Ref. No:<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">                
                <?php echo $this->Form->input("invoice_ref_no", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'value' => $data['Collection']['invoice_ref_no'],'id'=>'invoice_ref_no')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Currency:<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">                
                <?php echo $this->Form->input("currencytype", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 disabled", 'required' => 'required', 'value' => $data['Collection']['currency'],'id'=>'currencytype')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Cheque Amount<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("cheque_amount", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' =>false, 'step' => 'any')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Adust Adv. Amount</label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("ajust_adv_amount", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'step' => 'any')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">AIT</label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("ait", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'step' => 'any')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">VAT</label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("vat", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'step' => 'any')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">LD</label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("ld", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12")) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Other Deduction</label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("other_deduction", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12")) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Certification/Cheque Collection Date
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("cheque_or_payment_certification_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'aria-describedby' => "inputSuccess2Status3", 'id' => 'cheque_or_payment_certification_date', 'required' =>false)) ?>                
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Actual Payment Certification/Cheque Collection Date 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("actual_payment_certificate_or_cheque_collection_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'aria-describedby' => "inputSuccess2Status3", 'id' => 'actual_payment_certificate_or_cheque_collection_date','required'=>false)) ?>                
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-4 col-sm-6 col-xs-12" for="name">Forecasted Payment Collection Date 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("forecasted_payment_collection_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control has-feedback-left single_cal3", 'aria-describedby' => "inputSuccess2Status3", 'id' => 'forecasted_payment_collection_date','required'=>'required')) ?>                
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
            <div class="col-md-6 col-md-offset-3"> 
                <?php echo $this->Form->hidden('collection_id', array('value' => $data['Collection']['id'])); ?>
                <?php echo $this->Form->hidden('contract_id', array('value' => $data['Collection']['contract_id'])); ?>
                <?php echo $this->Form->hidden('invoice_ref_no', array('value' => $data['Collection']['invoice_ref_no'])); ?>
                <?php echo $this->Form->hidden('product_category_id', array('value' => $data['Collection']['product_category_id'])); ?>                
                <?php echo $this->Form->hidden('collection_type', array('value' => $data['Collection']['collection_type'])); ?>                
                <?php echo $this->Form->hidden('currency', array('value' => $data['Collection']['currency'])); ?>                    
                <?php echo $this->Form->submit('Submit', array('class' => 'btn btn-success disabled_btn', 'style' => 'text-align:right')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div> 
    </div>
    <?php endif; ?>
    <div class="x_content">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Collection Type</th>
                        <th>Cheque Amount</th>
                        <th>Received Amount</th>
                        <th>Adv. Adust Amount</th>
                        <th>AIT</th>
                        <th>VAT</th>
                        <th>L.D</th>                  
                        <th>Other Deduction</th>
                        <th>Balance</th>
                        <th>Certification/Cheque Date</th>
                        <th>Actual Payment Certification/Cheque Collection Date</th>
                        <th>Forecasted Payment Collection Date</th>
                        <th>Bank Credit(Payment Receive)Date</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['CollectionDetail'] as $value):?>
                        <tr>
                            <td><?php echo $this->Html->link(__('Entry Received Amount/Edit'), array('action' => 'edit', $value['id'])); ?></td>
                            <td><?php echo h($value['collection_type']);?></td>
                            <td><?php echo h($value['cheque_amount']);?></td>
                            <td><?php echo h($value['amount_received']);?></td>
                            <td><?php echo h($value['ajust_adv_amount']);?></td>
                            <td><?php echo h($value['ait']);?></td>
                            <td><?php echo h($value['vat']);?></td>
                            <td><?php echo h($value['ld']);?></td>
                            <td><?php echo h($value['other_deduction']);?></td>
                            <td><?php echo h($value['cheque_amount']-($value['amount_received']+$value['ait']+$value['vat']+$value['ld']+$value['other_deduction']));?></td>
                            <td><?php echo h($value['cheque_or_payment_certification_date']);?></td>
                            <td><?php echo h($value['actual_payment_certificate_or_cheque_collection_date']);?></td>
                            <td><?php echo h($value['forecasted_payment_collection_date']);?></td>
                            <td><?php echo h($value['payment_credited_to_bank_date']);?></td>
                            <td><?php echo h($value['remarks']);?></td>

                        </tr>
                    <?php endforeach; ?>                     
                </tbody>
            </table>
        </div>
</div>
<script>
    document.getElementById("contract_no").disabled=true;
    document.getElementById("invoice_ref_no").disabled=true;
    document.getElementById("currencytype").disabled=true;
    document.getElementById("balance").disabled=true;
</script>
