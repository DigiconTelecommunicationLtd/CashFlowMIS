<div class="x_panel">
    <div class="x_content">
        <?php echo $this->Form->create('Delivery', array('action' => 'post_landing_inspection/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'DeliverySearch')); ?>
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
                <div id="loading1" style="display: none;">
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Actual Date of PLI
            </label>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <?php echo $this->Form->input("date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 single_cal3",'value'=>isset($date)?$date:'','readOnly'=>true)) ?>
            </div>
           <label class="control-label col-md-2 col-sm-2 col-xs-12" for="name">Actual Date of PLI Approval
            </label>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <?php echo $this->Form->input("date1", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 single_cal3",'value'=>isset($date1)?$date1:'','readOnly'=>true)) ?>
            </div>            
               <div class="col-md-2 col-sm-2 col-xs-12">
                <?php echo $this->Form->submit('Search', array('class' => 'btn btn-success', 'id' => 'lotProductSubmit')); ?>
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
    <?php if ($actual_date_results):?>
    <div class="x_content">
        <table  class="table table-striped table-bordered table_scrol" style="width:100%">
        <thead>
            <tr>
                <td>Category</td>
                <td style="width:100px;">Product</td>                    
                <td><a data-toggle="tooltip"  title="Delivery Quantity">Deli. Qty</a></td> 
                <td><a data-toggle="tooltip"  title="Previous PLI Qty">Prev. PLI Qty</a></td>
                <td><a data-toggle="tooltip"  title="Balance PLI Qty">Balance PLI Qty</a></td>
                <td>UOM</td>  
                <!--<td>Total Weight</td> -->               
                <td><a data-toggle="tooltip"  title="Planned Delivery Date">Planned Delivery Date</a></td>
                <td><a data-toggle="tooltip"  title="Actual Delivery Date">Actual Delivery Date</a></td>
                <!--PLI -->
                <?php if($contract_assumption&&$contract_assumption['Contract']['contracttype']=="Supply"): ?>
                <td><a data-toggle="tooltip"  title="Planned Date Of PLI">Planned Date Of PLI</a></td>
                <td><a data-toggle="tooltip"  title="Actual Date Of PLI">Actual Date Of PLI</a></td>
                <td  style="width:100px;"><a data-toggle="tooltip"  title="Planned Date of PLI Approval">Planned Date of PLI Approval</a></td>
                <td><a data-toggle="tooltip"  title="Actual Date of PLI Approval">Actual Date of PLI Approval</a></td>
                <?php endif;?>
                <?php if($contract_assumption&&$contract_assumption['Contract']['contracttype']=="Supply & Installation"): ?>
                <!--PLI -->
                <td><a data-toggle="tooltip"  title="Planned Date Of Installation">Planned Date Of Installation</a></td>
                <td><a data-toggle="tooltip"  title="Actual date of Installation">Actual date of Installation</a></td>
                <td  style="width:100px;"><a data-toggle="tooltip"  title="Planned Date of Client Receiving">Planned Date of Client Receiving</a></td>
                <td><a data-toggle="tooltip"  title="Actual Date of Client Receiving">Actual Date of Client Receiving</a></td>
                <?php endif;?>                
                <!--<th>Action</th> -->                     
            </tr>
        </thead>
        <tbody>
 <?php
 $id=array();
 foreach ($actual_date_results as $actual_date_result):
 $id[]=$actual_date_result['Delivery']['id'];  
 
     ?>
                    <tr>
                        <td><?php echo $actual_date_result['ProductCategory']['name']; ?> </td>
                        <td><?php echo $actual_date_result['Product']['name']; ?> </td>
                        <td>
                            <input type="hidden" name="quantity[]" class="form-control col-md-1 col-xs-12" id="quantiy_<?php echo $actual_date_result['Delivery']['id']; ?>" value="<?php echo $actual_date_result['Delivery']['quantity']; ?>"/>
                            <?php echo $actual_date_result['Delivery']['quantity']; ?></td>
                         <td><?php echo $actual_date_result['Delivery']['pli_qty']; ?> </td>
                        <td width="80px;">
                            <?php $balance=$actual_date_result['Delivery']['quantity']-$actual_date_result['Delivery']['pli_qty'] ?>
                            <input type="hidden" name="pli_qty_already[]" class="form-control col-md-1 col-xs-12 numeric_number" id="pli_qty_already_<?php echo $actual_date_result['Delivery']['id']; ?>" value="<?php echo $actual_date_result['Delivery']['pli_qty']; ?>"/>
                            <input type="number" min="0" max="<?php echo $balance; ?>" name="pli_qty[]" class="form-control col-md-1 col-xs-12 numeric_number" id="pli_qty_<?php echo $actual_date_result['Delivery']['id']; ?>" value="<?php echo $balance; ?>" onkeyup="this.value = minmax(this.value, 0, <?php echo $balance; ?>)"/>
                           
                            </td>
                            <td><?php echo h($actual_date_result['Delivery']['uom']); ?></td>
                        <!--<td><?php //echo ($actual_date_result['Delivery']['unit_weight'] != 'N/A'&&$actual_date_result['Delivery']['unit_weight_uom'] != 'N/A') ? h($actual_date_result['Delivery']['unit_weight']).' '.$actual_date_result['Delivery']['unit_weight_uom']: 'N/A'; ?>&nbsp;</td>
                        <td><?php //echo ($actual_date_result['Delivery']['unit_weight'] != 'N/A'&&$actual_date_result['Delivery']['unit_weight_uom'] != 'N/A') ? h($actual_date_result['Delivery']['unit_weight'] * $actual_date_result['Delivery']['quantity']).' '.$actual_date_result['Delivery']['unit_weight_uom']: 'N/A'; ?>&nbsp;</td> -->
                        <td><?php echo $actual_date_result['Delivery']['planned_delivery_date']; ?>&nbsp;</td>
                        <td><?php echo $actual_date_result['Delivery']['actual_delivery_date']; ?>&nbsp;</td>
                         
                        <!--PLI -->
                        <?php if($contract_assumption&&$contract_assumption['Contract']['contracttype']=="Supply"): ?>
                        <td><?php echo h($actual_date_result['Delivery']['planned_pli_date']); ?>&nbsp;</td>
                        <td width="120px;">
                            <input type="text" name="actual_date_update" class="form-control col-md-1 col-xs-12 single_cal3" id="actual_date_update_<?php echo $actual_date_result['Delivery']['id']; ?>" value="<?php if(isset($actual_date_result['Delivery']['actual_pli_date'])&&$actual_date_result['Delivery']['actual_pli_date']!="0000-00-00") {echo $actual_date_result['Delivery']['actual_pli_date'];}else{echo ($date)?$date:'';} ?>" readonly="1"/>
                            <?php //echo h($actual_date_result['Delivery']['actual_pli_date']); ?>&nbsp;</td>
                        <td><?php echo h($actual_date_result['Delivery']['planned_date_of_pli_aproval']); ?>&nbsp;</td>
                        <td  width="110px;">
                            <input type="text" name="actual_date_update_1" class="form-control col-md-1 col-xs-12 single_cal3" id="actual_date_update_1_<?php echo $actual_date_result['Delivery']['id']; ?>" value="<?php if(isset($actual_date_result['Delivery']['actual_date_of_pli_aproval'])&&$actual_date_result['Delivery']['actual_date_of_pli_aproval']!="0000-00-00") {echo $actual_date_result['Delivery']['actual_date_of_pli_aproval'];}else{echo ($date1)?$date1:'';} ?>" readonly="1"/>
                            <?php //echo h($actual_date_result['Delivery']['actual_date_of_pli_aproval']); ?>&nbsp;</td>
                        <?php endif;?>
                        <?php if($contract_assumption&&$contract_assumption['Contract']['contracttype']=="Supply & Installation"): ?>
                        <!--PLI -->
                        <td><?php echo h($actual_date_result['Delivery']['planned_date_of_installation']); ?>&nbsp;</td>
                        <td  width="120px;">
                            <input type="text" name="actual_date_update" class="form-control col-md-1 col-xs-12 single_cal3" id="actual_date_update_<?php echo $actual_date_result['Delivery']['id']; ?>" value="<?php if(isset($actual_date_result['Delivery']['actual_date_of_installation'])&&$actual_date_result['Delivery']['actual_date_of_installation']!="0000-00-00") {echo $actual_date_result['Delivery']['actual_date_of_installation'];}else{echo ($date)?$date:'';} ?>" readonly="1"/>
                            <?php //echo h($actual_date_result['Delivery']['actual_date_of_installation']); ?>&nbsp;</td>
                        <td><?php echo h($actual_date_result['Delivery']['planned_date_of_client_receiving']); ?>&nbsp;</td>
                        <td width="110px;">
                            <input type="text" name="actual_date_update_1" class="form-control col-md-1 col-xs-12 single_cal3" id="actual_date_update_1_<?php echo $actual_date_result['Delivery']['id']; ?>" value="<?php if(isset($actual_date_result['Delivery']['actual_date_of_client_receiving'])&&$actual_date_result['Delivery']['actual_date_of_client_receiving']!="0000-00-00") {echo $actual_date_result['Delivery']['actual_date_of_client_receiving'];}else{echo ($date1)?$date1:'';} ?>" readonly="1"/>
                            <?php //echo h($actual_date_result['Delivery']['actual_date_of_client_receiving']); ?>&nbsp;</td>
                        <?php endif;?>
                       <!-- <td><button id="<?php //echo $actual_date_result['Delivery']['id']; ?>" class="actual_date_save_pli btn btn-success" name="Save" value="Save"  title="Save"><span class="fa fa-save" title="Save"></span></button>
                            <div id="message_<?php //echo $actual_date_result['Delivery']['id']; ?>"></div>
                        </td> -->
                    </tr>
                <?php endforeach; ?> 
                   <!-- <tr style="display:none;">
                        <td colspan="13">
                            <input type="hidden" id="url" value="deliveries/actual_pli_date_editing">
                            <input type="hidden" id="rr_collection" value="<?php //echo ($contract_assumption['Contract']['rr_collection_progressive'])?$contract_assumption['Contract']['rr_collection_progressive']:0?>">
                            <input type="hidden" id="contract_id" value="<?php //echo $contract_id;?>">
                        </td>
                    </tr>-->
                     <tr>
                     <td colspan="10"><div style="display:none"id="showActualDateMessage" class="alert alert-success alert-dismissible fade in">Your Request Has Been Saved. Successfully.</div></td>
                        <td colspan="2">
                             <input type="hidden" id="contract_id" value="<?php echo $contract_id;?>">
                            <input type="hidden" id="url" value="deliveries/actual_pli_date_editing">
                            <input type="hidden" id="rr_collection" value="<?php echo ($contract_assumption['Contract']['rr_collection_progressive'])?$contract_assumption['Contract']['rr_collection_progressive']:0?>">
                            <input type="hidden" id="contractID" value="<?php echo $contract_id;?>">
                            <input type="hidden" id="update_id" value="<?php echo implode("-", $id); ?>">
                            <input type="hidden" id="url_all" value="deliveries/actual_pli_date_editing_all">
                            <input style="float:right;" type="button" id="saveAllActualDatePLI" value="SaveAll  Actual Date" class="btn btn-success"/>
                        </td>
                    </tr>
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
            'before' => "$('#loading1').fadeIn();$('#lotProductSubmit').attr('disabled','disabled');",
            'complete' => "$('#loading1').fadeOut();$('#lotProductSubmit').removeAttr('disabled');",        
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);
?>  
<!--    
<?php/*
$this->Js->get('#lot_id')->event('change', $this->Js->request(array(
            'controller' => 'lot_products',
            'action' => 'getProductByLot',
            'model' => 'Delivery'
                ), array(
            'update' => '#DeliveryProductID',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'before' => "$('#loading2').fadeIn();",
            'complete' => "$('#loading2').fadeOut();",        
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);*/
?>      -->
    