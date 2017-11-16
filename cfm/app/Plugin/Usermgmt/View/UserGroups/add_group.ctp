<div class="x_panel">
    <div class="x_title">
        <span class="fa fa-user">&nbsp;<strong>Group Add:</strong></span>
        <ul class="nav navbar-right panel_toolbox">
            <li>
                <a href="<?php echo $this->Html->url('/allGroups/'); ?>" class="btn btn-primary"><i class="fa fa-arrow-right"></i></a>
            </li>                       

        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php echo $this->Form->create('UserGroup', array('action' => 'addGroup', 'class' => 'form-horizontal form-label-left')); ?>

        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">User Group Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("name", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'placeholder' => 'Group Name', 'required' => 'required')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alias">Display Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("alias_name", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'placeholder' => 'Group Name', 'required' => 'required')) ?>
                <?php echo $this->Form->hidden("allowRegistration", array("type" => "checkbox", 'label' => false, 'div' => false, 'checked' => "checked")) ?>
            </div>
        </div>                     
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3"> 
                <?php echo $this->Form->submit('submit', array('class' => 'btn btn-success')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>                    
    </div>
</div>