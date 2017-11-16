<!-- modals -->
<!-- Large modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg-lot">Show lot's Products</button>
<div class="modal fade bs-example-modal-lg-lot" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Lot's Products:</h4>
            </div>
            <div class="modal-body">
               <?php if($contractProducts): ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Contract/PO No</th>
                    <th>Lot No.</th>
                    <th>Product</th>                    
                    <th>Quantity</th>
                    <th>Unit Weight</th>
                    <th>Weight</th>                  
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contractProducts as $contractProduct): ?>
                    <tr>
                        <td><?php echo h($contractProduct['Contract']['contract_no']); ?>&nbsp;</td>
                        <td> <?php echo $contractProduct['LotProduct']['lot_id']; ?> </td>
                        <td> <?php echo $contractProduct['Product']['name']; ?> </td>
                        <td><?php echo h($contractProduct['LotProduct']['quantity']); ?>&nbsp;<?php echo h($contractProduct['LotProduct']['uom']); ?></td>                       
                        <td><?php echo h($contractProduct['LotProduct']['unit_weight']); ?>&nbsp;</td>
                        <td><?php echo h($contractProduct['LotProduct']['unit_weight'] * $contractProduct['LotProduct']['quantity']); ?>&nbsp;<?php echo h($contractProduct['LotProduct']['uom']); ?></td>
                        
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
