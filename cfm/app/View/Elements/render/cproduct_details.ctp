<table  class="table table-striped table-bordered" style="display: block;overflow-x: auto;">
    <thead>
        <tr>
            <th>S/N:</th>
            <th>Category</th>
            <th>Product</th>                    
            <th>Quantity</th>                   
            <th>Unit Price</th>
            <th>Unit Weight</th>
            <th>Weight</th>
            <th>Amount</th> 
            <th>Added Date</th>
            <th>Added By</th>                    
            <th>Modified Date</th>                   
            <th>Modified By</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sl=1;
        foreach ($cproducts as $product): ?>
            <tr>
                <td><?php echo $sl++; ?> </td>
                <td><?php echo $product['ProductCategory']['name']; ?> </td>
                <td> <?php echo $product['Product']['name']; ?> </td>
                <td><?php echo h($product['ContractProduct']['quantity']); ?>&nbsp;<?php echo h($product['ContractProduct']['uom']); ?></td>
                <td><?php echo h($product['ContractProduct']['unit_price']); ?>&nbsp;<?php echo h($product['ContractProduct']['currency']); ?>&nbsp;</td>
                <td><?php echo ($product['ContractProduct']['unit_weight'] != 'N/A'&&$product['ContractProduct']['unit_weight_uom'] != 'N/A') ? h($product['ContractProduct']['unit_weight']) . ' ' . $product['ContractProduct']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                <td><?php echo ($product['ContractProduct']['unit_weight'] != 'N/A'&&$product['ContractProduct']['unit_weight_uom'] != 'N/A') ? h($product['ContractProduct']['unit_weight'] * $product['ContractProduct']['quantity']) . ' ' . $product['ContractProduct']['unit_weight_uom'] : 'N/A'; ?>&nbsp;</td>
                <td><?php echo h($product['ContractProduct']['unit_price'] * $product['ContractProduct']['quantity']); ?>&nbsp;<?php echo h($product['ContractProduct']['currency']); ?></td>
                <td><?php echo h($product['ContractProduct']['added_date']); ?>&nbsp;</td>
                <td><?php echo h($product['ContractProduct']['added_by']); ?>&nbsp;</td>
                <td><?php echo h($product['ContractProduct']['modified_date'] != "0000-00-00 00:00:00") ? $product['ContractProduct']['modified_date'] : 'N/A'; ?>&nbsp;</td>
                <td><?php echo h($product['ContractProduct']['modified_by']); ?>&nbsp;</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>