<div class="x_panel">
<div class="x_title">
        <h2>Lot Number Add:</h2>
        <ul class="nav navbar-right panel_toolbox">                      
            <li><a href="javascript:window.history.go(-1);" class="btn btn-primary"><i class="fa fa-arrow-right"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php echo $this->Form->create('Lot', array('action' => 'add', 'class' => 'form-horizontal form-label-left','id'=>'Lot')); ?>

        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Contract/PO No:<span class="required">*</span>
            </label>
         <div class="col-md-6 col-sm-6 col-xs-12">
           
            <?php echo $this->Form->input("Lot.contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => true,'data-placeholder'=>'Choose Contract/PO No.','id'=>'contract_id')) ?>
        </div>
        </div>
      
         <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Lot No:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12" id='lotID'>
               
            </div>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <div id="loading" style="display: none;">
                    <?php echo $this->Html->image('loading.gif',array('alt'=>'Please Wait ...','height'=>"15",'width'=>"15")); ?>
                    Please Wait ...
                </div>
            </div>
        </div>    
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3"> 
                <?php echo $this->Form->submit('Save', array('class' => 'btn btn-success','id'=>'gLotNum')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>                    
    </div>
</div>
<?php
$this->Js->get('#contract_id')->event('change', $this->Js->request(array(
            'controller' => 'lots',
            'action' => 'generateLotNumberByContract'
                ), array(
            'update' => '#lotID',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'before' => "$('#loading').fadeIn();$('#gLotNum').attr('disabled','disabled');",
            'complete' => "$('#loading').fadeOut();$('#gLotNum').removeAttr('disabled');",        
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);
?>