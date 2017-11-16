<div class="x_panel">
    <div class="x_title">
        <strong>Product Delivery Report:</strong> 
    </div>
    <div class="x_content">        
        <?php echo $this->Form->create('Report', array('controller' =>'reports', 'action' =>'delivery_report/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'Report')); ?>
        <div class="form-group">           
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Date From</label>
                <?php echo $this->Form->input("date_from", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_from', 'required' => false)) ?>                
             </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Date To</label>
                <?php echo $this->Form->input("date_to", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_to', 'required' => false)) ?>                
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Date Type</label>
                <?php echo $this->Form->input("date", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'date', 'required' => false)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Contract/PO.No:</label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false,'id'=>'contract_id')) ?>
            </div>
             <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Lot No:</label>
                <?php echo $this->Form->input("lot_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'required' =>false, 'tabindex' => -1, 'id' => 'lot_id', 'empty'=>'', 'data-placeholder' => 'Choose Lot Number', 'data-default' =>isset($lot_id)?$lot_id:null)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                <label>Unit</label>
                <?php echo $this->Form->input("unit_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'unit_id', 'required' => false)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                <label>Client</label>
                <?php echo $this->Form->input("client_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'client_id', 'required' => false)) ?> 
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Category</label>
                <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'product_category_id', 'required' => false,'options'=>$product_categories)) ?>
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
                    <th>S/N</th>
                    <th>PO.NO</th>
                    <th>Lot.NO</th>
                    <th>Unit</th>
                    <th>Client</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>UOM</th>
                    <th>Unit Weight</th>
                    <th>Total Weight</th>
                    <th>Unit Weight UOM</th>
                    <th>Planned Delivery Date</th>
                    <th>Actual Delivery Date</th>
                    <th>Entry Date</th>  
                    <th>Added By</th>					
                </tr>
            </thead>
            <tbody>
                <?php
                 $sl=1;
                 $total_qty=0;
                 $uom='';
                 $total_weight=0;
                 $unit_weight_uom='';
                foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo $sl++; ?></td>
                        <td><?php echo h($result['Contract']['contract_no']); ?></td>
                        <td><?php echo h($result['Delivery']['lot_id']); ?></td>
                        <td><?php echo h($result['Unit']['name']); ?></td>
                        <td><?php echo h($result['Client']['name']); ?></td>
                        <td><?php echo h($result['ProductCategory']['name']); ?></td>
                        <td><?php echo h($result['Product']['name']); ?></td>
                        <td><?php echo h($result['Delivery']['quantity']);$total_qty+=$result['Delivery']['quantity']; ?></td>
                        <td><?php echo h($result['Delivery']['uom']);$uom=$result['Delivery']['uom']; ?></td>
                        <td><?php echo h($result['Delivery']['unit_weight']);$total_weight+=is_numeric($result['Delivery']['unit_weight'])?$result['Delivery']['quantity']*$result['Delivery']['unit_weight']:0; ?></td>
                        <td><?php echo is_numeric($result['Delivery']['unit_weight'])?$result['Delivery']['quantity']*$result['Delivery']['unit_weight']:'N/A'; ?></td>
                        <td><?php echo h($result['Delivery']['unit_weight_uom']);$unit_weight_uom=$result['Delivery']['unit_weight_uom']; ?></td>
                        <td><?php echo h($result['Delivery']['planned_delivery_date']); ?></td>
                        <td><?php echo h($result['Delivery']['actual_delivery_date']); ?></td>						
						<td><?php echo h($result['Delivery']['added_date']); ?></td>
						<td><?php echo h($result['Delivery']['added_by']); ?></td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td>Total:</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td> 
                        <td><?php echo $total_qty;?></td>
                        <td><?php echo $uom;?></td>
                        <td>&nbsp;</td>
                        <td><?php echo $total_weight;?></td>
                        <td><?php echo $unit_weight_uom;?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td> 
                        <td>&nbsp;</td>
                        <td>&nbsp;</td> 						
                    </tr>
            </tbody>
             
        </table>
    </div>
</div>
<?php
$this->Js->get('#contract_id')->event('change', $this->Js->request(array(
            'controller' => 'lots',
            'action' => 'getLotByContract',
            'model' => 'Report'
                ), array(
            'update' => '#lot_id',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'before' => "$('#loading').fadeIn();$('#ReportSubmit').attr('disabled','disabled');",
            'complete' => "$('#loading').fadeOut();$('#ReportSubmit').removeAttr('disabled');",        
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);
?>