<div class="x_panel">
    <div class="x_title">
        <strong>PO. Product Summary Report:</strong> 
    </div>
    <div class="x_content">        
        <?php echo $this->Form->create('Report', array('controller' =>'reports', 'action' =>'po_product_summary_report/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'Report')); ?>
        <div class="form-group">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Contract/PO.No:</label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => true,'id'=>'contract_id')) ?>
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
                    <th>S/L</th>
                    <th>CATEGORY</th>
                    <th>PRODUCT</th>
                    <th>PO. QTY</th>
                    <th>LOT WISE QTY</th>
                    <th><a data-toggle="tooltip"  title="Total Lot Quantity">T.LOT QTY</a></th>
                    <th><a data-toggle="tooltip"  title="Raw Material Quantity">RM. QTY</a></th>
                    <th><a data-toggle="tooltip"  title="Production Quantity">PRO. QTY</a></th>
                    <th><a data-toggle="tooltip"  title="Pre Shipment Inspection">PSI QTY</a></th>
                    <th>REAMING (LOT-PSI)</th>
                    <th>DELIVERY QTY</th>
                    <th>PLI QTY</th>
                    <th><a data-toggle="tooltip"  title="Progressive Payment Quantity">PP. QTY</a></th>
                    <th><a data-toggle="tooltip"  title="Unit of Measurement">UOM</a></th>
                    <th><a data-toggle="tooltip"  title="Unit Weight">U.WEIGHT</a></th>
                    <th><a data-toggle="tooltip"  title="Total Weight">T.WEIGHT</a></th>
                    <th><a data-toggle="tooltip"  title="Weight UOM">W.UOM</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sl=1;
                foreach ($data_product as $key=>$result): ?>
                    <tr>
                        <td><?php echo $sl++; ?></td>
                        <td><?php echo h($data['cp'][$key]['category']); ?></td>
                        <td><?php echo h($data['cp'][$key]['name']); ?></td>
                        <td><?php echo h($data['cp'][$key]['quantity']); ?></td>
                        <td><?php echo $lot_info[$key]; ?></td>
                        <td><?php echo h($data['lp'][$key]['quantity']); ?></td>
                        <td><?php echo h($data['rm'][$key]['quantity']); ?></td>
                        <td><?php echo h($data['p'][$key]['quantity']); ?></td>
                        <td><?php echo h($data['i'][$key]['quantity']); ?></td>
                        <td><?php echo h($data['lp'][$key]['quantity']-$data['i'][$key]['quantity']); ?></td>
                        <td><?php echo h($data['d'][$key]['quantity']); ?></td>
                        <td><?php echo h($data['d'][$key]['pli_qty']); ?></td>
                        <td><?php echo h($data['pp'][$key]['quantity']); ?></td>
                        <td><?php echo h($data['cp'][$key]['uom']); ?></td>
                        <td><?php echo h($data['cp'][$key]['unit_weight']); ?></td>
                        <td><?php echo h($data['cp'][$key]['unit_weight_uom']!="N/A")?$data['cp'][$key]['unit_weight']*$data['cp'][$key]['quantity']:'N/A'; ?></td>
                        <td><?php echo h($data['cp'][$key]['unit_weight_uom']); ?></td>
                    </tr>
                <?php endforeach; ?>                     
            </tbody>
        </table>
    </div>
</div>