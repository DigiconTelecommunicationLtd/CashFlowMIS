<div class="row-fluid">
                 <div class="span12">
                     <!-- BEGIN BLANK PAGE PORTLET-->
                     <div class="widget red">
                         <div class="widget-title">
                             <h4><i class="icon-edit"></i><?php echo $this->fetch('title'); ?></h4>
                           <span class="tools">
                               <a href="javascript:;" class="icon-chevron-down"></a>
                               <a href="javascript:;" class="icon-remove"></a>
                           </span>
                         </div>
                         <div class="widget-body">
            
                    <?php echo $this->Form->create('User', array('action' => 'forgotPassword'), array('class' => 'form-horizontal', 'inputDefaults' => array('label' => false), 'role' => 'form')); ?>
                    <div class="form-group">
                        <label><?php echo __('Enter Email / Username');?></label>                                             
                        <?php echo $this->Form->input("email", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control", 'required' => true)) ?>
                    </div>
                    
                    <div class="form-group">
                        <?php echo $this->Form->submit('Send Email', array('class' => 'btn btn-lg btn-success btn-block')); ?>         
                    </div>
     