<div class="x_panel">    
    <div class="x_content">    
    <?php echo $this->Form->create('Collection', array('controller' =>'collections', 'action' =>'/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'Collection')); ?>
    <div class="form-group">
       <!-- <div class="col-md-2 col-sm-2 col-xs-12">
            <label>Date From [Inv. Entry]</label>
            <?php //echo $this->Form->input("date_from", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' =>false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_from', 'required' =>false,'value'=>  isset($data['start_date'])?$data['start_date']:'','tabindex' =>0)) ?>                

        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label>Date To [Inv. Entry]</label>
            <?php //echo $this->Form->input("date_to", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_to', 'required' =>false,'value'=>isset($data['end_date'])?$data['end_date']:'','tabindex' => 1)) ?>                

        </div>-->
        <div class="col-md-4 col-sm-4 col-xs-12">
            <label>Invoice Ref.No:</label>
            <?php echo $this->Form->input("invoice_ref_no", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-4 col-xs-12", 'tabindex' =>2, 'required' => false,'value'=>  isset($data['invoice_ref_no'])?$data['invoice_ref_no']:'')) ?>
        </div>
       <div class="col-md-2 col-sm-2 col-xs-12 form-group">
            <label>Currency</label>
            <?php echo $this->Form->input("currency", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-4 col-xs-12", 'tabindex' =>3, 'empty' => '', 'id' => 'currency', 'required' => false,'default'=>  isset($data['currency'])?$data['currency']:'')) ?>
        </div>
         <div class="col-md-2 col-sm-2 col-xs-12 form-group">
            <label>Collection Type</label>
            <?php echo $this->Form->input("collection_type", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-4 col-xs-12", 'tabindex' =>3, 'empty' => '', 'id' => 'currency', 'required' => false,'default'=>  isset($data['collection_type'])?$data['collection_type']:'','options'=>$collection_types)) ?>
        </div>
       <div class="col-md-4 col-sm-4 col-xs-12">
                <label>PO.No:</label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false,'default'=>  isset($data['contract_id'])?$data['contract_id']:'')) ?>
            </div>
       </div>
        <div class="form-group">
             <div class="col-md-4 col-sm-4 col-xs-12">
                <label>L/C Reference</label>
                <?php echo $this->Form->input("lc_ref", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false,'options'=>$lc_refs)) ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Company/Unit</label>
                <?php echo $this->Form->input("unit_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'unit_id', 'required' => false,'default'=>  isset($data['unit_id'])?$data['unit_id']:'')) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                <label>Client</label>
                <?php echo $this->Form->input("client_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'client_id', 'required' => false,'default'=>  isset($data['client_id'])?$data['client_id']:'')) ?> 
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Product Category</label>
                <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'product_category_id', 'required' => false,'options'=>$product_category,'default'=>  isset($data['product_category_id'])?$data['product_category_id']:'')) ?>
            </div>
        <div class="col-md-1 col-sm-1 col-xs-12 form-group">
            <label>&nbsp;</label>
            <?php echo $this->Form->submit('Search', array('class' => 'btn btn-success', 'id' => 'ContractSubmit')); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
    <div class="x_content">
        <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>PO. No</th>
                    <th>L/C Ref:</th>
                    <th>Collection Type</th>
                    <th>Invoice Ref. No</th>
                    <th>Billing Percent(%)</th>
                    <th>Invoice Amount</th>
                    <th>Cheque Amount</th>
                    <th>Amount Received</th>
                    <th>AIT</th>
                    <th>VAT</th>
                    <th>L.D</th>
                    <th>Other Deduction</th>                    
                    <th>Currency</th>
                    <th>Balance</th>
                    <th>Adv. Adjustment</th>
                    <th>Planned Invoice Submission Date</th>
                    <th>Actual Invoice Submission Date</th>                     
                    <th>Planned Payment Certificate/Cheque Collection Date</th>                    
                    <th>Planned Payment Collection Date</th>                    
                    <th>Added By</th>
                    <th>Added Date</th>
                    <th>Modified By</th>
                    <th>Modified Date</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($collections as $collection): ?>
                    <tr> 
                        <td><?php echo h($product_category[$collection['Collection']['product_category_id']]); ?>&nbsp;</td>

                        <td>
                            <?php echo $collection['Contract']['contract_no']; ?>
                        </td>
                        <td><?php echo h($collection['Contract']['lc_ref']); ?></td>
                        <td><?php echo h($collection['Collection']['collection_type']); ?></td>
                        <td><?php echo h($collection['Collection']['invoice_ref_no']); ?></td>
                        <td><?php echo h($collection['Collection']['billing_percent']); ?>&nbsp;%</td>
                        <td><?php echo trim($collection['Collection']['invoice_amount']); ?></td>
                        <td><?php echo trim($collection['Collection']['cheque_amount']); ?></td>
                        <td><?php echo trim($collection['Collection']['amount_received']); ?></td>
                        <td><?php echo trim($collection['Collection']['ait']); ?></td>
                        <td><?php echo trim($collection['Collection']['vat']); ?></td>
                        <td><?php echo trim($collection['Collection']['ld']); ?></td>
                        <td><?php echo trim($collection['Collection']['other_deduction']); ?></td>
                        <td><?php echo h($collection['Collection']['currency']); ?></td>
                        <td><?php echo trim($collection['Collection']['invoice_amount']-($collection['Collection']['amount_received']+$collection['Collection']['ait']+$collection['Collection']['vat']+$collection['Collection']['ld']+$collection['Collection']['other_deduction'])); ?></td>
                        <td><?php echo trim($collection['Collection']['ajust_adv_amount']); ?></td>
                        <td><?php echo h($collection['Collection']['planned_submission_date'] != "0000-00-00 00:00:00") ? $collection['Collection']['planned_submission_date'] : 'N/A'; ?></td>
                        <td><?php echo h($collection['Collection']['actual_submission_date'] != "0000-00-00 00:00:00") ? $collection['Collection']['actual_submission_date'] : 'N/A'; ?></td>
                        <td><?php echo h($collection['Collection']['planned_payment_certificate_or_cheque_collection_date'] != "0000-00-00") ? $collection['Collection']['planned_payment_certificate_or_cheque_collection_date'] : 'N/A'; ?></td>
                        <td><?php echo h($collection['Collection']['planned_payment_collection_date'] != "0000-00-00") ? $collection['Collection']['planned_payment_collection_date'] : 'N/A'; ?></td>
                       <td><?php echo h($collection['Collection']['added_by']); ?></td>
                        <td><?php echo h($collection['Collection']['added_date']); ?></td>
                        <td><?php echo h($collection['Collection']['modified_by']); ?></td>
                        <td><?php echo h($collection['Collection']['modified_date'] != "0000-00-00 00:00:00") ? $collection['Collection']['modified_date'] : 'N/A'; ?></td>
                        <td><?php echo h($collection['Collection']['remarks']); ?></td>
                        <td class="actions">
						<?php $user = $this->Session->read('UserAuth');
						       $alias_name=$user['UserGroup']['alias_name'];
							   if($alias_name=="SM"||$alias_name=="SMA"||$alias_name=="Admin"||$alias_name=="Finance"):
						?>
                            <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg_cheque_<?php //echo $collection['Collection']['id']; ?>">Entry Cheque/Certification Date</button> -->
                            <?php echo $this->Html->link(__('Cheque/Payment Entry'), array('controller'=>'collection_details','action' => 'add', $collection['Collection']['id']), array('target'=>'_blank','class'=>'btn btn-primary',/*'confirm' => __('Are you sure you want to Edit ?')*/)); ?>
							<?php endif;?>
							<?php  if($alias_name=="Finance"||$alias_name=="Admin"): ?>
                            <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg_payment_<?php //echo $collection['Collection']['id']; ?>">Entry Receive Amount</button> -->
                            <?php endif;?>
							<?php //echo $this->Html->link(__('2nd Input'), "javascript:void(0)", array('class'=>'btn btn-primary',"onclick"=>"window.open('".$this->Html->url(array('controller' => 'collections', 'action' => 'cheque_date',$collection['Collection']['id']))."','photo','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=500,height=500')")); ?>
                            <?php //echo $this->Html->link(__('3rd Input'), "javascript:void(0)", array('class' => 'btn btn-primary', "onclick" => "window.open('" . $this->Html->url(array('controller' => 'collections', 'action' => 'bank_credit_date', $collection['Collection']['id'])) . "','photo','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=500,height=500')")); ?>
                           <?php if($alias_name=="Admin"):?>
                            <?php echo $this->Html->link(__('Action Edit'), array('action' => 'edit', $collection['Collection']['id']), array('target'=>'_blank','class'=>'btn btn-primary','confirm' => __('Are you sure you want to Edit ?'))); ?>
                            <?php //echo $this->Form->postLink(__('Delete This Invoice'), array('action' => 'delete', $collection['Collection']['id']), array('class'=>'btn btn-primary','confirm' => __('Are you sure you want to delete ?'))); ?>
                            <?php endif;?>
                        </td>
             
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div> 

