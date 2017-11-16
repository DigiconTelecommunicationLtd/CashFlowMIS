<div class="x_panel">
    <div class="x_title">
        <strong>Yearly Plan with work in hand report:</strong> 
    </div>
    <div class="x_content">        
        <?php echo $this->Form->create('Report', array('controller' =>'reports', 'action' =>'yearly_plan_with_work_in_hand/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'Report')); ?>
        <div class="form-group">           
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Date From[PO. Product Entry]:</label>
                <?php echo $this->Form->input("date_from", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_from', 'required' => false)) ?>                
             </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Date To[PO. Product Entry]:</label>
                <?php echo $this->Form->input("date_to", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_to', 'required' => false)) ?>                
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Contract/PO.No:</label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false,'id'=>'contract_id')) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                <label>Category:</label>
                <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'productCategoryId2', 'required' => false,'options'=>$product_categories)) ?>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                <label>Product Name:</label>
                <?php echo $this->Form->input("product_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' =>' ', 'id' => 'product_id','data-placeholder'=>'Choose a Product','default'=>'')) ?>
            </div>
           <div class="col-md-1 col-sm-1 col-xs-12 form-group">
                <div id="loading" style="display: none;">
                    <?php echo $this->Html->image('loading.gif',array('alt'=>'Please Wait ...','height'=>"15",'width'=>"15")); ?>
                    Please Wait ...
                </div>
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
                    <th><a data-toggle="tooltip"  title="Contract/PO No.">PO.NO</a></th>
                    <th>Contract Date</th> 
                    <th>Category</th>
                    <th>Product</th>
                    <th><a data-toggle="tooltip"  title="Contract/PO quantity">PO.QTY</a></th>
                    <th>UOM</th>
                    <th><a data-toggle="tooltip"  title="Unit Price">U.Price</a></th>
                    <th><a data-toggle="tooltip"  title="Total Price">T. Price</a></th>
                    <th><a data-toggle="tooltip"  title="Currency">Currency</a></th>
                    <th><a data-toggle="tooltip"  title="Unit Weight">U.Weight</a></th>
                    <th><a data-toggle="tooltip"  title="Total Weight">T.Weight</a></th>
                    <th><a data-toggle="tooltip"  title="Weight of Unit of Mesurement">W.UOM</a></th> 
                    <th>Added By</th>
                    <th>Added Date</th> 
                </tr>
            </thead>
            <tbody>
                <?php                 
                foreach ($results as $result): ?>
                    <tr>                        
                        <td><?php echo h($result['c']['contract_no']); ?></td>
                        <td><?php echo h($result['c']['contract_date']); ?></td>
                        <td><?php echo h($result['pc']['name']); ?></td>
                        <td><?php echo h($result['p']['name']); ?></td>                         
                        <td><?php echo h($result['cp']['quantity']); ?></td>                        
                        <td><?php echo h($result['cp']['uom']);?></td>
                        <td><?php echo h($result['cp']['unit_price']); ?></td>
                        <td><?php echo h($result['cp']['unit_price']*$result['cp']['quantity']); ?></td>
                        <td><?php echo h($result['cp']['currency']); ?></td>
                        <td><?php echo ($result['cp']['unit_weight']); ?></td>
                        <td><?php echo is_numeric($result['cp']['unit_weight'])?$result['cp']['unit_weight']*$result['cp']['quantity']:'N/A'; ?></td>
                        <td><?php echo ($result['cp']['unit_weight_uom']);?></td>   
                        <td><?php echo h($result['cp']['added_by']); ?></td>                        
                        <td><?php echo h(substr($result['cp']['added_date'],0,10));?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>