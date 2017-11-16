<table  class="table table-striped table-bordered">
    <thead>
        <tr>
             <th>S/N:</th>
            <th>Lot No.</th>
            <th>Product</th>                    
            <th>Quantity</th>
            <th>Unit Weight</th>
            <th>Weight</th>            
            <th>Added Date</th>
            <th>Added By</th>                    
            <th>Modified Date</th>                   
            <th>Modified By</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sl=1;
        foreach ($lotProducts as $lotProduct): ?>
            <tr>
                <td> <?php echo $sl++; ?> </td>
                <td> <?php echo $lotProduct['LotProduct']['lot_id']; ?> </td>
                <td> <?php echo $lotProduct['Product']['name']; ?> </td>
                <td><?php echo h($lotProduct['LotProduct']['quantity']); ?>&nbsp;<?php echo h($lotProduct['LotProduct']['uom']); ?></td>
                <td><?php echo ($lotProduct['LotProduct']['unit_weight'] != 'N/A'&&$lotProduct['LotProduct']['unit_weight_uom'] != 'N/A') ? h($lotProduct['LotProduct']['unit_weight']) . ' ' . $lotProduct['LotProduct']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                <td><?php echo ($lotProduct['LotProduct']['unit_weight'] != 'N/A'&&$lotProduct['LotProduct']['unit_weight_uom'] != 'N/A') ? h($lotProduct['LotProduct']['unit_weight'] * $lotProduct['LotProduct']['quantity']) . ' ' . $lotProduct['LotProduct']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                 <td><?php echo h($lotProduct['LotProduct']['added_date']); ?>&nbsp;</td>
                <td><?php echo h($lotProduct['LotProduct']['added_by']); ?>&nbsp;</td>
                <td><?php echo h($lotProduct['LotProduct']['modified_date'] != "0000-00-00 00:00:00") ? $lotProduct['LotProduct']['modified_date'] : 'N/A'; ?>&nbsp;</td>
                <td><?php echo h($lotProduct['LotProduct']['modified_by']); ?>&nbsp;</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
