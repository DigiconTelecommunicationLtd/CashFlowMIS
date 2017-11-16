<div class="x_panel">    
    <div class="x_content">    
        <?php echo $this->Form->create('Report', array('controller' => 'reports', 'action' => 'po_product_status/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'CollectionDetail')); ?>
        <div class="form-group">            
            <div class="col-md-2 col-sm-2 col-xs-12">
                <label>Contract/PO.No:<span class="red" style="color: red">*</span></label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false,'id'=>'contract_id','required'=>true)) ?>
            </div> 
             <div class="col-md-2 col-sm-2 col-xs-12">
                <label>LOT:</label>
                <?php echo $this->Form->input("lot_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false,'id'=>'lot_id','options'=>$lots,'empty'=>'Choose Lot')) ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Unit</label>
                <?php echo $this->Form->input("unit_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'required' =>false, 'tabindex' => -1, 'id' => 'unit_id', 'data-placeholder' => 'Choose unit','empty'=>'Choose Unit')) ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Client</label>
                <?php echo $this->Form->input("client_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'client_id', 'required' => false,'empty'=>'Choose Client')) ?> 
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Category</label>
                <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'product_category_id', 'required' => false, 'options' => $product_categories)) ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>&nbsp;</label>
                <?php echo $this->Form->submit('Show Report', array('class' => 'btn btn-success', 'id' => 'Show_Report')); ?>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-12  form-group">
                <label>&nbsp;</label>
                <?php echo $this->Form->hidden("showreport", array("type" => "text", 'value' => "showReport", 'id' => 'showreport')); ?>
                <?php echo $this->Form->button('Download Report', array('class' => 'btn btn-success', 'id' => 'Download')); ?>                
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
    <div class="x_content">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>PO.</th>
                    <th>Collection Type</th>
                    <th>Unit</th>
                    <th>Client</th>
                    <th>Product/Category</th>
                    <th>PO Qty</th>
                    <th>Lot Qty</th>
                    <th>Procurement Qty</th>
                    <th>Production Qty</th>
                    <th>Inspection Qty</th>
                    <th>Delivery Qty</th>
                    <th>PLI Qty</th> 
                    <th>Invoice Qty</th>
                    <th>Uom</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result):if($lot_id){if($lot_id==$result['lotproduct']['lot_id']):else:continue;endif;} ?>
                    <tr>
                        <td><?php echo $result['c']['contract_no']; ?></td>
                        <td><?php echo $result['c']['contracttype']; ?></td>
                        <td><?php echo $result['u']['unit']; ?></td>
                        <td><?php echo $result['cl']['client']; ?></td>
                        <td><?php echo $result['cp']['pc_name']; ?></td>
                        <td><?php echo $result[0]['cp_qty']; ?></td>
                        <td><?php echo $result[0]['lot_qty']; ?></td>
                        <td><?php echo $result[0]['procurement_qty']; ?></td>
                        <td><?php echo $result[0]['production_qty']; ?></td>
                        <td><?php echo $result[0]['inspection_qty']; ?></td>
                        <td><?php echo $result[0]['delivery_qty']; ?></td>
                        <td><?php echo $result[0]['pli_qty']; ?></td>
                        <td><?php echo $result[0]['progressive_qty']; ?></td>
                        <td><?php echo $result['cp']['uom']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$this->Js->get('#contract_id')->event('change', $this->Js->request(array(
            'controller' => 'lot_products',
            'action' => 'getLotByContract',
            'model' => 'Report'
                ), array(
            'update' => '#lot_id',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'before' => "$('#loading').fadeIn();$('#DeliverySearchSubmit').attr('disabled','disabled');",
            'complete' => "$('#loading').fadeOut();$('#DeliverySearchSubmit').removeAttr('disabled');",        
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);
?>
<script>
    window.onload = function() {
            document.getElementById('Download').onclick = function() {
            document.getElementById('showreport').value = "download";
            document.getElementById('CollectionDetail').submit();
            document.getElementById('showreport').value = "showreport";
            return false;
        };
    };
</script>