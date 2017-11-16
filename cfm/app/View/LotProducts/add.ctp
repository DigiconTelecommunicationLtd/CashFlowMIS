<div class="x_panel">
    <div class="x_content">
        <?php echo $this->Form->create('LotProduct', array('action' => 'add', 'class' => 'form-horizontal form-label-left', 'id' => 'LotProduct','onsubmit'=>'return check_balance();')); ?>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Contract/PO. No <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->hidden("contract_id", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required', 'id' => 'contract_id', 'value' => $lots['Contract']['id'])) ?>
                <?php echo $this->Form->input("contract_no", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'readOnly' => true, 'id' => 'contract_no', 'value' => $lots['Contract']['contract_no'])) ?>
            </div>
            <!-- Display contract product information by modal/ajax -->
            <div id='getAllProductByContract' class="col-md-3 col-sm-3 col-xs-12">
                <?php //echo $this->element('render/get_all_product_by_contract'); ?>
            </div>
            <!--Display contract product information by modal/ajax -->
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Lot No.<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("lot_id", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'readOnly' => true, 'id' => 'lot_id', 'value' => $lots['Lot']['lot_no'])) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product/Category Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control", 'required' => 'required', 'tabindex' => -1, 'empty' => '', 'id' => 'productCategoryId','data-placeholder'=>'Choose Product Category','options'=>$product_category)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product Name<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("product_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'required' => 'required', 'tabindex' => -1, 'empty' => '', 'id' => 'product_id','data-placeholder'=>'Choose a Product',)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div id="loading" style="display: none;">
                    <?php echo $this->Html->image('loading.gif',array('alt'=>'Please Wait ...','height'=>"15",'width'=>"15")); ?>
                    Please Wait ...
                </div>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Quantity<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("quantity", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number", 'required' => 'required', 'id' => 'quantity', 'tabindex' => 2, 'min'=>1,'onchange' => "calculate_reaming_qty(this.value)",'step'=>'any')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Contract Qty<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("contract_quantity", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'readOnly' => true, 'id' => 'contract_quantity')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Previous Lot quantity<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("lot_quantity", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'readOnly' => true, 'id' => 'lot_quantity', 'readOnly' => true)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">UOM <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php //echo $this->Form->input("uom", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control", 'required' => 'required', 'tabindex' => -1, 'empty' => '')) ?>
                <?php echo $this->Form->input("uom", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'id' => 'uom', 'required' => 'required', 'readOnly' => true,)) ?>
            </div>
        </div> 
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Unit Weight<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("unit_weight", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'id' => 'unit_weight', 'required' => 'required', 'readOnly' => true,)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">UOM(Unit Weight)<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("unit_weight_uom", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'id' => 'unit_weight_uom', 'required' => 'required', 'readOnly' => true,)) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Reaming Quantity <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("reaming_quantity", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'id' => 'reaming_quantity', 'readOnly' => true, 'style' => 'font-weight:bolder;')) ?>
            </div>
        </div>

        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Remarks
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("remarks", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'id' => 'remarks', 'tabindex' => 3)) ?>
            </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3"> 
                <?php echo $this->Form->submit('Add Lot Product', array('class' => 'btn btn-success', 'id' => 'lotProductSubmit')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>       
    </div>
    <div class="clearfix"></div>
    <!-- contract added product list -->
    <div class="x_content">
        <?php if ($this->Session->check('Message.flash')): ?> 
            <div class="x_title">       
                <div role="alert" class="alert alert-success alert-dismissible fade in">
                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                    </button>
                    <strong><?php echo $this->Session->flash(); ?></strong>
                </div>        
                <div class="clearfix"></div>
            </div>
        <?php endif; ?>
        <div  class="col-md-12 col-sm-12 col-xs-12" id="lotProductUpdate">
            <?php if ($lotProducts): ?>
                <table  class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL.NO:</th>
                            <!--<th>PO.No</th>-->
                            <th>Lot No.</th>
                            <th>Category</th>
                            <th>Product</th>                    
                            <th>PO. Qty</th>
                            <th>Lot Qty</th>
                            <th>UOM</th>
                            <!--<th>Balance Qty</th> -->
                            <th>Unit Weight</th>
                            <th>Lot Weight</th>
                            <th>Weight(UOM)</th>
                            <th>Remarks</th>
                            <th>Added By</th>
                            <th>Added Date</th>
                            <!--<th>Action</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sl=1;
                        $lot_id='';
                        foreach ($lotProducts as $lotProduct):?>
                            <tr>
                                <td> <?php echo $sl++; ?> </td>
                                <!--<td> <?php //echo $lotProduct['Contract']['contract_no']; ?> </td>-->
                                <td> <?php echo $lotProduct['LotProduct']['lot_id']; ?> </td>
                                <td> <?php echo $lotProduct['ProductCategory']['name']; ?> </td>
                                <td> <?php echo $lotProduct['Product']['name']; ?> </td>
                                <td><?php echo h($lotProduct['LotProduct']['contract_quantity']); ?>&nbsp;<?php echo h($lotProduct['LotProduct']['uom']); ?></td>
                                <td><?php echo h($lotProduct['LotProduct']['quantity']); ?>&nbsp;</td>
                                <td><?php echo h($lotProduct['LotProduct']['uom']); ?></td>
                                <!--<td><?php //echo h($lotProduct['LotProduct']['reaming_quantity']); ?>&nbsp;<?php //echo h($lotProduct['LotProduct']['uom']); ?></td> -->
                                <td><?php echo h($lotProduct['LotProduct']['unit_weight']!='N/A')?h($lotProduct['LotProduct']['unit_weight']):'N/A'; ?>&nbsp;</td>
                                <td><?php echo ($lotProduct['LotProduct']['unit_weight'] != 'N/A'&&$lotProduct['LotProduct']['unit_weight_uom'] != 'N/A') ? h($lotProduct['LotProduct']['unit_weight'] * $lotProduct['LotProduct']['quantity']): 'N/A'; ?>&nbsp;</td>
                                <td><?php echo h($lotProduct['LotProduct']['unit_weight_uom']); ?>&nbsp;</td>
                                <td> <?php echo $lotProduct['LotProduct']['remarks']; ?> </td> 
                                <td> <?php echo $lotProduct['LotProduct']['added_by']; ?> </td> 
                                <td> <?php echo $lotProduct['LotProduct']['added_date']; ?> </td> 
                                <!-- <td class="actions">
                                  <?php //if(substr($lotProduct['LotProduct']['added_date'],0,10)==date('Y-m-d')):?>
                                    <button onclick="delete_lot_product('<?php //echo $lotProduct['LotProduct']['id']; ?>', '<?php //echo $lotProduct['LotProduct']['contract_id']; ?>');"><i class="fa fa-remove"></i></button>
                                    <?php //endif;?>
                                </td>-->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<script tpye="text/javascript">
    function calculate_reaming_qty(qty)
    {
        var contract_quantity = parseInt(document.getElementById('contract_quantity').value);
        var lot_quantity = parseInt(document.getElementById('lot_quantity').value);
        var reaming_quantity = contract_quantity - qty;
        var reaming_quantity = reaming_quantity - lot_quantity;
        if(parseInt(Math.ceil(reaming_quantity)) < 0 || isNaN(reaming_quantity)) {
            alert('Given Qty is greater than balance Qty! Please try again.');
            document.getElementById('quantity').value='';
            document.getElementById('quantity').focus();
        }else{
        document.getElementById('reaming_quantity').value = reaming_quantity;
    }
    }
</script>

<?php
$data = $this->Js->get('#LotProduct')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#LotProduct')->event(
        'submit', $this->Js->request(
                array('controller' => 'lot_products', 'action' => 'add'), array(
            'update' => '#lotProductUpdate',
            'data' => $data,
            'async' => true,
            'dataExpression' => true,
            'method' => 'POST',
            'before' => "$('#loading').fadeIn();$('#lotProductSubmit').attr('disabled','disabled');",
            'complete' => "$('#loading').fadeOut();$('#lotProductSubmit').removeAttr('disabled');$('#quantity').val('');$('#unit_price').val('');$('#unit_weight').val('');$('#uom').val('');$('#remarks').val('');$('#reaming_quantity').val('');$('#lot_quantity').val('');$('#contract_quantity').val('');",
                )
        )
);
?>

<script>
function check_balance() {
    var reaming_quantity = document.forms["LotProduct"]["reaming_quantity"].value;
    var quantity = document.forms["LotProduct"]["quantity"].value;
    if (reaming_quantity<0) {
        alert("Lot size should exceed than PO size!,Please try again.");         
        window.location = window.location.href;     // Returns full URL
        return false;
    }
   else if (quantity<=0) {
        alert("Lot size should greater than zero !,Please try again.");         
        window.location = window.location.href;     // Returns full URL
        return false;
    }
}
</script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('fast');
        }, 1500); // <-- time in milliseconds
    });
</script>