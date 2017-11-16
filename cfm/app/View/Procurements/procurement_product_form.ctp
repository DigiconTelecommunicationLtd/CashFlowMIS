 <?php if ($lots_products): ?>
<div class="x_content">
    <table  class="table table-striped table-bordered">
        <thead>
            <tr>
                <!--<th>Contract/PO.No:</th>
                <th>Lot No:</th>-->
                <td>Product</td>                    
                <td>L.Qty</td>
                <td>prev.P.Qty</td>
                <td>Reaming.Qty</td>
                <td>U.W</td>
                <td>T.W</td>
                <td>UOM</td>
                <td>P.Qty</td>
                <td>P.Arrival.Date</td>
                <!--<th>Remarks</th>-->                        
            </tr>
        </thead>
        <tbody>           
            <?php echo $this->Form->create('Procurement', array('action' => 'procurement_product_save_lot_wise', 'class' => 'form-horizontal form-label-left', 'id' => 'ProcurementSave')); ?>
                <?php foreach ($lots_products as $lots_product): ?>
                    <tr>

                       <!-- <td><?php //echo $lots_product['Contract']['contract_no']; ?> </td>
                        <td><?php //echo $lots_product['LotProduct']['lot_id']; ?> </td>-->
                        <td><?php echo $lots_product['Product']['name']; ?> </td>
                        <td><?php echo $lot_qty=h($lots_product[0]['quantity']); ?>&nbsp;</td>
                        <td><?php
                        $pro_qty=isset($procurement[$lots_product['LotProduct']['product_id']])?$procurement[$lots_product['LotProduct']['product_id']]:0;
                        echo h($pro_qty); ?>&nbsp;</td>
                        <td><?php echo $lot_qty-$pro_qty;?></td>
                        <td><?php echo h($lots_product['LotProduct']['unit_weight']); ?>&nbsp;</td>
                        <td><?php echo ($lots_product['LotProduct']['unit_weight'] != 'N/A') ? h($lots_product['LotProduct']['unit_weight'] * $lots_product[0]['quantity']): 'N/A'; ?>&nbsp;</td>
                        <td><?php echo h($lots_product['LotProduct']['uom']); ?></td>
                        <td><?php echo $this->Form->input("quantity_".$lots_product['LotProduct']['product_id']."", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 procurement",'data-placeholder'=>'Procurement Quantity Here..', 'required' => 'required')) ?></td> 
                        <td><?php echo $this->Form->input("arrival_".$lots_product['LotProduct']['product_id']."", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 single_cal3 procurement",'readOnly'=>true, 'required' => 'required')) ?></td> 
                        <td><?php echo $this->Form->input("actual_".$lots_product['LotProduct']['product_id']."", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 single_cal3 procurement",'readOnly'=>true, 'required' => 'required')) ?></td> 
                        <!--<td><?php //echo $this->Form->input("remarks_".$lots_product['LotProduct']['product_id']."", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-1 col-xs-12 procurement")) ?></td>-->
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td align="right" colspan="9" class="right">
                             <?php echo $this->Form->submit('Save Procurement', array('class' => 'btn btn-success', 'id' => 'ProcurementSaveSubmit')); ?>
                             <?php echo $this->Form->end(); ?>
                        </td>
                    </tr>          
        </tbody>
    </table>
</div>
<?php endif; ?>

<script>
      $(document).ready(function() {       
        $('.single_cal3').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_3"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        }); 
    });
</script>
<?php /*
$data = $this->Js->get('#ProcurementSave')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#ProcurementSave')->event(
        'submit', $this->Js->request(
                array('controller' => 'procurements', 'action' => 'procurement_product_save_lot_wise'), array(
            'update' => '#lotProductUpdate',
            'data' => $data,
            'async' => true,
            'dataExpression' => true,
            'method' => 'POST',
            'before' => "$('#loading').fadeIn();$('#ProcurementSaveSubmit').attr('disabled','disabled');",
            'complete' => "$('#loading').fadeOut();$('#ProcurementSaveSubmit').removeAttr('disabled');$('#lotProductUpdate').fadeIn();",
                )
        )
);
 * 
 */
?>

