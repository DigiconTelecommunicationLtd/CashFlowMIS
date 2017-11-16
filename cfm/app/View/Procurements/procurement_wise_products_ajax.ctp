<div class="x_panel"> 
    <?php if ($this->Session->check('Message.flash')): ?> 
    <div class="x_title">       
            <div role="alert" class="alert alert-success alert-dismissible fade in">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                </button>
                <strong><?php echo $this->Session->flash(); ?></strong>
            </div>        
        <div class="clearfix"></div>
    </div>
    <?php endif; ?>
    <div class="x_content">
        <?php if ($procurements): ?>
            <table  class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Contract/PO.No</th>
                        <th>Lot No.</th>
                        <th>Product</th>                    
                        <th>Quantity</th>
                        <th>Unit Weight</th>
                        <th>Weight</th>
                         <th>Planned Arrival Date</th>
                        <th>Actual Arrival Date</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($procurements as $procurement): ?>
                        <tr>

                            <td> <?php echo $procurement['Contract']['contract_no']; ?> </td>
                            <td> <?php echo $procurement['Procurement']['lot_id']; ?> </td>
                            <td> <?php echo $procurement['Product']['name']; ?> </td>
                            <td><?php echo h($procurement['Procurement']['quantity']); ?>&nbsp;<?php echo h($procurement['Procurement']['uom']); ?></td>
                            <td><?php echo h($procurement['Procurement']['unit_weight']); ?>&nbsp;</td>
                            <td><?php echo ($procurement['Procurement']['unit_weight'] != 'N/A') ? h($procurement['Procurement']['unit_weight'] * $procurement['Procurement']['quantity']) . ' ' . $procurement['Procurement']['uom'] : 'N/A'; ?>&nbsp;</td>
                            <td> <?php echo $procurement['Procurement']['planned_arrival_date']; ?> </td> 
                            <td> <?php echo $procurement['Procurement']['actual_arrival_date']; ?> </td> 
                            <td> <?php echo $procurement['Procurement']['remarks']; ?> </td> 
                            <td class="actions">
                                <button onclick="delete_procurement_product('<?php echo $procurement['Procurement']['id']; ?>','<?php echo $procurement['Procurement']['contract_id']; ?>','<?php echo $procurement['Procurement']['lot_id']; ?>');"><i class="fa fa-remove"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div> 
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('fast');
        }, 1500); // <-- time in milliseconds
    });
</script>
