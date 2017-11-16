<?php if ($productions): ?>
            <table  class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>S/N:</th>
                        <th>Lot No.</th>
                        <th>Product</th>                    
                        <th>Quantity</th>
                        <th>Unit Weight</th>
                        <th>Weight</th>
                         <th>Planned Completion Date</th>
                        <th>Actual Completion Date</th>
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
                    foreach ($productions as $production): ?>
                        <tr>
                            <td> <?php echo $sl++; ?> </td>
                            <td> <?php echo $production['Production']['lot_id']; ?> </td>
                            <td> <?php echo $production['Product']['name']; ?> </td>
                            <td><?php echo h($production['Production']['quantity']); ?>&nbsp;<?php echo h($production['Production']['uom']); ?></td>
                            <td><?php echo ($production['Production']['unit_weight'] != 'N/A'&&$production['Production']['unit_weight_uom'] != 'N/A') ? h($production['Production']['unit_weight'] * $production['Production']['quantity']) . ' ' . $production['Production']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td><?php echo ($production['Production']['unit_weight'] != 'N/A'&&$production['Production']['unit_weight_uom'] != 'N/A') ? h($production['Production']['unit_weight'] * $production['Production']['quantity']) . ' ' . $production['Production']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                            <td> <?php echo ($production['Production']['planned_completion_date']!="0000-00-00")?$production['Production']['planned_completion_date']:"N/A"; ?> </td> 
                            <td> <?php echo ($production['Production']['actual_completion_date']!="0000-00-00")?$production['Production']['actual_completion_date']:"N/A"; ?> </td> 
                            <td> <?php echo $production['Production']['remarks']; ?> </td>
                            <td> <?php echo $production['Production']['added_date']; ?> </td>
                            <td> <?php echo $production['Production']['added_by']; ?> </td>
                            <td> <?php echo ($production['Production']['modified_date']!="0000-00-00 00:00:00")?$production['Production']['modified_date']:"N/A"; ?> </td>
                            <td> <?php echo $production['Production']['modified_by']; ?> </td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>