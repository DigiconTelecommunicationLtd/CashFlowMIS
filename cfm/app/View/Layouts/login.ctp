<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CASH CYCLE MIS: | Login </title>
    <?php echo $this->Html->meta('favicon.ico','img/favicon.png',array('type' => 'icon')); ?>
    <!-- Bootstrap -->
	<?php echo $this->Html->css('/vendors/bootstrap/dist/css/bootstrap.min');?>     
    <!-- Font Awesome -->
	<?php echo $this->Html->css('/vendors/font-awesome/css/font-awesome.min');?>
    <!-- NProgress -->
	<?php echo $this->Html->css('/vendors/nprogress/nprogress');?>
   

    <!-- Custom Theme Style -->
	<?php echo $this->Html->css('/build/css/custom.min');?>
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
             <h3 style="color:red;"><strong><?php echo $this->Session->flash(); ?></strong></h3>
          <section class="login_content">
            <?php echo $this->Form->create('User', array('action' => 'login'), array('class' => 'form-horizontal', 'inputDefaults' => array('label' => false), 'role' => 'form')); ?>
               <?php echo $this->Html->image('Infrastructure_Logo-.jpg',array('width'=>'100%')); ?> 
              <div style="margin-top: 20px;">
				<?php echo $this->Form->input('email', array('type' => 'text', 'class' => 'form-control', 'label' => false, 'placeholder' => 'Username', 'autofocus','required'=>'required')); ?>
              </div>
              <div>
				<?php echo $this->Form->input('password', array("type" => "password", 'class' => 'form-control', 'label' => false, 'placeholder' => 'Password','required'=>'required')); ?>
              </div>
              <div style="float: right">
                 <?php echo $this->Form->submit('Log in', array('class' => 'btn btn-default submit')); ?>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div>                  
                  <p>©2016 All Rights Reserved. CASH CYCLE MIS - Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>