<?php if ($contractProducts): ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Contract/PO No</th>
                    <th>Product/Category</th>
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
                <?php foreach ($contractProducts as $contractProduct): ?>
                    <tr>
                        <td><?php echo h($contractProduct['Contract']['contract_no']); ?>&nbsp;</td>
                        <td> <?php echo $contractProduct['ProductCategory']['name']; ?> </td>
                        <td> <?php echo $contractProduct['Product']['name']; ?> </td>
                        <td><?php echo h($contractProduct['ContractProduct']['quantity']); ?>&nbsp;<?php echo h($contractProduct['ContractProduct']['uom']); ?></td>

                        <td><?php echo h($contractProduct['ContractProduct']['unit_price']); ?>&nbsp;<?php echo h($contractProduct['ContractProduct']['currency']); ?>&nbsp;</td>

                        <td><?php echo h($contractProduct['ContractProduct']['unit_weight']); ?>&nbsp;</td>
                        <td><?php echo h($contractProduct['ContractProduct']['unit_weight'] * $contractProduct['ContractProduct']['quantity']); ?>&nbsp;<?php echo h($contractProduct['ContractProduct']['uom']); ?></td>
                        <td><?php echo h($contractProduct['ContractProduct']['unit_price'] * $contractProduct['ContractProduct']['quantity']); ?>&nbsp;<?php echo h($contractProduct['ContractProduct']['currency']); ?></td>
                        <td><?php echo h($contractProduct['ContractProduct']['added_date']); ?>&nbsp;</td>
                        <td><?php echo h($contractProduct['ContractProduct']['added_by']); ?>&nbsp;</td>
                        <td><?php echo ($contractProduct['ContractProduct']['modified_date'] != '0000-00-00 00:00:00') ? h($contractProduct['ContractProduct']['modified_date']) : 'N/A'; ?>&nbsp;</td>
                        <td><?php echo h($contractProduct['ContractProduct']['modified_by']); ?>&nbsp;</td>
                    </tr>
                <?php endforeach; ?>                     
            </tbody>
        </table>
    <?php endif; ?>
 <?php echo $this->Html->script('common-table'); ?>