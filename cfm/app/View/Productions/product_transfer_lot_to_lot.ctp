<div class="x_panel"> 
    <div class="x_content">    
        <?php echo $this->Form->create('Production', array('controller' => 'productions', 'action' => 'product_transfer_lot_to_lot/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'transfer_product_one_lot_to_another')); ?>
        <div class="form-group">        
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                <label>PO NO:<span class="required">*</span></label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-4 col-xs-12", 'tabindex' => 1, 'empty' => '', 'id' => 'contract_id', 'required' => true, 'default' => isset($contract_id) ? $contract_id : '')) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                <label>LOT NO:<span class="required">*</span></label>
                <?php echo $this->Form->input("lot_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-4 col-xs-12", 'tabindex' => 2, 'id' => 'lot_id', 'empty' => '', 'required' => true, 'default' => isset($lot_id) ? $lot_id : '')) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                <label>Product Category:<span class="required">*</span></label>
                <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'product_category_id', 'required' => true, 'options' => $product_categories)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                <label>&nbsp;</label>
                <?php echo $this->Form->submit('Search', array('class' => 'btn btn-success', 'id' => 'TransferSubmit')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>      
        <div class="clearfix"></div>    
    </div>
    <?php if ($lot_products): ?>
        <div class="x_content">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>S/L</th> 
                        <th>Product</th>
                        <th>LOT Qty</th>
                        <th>PRO. Qty</th>
                        <th>PSI Qty</th>
                        <th>LOT.Balance=(LOT-PRO)</th>
                        <th>PRO.Balance=(PRO-PSI)</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sl = 1;
                    $balance='';
                    $product_ids='';
                    foreach ($lot_products as $value):
                        $product_id = $value['LotProduct']['product_id'];
                        ?>  
                        <tr>
                            <td><?php echo $sl++; ?></td>
                            <td><?php echo $value['Product']['name']; ?></td>
                            <td><?php echo $value['LotProduct']['quantity']; ?></td>
                            <td><?php echo $data['Production'][$product_id]; ?></td>
                            <td><?php echo $data['Inspection'][$product_id]; ?></td>
                            <td><?php echo $value['LotProduct']['quantity'] - $data['Production'][$product_id]; ?></td>
                            <td>
                                <?php 
                                   echo $proQtyDiff=$data['Production'][$product_id] - $data['Inspection'][$product_id];
                                   
                                   /*check the balance*/
                                   $lotQtyDiff=$value['LotProduct']['quantity']-$data['Inspection'][$product_id];
                                   $rwQtyDiff=$data['Procurement'][$product_id]-$data['Inspection'][$product_id];
                                   
                                   if($lotQtyDiff>0||$rwQtyDiff>0||$proQtyDiff>0)
                                   {
                                    $balance=1;   
                                    $product_ids[$product_id]=$product_id;
                                   }
                                 ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                        <?php if($balance):?>
                        <tr>
                            <?php echo $this->Form->create('Production', array('controller' => 'productions', 'action' => 'product_transfer_lot_to_lot/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'transfer_product_one_lot_to_another_save')); ?>
                            <td colspan="4">&nbsp;</td>
                            <td align ="right">
                                Transfer LOT NO:
                            </td>
                            <td align="right"> 
                            
                                <?php echo $this->Form->input("transfer_lot", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-4 col-xs-12", 'tabindex' => 2, 'id' => 'transfer_lot', 'empty' => '', 'required' => true,'options'=>$lot_trans)) ?>
                            
                            </td>
                            <td align="right">                                
                                <?php echo $this->Form->hidden("contract_id", array('label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' =>true,'value'=>$contract_id)) ?>
                                <?php echo $this->Form->hidden("lot_id", array('label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' =>true,'value'=>$lot_id)) ?>
                                <?php echo $this->Form->hidden("product_category_id", array('label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' =>true,'value'=>$product_category_id)) ?>
                                <?php echo $this->Form->hidden("check_form_submit", array('label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' =>true,'value'=>'submitted')) ?>
                                <?php echo $this->Form->hidden("product_ids", array('label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' =>true,'value'=>  implode("-", $product_ids))) ?>
                                <?php echo $this->Form->submit('Transfer Prodduct', array('class' => 'btn btn-success', 'id' => 'TransferSubmitSave')); ?>
                               <?php echo $this->Form->end(); ?>
                            </td>
                        </tr>
                        <?php endif;?>
                </tbody>
            </table>    
        </div>

    <?php endif; ?>
</div>

<?php
$this->Js->get('#contract_id')->event('change', $this->Js->request(array(
            'controller' => 'lots',
            'action' => 'getLotByContract',
            'model' => 'Production'
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