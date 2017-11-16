<div class="x_panel">
    <div class="x_content">     
        <?php echo $this->Form->create('Report', array('controller' => 'reports', 'action' => 'credit_report/ ', 'class' => 'form-horizontal form-label-left', 'id' => 'Report', 'onsubmit' => "return validate();")); ?>
        <div class="form-group"> 
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>PO. NO:</label>
                <?php echo $this->Form->input("contract_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'tabindex' => -1, 'empty' => '', 'required' => false)) ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Date From</label>
                <?php echo $this->Form->input("date_from", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_from', 'required' => false)) ?>                

            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label>Date To</label>
                <?php echo $this->Form->input("date_to", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'date_to', 'required' => false)) ?>                

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
        <!--<div class="ln_solid"></div>-->
        <?php //echo $this->element('sql_dump');  ?>
    </div>

    <div class="x_content">    
        <table class="table table-striped table-bordered">
            <thead>
                <tr>            
                    <th>PO. NO:</th>
                    <th>Client</th>            
                    <th>PO. Value</th>
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
                    <th>Credit</th>           
                </tr>
            </thead>
            <tbody>
                <?php
                if ($po):
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
                    foreach ($po as $value)://echo '<pre>';print_r($data);exit; 
                        ?>
                        <tr>
                            <td><?php echo h($value['Contract']['contract_no']); ?>&nbsp;</td>
                            <td><?php echo h($value['Client']['name']); ?>&nbsp;</td>
                            <td align="right"><?php
                                $po_vlue = ($currency == "BDT") ? $value['Contract']['contract_value_bdt'] : $value['Contract']['contract_value_usd'];
                                echo $this->Number->currency($po_vlue, $options);
                                ?> </td>
                            <td align="right"><?php
                            $delivery=$data['Delivery'][$value['Contract']['id']]=($data['Delivery'][$value['Contract']['id']])?$data['Delivery'][$value['Contract']['id']]:0;
                            echo $this->Number->currency($delivery, $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['Advance']['Collection']['amount_received'][$value['Contract']['id']], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['Progressive']['Collection']['amount_received'][$value['Contract']['id']], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['Retention(1st)']['Collection']['amount_received'][$value['Contract']['id']], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['Retention(2nd)']['Collection']['amount_received'][$value['Contract']['id']], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['ait']['Collection']['ait'][$value['Contract']['id']], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['vat']['Collection']['vat'][$value['Contract']['id']], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['ld']['Collection']['ld'][$value['Contract']['id']], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['other_deduction']['Collection']['other_deduction'][$value['Contract']['id']], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['ajust_adv_amount']['Collection']['ajust_adv_amount'][$value['Contract']['id']], $options); ?></td>
                            <td align="right"><?php echo $this->Number->currency($data['total_collection'][$value['Contract']['id']], $options); ?></td>
                            <?php 
                             $adv_receiveable=($po_vlue * $value['Contract']['billing_percent_adv']) / 100; 
                             $delivery=$data['Delivery'][$value['Contract']['id']]=($data['Delivery'][$value['Contract']['id']])?$data['Delivery'][$value['Contract']['id']]:1;
                             $Advance_adjust=(($data['Advance']['Collection']['amount_received'][$value['Contract']['id']]/$po_vlue)*100);
                             if($delivery!=1):
                                 $dilivery_value=($delivery * (100-$value['Contract']['billing_percent_adv'])) / 100; 
                             else:
                              $dilivery_value=0;
                              endif;
                            ?>
                            <td align="right"><?php echo $this->Number->currency(($data['Advance']['Collection']['amount_received'][$value['Contract']['id']] +$dilivery_value ) -($Advance_adjust+$data['total_collection_for_credit'][$value['Contract']['id']]), $options); ?></td>
                        </tr>
                        <?php
                    endforeach;
                else:
                    ?>
                    <tr>
                        <td align="center" colspan="14">There is no records found</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

