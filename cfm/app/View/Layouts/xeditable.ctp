<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CASH CYCLE MIS: | <?php echo $this->fetch('title'); ?></title>

        <!-- Bootstrap -->
        <?php echo $this->Html->css('/vendors/bootstrap/dist/css/bootstrap.min'); ?>
        <!-- Font Awesome -->
        <?php echo $this->Html->css('/vendors/font-awesome/css/font-awesome.min'); ?>
        <!-- NProgress -->
        <?php echo $this->Html->css('/vendors/nprogress/nprogress'); ?>
        <!-- iCheck -->
        <?php echo $this->Html->css('/vendors/iCheck/skins/flat/green'); ?>
         <!-- Select2 -->
        <?php echo $this->Html->css('/vendors/select2/dist/css/select2.min'); ?>
        <!-- Datatables -->
        <?php echo $this->Html->css('/vendors/datatables.net-bs/css/dataTables.bootstrap.min'); ?>
        <?php echo $this->Html->css('/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min'); ?>
        <?php echo $this->Html->css('/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min'); ?>
        <?php echo $this->Html->css('/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min'); ?>
        <?php echo $this->Html->css('/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min'); ?>
        <?php echo $this->Html->css('style'); ?>

        <!-- Custom Theme Style -->
        <?php echo $this->Html->css('/build/css/custom.min'); ?>
        <?php echo $this->Html->script('jquery-1.7.1.min');
		echo $this->Html->script('jquery.jeditable.mini');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
    </head>
<body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <?php echo $this->element('menu'); ?>

                <!-- top navigation -->
                <?php echo $this->element('top-menu'); ?>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?php if ($this->Session->check('Message.flash')): ?> 
                            <div role="alert" class="alert alert-success alert-dismissible fade in">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                </button>
                                <strong><?php echo $this->Session->flash(); ?></strong>
                            </div> 
                        <?php endif; ?>  

			<?php echo $this->fetch('content'); ?>
		</div> 
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        ©2016 All Rights Reserved. CASH CYCLE MIS - Privacy and Terms
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>

        <!-- jQuery -->
        <?php //echo $this->Html->script('/vendors/jquery/dist/jquery.min'); ?>
        <!-- Jeditable -->
        <?php //echo $this->Html->script('jquery.jeditable'); ?>
        <!-- Bootstrap -->
        <?php //echo $this->Html->script('/vendors/bootstrap/dist/js/bootstrap.min'); ?>
         
        <!-- FastClick -->
        <?php echo $this->Html->script('/vendors/fastclick/lib/fastclick'); ?>
        <!-- NProgress -->
        <?php echo $this->Html->script('/vendors/nprogress/nprogress'); ?>
        <!-- iCheck -->
        <?php echo $this->Html->script('/vendors/iCheck/icheck.min'); ?>
        <!-- bootstrap-daterangepicker -->
        <?php echo $this->Html->script('/js/moment/moment.min'); ?>     
        <?php echo $this->Html->script('/js/datepicker/daterangepicker'); ?>
        <!-- Datatables -->
        <?php echo $this->Html->script('/vendors/datatables.net/js/jquery.dataTables.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-bs/js/dataTables.bootstrap.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-buttons/js/dataTables.buttons.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-buttons/js/buttons.flash.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-buttons/js/buttons.html5.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-buttons/js/buttons.print.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-keytable/js/dataTables.keyTable.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-responsive/js/dataTables.responsive.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-responsive-bs/js/responsive.bootstrap'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-scroller/js/datatables.scroller.min'); ?>

        <?php echo $this->Html->script('/vendors/jszip/dist/jszip.min'); ?>

        <?php echo $this->Html->script('/vendors/pdfmake/build/pdfmake.min'); ?>
        <?php echo $this->Html->script('/vendors/pdfmake/build/vfs_fonts'); ?>
        <!-- Switchery -->
     <?php echo $this->Html->script('/vendors/switchery/dist/switchery.min'); ?>
        <!-- Select2 -->
     <?php echo $this->Html->script('/vendors/select2/dist/js/select2.full.min'); ?>

        <!-- Custom Theme Scripts -->
        <?php echo $this->Html->script('/build/js/custom.min'); ?>
       
      
    </body>
</html>