<div class="x_panel">
    <div class="x_content">
        <?php echo $this->Form->create('LotProduct', array('action' => 'edit', 'class' => 'form-horizontal form-label-left', 'id' => 'LotProduct')); ?>
         <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Quantity<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("quantity", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number", 'required' => 'required', 'id' => 'quantity', 'tabindex' => 1)) ?>
            </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3"> 
                <?php echo $this->Form->hidden("id", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number", 'required' => 'required', 'id' => 'id')) ?>
                <?php echo $this->Form->hidden("contract_id", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number", 'required' => 'required', 'id' => 'contract_id')) ?>
                <?php echo $this->Form->hidden("product_id", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12 numeric_number", 'required' => 'required', 'id' => 'product_id')) ?>
                <?php echo $this->Form->submit('Save Lot Product Qty', array('class' => 'btn btn-success', 'id' => 'lotProductSubmit')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>       
    </div>
</div>