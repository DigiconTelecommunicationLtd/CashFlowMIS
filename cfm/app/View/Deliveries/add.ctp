<div class="x_panel">
    <div class="x_content">
        <?php echo $this->Form->create('Delivery', array('action' => 'add/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'DeliverySearch')); ?>
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
            <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'product_category_id', 'required' => false, 'options' => $product_categories)) ?>
            </div>
             <label class="control-label col-md-1 col-sm-1 col-xs-12" for="name">SKIP
            </label>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <?php $psis=array('psi'=>'PSI'); echo $this->Form->input("psi", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'id' => 'psi', 'empty'=>'', 'required' => false, 'options' =>$psis,'default'=>($up_to_psi)?$up_to_psi:'' )) ?>
            </div>
        </div>
         <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Planned/Actual Delivery Date
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $this->Form->input("date", array("type" => "text", 'label' => false, 'div' => false, 'autocomplete'=>'off', 'class' => "form-control col-md-1 col-xs-12 single_cal3",'value'=>isset($date)?$date:'','required'=>true)) ?>
            </div>
           
            <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $this->Form->input("date_type", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'required' =>true,'options'=>array('both'=>'Planned/Actual both date same'))) ?>
            </div>             
               <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?php echo $this->Form->submit('Search', array('class' => 'btn btn-success', 'id' => 'DeliverySearchSubmit')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>      
    </div>
    <div class="clearfix"></div>

<?php if ($this->Session->check('Message.flash')): ?>
         <div role="alert" class="alert alert-success alert-dismissible fade in">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
            </button>
            <strong><?php echo $this->Session->flash(); ?></strong>
        </div>
    <?php endif; ?>     
    <?php if($inspection_results): ?>
        <div class="x_content">
            <table  class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td colspan="10"style="text-align:center;font-weight: bold;color:#FFF;background-color:#2A3F54;">Delivery quantity and Planned Completion Date section:Form no:#1</td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>Product</td>                    
                        <td><a data-toggle="tooltip"  title="LOT or Production quantity">Lot/Pro.Qty</a></td>
                        <td><a data-toggle="tooltip"  title="Previous Delivery quantity">Prev.Deli.Qty</a></td>
                        <td>Balance.Qty</td>
                        <td><a data-toggle="tooltip"  title="Unit Weight">U.Weight</a></td>
                        <td><a data-toggle="tooltip"  title="Total Weight">T.Weight</a></td>
                        <td>Delivery.Qty</td>
                        <td><a data-toggle="tooltip"  title="Planned Delivery Date">P.Delivery.Date</a></td> 
                        <td><a data-toggle="tooltip" data-placement="top" title="<?php echo ($label=="A.Ins.Date")?"Actual Inspection Date":"Actual Completion Date" ?>"><?php echo $label;?></a></td> 
                    </tr>
                </thead>
                <tbody>           
                    <?php echo $this->Form->create('Delivery', array('action' => 'add/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'DeliverySave')); ?>
                    <?php
                    $check_balance_qty_greater_than_zero=null;
                    foreach ($inspection_results as $value): ?>
                        <tr>

                       <!-- <td><?php //echo $value['Contract']['contract_no'];          ?> </td>
                            <td><?php //echo $value[$model]['lot_id'];          ?> </td>-->
                            <td><?php echo $value['ProductCategory']['name']; ?> </td>
                            <td><?php echo $value['Product']['name']; ?> </td>
                            <td><?php echo $lot_qty = h($value[0]['quantity']); ?>&nbsp;<?php echo h($value[$model]['uom']); ?></td>
                            <td><?php
                            $pro_qty = isset($result[$value[$model]['product_id']]) ? $result[$value[$model]['product_id']] : '';
                            echo h($pro_qty>0)?$pro_qty:0; 
                            ?>&nbsp;<?php echo h($value[$model]['uom']); ?></td>
                            <td><?php echo $balance=$lot_qty - $pro_qty;
                            /*check  balance quantity is greater than zero  if one product's balace qty is greater than zero then submit button will be visible*/
                                           if($balance>0)
                                           {
                                               $check_balance_qty_greater_than_zero=1;
                                           }?>&nbsp;<?php echo h($value[$model]['uom']); ?></td>
                            <td><?php echo ($value[$model]['unit_weight'] != 'N/A'&&$value[$model]['unit_weight_uom']!= 'N/A') ? h($value[$model]['unit_weight']).' '.$value[$model]['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td><?php echo ($value[$model]['unit_weight'] != 'N/A'&&$value[$model]['unit_weight_uom']!= 'N/A') ? h($value[$model]['unit_weight'] * $value[0]['quantity']).' '.$value[$model]['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td>
                                <!--<input type="hidden" name="data[Delivery][product_category_id][<?php //echo $value[$model]['product_category_id'] ?>]" value="<?php //echo $value[$model]['product_category_id'] ?>" required="1"/> -->
                                <input type="hidden" name="data[Delivery][unit_weight_uom][<?php echo $value[$model]['product_id'] ?>]" value="<?php echo $value[$model]['unit_weight_uom'] ?>" required="1"/>
                                <?php echo $this->Form->hidden("uom][".$value[$model]['product_id']."]", array( 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' =>$value[$model]['uom'])); ?>
                                <?php echo $this->Form->hidden("unit_weight][".$value[$model]['product_id']."]", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' =>$value[$model]['unit_weight'])); ?>
                                <?php echo $this->Form->input("quantity][".$value[$model]['product_id']."]", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 numeric_number", 'value' =>(($date_type=="Planned"||$date_type=="both")&&$balance>0)?$balance:'', 'type'=>'number','min'=>1,'max'=>$balance,'step'=>'any', 'onkeyup'=>"this.value = minmax(this.value, 0, $balance)")); ?>
                            </td> 
                            <td><?php echo $this->Form->input("planned][".$value[$model]['product_id']."]", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 single_cal3", 'value' =>(($date_type=="Planned"||$date_type=="both")&&$balance>0)?$date:'','readOnly'=>true)); ?></td>
                            <td><?php echo ($actaul_date_info[$value[$model]['product_id']])?$actaul_date_info[$value[$model]['product_id']]:'N/A' ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td align="right" colspan="10" class="right">
                            <?php echo $this->Form->hidden("psi", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' =>false, 'value' => isset($up_to_psi)?$up_to_psi : '')); ?>
                            <?php echo $this->Form->hidden("product_category_id", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' =>false, 'value' => isset($product_category_id)?$product_category_id : '')); ?>
                            <?php echo $this->Form->hidden("date", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' =>false, 'value' => isset($date)?$date : '')); ?>
                            <?php echo $this->Form->hidden("date_type", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => false,'required', 'value' => isset($date_type) ? $date_type : '')); ?>
                            
                            <?php echo $this->Form->hidden("planned_same_as_actual", array("type" => "number",'id'=>'planned_same_as_actual', 'label' => false,'div' => false, 'class' => "form-control col-md-1 col-xs-12",'value'=>($date_type=="both")?1:0)) ?>  
                            <?php echo $this->Form->hidden("contract_id", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => isset($contract_id) ? $contract_id : '')); ?>
                            <?php echo $this->Form->hidden("lot_id", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => isset($lot_id) ? $lot_id : '')); ?>
                            <?php echo $this->Form->hidden("FormType", array('label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12", 'required' => 'required', 'value' => 'submit')); ?>
                            <?php echo $this->Form->submit('Save Delivery', array('class' => 'btn btn-success', 'id' => 'DeliverySaveSubmit')); ?>
                            <?php echo $this->Form->end(); ?>
                        </td>
                    </tr>          
                </tbody>
            </table>
        </div>
    <?php else :
        if(isset($inspection_results)):
        ?>
        <div role="alert" class="alert alert-success alert-dismissible fade in">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
            <strong>There is no Product/PSI with your search filter options.Please try again.</strong>
        </div>
    <?php endif; endif; ?>
     
<?php if($actual_date_results): ?>  
<div class="x_content">
    <table  class="table table-striped table-bordered">
        <thead>
            <tr>
                <th colspan="11" style="text-align:center;font-weight: bold;color:#FFF;background-color:#2A3F54;">Actual Completion Date section:Form no:#2</th>
            </tr>
            <tr>
                <td>Category</td>
                <td>Product</td>                    
                <td>Quantity</td>                 
                <td><a data-toggle="tooltip"  title="Unit Weight">U.Weight</a></td>
                <td><a data-toggle="tooltip"  title="Total Weight">T.Weight</a></td>
                <td><a data-toggle="tooltip" data-placement="top" title="<?php echo ($label=="A.Ins.Date")?"Actual Inspection Date":"Actual Completion Date" ?>"><?php echo $label;?></a></td> 
                <td><a data-toggle="tooltip"  title="Planned Delivery Date">P.Deli.Date</a></td>
                <td><a data-toggle="tooltip"  title="Actual Delivery Date">A.Deli.Date</a></td>
                <!--<th><a data-toggle="tooltip"  title="Save Actual Delivery Date">Save</a></th>-->
                <th>Added By</th>
                <th>Entry Date</th>
                <th>Delete</th>                     
            </tr>
        </thead>
        <tbody>
 <?php
 $id=array();
 $check_ad='';
 foreach ($actual_date_results as $actual_date_result):
 $id[]=$actual_date_result['Delivery']['id'];  
 if($actual_date_result['Delivery']['actual_delivery_date']=="0000-00-00")
 {
     $check_ad=$actual_date_result['Delivery']['actual_delivery_date'];
 }
     ?>
                    <tr id='tr_<?php echo $actual_date_result['Delivery']['id']; ?>'>
                        <td><?php echo $actual_date_result['ProductCategory']['name']; ?> </td>
                        <td><?php echo $actual_date_result['Product']['name']; ?> </td>
                        <td><?php echo $actual_date_result['Delivery']['quantity']; ?>&nbsp;<?php echo $actual_date_result['Delivery']['uom']; ?></td>                       
                        <td><?php echo ($actual_date_result['Delivery']['unit_weight'] != 'N/A'&&$actual_date_result['Delivery']['unit_weight_uom'] != 'N/A') ? h($actual_date_result['Delivery']['unit_weight']).' '.$actual_date_result['Delivery']['unit_weight_uom']: 'N/A'; ?>&nbsp;</td>
                        <td><?php echo ($actual_date_result['Delivery']['unit_weight'] != 'N/A'&&$actual_date_result['Delivery']['unit_weight_uom'] != 'N/A') ? h($actual_date_result['Delivery']['unit_weight'] * $actual_date_result['Delivery']['quantity']).' '.$actual_date_result['Delivery']['unit_weight_uom']: 'N/A'; ?>&nbsp;</td>
                        <td><?php echo ($actaul_date_info[$actual_date_result['Delivery']['product_id']])?$actaul_date_info[$actual_date_result['Delivery']['product_id']]:'N/A' ?> </td>
                        <td style="width:90px;"><?php echo $actual_date_result['Delivery']['planned_delivery_date']; ?>&nbsp;</td>
                        <td><input type="text" name="actual_date_update" class="form-control col-md-1 col-xs-12 single_cal3" id="actual_date_update_<?php echo $actual_date_result['Delivery']['id']; ?>" value="<?php if(isset($actual_date_result['Delivery']['actual_delivery_date'])&&$actual_date_result['Delivery']['actual_delivery_date']!="0000-00-00") {echo $actual_date_result['Delivery']['actual_delivery_date'];}else{echo($date_type=="Actual")?$date:'';} ?>" readonly="1"/></td> 
                        <!--<td><button id="<?php //echo $actual_date_result['Delivery']['id']; ?>" class="actual_date_save btn btn-success" name="Save" value="Save"><span class="fa fa-save">Save</span></button>
                            <div id="message_<?php //echo $actual_date_result['Delivery']['id']; ?>"></div>
                        </td> -->
                       <td><?php echo $actual_date_result['Delivery']['added_by']; ?></td>
                       <td><?php echo  substr($actual_date_result['Delivery']['added_date'],0,10); ?></td>
                        <td>
                            <?php if(strtotime($actual_date_result['Delivery']['added_date'])>=  strtotime(date('Y-m-d'))){?>
                            <input type="button" id="production_<?php echo $actual_date_result['Delivery']['id']; ?>_deliveries" value="Delete" class="btn btn-danger product_delete"/>
                            <?php }?>
                        </td>
                    </tr>
                <?php endforeach; ?> 
                     <?php if($check_ad!=''): ?>
                    <tr>
                     <td colspan="9"><div style="display:none"id="showActualDateMessage" class="alert alert-success alert-dismissible fade in">Your Request Has Been Saved. Successfully.</div></td>
                        <td colspan="2">
                            <input type="hidden" id="url" value="deliveries/actual_delivery_date_editing">
                            <input type="hidden" id="contractID" value="<?php echo $contract_id;?>">
                            <input type="hidden" id="update_id" value="<?php echo implode("-", $id); ?>">
                            <input type="hidden" id="url_all" value="deliveries/actual_delivery_date_editing_all">
                            <input style="float:right;" type="button" id="saveAllActualDate" value="SaveAll  Actual Date" class="btn btn-success"/>
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
            'controller' => 'lot_products',
            'action' => 'getLotByContract',
            'model' => 'Delivery'
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