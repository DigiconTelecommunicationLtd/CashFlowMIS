<div class="x_panel">
    <div class="x_title">
        <span class="fa fa-user">&nbsp;<strong> Password Change:</strong></span>
        <ul class="nav navbar-right panel_toolbox">
            <li>
                <a href="<?php echo $this->Html->url('/dashboard/'); ?>" class="btn btn-primary"><i class="fa fa-dashboard"></i></a>
            </li>                       

        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php echo $this->Form->create('User', array('class' => 'form-horizontal form-label-left')); ?> 
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alias">New Password <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("password", array("type" => "password", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => true)) ?>
            </div>
        </div> 
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alias">Confirm Password<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("cpassword", array("type" => "password", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => true)) ?>
            </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3"> 
                <?php echo $this->Form->submit('change password', array('class' => 'btn btn-success')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>                    
    </div>
</div>
          
            
             
            
            