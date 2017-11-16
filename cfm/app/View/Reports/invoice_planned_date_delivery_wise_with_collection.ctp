<div class="x_panel">
    <div class="x_title">
       Planned Payment Certificate/Cheque Collection Date Delivery wise:
        <div class="clearfix"></div>
    </div>
    <div class="x_content">        
        <?php echo $this->Form->create('Report', array('controller' =>'reports', 'action' =>"invoice_planned_date_delivery_wise_with_collection/ ", 'class' => 'form-horizontal form-label-left', 'id' => 'Report', 'onsubmit' => "return validate();")); ?>
        <div class="form-group">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Date From:<span class="required">*</span></label>
                <?php echo $this->Form->input("date_from", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_from', 'required' =>true)) ?>                
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Date To:<span class="required">*</span></label>
                <?php echo $this->Form->input("date_to", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_to', 'required' =>true)) ?>              
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>PO No:</label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '')) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                <label>Company/Unit</label>
                <?php echo $this->Form->input("unit_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'unit_id', 'required' => false)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                <label>Client</label>
                <?php echo $this->Form->input("client_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'client_id', 'required' => false)) ?> 
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Product Category</label>
                <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'product_category_id', 'required' => false,'options'=>$product_categories)) ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Currency</label>
                <?php echo $this->Form->input("currency", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'currency', 'required' => false)) ?>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-12 form-group">
                <label>&nbsp;</label>
                <?php echo $this->Form->submit('Search', array('class' => 'btn btn-success', 'id' => 'ReportSubmit')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>      
    </div>
    <div class="clearfix"></div>
    <div class="x_content">
        <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>PO.NO</th>
                    <th>Lot.NO</th>                    
                    <th>Unit</th>
                    <th>Client</th>                    
                    <th>Product/Category</th>                     
                    <th>Planned Quantity</th>
                    <th>Actual Invoice Quantity</th>                    
                    <th>UOM</th>                     
                    <th>Actual Delivery Date</th>
                    <th>Delivery Value</th>                    
                    <th>Planned Invoice Amount</th>
                    <th>Actual Invoice Amount</th>                    
                    <th>Cheque Amount</th>
                    <th>Currency</th>
                    <th>Days Remaining</th>
                    <th>Invoice Ref.</th>                    
                    <th>Planned Invoice Submission Date</th>                   
                    <th>Actual Invoice Submission Date</th>                    
                   <th>Planned Certificate/Cheque Collection Date</th>                    
                   <th>Actual Certificate/Cheque Collection Date</th>                   
                   <th>Certificate/Cheque Date</th>                    
                    <th>Forecasted Payment Collection Date</th> 
                    <th>Planned Bank Credit (Payment Received) Date</th> 
                    <th>Actual Bank Credit (Payment Received) Date</th>                    
                    <th>Amount Received</th>
                    <th>Adv. Adjustment</th>
                    <th>AIT</th>
                    <th>VAT</th>
                    <th>L.D</th>
                    <th>Other Deduction</th>                    
                    <th>Planned Balance</th>
                    <th>Actual Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($results as $result): 
		 $invoice_submission_progressive=$result['Delivery']['invoice_submission_progressive'];  
              
                 //calculation remainging days
                 $reaming_days=strtotime($invoice_submission_progressive)-strtotime(date('Y-m-d'));
                 $reaming_days = $reaming_days/86400;                 
                 //Planned Payment Certificate/Cheque Collection Date
                $payment_cheque_collection_progressive=$result['Delivery']['payment_cheque_collection_progressive'];
                 //planned payment collection date
                 $payment_credited_to_bank_progressive=$result['Delivery']['payment_credited_to_bank_progressive'];
                  
                 $collection_history=  ClassRegistry::init('Collection')->getCollectionByTrackID($payment_cheque_collection_progressive,$result['Delivery']['product_category_id'],$result['Delivery']['contract_id'],$result['Delivery']['unitid'],$result['Delivery']['clientid'],$result['Delivery']['currency'],$result['Delivery']['lot_id']);  
                 
                ?>
                    <tr>                       
                        <td><?php echo h($result['Contract']['contract_no']);?></td>
                        <td><?php echo h($result['Delivery']['lot_id']);?></td>
                        <td><?php echo h($units[$result['Delivery']['unitid']]);?></td>
                        <td><?php echo h($clients[$result['Delivery']['clientid']]);?></td>
                        <td><?php echo h($result['ProductCategory']['name']);?></td> 
                        
                        <td><?php echo h($result[0]['quantity']);?></td>
                        <td><?php echo $quantity=($collection_history)? $collection_history[0]['quantity']:0;?></td>
                        
                        <td><?php echo h($result['Delivery']['uom']);?></td>
                        
                        <td><?php echo h($result[0]['actual_delivery_date']);?></td>
                        <td><?php echo $delivery_amount=h($result[0]['delivery_amount']);?></td>
                        
                        <td><?php echo $invoice_amount=h(round(($delivery_amount*$result['Contract']['billing_percent_progressive'])/100,3));?></td>                        
                        <td><?php echo $actual_invoice_amount=($collection_history)? $collection_history[0]['invoice_amount']:0.00;?></td>
                        
                        <td><?php echo $cheque_amount=($collection_history)? $collection_history[0]['cheque_amount']:0.00;?></td>
			            <td><?php echo h($result['Delivery']['currency']);?></td>
						
                        <td><?php echo h($reaming_days);?></td>
                        <td><?php echo h(($collection_history)?$collection_history['Collection']['invoice_ref_no']:"");?></td>
                        
                        
                        <td><?php echo h($invoice_submission_progressive);?></td>                        
                        <td><?php echo ($collection_history)? ($collection_history['Collection']['actual_submission_date']!="0000-00-00")?$collection_history['Collection']['actual_submission_date']:"":"";?></td>
                        
                        <td><?php echo h($payment_cheque_collection_progressive);?></td>
                        <td><?php echo ($collection_history)? ($collection_history['Collection']['actual_payment_certificate_or_cheque_collection_date']!="0000-00-00")?$collection_history['Collection']['actual_payment_certificate_or_cheque_collection_date']:"":"";?></td>
                        
                        <td><?php echo ($collection_history)? ($collection_history['Collection']['cheque_or_payment_certification_date']!="0000-00-00")?$collection_history['Collection']['cheque_or_payment_certification_date']:"":"";?></td>
                        
                        <td><?php echo ($collection_history)? ($collection_history['Collection']['forecasted_payment_collection_date']!="0000-00-00")?$collection_history['Collection']['forecasted_payment_collection_date']:"":"";?></td>
                        
                        
                        <td><?php echo h($payment_credited_to_bank_progressive);?></td>  
                        <td><?php echo ($collection_history)? ($collection_history['Collection']['payment_credited_to_bank_date']!="0000-00-00")?$collection_history['Collection']['payment_credited_to_bank_date']:"":"";?></td>
                        
                        <td><?php echo $amount_received=($collection_history)? $collection_history[0]['amount_received']:0.00;?></td>
                        <td><?php echo $ajust_adv_amount=($collection_history)? $collection_history[0]['ajust_adv_amount']:0.00;?></td>
                        <td><?php echo $ait=($collection_history)? $collection_history[0]['ait']:0.00;?></td>
                        <td><?php echo $vat=($collection_history)? $collection_history[0]['vat']:0.00;?></td>
                        <td><?php echo $ld=($collection_history)? $collection_history[0]['ld']:0.00;?></td>
                        <td><?php echo $other_deduction=($collection_history)? $collection_history[0]['other_deduction']:0.00;?></td>
                        
                        <td><?php echo round($invoice_amount-($amount_received+$ait+$vat+$ld+$other_deduction),3);?></td>
                        <td><?php echo round($actual_invoice_amount-($amount_received+$ait+$vat+$ld+$other_deduction),3);?></td>
                    </tr>			 
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
