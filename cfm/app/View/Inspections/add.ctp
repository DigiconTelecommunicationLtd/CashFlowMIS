<div class="x_panel">
    <div class="x_content">
        <?php echo $this->Form->create('Inspection', array('action' => 'add/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'InspectionSearch')); ?>
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
            <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $this->Form->input("date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 single_cal3",'value'=>isset($date)?$date:'','readOnly'=>true)) ?>
            </div>
           
            <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $this->Form->input("date_type", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '','options'=>array('both'=>'Planned/Actual both date same','Planned'=>'Planned Inspection Date','Actual'=>'Actual Inspection Date'))) ?>
            </div>             
              <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?php echo $this->Form->submit('Search', array('class' => 'btn btn-success', 'id' => 'InspectionSearchSubmit')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
<div id="lotProductUpdate"<!--style="display: none;"-->
<?php if ($this->Session->check('Message.flash')): ?>
         <div role="alert" class="alert alert-success alert-dismissible fade in">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
            </button>
            <strong><?php echo $this->Session->flash(); ?></strong>
        </div>
    <?php endif; ?>
    <?php if ($production_results): ?>
        <div class="x_content">
            <table  class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td>Category</td>
                        <td>Product</td>                    
                        <td><a data-toggle="tooltip"  title="Production Quantity">pro.qty</a></td>
                        <td><a data-toggle="tooltip"  title="Production Quantity">prev.Ins.qty</td>
                        <td>Balance.Qty</td>                         
                        <td><a data-toggle="tooltip"  title="Unit Weight">U.Weight</a></td>
                        <td><a data-toggle="tooltip"  title="Total Weight">T.Weight</a></td>
                        <td><a data-toggle="tooltip"  title="Current Inspection Quantity Input">Inspection.Qty</a></td>
                        <td><a data-toggle="tooltip"  title="Planned Inspection Date">P.Ins.Date</a></td>
                        <td><a data-toggle="tooltip" data-placement="top" title="Actual Completion Date">A.Com.Date</a></td>                       
                        <!--<th>Remarks</th>-->                        
                    </tr>
                </thead>
                <tbody>           
                    <?php echo $this->Form->create('Inspection', array('action' => 'add/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'InspectionSave')); ?>
                    <?php
                    $check_balance_qty_greater_than_zero=null;
                    foreach ($production_results as $value): ?>
                        <tr>
                            <!-- <td><?php //echo $value['Contract']['contract_no'];          ?> </td>
                            <td><?php //echo $value['LotProduct']['lot_id'];          ?> </td>-->
                            <td><?php echo $value['ProductCategory']['name']; ?> </td>
                            <td><?php echo $value['Product']['name']; ?> </td>
                            <td><?php echo $lot_qty = h($value[0]['quantity']>0)?$value[0]['quantity']:0; ?>&nbsp;<?php echo h($value['Production']['uom']); ?></td>
                            <td><?php
                            $pro_qty = isset($result[$value['Production']['product_id']]) ? $result[$value['Production']['product_id']] : '';
                            echo h($pro_qty>0)?$pro_qty:0; 
                            ?>&nbsp;<?php echo h($value['Production']['uom']); ?></td>                           
                            <td><?php echo $balance=$lot_qty - $pro_qty; ?>&nbsp;<?php echo h($value['Production']['uom']);
                            
                            /*check  balance quantity is greater than zero  if one product's balace qty is greater than zero then submit button will be visible*/
                                           if($balance>0)
                                           {
                                               $check_balance_qty_greater_than_zero=1;
                                           }
                                           ?></td>
                            
                            <td><?php echo ($value['Production']['unit_weight'] != 'N/A'&&$value['Production']['unit_weight_uom'] != 'N/A') ? h($value['Production']['unit_weight']).' '.$value['Production']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td><?php echo ($value['Production']['unit_weight'] != 'N/A'&&$value['Production']['unit_weight_uom'] != 'N/A') ? h($value['Production']['unit_weight'] * $value[0]['quantity']).' '.$value['Production']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td>
                                <input type="hidden" name="data[Inspection][product_category_id][<?php echo $value['Production']['product_id'] ?>]" value="<?php echo $value['Production']['product_category_id'] ?>" required="1"/>
                                <input type="hidden" name="data[Inspection][unit_weight_uom][<?php echo $value['Production']['product_id'] ?>]" value="<?php echo $value['Production']['unit_weight_uom'] ?>" required="1"/>
                                <?php echo $this->Form->hidden("uom][" . $value['Production']['product_id'] . "]", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => $value['Production']['uom'])); ?>
                                <?php echo $this->Form->hidden("unit_weight][" . $value['Production']['product_id'] . "]", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => $value['Production']['unit_weight'])); ?>
                                <?php echo $this->Form->input("quantity][" . $value['Production']['product_id'] . "]", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'value' =>(($date_type=="Planned"||$date_type=="both")&&$balance>0)?$balance:'','type'=>'number','min'=>1,'max'=>$balance,'step'=>'any','onkeyup'=>"this.value = minmax(this.value, 0, $balance)")); ?>
                            </td> 
                            <td><?php echo $this->Form->input("planned][" . $value['Production']['product_id'] . "]", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 single_cal3", 'value'=>(($date_type=="Planned"||$date_type=="both")&&$balance>0)?$date:'','readOnly'=>true)); ?></td> 
                            <td><?php echo ($actaul_date_info[$value['Production']['product_id']])?$actaul_date_info[$value['Production']['product_id']]:'N/A' ?> </td>
                            <?php //echo $this->Form->input("planned][" . $value['LotProduct']['product_id'] . "]", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 single_cal3", 'required' => 'required', 'value' => ($result['pd_' . $value['LotProduct']['product_id']] != "0000-00-00") ? $result['pd_' . $value['LotProduct']['product_id']] : '')); ?>
                            <!--<td><?php //echo $this->Form->input("actual][" . $value['LotProduct']['product_id'] . "]", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 single_cal3", 'value' => ($result['ad_' . $value['LotProduct']['product_id']] != "0000-00-00") ? $result['ad_' . $value['LotProduct']['product_id']] : '')); ?></td> 
                            <td><?php //echo $this->Form->input("remarks_".$value['LotProduct']['product_id'], array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 procurement"))          ?></td>-->
                        </tr>
                    <?php endforeach; ?>
                    <?php if($check_balance_qty_greater_than_zero): ?>
                    <tr>
                        <td align="right" colspan="10" class="right">
                            <?php echo $this->Form->hidden("planned_same_as_actual", array("type" => "number",'id'=>'planned_same_as_actual', 'label' => false,'div' => false, 'class' => "form-control col-md-1 col-xs-12",'value'=>($date_type=="both")?1:0)) ?>  
                            <?php echo $this->Form->hidden("contract_id", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => isset($contract_id) ? $contract_id : '')); ?>
                            <?php echo $this->Form->hidden("lot_id", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => isset($lot_id) ? $lot_id : '')); ?>
                            <?php echo $this->Form->hidden("FormType", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => 'submit')); ?>
                            <?php echo $this->Form->submit('Save Inspection', array('class' => 'btn btn-success', 'id' => 'ProductionSaveSubmit')); ?>
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
                <td><a data-toggle="tooltip"  title="Unit Weight">U.Weight</a></td>
                <td><a data-toggle="tooltip"  title="Total Weight">T.Weight</a></td>
                <td><a data-toggle="tooltip" data-placement="top" title="Actual Completion Date">A.Com.Date</a></td> 
                <td><a data-toggle="tooltip"  title="Planned Inspection Date">P.Ins.Date</a></td>
                <td><a data-toggle="tooltip"  title="Actual Inspection Date">A.Ins.Date</a></td>
                <!--<th><a data-toggle="tooltip"  title="Save Actual Inspection Date">Save</a></th>-->
                <th>Added By/Date</th>
                <th>Delete</th>                  
            </tr>
        </thead>
        <tbody>
 <?php
 $id=array();
 $check_ad='';
 foreach ($actual_date_results as $actual_date_result):
$id[]=$actual_date_result['Inspection']['id'];  
 if($actual_date_result['Inspection']['actual_inspection_date']=="0000-00-00")
 {
     $check_ad=$actual_date_result['Inspection']['actual_inspection_date'];
 }
     ?>
                    <tr id='tr_<?php echo $actual_date_result['Inspection']['id']; ?>'>
                        <td><?php echo $actual_date_result['ProductCategory']['name']; ?> </td>
                        <td><?php echo $actual_date_result['Product']['name']; ?> </td>
                        <td><?php echo $actual_date_result['Inspection']['quantity']; ?>&nbsp;<?php echo h($actual_date_result['Inspection']['uom']); ?></td>                       
                        <td><?php echo ($actual_date_result['Inspection']['unit_weight'] != 'N/A'&&$actual_date_result['Inspection']['unit_weight_uom'] != 'N/A') ? h($actual_date_result['Inspection']['unit_weight']).' '.$actual_date_result['Inspection']['unit_weight_uom']: 'N/A'; ?>&nbsp;</td>
                        <td><?php echo ($actual_date_result['Inspection']['unit_weight'] != 'N/A'&&$actual_date_result['Inspection']['unit_weight_uom'] != 'N/A') ? h($actual_date_result['Inspection']['unit_weight'] * $actual_date_result['Inspection']['quantity']).' '.$actual_date_result['Inspection']['unit_weight_uom']: 'N/A'; ?>&nbsp;</td>
                        <td><?php echo ($actaul_date_info[$actual_date_result['Inspection']['product_id']])?$actaul_date_info[$actual_date_result['Inspection']['product_id']]:'N/A' ?> </td>
                        <td><?php echo $actual_date_result['Inspection']['planned_inspection_date']; ?>&nbsp;</td>
                        <td><input type="text" name="actual_date_update" class="form-control col-md-1 col-xs-12 single_cal3" id="actual_date_update_<?php echo $actual_date_result['Inspection']['id']; ?>" value="<?php if(isset($actual_date_result['Inspection']['actual_inspection_date'])&&$actual_date_result['Inspection']['actual_inspection_date']!="0000-00-00") {echo $actual_date_result['Inspection']['actual_inspection_date'];}else{echo($date_type=="Actual")?$date:'';} ?>" readonly="1"/></td> 
                        <!--<td><button id="<?php //echo $actual_date_result['Inspection']['id']; ?>" class="actual_date_save btn btn-success" name="Save" value="Save"><span class="fa fa-save">Save</span></button>
                            <div id="message_<?php //echo $actual_date_result['Inspection']['id']; ?>"></div>
                        </td>-->
                        <td><?php echo $actual_date_result['Inspection']['added_by']; ?>/<?php echo  substr($actual_date_result['Inspection']['added_date'],0,10); ?></td>
                        <td>
                            <?php if(strtotime($actual_date_result['Inspection']['added_date'])>=strtotime(date('Y-m-d'))){?>
                            <input type="button" id="production_<?php echo $actual_date_result['Inspection']['id']; ?>_inspections" value="Delete" class="btn btn-danger product_delete"/>
                            <?php }?>
                        </td>
                    </tr>
                <?php endforeach; ?> 
                    <?php if($check_ad!=''): ?>
                    <tr>
                     <td colspan="7"><div style="display:none"id="showActualDateMessage" class="alert alert-success alert-dismissible fade in">Your Request Has Been Saved. Successfully.</div></td>
                        <td colspan="2">
                            <input type="hidden" id="url" value="inspections/actual_inspection_date_editing">
                            <input type="hidden" id="contractID" value="<?php echo $contract_id;?>">
                            <input type="hidden" id="update_id" value="<?php echo implode("-", $id); ?>">
                            <input type="hidden" id="url_all" value="inspections/actual_inspection_date_editing_all">
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
            'model' => 'Inspection'
                ), array(
            'update' => '#lot_id',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'before' => "$('#loading').fadeIn();$('#InspectionSearchSubmit').attr('disabled','disabled');",
            'complete' => "$('#loading').fadeOut();$('#InspectionSearchSubmit').removeAttr('disabled');",        
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);
?>