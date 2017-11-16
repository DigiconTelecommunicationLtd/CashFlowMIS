<div class="x_panel"> 
    <div class="x_content">
        <?php if ($lotProducts): ?>
            <table id='datatable-buttons'  class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Contract/PO.No</th>
                        <th>Lot No.</th>
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
                            <td><?php echo h($lotProduct['LotProduct']['unit_weight']); ?>&nbsp;</td>
                            <td><?php echo ($lotProduct['LotProduct']['unit_weight'] != 'N/A') ? h($lotProduct['LotProduct']['unit_weight'] * $lotProduct['LotProduct']['quantity']) . ' ' . $lotProduct['LotProduct']['uom'] : 'N/A'; ?>&nbsp;</td>
                            <td> <?php echo $lotProduct['LotProduct']['remarks']; ?> </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div> 
