<div class="x_content">     
    <?php echo $this->Form->create('Lot', array('controller' => 'lots', 'action' => '/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'Lot',"onsubmit"=>"return checkCategory();")); ?>
    <div class="form-group">
        <div class="col-md-3 col-sm-3 col-xs-12">
            <label>PO.No:</label>
            <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false, 'data-placeholder' => 'Choose Contract/PO No.','id'=>'contract_id')) ?>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 form-group">
            <label>Category:</label>
            <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'product_category_id', 'required' => false, 'options' => $product_categories)) ?>
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12 form-group">
            <label>&nbsp;</label>
            <?php echo $this->Form->submit('Search', array('class' => 'btn btn-success', 'id' => 'LotSubmit')); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>    
</div>
<div class="clearfix"></div>
<div class="x_content">
    <table id="datatable-buttons" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>S/N:</th>
                <th>PO No:</th>
                <th>Lot No:</th>                   
                <th>Added By</th>
                <th>Added Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sl = 1;
            foreach ($lots as $lot):
                ?>
                <tr>
                    <td><?php echo $sl++; ?>&nbsp;</td>
                    <td> <?php echo $lot['Contract']['contract_no']; ?></td>
                    <td><?php echo h($lot['Lot']['lot_no']); ?>&nbsp;</td>		 
                    <td><?php echo h($lot['Lot']['added_by']); ?>&nbsp;</td>
                    <td><?php echo h($lot['Lot']['added_date']); ?>&nbsp;</td>
                    <td>
                        <a href="<?php echo $this->Html->url('/lot_products/add/' . $lot['Lot']['id']); ?>"><button class="btn btn-primary">Add New Product To Lot</button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    function checkCategory()
    {
        var product_category_id=document.getElementById('product_category_id').value;
        var contract_id=document.getElementById('contract_id').value;
        if(product_category_id&&!contract_id)
        {
            alert("PO. No. is required when category is selected. Please try again");
            return false;
        }
        else{
            return true;
        }
    }
    </script>
