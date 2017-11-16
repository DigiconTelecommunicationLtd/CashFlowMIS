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
        <?php if ($inspections): ?>
            <table  class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Contract/PO.No</th>
                        <th>Lot No.</th>
                        <th>Product</th>                    
                        <th>Quantity</th>
                        <th>Unit Weight</th>
                        <th>Weight</th>
                         <th>Planned Completion Date</th>
                        <th>Actual Completion Date</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inspections as $inspection): ?>
                        <tr>

                            <td> <?php echo $inspection['Contract']['contract_no']; ?> </td>
                            <td> <?php echo $inspection['Inspection']['lot_id']; ?> </td>
                            <td> <?php echo $inspection['Product']['name']; ?> </td>
                            <td><?php echo h($inspection['Inspection']['quantity']); ?>&nbsp;<?php echo h($inspection['Inspection']['uom']); ?></td>
                            <td><?php echo h($inspection['Inspection']['unit_weight']); ?>&nbsp;</td>
                            <td><?php echo ($inspection['Inspection']['unit_weight'] != 'N/A') ? h($inspection['Inspection']['unit_weight'] * $inspection['Inspection']['quantity']) . ' ' . $inspection['Inspection']['uom'] : 'N/A'; ?>&nbsp;</td>
                            <td> <?php echo $inspection['Inspection']['planned_inspection_date']; ?> </td> 
                            <td> <?php echo $inspection['Inspection']['actual_inspection_date']; ?> </td> 
                            <td> <?php echo $inspection['Inspection']['remarks']; ?> </td> 
                            <td class="actions">
                                <button onclick="delete_inspection_product('<?php echo $inspection['Inspection']['id']; ?>','<?php echo $inspection['Inspection']['contract_id']; ?>','<?php echo $inspection['Inspection']['lot_id']; ?>');"><i class="fa fa-remove"></i></button>
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
