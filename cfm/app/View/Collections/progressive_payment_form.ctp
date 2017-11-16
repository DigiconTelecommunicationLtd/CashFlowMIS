<div class="x_panel">
    <div class="x_title">
        <h2>Progressive Payment:</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php echo $this->Form->create('Collection', array('action' => 'progressive_payment_form/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'Collection')); ?>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Contract/PO. No <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">                
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'required' => 'required', 'tabindex' => -1, 'empty' => '', 'id' => 'contract_id')) ?>
            </div>
            <!-- Display contract product information by modal/ajax -->
            <div id='getAllProductByContract' class="col-md-3 col-sm-3 col-xs-12">
             </div>
            <!--Display contract product information by modal/ajax -->
        </div>
         <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Lot No.<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">                
                <?php echo $this->Form->input("lot_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'required' => 'required', 'tabindex' => -1, 'id' => 'lot_id','default'=>$lot_id)) ?>
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Currency <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("currency", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control", 'required' => 'required', 'tabindex' => -1, 'empty' => '')) ?>
            </div>
        </div>         
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3"> 
                <?php echo $this->Form->submit('Go!', array('class' => 'btn btn-success', 'id' => 'CollectionSubmit')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>         
    </div>
    <!--if one-->
    <?php if($deliveries):?>
    <table class="table table-striped table-bordered">
        <tr>
            <th>SL.No:</th>
            <th>Category</th>
            <th>Product</th>
            <th>Delivery Qty</th>
            <th>PLI Qty</th>
            <th>Previous Invoice Qty</th>            
            <th>Balance Qty</th>            
            <th>Unit Price</th>
            <th>Invoice Qty</th>
        </tr>
       <?php echo $this->Form->create('Collection', array('action' => 'add_progressive_payment', 'class' => 'form-horizontal form-label-left','id'=>'ProgressivePayment')); ?>
      <?php
      $sl=1;
      foreach ($deliveries as $delivery):?>
          <tr>
            <td><?php echo $sl++;?></td>
            <td><?php echo $delivery['ProductCategory']['name'];?></td>
            <td><?php echo $delivery['Product']['name'];?></td>
            <td><?php echo $dp=$delivery[0]['quantity'];?>&nbsp;<?php echo $delivery['Delivery']['uom'];?></td>
            <td><?php echo $pli_qty=$delivery[0]['pli_qty'];?>&nbsp;<?php echo $delivery['Delivery']['uom'];?></td>
            <td><?php echo $pp=($alr_pro_products[$delivery['Delivery']['product_id']])?$alr_pro_products[$delivery['Delivery']['product_id']]:0; ?>&nbsp;<?php echo $delivery['Delivery']['uom'];?></td>            
            <td><?php echo $balance=$pli_qty-$pp;?>&nbsp;<?php echo $delivery['Delivery']['uom'];?></td>             
            <td><?php echo ($con_unit_price[$delivery['Delivery']['product_id']]>0)?$con_unit_price[$delivery['Delivery']['product_id']]:"0.00";?></td>
            <td>
                <input type="hidden" name="product_category_id[<?php echo $delivery['Delivery']['product_id'];?>]" value="<?php echo $delivery['Delivery']['product_category_id'];?>"  required="1"/>
                <input type="hidden" name="unit_weight_uom[<?php echo $delivery['Delivery']['product_id'];?>]" value="<?php echo $delivery['Delivery']['unit_weight_uom'];?>"  required="1"/>
                <input type="hidden" name="unit_weight[<?php echo $delivery['Delivery']['product_id'];?>]" value="<?php echo $delivery['Delivery']['unit_weight'];?>"  required="1"/>
                <input type="hidden" name="unit_price[<?php echo $delivery['Delivery']['product_id'];?>]" value="<?php echo ($con_unit_price[$delivery['Delivery']['product_id']]>0)?$con_unit_price[$delivery['Delivery']['product_id']]:0;?>"  required="1"/>
                <input type="hidden" name="uom[<?php echo $delivery['Delivery']['product_id'];?>]" value="<?php echo $delivery['Delivery']['uom'];?>"  required="1"/>
                <input type="number" name="quantity[<?php echo $delivery['Delivery']['product_id'];?>]" value="<?php echo ($balance>0)?$balance:''; ?>" class="numeric_number" onkeyup="this.value = minmax(this.value, 0, <?php echo $balance;?>)" min="0" max="<?php echo $balance; ?>" step="any"/>
                
            </td>
        </tr>
      <?php endforeach; ?>   
        <tr>
            <td align="right" colspan="9">
                <input type="hidden" name="currency" value="<?php echo $currency;?>" required="1"/>
                <input type="hidden" name="contract_id" value="<?php echo $contract_id;?>" required="1"/>
                <input type="hidden" name="lot_id" value="<?php echo $lot_id;?>" required="1"/>
                <input class="btn btn-success" type="submit" name="submit" value="Submit"/></td>
        </tr>
        </form>  
    </table>
        
    <?php endif; ?>
    <!--/if one-->
</div>  
<!--  product by contract -->
<?php
$this->Js->get('#contract_id')->event('change', $this->Js->request(array(
            'controller' => 'lot_products',
            'action' => 'getLotByContract',
            'model' => 'Collection'
                ), array(
            'update' => '#lot_id',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'before' => "$('#loading').fadeIn();$('#CollectionSubmit').attr('disabled','disabled');",
            'complete' => "$('#loading').fadeOut();$('#CollectionSubmit').removeAttr('disabled');",        
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);
?>
<!--  /product by contract -->