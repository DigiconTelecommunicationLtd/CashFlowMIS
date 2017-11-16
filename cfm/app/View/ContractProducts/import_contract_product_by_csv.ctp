<div class="x_panel">
    <div class="x_title">
        <h2>Contract Product Upload:</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php echo $this->Form->create('ContractProduct', array('action' => 'import_contract_product_by_csv/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'import_contract_product_by_csv',"enctype" => "multipart/form-data")); ?>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Contract/PO. No <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'required' => 'required', 'tabindex' => -1, 'empty' => '', 'id' => 'contract_id')) ?>
            </div>            
        </div>       
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Contract Product CSV Files <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("import_contract_product_by_csv", array("type" => "file", 'label' => false, 'div' => false, 'class' => "form-control", 'required' => 'required')) ?>
            </div>
        </div>         
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3"> 
                <?php echo $this->Form->submit('Upload', array('class' => 'btn btn-success disabled_btn', 'id' => 'ContractProductSubmit')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>         
    </div>
</div> 