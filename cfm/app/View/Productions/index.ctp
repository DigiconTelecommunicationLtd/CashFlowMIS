<div class="x_panel"> 
    <div class="x_content">
        <?php if ($lotProducts): ?>
            <table id='datatable-buttons'  class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>PO. NO:</th>
                        <th>Lot NO:</th>
                        <th>Product</th>                    
                        <th>Quantity</th>
                        <th>Unit Weight</th>
                        <th>Weight</th>
                        <th>Remarks</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lotProducts as $lotProduct): ?>
                        <tr>

                            <td> <?php echo $lotProduct['Contract']['contract_no']; ?> </td>
                            <td> <?php echo $lotProduct['LotProduct']['lot_id']; ?> </td>
                            <td> <?php echo $lotProduct['Product']['name']; ?> </td>
                            <td><?php echo h($lotProduct['LotProduct']['quantity']); ?>&nbsp;<?php echo h($lotProduct['LotProduct']['uom']); ?></td>
                            <td><?php echo ($lotProduct['LotProduct']['unit_weight'] != 'N/A'&&$lotProduct['LotProduct']['unit_weight_uom'] != 'N/A') ? h($lotProduct['LotProduct']['unit_weight']) . ' ' . $lotProduct['LotProduct']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td><?php echo ($lotProduct['LotProduct']['unit_weight'] != 'N/A'&&$lotProduct['LotProduct']['unit_weight_uom'] != 'N/A') ? h($lotProduct['LotProduct']['unit_weight'] * $lotProduct['LotProduct']['quantity']) . ' ' . $lotProduct['LotProduct']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td><?php echo $lotProduct['LotProduct']['remarks']; ?> </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div> 
