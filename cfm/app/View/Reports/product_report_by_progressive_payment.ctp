<div class="x_panel">
    <!-- contract added product list -->     
    <div class="x_content">            
        <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>S/N:</th>
                    <th>Contract/PO.No</th>
                    <th>Lot No.</th>
                    <th>Category</th>
                    <th>Product</th>                    
                    <th>Invoice Quantity</th>
                    <th>Unit Weight</th>
                    <th>Total Weight</th>
                    <th>Unit Price</th>
                    <th>Delivery value</th>                                        
                </tr>
            </thead>
            <tbody>
                <?php
                $sl = 1;                 
                foreach ($productions as $production):
                    ?>
                    <tr>
                        <td><?php echo $sl++; ?> </td>
                        <td><?php echo h($production['Contract']['contract_no']); ?> </td>
                        <td><?php echo h($production['ProgressivePayment']['lot_id']); ?> </td>
                        <td><?php echo h($production['ProductCategory']['name']); ?> </td>
                        <td><?php echo h($production['Product']['name']); ?> </td>                        
                        <td><?php echo $quantity=h($production['ProgressivePayment']['quantity']); ?>&nbsp;<?php echo h($production['ProgressivePayment']['uom']); ?></td>
                        <td><?php echo h($production['ProgressivePayment']['unit_weight'] != 'N/A'&&$production['ProgressivePayment']['unit_weight_uom'] != 'N/A') ? h($production['ProgressivePayment']['unit_weight']).' '.$production['ProgressivePayment']['unit_weight_uom']: 'N/A'; ?>&nbsp;</td>
                        <td><?php echo h($production['ProgressivePayment']['unit_weight'] != 'N/A'&&$production['ProgressivePayment']['unit_weight_uom'] != 'N/A') ? h($production['ProgressivePayment']['unit_weight'] * $production['ProgressivePayment']['quantity']).' '.$production['ProgressivePayment']['unit_weight_uom']: 'N/A'; ?>&nbsp;</td>
                        <td><?php echo $unit_price=$production['ProgressivePayment']['unit_price']; ?> </td>
                        <td><?php echo $production['ProgressivePayment']['quantity'] * $production['ProgressivePayment']['unit_price']; ?>&nbsp;<?php echo $production['ProgressivePayment']['currency']; ?> </td>
                     </tr>
                <?php endforeach; ?>
            </tbody>
        </table>     
    </div>
<div class="clearfix"></div>
</div>