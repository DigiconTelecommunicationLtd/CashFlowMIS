<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-bars"></i> Contract <small>Details View</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">


            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Contract Products</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Payment Collections</a>
                    </li>                   
                    <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab1" data-toggle="tab" aria-expanded="false">Lot Products</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Procurements</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Productions</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content6" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Inspections</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content7" role="tab" id="profile-tab5" data-toggle="tab" aria-expanded="false">Deliveries</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        <?php echo $this->element('render/cproduct_details'); ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        <?php echo $this->element('render/advance_collection'); ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                        <?php echo $this->element('render/lot_products'); ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                        <?php echo $this->element('render/procurement_details'); ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">
                        <?php echo $this->element('render/production_details'); ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="profile-tab">
                        <?php echo $this->element('render/inspection_details'); ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content7" aria-labelledby="profile-tab">
                        <?php echo $this->element('render/delivery_details'); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>