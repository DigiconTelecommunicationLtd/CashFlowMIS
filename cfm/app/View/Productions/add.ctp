<div class="x_panel">
    <div class="x_content">
        <?php echo $this->Form->create('Production', array('action' => 'add/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'ProductionSearch')); ?>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Contract/PO. No <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'required' => 'required', 'tabindex' => -1, 'empty' => '', 'id' => 'contract_id', 'data-placeholder' => 'Choose Contract/PO.NO')) ?>
            </div>            
        </div>       
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Lot No.<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->hidden("FormType", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => 'search')); ?>
                <?php echo $this->Form->input("lot_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'required' => 'required', 'tabindex' => -1, 'id' => 'lot_id', 'data-placeholder' => 'Choose Lot Number', 'data-default' =>isset($lot_id)?$lot_id:null)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div id="loading" style="display: none;">
                    <?php echo $this->Html->image('loading.gif',array('alt'=>'Please Wait ...','height'=>"15",'width'=>"15")); ?>
                    Please Wait ...
                </div>
            </div>           
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product Category
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'product_category_id', 'required' => false, 'options' => $product_categories)) ?>
            </div>
        </div> 
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Date
            </label>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <?php echo $this->Form->input("date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 single_cal3",'value'=>isset($date)?$date:'','readOnly'=>true)) ?>
            </div>
           
            <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $this->Form->input("date_type", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '','options'=>array('both'=>'Planned/Actual both date same','Planned'=>'Planned Completion Date','Actual'=>'Actual Completion Date'))) ?>
            </div>             
             <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?php echo $this->Form->submit('Search', array('class' => 'btn btn-success', 'id' => 'ProductionSearchSubmit')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div> 
    </div>
    <div class="clearfix"></div>
<div id="lotProductUpdate">
<?php if ($this->Session->check('Message.flash')): ?>
         <div role="alert" class="alert alert-success alert-dismissible fade in">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
            </button>
            <strong><?php echo $this->Session->flash(); ?></strong>
        </div>
    <?php endif; ?>
    <?php if (isset($lots_products)): ?>
        <div class="x_content">
            <table  class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td>Category</td>
                        <td>Product</td>                    
                        <td>Lot.Qty</td>
                        <td><a data-toggle="tooltip"  title="Previous Production Quantity">P.Pro.qty</a></a></td>
                        <td>Balance.Qty</td>                        
                        <td><a data-toggle="tooltip"  title="Unit Weight">U.Weight</a></td>
                        <td><a data-toggle="tooltip"  title="Total Weight">T.Weight</a></td>                         
                        <td>Production.Qty</td>                       
                        <td><a data-toggle="tooltip" data-placement="top" title="Planned Completion Date">P.C.Date</a></td>
                        <td><a data-toggle="tooltip" data-placement="top" title="Actual Arrival Date">A.Arv.Date</a></td>
                        <!--<th>Remarks</th>-->                        
                    </tr>
                </thead>
                <tbody>           
                    <?php echo $this->Form->create('Production', array('action' => 'add/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'ProductionSave')); ?>
                    <?php
                    $check_balance_qty_greater_than_zero=null;
                    foreach ($lots_products as $lots_product): ?>
                        <tr>

                            <!-- <td><?php //echo $lots_product['Contract']['contract_no'];          ?> </td>
                            <td><?php //echo $lots_product['LotProduct']['lot_id'];          ?> </td>-->
                            <td><?php echo $lots_product['ProductCategory']['name']; ?> </td>
                            <td><?php echo $lots_product['Product']['name']; ?> </td>
                            <td><?php echo $lot_qty = h($lots_product[0]['quantity']); ?>&nbsp;<?php echo h($lots_product['LotProduct']['uom']); ?></td>
                            <td><?php
                            $pro_qty = isset($result[$lots_product['LotProduct']['product_id']]) ? $result[$lots_product['LotProduct']['product_id']] : '';
                            echo h($pro_qty>0)?$pro_qty:0; 
                            ?>&nbsp;<?php echo h($lots_product['LotProduct']['uom']); ?></td>
                            <td><?php echo $balance= $lot_qty - $pro_qty; ?>&nbsp;<?php echo h($lots_product['LotProduct']['uom']);
                                           /*check  balance quantity is greater than zero  if one product's balace qty is greater than zero then submit button will be visible*/
                                           if($balance>0)
                                           {
                                               $check_balance_qty_greater_than_zero=1;
                                           }
                                           ?></td>
                           
                            <td><?php echo ($lots_product['LotProduct']['unit_weight'] != 'N/A'&&$lots_product['LotProduct']['unit_weight_uom'] != 'N/A') ? h($lots_product['LotProduct']['unit_weight']).' '.$lots_product['LotProduct']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td><?php echo ($lots_product['LotProduct']['unit_weight'] != 'N/A'&&$lots_product['LotProduct']['unit_weight_uom'] != 'N/A') ? h($lots_product['LotProduct']['unit_weight'] * $lots_product[0]['quantity']).' '.$lots_product['LotProduct']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td>
                                <input type="hidden" name="data[Production][product_category_id][<?php echo $lots_product['LotProduct']['product_id'] ?>]" value="<?php echo $lots_product['LotProduct']['product_category_id'] ?>" required="1"/>
                                <input type="hidden" name="data[Production][unit_weight_uom][<?php echo $lots_product['LotProduct']['product_id'] ?>]" value="<?php echo $lots_product['LotProduct']['unit_weight_uom'] ?>" required="1"/>
                                <?php echo $this->Form->hidden("uom][" . $lots_product['LotProduct']['product_id'] . "]", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => $lots_product['LotProduct']['uom'])); ?>
                                <?php echo $this->Form->hidden("unit_weight][" . $lots_product['LotProduct']['product_id'] . "]", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => $lots_product['LotProduct']['unit_weight'])); ?>
                                <?php echo $this->Form->input("quantity][" . $lots_product['LotProduct']['product_id'] . "]", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'value' =>(($date_type=="Planned"||$date_type=="both")&&$balance>0)?$balance:'','type'=>'number','min'=>1,'max'=>$balance,'onkeyup'=>"this.value = minmax(this.value, 0, $balance)",'step'=>'any')); ?>
                            </td> 
                            <td><?php echo $this->Form->input("planned][" . $lots_product['LotProduct']['product_id'] . "]", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 single_cal3",'value'=>(($date_type=="Planned"||$date_type=="both")&&$balance>0)?$date:'','readOnly'=>true,'default'=>false,'empty'=>'')); ?></td> 
                            <td><?php echo ($actaul_date_info[$lots_product['LotProduct']['product_id']])?$actaul_date_info[$lots_product['LotProduct']['product_id']]:'N/A' ?> </td>
                            <?php //echo $this->Form->input("planned][" . $lots_product['LotProduct']['product_id'] . "]", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 single_cal3", 'required' => 'required', 'value' => ($result['pd_' . $lots_product['LotProduct']['product_id']] != "0000-00-00") ? $result['pd_' . $lots_product['LotProduct']['product_id']] : '')); ?>
                            <!--<td><?php //echo $this->Form->input("actual][" . $lots_product['LotProduct']['product_id'] . "]", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 single_cal3", 'value' => ($result['ad_' . $lots_product['LotProduct']['product_id']] != "0000-00-00") ? $result['ad_' . $lots_product['LotProduct']['product_id']] : '')); ?></td> 
                            <td><?php //echo $this->Form->input("remarks_".$lots_product['LotProduct']['product_id'], array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 procurement"))          ?></td>-->
                        </tr>
                    <?php endforeach; ?>
                    <?php if($check_balance_qty_greater_than_zero): ?>    
                    <tr>
                        <td align="right" colspan="10" class="right">
                            <?php echo $this->Form->hidden("planned_same_as_actual", array("type" => "number",'id'=>'planned_same_as_actual', 'label' => false,'div' => false, 'class' => "form-control col-md-1 col-xs-12",'value'=>($date_type=="both")?1:0)) ?>  
                            <?php echo $this->Form->hidden("contract_id", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => isset($contract_id) ? $contract_id : '')); ?>
                            <?php echo $this->Form->hidden("lot_id", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => isset($lot_id) ? $lot_id : '')); ?>
                            <?php echo $this->Form->hidden("FormType", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => 'submit')); ?>
                            <?php echo $this->Form->submit('Save Production', array('class' => 'btn btn-success', 'id' => 'ProductionSaveSubmit')); ?>
                            <?php echo $this->Form->end(); ?>
                        </td>
                    </tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
     
<?php if ($actual_date_results): ?>
<div class="x_content">
    <table  class="table table-striped table-bordered">
        <thead>
            <tr>
                <td>Category</td>
                <td>Product</td>                    
                <td>Quantity</td>                 
                <td><a data-toggle="tooltip" data-placement="top" title="Unit Weight">U.Weight</a></td>  
                <td><a data-toggle="tooltip" data-placement="top" title="Total Weight">T.Weight</a></td> 
                <td><a data-toggle="tooltip"  title="Actual Arrival Date">A.Arv.Date</a></td>
                <td><a data-toggle="tooltip"  data-placement="top" title="Planned Completion Date">P.C.Date</a></td>
                <td><a data-toggle="tooltip"  title="Actual Completion Date">A.C.Date</a></td>
                <!--<th><a data-toggle="tooltip"  title="Save Actual Completion Date Action">Save</a></th>-->
                <th>Added By/Date</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
 <?php
 $id=array();
 $check_ad='';
 foreach ($actual_date_results as $actual_date_result):
       $id[]=$actual_date_result['Production']['id']; 
 if($actual_date_result['Production']['actual_completion_date']=="0000-00-00")
 {
     $check_ad=$actual_date_result['Production']['actual_completion_date'];
 }
     ?>
                    <tr id='tr_<?php echo $actual_date_result['Production']['id']; ?>'>
                        <td><?php echo $actual_date_result['ProductCategory']['name']; ?> </td>
                        <td><?php echo $actual_date_result['Product']['name']; ?> </td>
                        <td><?php echo $actual_date_result['Production']['quantity']; ?>&nbsp;<?php echo h($actual_date_result['Production']['uom']); ?></td>                       
                        <td><?php echo ($actual_date_result['Production']['unit_weight'] != 'N/A'&&$actual_date_result['Production']['unit_weight_uom'] != 'N/A') ? h($actual_date_result['Production']['unit_weight']).' '.$actual_date_result['Production']['unit_weight_uom']: 'N/A'; ?>&nbsp;</td>
                        <td><?php echo ($actual_date_result['Production']['unit_weight'] != 'N/A'&&$actual_date_result['Production']['unit_weight_uom'] != 'N/A') ? h($actual_date_result['Production']['unit_weight'] * $actual_date_result['Production']['quantity']).' '.$actual_date_result['Production']['unit_weight_uom']: 'N/A'; ?>&nbsp;</td>
                        <td><?php echo ($actaul_date_info[$actual_date_result['Production']['product_id']])?$actaul_date_info[$actual_date_result['Production']['product_id']]:'N/A' ?> </td>
                        <td><?php echo $actual_date_result['Production']['planned_completion_date']; ?>&nbsp;</td>
                        <td><input type="text" name="actual_date_update" class="form-control col-md-1 col-xs-12 single_cal3" id="actual_date_update_<?php echo $actual_date_result['Production']['id']; ?>" value="<?php if(isset($actual_date_result['Production']['actual_completion_date'])&&$actual_date_result['Production']['actual_completion_date']!="0000-00-00") {echo $actual_date_result['Production']['actual_completion_date'];}else{echo($date_type=="Actual")?$date:'';} ?>" readonly="1" style="width:100px;"/></td> 
                        <!--<td><button id="<?php //echo $actual_date_result['Production']['id']; ?>" class="actual_date_save btn btn-success" name="Save" value="Save"><span class="fa fa-save">Save</span></button>
                            <div id="message_<?php //echo $actual_date_result['Production']['id']; ?>"></div>
                        </td>-->
                        <td><?php echo $actual_date_result['Production']['added_by']; ?>/<?php echo substr($actual_date_result['Production']['added_date'],0,10); ?></td>
                        <td>
                            <?php if(strtotime($actual_date_result['Production']['added_date'])>=strtotime(date('Y-m-d'))){?>
                            <input type="button" id="production_<?php echo $actual_date_result['Production']['id']; ?>_productions" value="Delete" class="btn btn-danger product_delete"/>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?> 
                    <?php if($check_ad!=''): ?>
                    <tr>
                     <td colspan="8"><div style="display:none"id="showActualDateMessage" class="alert alert-success alert-dismissible fade in">Your Request Has Been Saved. Successfully.</div></td>
                        <td colspan="2">
                            <input type="hidden" id="url" value="productions/production_completion_date_editing">
                            <input type="hidden" id="contractID" value="<?php echo $contract_id;?>">
                            <input type="hidden" id="update_id" value="<?php echo implode("-", $id); ?>">
                            <input type="hidden" id="url_all" value="productions/production_actual_completion_date_editing_all">
                            <input style="float:right;" type="button" id="saveAllActualDate" value="SaveAll  Actual Date" class="btn btn-success"/>
                        </td>
                    </tr>
                    <?php endif;?>
        </tbody>
    </table>
</div>
<?php endif; ?>  
</div>
</div>
<?php
$this->Js->get('#contract_id')->event('change', $this->Js->request(array(
            'controller' => 'lot_products',
            'action' => 'getLotByContract',
            'model' => 'Production'
                ), array(
            'update' => '#lot_id',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'before' => "$('#loading').fadeIn();$('#ProductionSearchSubmit').attr('disabled','disabled');",
            'complete' => "$('#loading').fadeOut();$('#ProductionSearchSubmit').removeAttr('disabled');",        
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);
?>
