<div class="x_panel">
    <div class="x_title">
        <strong>Work in Progress Summary report:</strong> 
    </div>
    <div class="x_content">        
        <?php echo $this->Form->create('Report', array('controller' => 'reports', 'action' => 'work_in_progress_summary_report/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'Report')); ?>
        <div class="form-group">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>PO NO:</label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false, 'id' => 'contract_id')) ?>
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
                <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'product_category_id', 'required' => false, 'options' => $product_categories)) ?>
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
                    <th>Product Category</th> 
                    <th>PO. QTY</th>
                    <th>Deli. QTY</th>
                    <th>Balance(PO-Deli)QTY</th>
                    <th>UOM</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($iteration as $key=>$iteration):
                    ?>
                    <tr>
                        <td><?php echo $data[$iteration]['name']; ?></td>
                        <td><?php echo h($data['po.qty'][$key]); ?></td>
                        <td><?php echo h($data['d.qty'][$key]); ?></td>
                        <td><?php echo h($data['po.qty'][$key]-$data['d.qty'][$key]); ?></td>
                        <td><?php $uom=explode('-', $key); echo h($uom[1]); ?></td>                         
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</div>