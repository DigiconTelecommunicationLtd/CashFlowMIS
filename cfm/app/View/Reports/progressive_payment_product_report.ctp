<div class="x_panel">
    <div class="x_content">
        <div id="loading" style="display: none;"><div class="alert alert-info" role="alert"><i class=" fa fa-spinner fa-spin"></i> Please wait...</div></div>
        <?php echo $this->Form->create('Report', array('controller' => 'reports', 'action' => 'progressive_payment_product_report/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'Report', 'onsubmit' => "return validate();")); ?>
        <div class="form-group">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Contract/PO.No:</label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false)) ?>
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
        <?php //echo $this->element('sql_dump');  ?>
    </div> 
    <div class="x_content">    
        <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>S/N:</th>
                    <th>PO. NO:</th>
                    <th>Unit</th>
                    <th>Client</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>UOM</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($results):
                    $sl = 1;
                    foreach ($results as $result):
                        ?>
                        <tr>
                            <td><?php echo $sl++; ?>&nbsp;</td>
                            <td><?php echo h($result[0]['contract_no']); ?>&nbsp;</td>
                            <td><?php echo h($result[0]['unit_name']); ?>&nbsp;</td>
                            <td><?php echo h($result[0]['client_name']); ?>&nbsp;</td>
                            <td><?php echo h($result[0]['product_category']); ?>&nbsp;</td>
                            <td><?php echo h($result[0]['product_name']); ?>&nbsp;</td>
                            <td align="right"><?php echo h($result['ProgressivePayment']['quantity']); ?>&nbsp;</td>
                            <td><?php echo h($result['ProgressivePayment']['uom']); ?>&nbsp;</td>
                        </tr>
                        <?php
                    endforeach;
                else:
                    ?>                    
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>
