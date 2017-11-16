<div class="x_panel"> 
    <?php if ($this->Session->check('Message.flash')): ?> 
    <div class="x_title">       
            <div role="alert" class="alert alert-success alert-dismissible fade in">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                </button>
                <strong><?php echo $this->Session->flash(); ?></strong>
            </div>        
        <div class="clearfix"></div>
    </div>
    <?php endif; ?>
    <div  class="col-md-12 col-sm-12 col-xs-12" id="lotProductUpdate">
            <?php if ($lotProducts): ?>
                <table  class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL.NO:</th>
                            <!--<th>PO.No</th>-->
                            <th>Lot No.</th>
                            <th>Category</th>
                            <th>Product</th>                    
                            <th>PO. Qty</th>
                            <th>Lot Qty</th>
			      <th>UOM</th>
                            <!--<th>Balance Qty</th>-->
                            <th>Unit Weight</th>
                            <th>Lot Weight</th>
			    <th>Weight(UOM)</th>
                            <th>Remarks</th>
                            <th>Added By</th>
                            <th>Added Date</th>
                            <!--<th>Action</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sl=1;
                        $lot_id='';
                        foreach ($lotProducts as $lotProduct):?>
                            <tr>
                                <td> <?php echo $sl++; ?> </td>
                                <!--<td> <?php //echo $lotProduct['Contract']['contract_no']; ?> </td>-->
                                <td> <?php echo $lotProduct['LotProduct']['lot_id']; ?> </td>
                                <td> <?php echo $lotProduct['Product']['name']; ?> </td>
                                <td> <?php echo $lotProduct['ProductCategory']['name']; ?> </td>
                                <td><?php echo h($lotProduct['LotProduct']['contract_quantity']); ?>&nbsp;</td>
                                <td><?php echo h($lotProduct['LotProduct']['quantity']); ?>&nbsp;</td>
				<td><?php echo h($lotProduct['LotProduct']['uom']); ?>&nbsp;</td>
                                <!--<td><?php //echo h($lotProduct['LotProduct']['reaming_quantity']); ?>&nbsp;<?php //echo h($lotProduct['LotProduct']['uom']); ?></td>-->
                                <td><?php echo h($lotProduct['LotProduct']['unit_weight']!='N/A')?h($lotProduct['LotProduct']['unit_weight']):'N/A'; ?>&nbsp;</td>
                                <td><?php echo ($lotProduct['LotProduct']['unit_weight'] != 'N/A') ? h($lotProduct['LotProduct']['unit_weight'] * $lotProduct['LotProduct']['quantity']): 'N/A'; ?>&nbsp;</td>
				<td><?php echo h($lotProduct['LotProduct']['unit_weight_uom']); ?>&nbsp;</td>
                                <td> <?php echo $lotProduct['LotProduct']['remarks']; ?> </td> 
                                 <td> <?php echo $lotProduct['LotProduct']['added_by']; ?> </td> 
                                <td> <?php echo $lotProduct['LotProduct']['added_date']; ?> </td> 
								
                                <!-- <td class="actions">
                                  <?php //if(substr($lotProduct['LotProduct']['added_date'],0,10)==date('Y-m-d')):?>
                                    <button onclick="delete_lot_product('<?php //echo $lotProduct['LotProduct']['id']; ?>', '<?php //echo $lotProduct['LotProduct']['contract_id']; ?>');"><i class="fa fa-remove"></i></button>
                                    <?php //endif;?>
                                </td>-->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
</div> 
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('fast');
        }, 1500); // <-- time in milliseconds
    });
</script>
