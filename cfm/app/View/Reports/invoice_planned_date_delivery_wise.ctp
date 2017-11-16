<div class="x_panel">
<div class="x_title">
       Planned Payment Certificate/Cheque Collection Date Delivery wise[without collection]:
        <div class="clearfix"></div>
    </div>
    <div class="x_content">        
        <?php echo $this->Form->create('Report', array('controller' =>'reports', 'action' =>"invoice_planned_date_delivery_wise/ ", 'class' => 'form-horizontal form-label-left', 'id' => 'Report', 'onsubmit' => "return validate();")); ?>
        <div class="form-group">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Planned Payment Certification From</label>
                <?php echo $this->Form->input("date_from", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => 1, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_from', 'required' => false)) ?>                
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Planned Payment Certification To</label>
                <?php echo $this->Form->input("date_to", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => 1, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_to', 'required' => false)) ?>              
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>PO No:</label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false)) ?>
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
                    <th>Quantity</th>
                    <th>UOM</th>                    
                    <th>Delivery Date</th>
                    <th>Delivery Value/Planned to Invoice Amounts</th>
                    <th>Currency</th>                    
                    <th>Planned Invoice Submission</th>
                    <th>Days Reaming</th>
                    <th>Planned Payment Certification/Cheque Collection</th>
                    <th>Planned Payment Credited To Bank</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($results as $result):  
                 $actual_delivery_date=$result[0]['actual_delivery_date'];  
                 //Planned pli_pac Date calculation
                 $pli_pac=strtotime($actual_delivery_date)+$result['Contract']['pli_pac']* 86400;
                 //Planned pli_aproval Date calculation
                 $pli_aproval=$pli_pac+$result['Contract']['pli_aproval']* 86400;
                 //Planned rr_collection_progressive Date calculation
                 $rr_collection_progressive=$pli_aproval+$result['Contract']['rr_collection_progressive']* 86400;
                 //Planned invoice Submission Date calculation
                 $planned_submission_date = $rr_collection_progressive+ $result['Contract']['invoice_submission_progressive'] * 86400;
                 $planned_submission_date = date('Y-m-d', $planned_submission_date);
                 //calculation remainging days
                 $reaming_days=strtotime($planned_submission_date)-strtotime(date('Y-m-d'));
                 $reaming_days = $reaming_days/86400;                 
                 //Planned Payment Certificate/Cheque Collection Date
                 $planned_payment_certificate_or_cheque_collection_date=strtotime($planned_submission_date)+$result['Contract']['payment_cheque_collection_progressive'] * 86400;
                 $planned_payment_certificate_or_cheque_collection_date = date('Y-m-d', $planned_payment_certificate_or_cheque_collection_date);
                 //planned payment collection date
                 $planned_payment_collection_date=  strtotime($planned_payment_certificate_or_cheque_collection_date)+$result['Contract']['payment_credited_to_bank_progressive'] * 86400;
                 $planned_payment_collection_date = date('Y-m-d', $planned_payment_collection_date);
                ?>
                    <tr>                       
                        <td><?php echo h($result['Contract']['contract_no']);?></td>
                        <td><?php echo h($result['Delivery']['lot_id']);?></td>
                        <td><?php echo h($units[$result['Delivery']['unitid']]);?></td>
                        <td><?php echo h($clients[$result['Delivery']['clientid']]);?></td>
                        <td><?php echo h($result['ProductCategory']['name']);?></td>                         
                        <td><?php echo h($result[0]['quantity']);?></td>
                        <td><?php echo h($result['Delivery']['uom']);?></td>
                        <td><?php echo h($result[0]['actual_delivery_date']);?></td>
                        <td><?php echo h(round($result[0]['quantity']*$result['Delivery']['unit_price'],3));?></td>
                        <td><?php echo h($result['Delivery']['currency']);?></td>
                        <td><?php echo h($planned_submission_date);?></td>
                        <td><?php echo h($reaming_days);?></td>
                        <td><?php echo h($planned_payment_certificate_or_cheque_collection_date);?></td>
                        <td><?php echo h($planned_payment_collection_date);?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
