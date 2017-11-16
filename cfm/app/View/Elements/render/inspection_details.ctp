<?php if ($inspections): ?>
            <table   class="table table-striped table-bordered table_scrol">
                <thead>
                    <tr>
                        <th>S/N:</th>
                        <th>Lot No.</th>
                        <th>Product</th>                    
                        <th>Delivery Quantity</th>                       
                        <th>Unit Weight</th>
                        <th>Weight</th>
                         <th>Planned Inspection Date</th>
                        <th>Actual Inspection Date</th>
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
                    foreach ($inspections as $inspection): ?>
                        <tr>
                            <td><?php echo $sl++; ?> </td>
                            <td><?php echo $inspection['Inspection']['lot_id']; ?> </td>
                            <td><?php echo $inspection['Product']['name']; ?> </td>
                            <td><?php echo h($inspection['Inspection']['quantity']); ?>&nbsp;<?php echo h($inspection['Inspection']['uom']); ?></td>
                            <td><?php echo ($inspection['Inspection']['unit_weight'] != 'N/A'&&$inspection['Inspection']['unit_weight_uom'] != 'N/A') ? h($inspection['Inspection']['unit_weight']) . ' ' . $inspection['Inspection']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td><?php echo ($inspection['Inspection']['unit_weight'] != 'N/A'&&$inspection['Inspection']['unit_weight_uom'] != 'N/A') ? h($inspection['Inspection']['unit_weight'] * $inspection['Inspection']['quantity']) . ' ' . $inspection['Inspection']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td><?php echo $inspection['Inspection']['planned_inspection_date']; ?> </td> 
                            <td><?php echo $inspection['Inspection']['actual_inspection_date']; ?> </td> 
                            <td><?php echo $inspection['Inspection']['remarks']; ?> </td>
                            <td><?php echo $inspection['Inspection']['added_date']; ?> </td> 
                            <td><?php echo $inspection['Inspection']['added_by']; ?> </td> 
                            <td><?php echo ($inspection['Inspection']['modified_date']!="0000-00-00")?$inspection['Inspection']['modified_date']:"N/A"; ?> </td> 
                            <td><?php echo $inspection['Inspection']['modified_by']; ?> </td> 
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
 