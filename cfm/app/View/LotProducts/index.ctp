<div class="x_panel"> 
    <div class="x_content">    
        <?php echo $this->Form->create('LotProduct', array('controller' => 'lot_products', 'action' => '/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'LotProduct')); ?>
        <div class="form-group">        
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                <label>PO NO:</label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-4 col-xs-12", 'tabindex' => 1, 'empty' => '', 'id' => 'contract_id', 'required' => true,'default'=>isset($contract_id)?$contract_id:'')) ?>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                <label>Lot NO:</label>
                <?php echo $this->Form->input("lot_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-4 col-xs-12", 'tabindex' => 2, 'id' => 'lot_id','empty'=>'' , 'required' => false,'default'=>isset($lot_id)?$lot_id:'')) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
            <label>Category:</label>
            <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'product_category_id', 'required' => false, 'options' => $product_categories)) ?>
        </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>&nbsp;</label>
                <?php echo $this->Form->submit('Search', array('class' => 'btn btn-success', 'id' => 'LotProductSubmit')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>      
        <div class="clearfix"></div>    
    </div>
    <div class="x_content">
        <?php if ($lotProducts): ?>
            <table id='datatable-buttons'  class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Lot No.</th> 
                        <th>Category</th>
                        <th>Product</th>                    
                        <th>Quantity</th>
                        <th>UOM</th>
                        <th>Unit Weight</th>
                        <th>Total Weight</th>
                        <th>Weight(UOM)</th>
                        <th>Remarks</th>
                        <th>Added By</th>
                        <th>Added Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lotProducts as $lotProduct):?>
                        <tr> 
                            <td><?php echo h($lotProduct['LotProduct']['lot_id']); ?></td>
                            <td> <?php echo $lotProduct['ProductCategory']['name']; ?> </td>
                            <td> <?php echo $lotProduct['Product']['name']; ?> </td>
                            <td><?php echo h($lotProduct['LotProduct']['quantity']); ?></td>
                            <td><?php echo h($lotProduct['LotProduct']['uom']); ?></td>
                            <td><?php echo h($lotProduct['LotProduct']['unit_weight']!= 'N/A'&&$lotProduct['LotProduct']['unit_weight_uom']!= 'N/A')?$lotProduct['LotProduct']['unit_weight']:'N/A'; ?>&nbsp;</td>
                            <td><?php echo ($lotProduct['LotProduct']['unit_weight'] != 'N/A'&&$lotProduct['LotProduct']['unit_weight_uom']!= 'N/A') ? h($lotProduct['LotProduct']['unit_weight'] * $lotProduct['LotProduct']['quantity']): 'N/A'; ?>&nbsp;</td>
                            <td><?php echo $lotProduct['LotProduct']['unit_weight_uom']; ?>&nbsp;</td>
                            <td><?php echo $lotProduct['LotProduct']['remarks']; ?> </td>
                            <td><?php echo $lotProduct['LotProduct']['added_by']; ?> </td>
                             <td><?php echo $lotProduct['LotProduct']['added_date']; ?> </td>
                           <td>  
                               <a href="<?php echo $this->Html->url('/lot_products/edit/' . $lotProduct['LotProduct']['id']); ?>"><i class="fa fa-edit" title="edit"></i>EDIT</a>&nbsp;&nbsp;
                                  <?php 
                                  if( strtotime($lotProduct['LotProduct']['added_date'])>=strtotime(date('Y-m-d'))){
                                    echo $this->Html->link('DELETE',array('controller'=>'lot_products','action'=>'delete',$lotProduct['LotProduct']['id'],$lotProduct['LotProduct']['product_id'],  str_replace("/","||",$lotProduct['LotProduct']['lot_id'])),
                                    array('confirm'=>'Are you sure you want to delete the product?'));
                                  }
                                  ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div> 
<?php
$this->Js->get('#contract_id')->event('change', $this->Js->request(array(
            'controller' => 'lot_products',
            'action' => 'getLotByContract',
            'model' => 'LotProduct'
                ), array(
            'update' => '#lot_id',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);
?>
 
