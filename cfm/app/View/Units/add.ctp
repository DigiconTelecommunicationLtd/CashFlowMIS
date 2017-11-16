<div class="x_panel">
    <div class="x_title">
        <h2>Company/Unit Add:</h2>
        <ul class="nav navbar-right panel_toolbox">                      
            <li><a href="javascript:window.history.go(-1);" class="btn btn-primary"><i class="fa fa-arrow-right"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php echo $this->Form->create('Unit', array('action' => 'add', 'class' => 'form-horizontal form-label-left')); ?>

        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Company/Unit Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("name", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12", 'required' => 'required')) ?>
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