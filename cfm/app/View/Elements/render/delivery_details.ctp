 <?php if ($deliverys): ?>
            <table  class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>S/N:</th>
                        <th>Lot No.</th>
                        <th>Product</th>                    
                        <th>Quantity</th>
                        <th>Unit Weight</th>
                        <th>Weight</th>
                        <th>Planned Delivery Date</th>
                        <th>Actual Delivery Date</th>
                        <th>Remarks</th>
                        <th>Added Date</th>
                        <th>Added By</th>
                        <th>Modified Date</th>
                        <th>Modified By</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sl=1;
                    foreach ($deliverys as $delivery): ?>
                        <tr>
                            <td><?php echo $sl++; ?> </td>
                            <td><?php echo $delivery['Delivery']['lot_id']; ?> </td>
                            <td><?php echo $delivery['Product']['name']; ?> </td>
                            <td><?php echo h($delivery['Delivery']['quantity']); ?>&nbsp;<?php echo h($delivery['Delivery']['uom']); ?></td>
                            <td><?php echo ($delivery['Delivery']['unit_weight'] != 'N/A'&&$delivery['Delivery']['unit_weight_uom'] != 'N/A') ? h($delivery['Delivery']['unit_weight']) . ' ' . $delivery['Delivery']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td><?php echo ($delivery['Delivery']['unit_weight'] != 'N/A'&&$delivery['Delivery']['unit_weight_uom'] != 'N/A') ? h($delivery['Delivery']['unit_weight'] * $delivery['Delivery']['quantity']) . ' ' . $delivery['Delivery']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td><?php echo ($delivery['Delivery']['planned_delivery_date']!="0000-00-00")?$delivery['Delivery']['planned_delivery_date']:'N/A'; ?> </td> 
                            <td><?php echo ($delivery['Delivery']['actual_delivery_date']!="0000-00-00")?$delivery['Delivery']['actual_delivery_date']:"N/A"; ?> </td>
                            <td><?php echo $delivery['Delivery']['remarks']; ?> </td>
                            <td><?php echo $delivery['Delivery']['added_date']; ?> </td>
                            <td><?php echo $delivery['Delivery']['added_by']; ?> </td>
                            <td><?php echo ($delivery['Delivery']['modified_date']!="0000-00-00 00:00:00")?$delivery['Delivery']['modified_date']:"N/A"; ?> </td>
                            <td><?php echo $delivery['Delivery']['modified_by']; ?> </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>