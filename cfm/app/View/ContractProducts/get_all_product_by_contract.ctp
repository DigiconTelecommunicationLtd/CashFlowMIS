<!-- modals -->
<!-- Large modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Show Products</button>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Contract's Products:</h4>
            </div>
            <div class="modal-body">
               <?php if($contractProducts): ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>PO. NO:</th>
                    <th>Product/Category</th>
                    <th>Product Size</th>                    
                    <th>Quantity</th>
                    <th>Unit Weight</th>
                    <th>Total Weight</th>                  
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contractProducts as $contractProduct): ?>
                    <tr>
                        <td><?php echo h($contractProduct['Contract']['contract_no']); ?>&nbsp;</td>
                        <td><?php echo $contractProduct['ProductCategory']['name']; ?> </td>
                        <td><?php echo $contractProduct['Product']['name']; ?> </td>
                        <td><?php echo h($contractProduct['ContractProduct']['quantity']); ?>&nbsp;<?php echo h($contractProduct['ContractProduct']['uom']); ?></td>                       
                        <td><?php echo h($contractProduct['ContractProduct']['unit_weight']!="N/A"&&$contractProduct['ContractProduct']['unit_weight_uom']!="N/A")?$contractProduct['ContractProduct']['unit_weight'].' '.$contractProduct['ContractProduct']['unit_weight_uom']:"N/A"; ?>&nbsp;</td>
                        <td><?php echo h($contractProduct['ContractProduct']['unit_weight']!="N/A"&&$contractProduct['ContractProduct']['unit_weight_uom']!="N/A")?h($contractProduct['ContractProduct']['unit_weight'] * $contractProduct['ContractProduct']['quantity']).' '.$contractProduct['ContractProduct']['unit_weight_uom']:"N/A"; ?>&nbsp;</td>
                        
                    </tr>
                <?php endforeach; ?>                     
            </tbody>
        </table>
        <?php endif;?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                 
            </div>

        </div>
    </div>
</div>
