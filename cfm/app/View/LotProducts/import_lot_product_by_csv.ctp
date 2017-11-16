<div class="x_panel">
    <div class="x_title">
        <h2>Lot Product Upload:</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php echo $this->Form->create('LotProduct', array('action' => 'import_lot_product_by_csv/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'LotProduct',"enctype" => "multipart/form-data")); ?>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Contract/PO. No <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'required' => 'required', 'tabindex' => -1, 'empty' => '', 'id' => 'contract_id')) ?>
            </div>            
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Lot No: <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">               
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Contract Product CSV Files <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("import_contract_product_by_csv", array("type" => "file", 'label' => false, 'div' => false, 'class' => "form-control", 'required' => 'required')) ?>
            </div>
        </div>         
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3"> 
                <?php echo $this->Form->submit('Upload', array('class' => 'btn btn-success', 'id' => 'LotProductSubmit')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>         
    </div>
</div> 
<?php
$this->Js->get('#contract_id')->event('change', $this->Js->request(array(
            'controller' => 'lots',
            'action' => 'getLotByContract',
            'model' => 'LotProduct'
                ), array(
            'update' => '#lot_id',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'before' => "$('#loading').fadeIn();$('#LotProductSubmit').attr('disabled','disabled');",
            'complete' => "$('#loading').fadeOut();$('#LotProductSubmit').removeAttr('disabled');",         
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);
?>