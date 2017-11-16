<div class="x_panel">
    <div class="x_title">
        <h2>Advance Payment:</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php echo $this->Form->create('Collection', array('action' => 'advance_payment_add/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'Collection')); ?>
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
</div> 
<!--  product by contract -->
<?php
/*$this->Js->get('#contract_id')->event('change', $this->Js->request(array(
            'controller' => 'contract_products',
            'action' => 'getAllProductByContract',
            'model'=>'Collection'
                ), array(
            'update' => '#getAllProductByContract',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);*/
?>
<!--  /product by contract -->