<div class="x_panel">
    <div class="x_content">     
        <?php echo $this->Form->create('Report', array('controller' => 'reports', 'action' => 'credit_report/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'Report')); ?>
        <div class="form-group">  
           <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Contract/PO.No:</label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                <label>Unit</label>
                <?php echo $this->Form->input("unit_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'unit_id', 'required' => false)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                <label>Client</label>
                <?php echo $this->Form->input("client_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'client_id', 'required' => false)) ?> 
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Category</label>
                <?php echo $this->Form->input("product_category_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'product_category_id', 'required' => false,'options'=>$product_categories)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Date From</label>
                <?php echo $this->Form->input("date_from", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_from', 'readOnly' => true)) ?>                
             </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Date To</label>
                <?php echo $this->Form->input("date_to", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_to', 'readOnly' => true)) ?>                
             </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <label>Currency</label> 
                <?php echo $this->Form->input("currency", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'id' => 'currency', 'required' => false)) ?>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-12 form-group">
                <label>&nbsp;</label>
                <?php echo $this->Form->submit('Search', array('class' => 'btn btn-success', 'id' => 'ReportSubmit')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>

    <div class="x_content">    
        <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
                <tr>                    
                    <th>PO. NO:</th>
                    <th>Unit</th> 
                    <th>Client</th>
                    <th>Category</th>
                    <th>Delivery Value</th>
                    <th>Received Advance</th>
                    <th>Received Progressive</th>
                    <th>Received 1st Retention</th>
                    <th>Received 2nd Retention</th>
                    <th>AIT</th>
                    <th>VAT</th>
                    <th>L.D</th>
                    <th>Other Deduction</th>
                    <th>Adv. Adjusted</th>
                    <th>Total Collection</th>
                    <th>Credit/AR</th> 
                    <th>Currency</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($con_category)):
                    $options = array(
                        'wholeSymbol' => '',
                        'wholePosition' => 'before',
                        'fractionSymbol' => false,
                        'fractionPosition' => 'after',
                        'zero' => 0,
                        'places' => 2,
                        'thousands' => ',',
                        'decimals' => '.',
                        'negative' => '()',
                        'escape' => true,
                        'fractionExponent' => 2
                    );
                    foreach ($con_category as $key_con_category=>$contract_id):
                        ?>
                        <tr>
                            <td><?php echo h($po['contract_no'][$contract_id]); ?></td>
                            <td><?php echo h($po['Unit'][$contract_id]); ?></td>
                            <td><?php echo h($po['Client'][$contract_id]); ?></td>
                           <!-- <td align="right"><?php
                                $po_vlue = ($currency == "BDT") ? $value['Contract']['contract_value_bdt'] : $value['Contract']['contract_value_usd'];
                                //echo $this->Number->currency($po_vlue, $options);
                                ?> </td>-->
                            <td><?php
                            $ck_currency=  explode('-', $key_con_category);
                            echo h($product_categories[$category[$ck_currency[0]]]); ?></td>    
                            <td align="right"><?php
                            $delivery=$data['Delivery'][$key_con_category]=($data['Delivery'][$key_con_category])?$data['Delivery'][$key_con_category]:0;
                            echo $this->Number->currency($delivery, $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['Advance']['Collection']['amount_received'][$key_con_category], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['Progressive']['Collection']['amount_received'][$key_con_category], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['Retention(1st)']['Collection']['amount_received'][$key_con_category], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['Retention(2nd)']['Collection']['amount_received'][$key_con_category], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['ait']['Collection']['ait'][$key_con_category], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['vat']['Collection']['vat'][$key_con_category], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['ld']['Collection']['ld'][$key_con_category], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['other_deduction']['Collection']['other_deduction'][$key_con_category], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['ajust_adv_amount']['Collection']['ajust_adv_amount'][$key_con_category], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['total_collection'][$key_con_category], $options); ?></td>
                            <?php 
                             //$adv_receiveable=($po_vlue * $value['Contract']['billing_percent_adv']) / 100; 
                             //$delivery=$data['Delivery'][$key_con_category]=($data['Delivery'][$key_con_category])?$data['Delivery'][$key_con_category]:1;
                             //$Advance_adjust=(($data['Advance']['Collection']['amount_received'][$key_con_category]/$po_vlue)*100);
                             //if($delivery!=1):
                                // $dilivery_value=$delivery; 
                            // else:
                              //$dilivery_value=0;
                              //endif;
                            ?>
                            <td align="right">
                           <?php 
                            if($delivery!=0):
                            echo $this->Number->currency(($delivery+$data['Advance']['Collection']['amount_received'][$key_con_category]) -(($data['Advance']['Collection']['amount_received'][$key_con_category] *$delivery)/$data['contract_product_value'][$key_con_category]+$data['total_collection_for_credit'][$key_con_category]), $options); 
                            else:
                             echo $this->Number->currency(($data['Advance']['Collection']['amount_received'][$key_con_category]), $options);    
                            endif;
                            ?>
                            </td>
                            <td align="right"><?php 
                         
                            echo $ck_currency[1]; ?></td>
                        </tr>
                        <?php  endforeach;   endif; ?>

            </tbody>
        </table>
    </div>
</div>

