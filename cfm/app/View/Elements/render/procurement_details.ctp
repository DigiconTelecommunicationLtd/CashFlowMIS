<?php if ($procurements): ?>
            <table  class="table table-striped table-bordered table_scrol">
                <thead>
                    <tr>
                        <th>S/A:</th>
                        <th>Lot No.</th>
                        <th>Product</th>                    
                        <th>Quantity</th>
                        <th>Unit Weight</th>
                        <th>Weight</th>
                        <th>Planned Arrival Date</th>
                        <th>Actual Arrival Date</th>
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
                    foreach ($procurements as $procurement): ?>
                        <tr>
                            <td> <?php echo $sl++; ?> </td>
                            <td> <?php echo $procurement['Procurement']['lot_id']; ?> </td>
                            <td> <?php echo $procurement['Product']['name']; ?> </td>
                            <td><?php echo h($procurement['Procurement']['quantity']); ?>&nbsp;<?php echo h($procurement['Procurement']['uom']); ?></td>
                            <td><?php echo ($procurement['Procurement']['unit_weight'] != 'N/A'&&$procurement['Procurement']['unit_weight_uom'] != 'N/A') ? h($procurement['Procurement']['unit_weight']) . ' ' . $procurement['Procurement']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td><?php echo ($procurement['Procurement']['unit_weight'] != 'N/A'&&$procurement['Procurement']['unit_weight_uom'] != 'N/A') ? h($procurement['Procurement']['unit_weight'] * $procurement['Procurement']['quantity']) . ' ' . $procurement['Procurement']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td><?php echo ($procurement['Procurement']['planned_arrival_date']!="0000-00-00")?$procurement['Procurement']['planned_arrival_date']:"N/A"; ?> </td> 
                            <td><?php echo ($procurement['Procurement']['actual_arrival_date']!="0000-00-00")?$procurement['Procurement']['actual_arrival_date']:"N/A"; ?> </td> 
                            <td><?php echo $procurement['Procurement']['remarks']; ?> </td> 
                            <td><?php echo $procurement['Procurement']['added_date']; ?> </td>
                            <td><?php echo $procurement['Procurement']['added_by']; ?> </td>
                            <td><?php echo ($procurement['Procurement']['modified_date']!="0000-00-00 00:00:00")?$procurement['Procurement']['modified_date']:"N/A"; ?> </td>
                            <td><?php echo $procurement['Procurement']['modified_by']; ?> </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>