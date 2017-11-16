<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo $this->Html->url("/dashboard/"); ?>" class="site_title"><?php echo $this->Html->image('CG.jpg',array('width'=>'15%')); ?> <span>Cash Cycle MIS!</span></a>
        </div>
        <?php $user = $this->Session->read('UserAuth');
              $UserGroup=$user['UserGroup']['alias_name'];
              if(!$user)
              {
              echo'<meta http-equiv="refresh" content="0; url=http://'.$_SERVER['HTTP_HOST'].'/cfm/logout">';
              exit;  
              }
              ?>
        <div class="clearfix"></div>
        
        <!-- menu profile quick info -->
        <!-- <div class="profile">
          <div class="profile_pic">
            <img src="images/img.jpg" alt="..." class="img-circle profile_img">
          </div>
          <div class="profile_info">
            <span>Welcome,</span>
            <h2>John Doe</h2>
          </div>
        </div>-->
        <!-- /menu profile quick info --> 
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section" style="margin-bottom:-8px;">                
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-home"></i> Dashboard <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">				  
                            <li><a href="<?php echo $this->Html->url("/dashboard/"); ?>">Dashboard</a></li>                       
                        </ul>
                    </li>
                </ul>
            </div>  
            <div class="menu_section">                
                <ul class="nav side-menu">
                    <?php
                    #user management,sma,oa
                    $gp=array('Admin','OA','SMA');
                    if(in_array($UserGroup, $gp)): ?>
                    <li><a><i class="fa fa-user"></i> User Management <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                         <?php $gp=array('Admin');
                            if(in_array($UserGroup, $gp)): ?>
                            <li><a href="<?php echo $this->Html->url("/addGroup/"); ?>">Add User Group</a></li>
                            <li><a href="<?php echo $this->Html->url("/allGroups/"); ?>">User Group List</a></li>
                            <li><a href="<?php echo $this->Html->url("/permissions/"); ?>">User Group Permission</a></li>
                            <?php endif;?>
                            <li><a href="<?php echo $this->Html->url("/allUsers/"); ?>">User List</a></li>
                        </ul>
                    </li>
                    <?php endif;#User Management?>
                    <?php
                    #setting+contract,lot define,sma
                    $gp=array('Admin','SMA');
                    if(in_array($UserGroup, $gp)): ?>
                    <li <?php $controllers = array('clients','units','product_categories','products');echo (in_array($this->params['controller'], $controllers)) ? "class='active'" : ""?>><a><i class="fa fa-cogs"></i> Setting <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" <?php echo (in_array($this->params['controller'], $controllers)) ? "style=display:block;" : ''; ?>>
                            <li><a href="<?php echo $this->Html->url("/clients/add/"); ?>">Add Client</a></li>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action'] == "clients_index"||$this->params['controller'] . '_' . $this->params['action'] == "clients_edit") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/clients/"); ?>">Client List</a></li>
                            <li><a href="<?php echo $this->Html->url("/units/add/"); ?>">Company/Unit Add</a></li>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action'] == "units_index"||$this->params['controller'] . '_' . $this->params['action'] == "units_edit") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/units/"); ?>">Company/Unit List</a></li>
                            <li><a href="<?php echo $this->Html->url("/product_categories/add/"); ?>">Product/Category Add</a></li>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action'] == "product_categories_index"||$this->params['controller'] . '_' . $this->params['action'] == "product_categories_edit") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/product_categories/"); ?>">Product/Category List</a></li>
                            <li><a href="<?php echo $this->Html->url("/products/add/"); ?>">Product Add</a></li>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action'] == "products_index"||$this->params['controller'] . '_' . $this->params['action'] == "products_edit") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/products/"); ?>">Product List</a></li>
                        </ul>
                    </li>   
                    <?php endif;?>
                    <?php
                    #setting+contract,lot define,sma
                    $gp=array('Admin','SM','SMA');
                    if(in_array($UserGroup, $gp)): ?>
                    <li <?php $controllers = array('contracts');echo (in_array($this->params['controller'], $controllers)) ? "class='active'" : ""?>><a><i class="fa fa-desktop"></i> Contract <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" <?php echo (in_array($this->params['controller'], $controllers)) ? "style=display:block;" : ''; ?>>
                            <li><a href="<?php echo $this->Html->url("/contracts/add/"); ?>">Contract Add</a></li>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action'] == "contracts_index"||$this->params['controller'] . '_' . $this->params['action'] == "contracts_edit"||$this->params['controller'] . '_' . $this->params['action'] == "contracts_view") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/contracts/"); ?>">Contract List</a></li>                            
                        </ul>
                    </li>                    
                    <li <?php $controllers = array('lot_products', 'lots');echo (in_array($this->params['controller'], $controllers)) ? "class='active'" : ""?>><a><i class="fa fa-wrench"></i> Lot Define <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" <?php echo (in_array($this->params['controller'], $controllers)) ? "style=display:block;" : ''; ?>>                      
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action'] == "lots_add") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/lots/add/"); ?>">Define Lot Number.</a></li>
                            <!--<li <?php //echo ($this->params['controller'] . '_' . $this->params['action'] == "lot_products_add") ? "class='current-page'" : "" ?>><a href="<?php //echo $this->Html->url("/lot_products/add/"); ?>">Define Lot Product</a></li> -->
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action'] == "lots_index") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/lots/"); ?>">List of Lot's Number</a></li>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action'] == "lot_product_index") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/lot_products/"); ?>">List of Lot Product's</a></li>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action'] == "lot_products_import_lot_product_by_csv") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/lot_products/import_lot_product_by_csv/"); ?>">Import Lot Product-CSV</a></li>
                        </ul>
                    </li>
                  <?php endif;#Setting?>
                     <?php
                    #procurement+production,sma,oa
                    $gp=array('Admin','Operations','OA','SM','SMA');
                    if(in_array($UserGroup, $gp)): ?>
                    <li><a><i class="fa fa-dribbble"></i>Raw Material Procurement <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">                                               
                            <li><a href="<?php echo $this->Html->url("/procurements/add/"); ?>">Define Procurement </a></li>
                         </ul>
                    </li>
                    <li><a><i class="fa fa-industry"></i> Production <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">                                               
                            <li><a href="<?php echo $this->Html->url("/productions/add/"); ?>">Define Production</a></li>
                            <?php
                            #Only Admin allow
                            $gp=array('Admin');
                            if(in_array($UserGroup, $gp)): ?>
                           <li><a href="<?php echo $this->Html->url("/productions/product_transfer_lot_to_lot/"); ?>">Product Transfer</a></li>
                           <?php endif;?>
                         </ul>
                    </li>
                    <?php endif;?>
                     <?php
                    #procurement+production,sma,oa
                    $gp=array('Admin','Operations','SM','SMA','OA');
                    if(in_array($UserGroup, $gp)): ?>
                    <li><a><i class="fa fa-cubes"></i> PSI <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                                               
                            <li><a href="<?php echo $this->Html->url("/inspections/add/"); ?>">Define PSI</a></li>
                           
                        </ul>
                    </li>
                    <?php endif;?>
                    <?php
                    #procurement+production,sma,oa
                    $gp=array('Admin','Operations','OA');
                    if(in_array($UserGroup, $gp)): ?>
                    <li><a><i class="fa fa-truck"></i> Delivery <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">                                               
                            <li><a href="<?php echo $this->Html->url("/deliveries/add/"); ?>">Define Delivery</a></li>
                        </ul>
                    </li>
                    <?php endif;?>
                    <?php
                    #pli,sma,operations
                    $gp=array('Admin','Operations','SM','SMA','OA');
                    if(in_array($UserGroup, $gp)): ?>
                    <li><a><i class="fa fa-check-square-o"></i> PLI <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                                               
                            <li><a href="<?php echo $this->Html->url("/deliveries/post_landing_inspection/"); ?>">Define PLI</a></li>
                           
                        </ul>
                    </li>
                    <?php endif;?>
                     <?php
                    #pli,sma,operations
                    $gp=array('Admin','Finance','SM','SMA');
                    if(in_array($UserGroup, $gp)): ?>
                    <li <?php $controllers = array('collections', 'progressive_payments');echo (in_array($this->params['controller'], $controllers)) ? "class='active'" : ""?>><a><i class="fa fa-dollar"></i> Payment Collection <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" <?php echo (in_array($this->params['controller'], $controllers)) ? "style=display:block;" : ''; ?>>                      
                            <?php $gp=array('Admin','SM','SMA');
                                   if(in_array($UserGroup, $gp)): ?>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action']== "collections_advance_collection_form"||$this->params['controller'] . '_' . $this->params['action']== "collections_advance_payment_add") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/collections/advance_collection_form/"); ?>">Advance Collection</a></li>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action']== "collections_progressive_payment_form"||$this->params['controller'] . '_' . $this->params['action']== "progressive_payments_add") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/collections/progressive_payment_form/"); ?>">Progressive Collection</a></li>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action']== "collections_retention_collection_form"||$this->params['controller'] . '_' . $this->params['action']== "collections_retention_payment_add") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/collections/retention_collection_form/"); ?>">Retention Collection</a></li>
                             <!--<li><a onclick="javascript: void(0)" href="<?php //echo $this->Html->url("/progressive_payments/add/"); ?>">Progressive Payment</a></li>-->
                            <?php endif;?>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action']== "collections_index") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/collections/"); ?>">Collection List</a></li>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action']== "collection_details_index") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/collection_details/ "); ?>">Cheque/Payment Received List</a></li>
                        </ul>
                    </li>
                    <?php endif;?>
                    <?php $gp=array('Admin','SM','SMA');
                           if(in_array($UserGroup, $gp)): ?>
                    <li <?php $controllers = array('contract_products'); echo (in_array($this->params['controller'], $controllers)) ? "class='active'" : ""?>><a><i class="fa fa-product-hunt"></i> Contract's Product <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" <?php echo (in_array($this->params['controller'], $controllers)) ? "style=display:block;" : ''; ?>>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action'] == "contract_products_add") ? "class='current-page'" : "" ?>><a href="javascript:void(0)<?php //echo $this->Html->url("/contract_products/add/");       ?>">Contract Product add</a></li> 
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action'] == "contract_import_contract_product_by_csv") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/contract_products/import_contract_product_by_csv/"); ?>">Import Contract Product-CSV</a></li>
                            <li <?php echo ($this->params['controller'] . '_' . $this->params['action'] == "contract_products_index") ? "class='current-page'" : "" ?>><a href="<?php echo $this->Html->url("/contract_products/"); ?>">Contract Product List</a></li>
                        </ul>
                    </li>
                    <?php endif;?>
                   <?php $gp=array('Admin','Finance','SM','Operations','SMA','OA');
                    if(in_array($UserGroup, $gp)): ?>
                    <li><a><i class="fa fa-table"></i> Report <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                         <li><a href="<?php echo $this->Html->url("/reports/invoice_planned_date_delivery_wise_with_collection/"); ?>">Invoice Planned Date Delivery wise With Collections</a></li>
                         <li><a href="<?php echo $this->Html->url("/reports/cheque_payment_received_report/"); ?>">Cheque/Payment Received Report</a></li>
						 <li><a href="<?php echo $this->Html->url("/reports/finance_invoice_planned_date_delivery_wise_with_collection/"); ?>">Planned Date wise Report Balance Carry option(Finance)</a></li>
                         <?php $gp=array('Admin','Finance','SM','SMA');
                           if(in_array($UserGroup, $gp)): ?>
                            <li><a href="<?php echo $this->Html->url("/reports/invoice_planned_date_delivery_wise/"); ?>">Invoice Planned Date Delivery wise</a></li>
                            
                            <li><a href="<?php echo $this->Html->url("/reports/credit_report/"); ?>">Credit Report</a></li>
                            <li><a href="<?php echo $this->Html->url("/reports/collection_report_details/"); ?>">Collect Report Details</a></li>
                            <li><a href="<?php echo $this->Html->url("/reports/collection_report_summary/"); ?>">Collect Report Summary</a></li>
                            <li><a href="<?php echo $this->Html->url("/reports/progressive_payment_product_report/"); ?>">Progressive Payment Product Report</a></li>
                            <?php endif;?>
                            <li><a href="<?php echo $this->Html->url("/reports/production_report/"); ?>">Production Report</a></li>
                            <li><a href="<?php echo $this->Html->url("/reports/delivery_report/"); ?>">Delivery Report</a></li>
                            <li><a href="<?php echo $this->Html->url("/reports/lot_report/"); ?>">Lot Report</a></li>
                            <li><a href="<?php echo $this->Html->url("/reports/procurement_report/"); ?>">Procurement Report</a></li>
                            <li><a href="<?php echo $this->Html->url("/reports/psi_report/"); ?>">PSI Report</a></li>
                            <li><a href="<?php echo $this->Html->url("/reports/pli_report/"); ?>">PLI Report</a></li>
                            <li><a href="<?php echo $this->Html->url("/reports/po_product_summary_report/"); ?>">PO. Product Summary Report</a></li>
                            <li><a href="<?php echo $this->Html->url("/reports/yearly_plan_with_work_in_hand/"); ?>">Category Wise PO/Product Report</a></li>
                            <li><a href="<?php echo $this->Html->url("/reports/work_in_progress_summary_report/"); ?>">Work in Progress Summary report</a></li>
                            <li><a href="<?php echo $this->Html->url("/reports/po_product_status/"); ?>">PO. Product Summary</a></li>
                        </ul>
                    </li> 
                    <?php endif;?>                     
                   <?php $gp=array('Admin','Finance','SM','Operations','SMA','OA');
                    if(in_array($UserGroup, $gp)): ?>
                    <li><a><i class="fa fa-outdent"></i> Transformer Direct Sale <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">                                               
                            <li><a href="<?php echo $this->Html->url("/order_items/add/"); ?>">Delivery Order Entry</a></li>
                            <li><a href="<?php echo $this->Html->url("/orders/"); ?>">Delivery Order Report</a></li>
                            <li><a href="<?php echo $this->Html->url("/payment_histories/add/"); ?>">Payment Entry</a></li>
                            <li><a href="<?php echo $this->Html->url("/payment_histories/payment_receive_history/"); ?>">Payment Received Report</a></li>
                            <li><a href="<?php echo $this->Html->url("/payment_histories /"); ?>">Payment Entry List</a></li>
                            <li><a href="<?php echo $this->Html->url("/client_balances /"); ?>">Client Balance List</a></li>
                            <li><a href="<?php echo $this->Html->url("/order_payments/"); ?>">Order Payment Report</a></li>
                            <li><a href="<?php echo $this->Html->url("/order_items/"); ?>">Delivery Order Item Report</a></li>
                        </ul>
                    </li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>