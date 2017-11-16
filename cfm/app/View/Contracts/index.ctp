<div class="x_content">
<!--    <div id="loading" style="display: none;"><div class="alert alert-info" role="alert"><i class=" fa fa-spinner fa-spin"></i> Please wait...</div></div>-->
    <?php echo $this->Form->create('Contract', array('controller' => $controller, 'action' => $action, 'class' => 'form-horizontal form-label-left', 'id' => 'Contract')); ?>
    <div class="form-group">
        <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Contract/Type:</label>
            <?php echo $this->Form->input("contracttype", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' =>false,'data-placeholder'=>'Choose Contract Type')) ?>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Date From</label>
            <?php echo $this->Form->input("date_from", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' =>false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_from', 'required' =>false,'value'=>$start_date)) ?>                

        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Date To</label>
            <?php echo $this->Form->input("date_to", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_to', 'required' =>false,'value'=>$end_date)) ?>                

        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Date Type</label>
            <?php echo $this->Form->input("date", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1,'id'=>'DateFieldContract', 'empty'=>'', 'required' =>false)) ?>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Contract/PO.No:</label>
            <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false,'data-placeholder'=>'Choose Contract/PO No.')) ?>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12 form-group">
            <label>Company/Unit</label>
            <?php echo $this->Form->input("unit_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'unit_id', 'required' => false,'data-placeholder'=>'Choose Company/Unit')) ?>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 form-group">
            <label>Client</label>
            <?php echo $this->Form->input("client_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'client_id', 'required' => false,'data-placeholder'=>'Choose Client')) ?>
        </div>
       <!-- <div class="col-md-2 col-sm-2 col-xs-12 form-group">
            <label>Currency</label>
            <?php //echo $this->Form->input("currency", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'currency', 'required' => false)) ?>
        </div> -->
        <div class="col-md-1 col-sm-1 col-xs-12 form-group">
            <label>&nbsp;</label>
            <?php echo $this->Form->submit('Search', array('class' => 'btn btn-success disabled_btn', 'id' => 'ContractSubmit')); ?>
            <?php echo $this->Form->end(); ?>
        </div>

    </div>
   
    <?php //echo $this->element('sql_dump');  ?>
</div>
 
<div class="x_panel">
    <div class="x_title">
        <h2>Contract List:</h2>
        <ul class="nav navbar-right panel_toolbox">                      
            <li><a href="<?php echo $this->Html->url('/contracts/add/'); ?>" class="btn btn-primary"><i class="fa fa-plus"> New PO.</i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Unit</th>
                    <th>Contract Type</th>
                    <th>Contract/PO No</th>
                    <th>Amount(BDT)</th>
                    <th>Amount(USD)</th>
                    <th>Contract Date</th>                   
                    <th>Delivery Start</th>
                    <th>Deadline</th>
                    <th>Billing Percent(Advance)</th>
                    <th>Billing Percent(Progressive)</th>                   
                    <th>Billing Percent(1st Retention)</th>
                    <th>Billing Percent(2nd Retention)</th>
                    <th>LC Ref:</th>
                    <th>LC Validity</th>
                    <th>Invoice Submission For Advance Payment</th>
                    <th>Payment Cheque Collection/EFT For Advance Payment</th>
                    <th>Payment Credited To Bank For Advance Payment</th>
                    <th>PLI/PAC</th>
                    <th>PLI Approval</th>
                    <th>RR Collection/Bidders PC Receive/FAC</th>
                    <th>Invoice Submission For Progressive Payment</th>
                    <th>Payment Certificate/Cheque Collection/EFT For Progressive Payment</th>
                    <th>Payment Credited To Bank for Progressive Payment</th>
                    <th>Invoice Submission For Retention Payment(1st)</th>
                    <th>Payment Certificate/Cheque Received For Retention Payment(1st)</th>
                    <th>Payment Credited to Bank For Retention Payment(1st)</th>
                    <th>Invoice Submission For Retention Payment(2nd)</th>
                    <th>Payment Certificate/Cheque Received For Retention Payment(2nd)</th>
                    <th>Payment Credited to Bank For Retention Payment(2nd)</th>
                    <th>Status</th>                    
                    <th>Added By</th>
                    <th>Added Date</th>
                    <th>Modified By</th>
                    <th>Modified Date</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($results as $contract):
                    ?>
                    <tr> 
                        <td><?php echo $contract['Client']['name']; ?></td>
                        <td><?php echo $contract['Unit']['name']; ?></td>
                        <td><?php echo h($contract['Contract']['contracttype']); ?>&nbsp;</td>
                        <td><?php echo h($contract['Contract']['contract_no']); ?>&nbsp;</td>
                        <td><?php echo h($contract['Contract']['contract_value_bdt']); ?>&nbsp;</td>
                        <td><?php echo h($contract['Contract']['contract_value_usd']); ?>&nbsp;</td>
                        <!-- <td><?php //echo (isset($contract_amounts[$contract['Contract']['id']]['BDT']))?($contract_amounts[$contract['Contract']['id']]['BDT']):0.00; ?>&nbsp;</td>
                        <td><?php //echo (isset($contract_amounts[$contract['Contract']['id']]['USD']))?$contract_amounts[$contract['Contract']['id']]['USD']:0.00; ?>&nbsp;</td>-->
                        <td><?php echo h($contract['Contract']['contract_date']); ?>&nbsp;</td>                       
                        <td><?php echo h($contract['Contract']['delivery_strat_date']); ?>&nbsp;</td>
                        <td><?php echo h($contract['Contract']['contract_deadline']); ?>&nbsp;</td>
                        <td><?php echo h($contract['Contract']['billing_percent_adv']); ?>&nbsp;%</td>
                        <td><?php echo h($contract['Contract']['billing_percent_progressive']); ?>&nbsp;%</td>
                        <td><?php echo h($contract['Contract']['billing_percent_first_retention']); ?>&nbsp;%</td>
                        <td><?php echo h($contract['Contract']['billing_percent_second_retention']); ?>&nbsp;%</td>
                        <td><?php echo h($contract['Contract']['lc_ref']); ?>&nbsp;</td>
                        <td><?php echo h($contract['Contract']['lc_validity']); ?>&nbsp;</td>
                        <td><?php echo h($contract['Contract']['invoice_submission_adv']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['payment_cheque_collection_adv']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['payment_credited_to_bank_adv']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['pli_pac']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['pli_aproval']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['rr_collection_progressive']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['invoice_submission_progressive']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['payment_cheque_collection_progressive']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['payment_credited_to_bank_progressive']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['invoice_submission_retention']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['payment_cheque_collection_retention']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['payment_credited_to_bank_retention']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['invoice_submission_retention_2nd']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['payment_cheque_collection_retention_2nd']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['payment_credited_to_bank_retention_2nd']); ?>&nbsp;Days</td>
                        <td><?php echo h($contract['Contract']['status']!=1)?'Running':'Complited'; ?>&nbsp;</td>                        
                        <td><?php echo h($contract['Contract']['added_by']); ?>&nbsp;</td>
                        <td><?php echo h($contract['Contract']['added_date']); ?>&nbsp;</td>
                        <td><?php echo h($contract['Contract']['modified_by']); ?>&nbsp;</td>
                        <td><?php echo ($contract['Contract']['modified_date'] != '0000-00-00 00:00:00') ? $contract['Contract']['modified_date'] : 'N/A'; ?>&nbsp;</td>
                        <td><?php echo h($contract['Contract']['remarks']); ?>&nbsp;</td>
                        <td>
                            <a href="<?php echo $this->Html->url('/contracts/edit/' . $contract['Contract']['id']); ?>"><i class="fa fa-edit" title="Contract Edit">EDIT</i></a>&nbsp;&nbsp;&nbsp;&nbsp;

                            <a href="<?php echo $this->Html->url('/contracts/view/' . $contract['Contract']['id']); ?>"><i class="glyphicon glyphicon-search" title="Contract Details"></i>SEARCH</a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo $this->Html->url('/contract_products/add/' . $contract['Contract']['id']); ?>"><i class="fa fa-shopping-cart" title="Add Contract's Products">ADD PRODUCT</i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div> 