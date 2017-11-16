<?php if($results): ?>
    <table id="datatable-buttons"  class="table table-striped table-bordered">
    <thead>
        <tr>            
            <th>PO. NO:</th>
            <th>Collection Type</th>
            <th>Category</th>
            <th>Invoice Ref. No</th>
            <th>Billing Percent</th>
            <th>Invoice Amount</th>
            <th>Amount Received</th>
            <th>AIT</th>
            <th>VAT</th>
            <th>L.D</th>
            <th>Other Deduction</th>
            <th>Balance</th>            
            <th>Currency</th> 
            <th>Adv. Adjustment</th>
            <th>Client</th>
            <th>Unit</th>
            <th>Planned Invoice Submission Date</th>
            <th>Actual Invoice Submission Date</th>                     
            <th>Planned Payment Certificate/Cheque Collection Date</th>           
            <th>Planned Payment Collection Date</th>
            <th>Forecasted Payment Collection Date</th>
            <th>Cheque/Payment Certificate Date</th>
             <th>Actual Payment Certificate/Cheque Collection Date</th>
            <th>Bank Credit (Payment Receive )Date</th>
            <th>Added By</th>
            <th>Added Date</th>
            <th>Modified By</th>
            <th>Modified Date</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $invoice_amount=0;
        $amount_received=0;
        $ait=0;
        $vat=0;
        $ld=0;
        $other_deduction=0;
        foreach ($results as $result): ?>
            <tr>                
                <td><?php echo h($result[0]['contract_no']);?></td>
                <td><?php echo h($result['Collection']['collection_type']);?></td>
                <td><?php echo h($result[0]['product_category']);?></td>
                <td><?php echo h($result['Collection']['invoice_ref_no']);?></td>
                <td><?php echo h($result['Collection']['billing_percent']);?></td>
                <td><?php echo h($result['Collection']['invoice_amount']);$invoice_amount+=($result['Collection']['invoice_amount']>0)?$result['Collection']['invoice_amount']:0.00;?></td>
                <td><?php echo h($result['Collection']['amount_received']);$amount_received+=($result['Collection']['amount_received']>0)?$result['Collection']['amount_received']:0.00;?></td>
                <td><?php echo h($result['Collection']['ait']);$ait+=($result['Collection']['ait']>0)?$result['Collection']['ait']:0.00;?></td>
                <td><?php echo h($result['Collection']['vat']);$vat+=($result['Collection']['vat']>0)?$result['Collection']['vat']:0.00;?></td>
                <td><?php echo h($result['Collection']['ld']);$ld+=($result['Collection']['ld']>0)?$result['Collection']['ld']:0.00;?></td>
                <td><?php echo h($result['Collection']['other_deduction']);$other_deduction+=($result['Collection']['other_deduction']>0)?$result['Collection']['other_deduction']:0.00;?></td>
                <td><?php echo h($result['Collection']['invoice_amount']-($result['Collection']['amount_received']+$result['Collection']['ait']+$result['Collection']['vat']+$result['Collection']['ld']+$result['Collection']['other_deduction']));?></td>
                <td><?php echo h($result['Collection']['currency']);?></td>   
                <td><?php echo h($result['Collection']['ajust_adv_amount']);?></td>   
                <td><?php echo h($result[0]['client_name']);?></td>
                <td><?php echo h($result[0]['unit_name']);?></td>
                <td><?php echo h($result['Collection']['planned_submission_date'] != "0000-00-00 00:00:00") ? $result['Collection']['planned_submission_date'] : 'N/A';?></td>
                <td><?php echo h($result['Collection']['actual_submission_date'] != "0000-00-00 00:00:00") ? $result['Collection']['actual_submission_date'] : 'N/A';?></td>
                <td><?php echo h($result['Collection']['planned_payment_certificate_or_cheque_collection_date'] != "0000-00-00") ? $result['Collection']['planned_payment_certificate_or_cheque_collection_date'] : 'N/A';?></td>
                <td><?php echo h($result['Collection']['planned_payment_collection_date'] != "0000-00-00") ? $result['Collection']['planned_payment_collection_date'] : 'N/A';?></td>
                <td><?php echo h($result['cd']['forecasted_payment_collection_date'] != "0000-00-00") ? $result['cd']['forecasted_payment_collection_date'] : 'N/A';?></td>
                <td><?php echo h($result['cd']['cheque_or_payment_certification_date'] != "0000-00-00") ? $result['cd']['cheque_or_payment_certification_date'] : 'N/A';?></td>
                <td><?php echo h($result['cd']['actual_payment_certificate_or_cheque_collection_date'] != "0000-00-00") ? $result['cd']['actual_payment_certificate_or_cheque_collection_date'] : 'N/A';?></td>
                <td><?php echo h($result['cd']['payment_credited_to_bank_date'] != "0000-00-00") ? $result['cd']['payment_credited_to_bank_date'] : 'N/A';?></td>                       
                <td><?php echo h($result['Collection']['added_by']);?></td>
                <td><?php echo h($result['Collection']['added_date']);?></td>
                <td><?php echo h($result['cd']['modified_by']);?></td>
                <td><?php echo h($result['cd']['modified_date'] != "0000-00-00 00:00:00") ? $result['cd']['modified_date'] : 'N/A';?></td>
                <td><?php echo h($result['cd']['remarks']);?></td>
            </tr>
        <?php endforeach; ?>
    <tfoot>
            <tr>
                <td  colspan="5">Total:</td>
                <td><?php echo$invoice_amount;?></td>
                <td><?php echo $amount_received;?></td>
                <td><?php echo $ait;?></td>
                <td><?php echo $vat;?></td>
                <td><?php echo $ld;?></td>
                <td><?php echo $other_deduction;?></td>
                <td colspan="18"></td>                           
            </tr> 
            </tfoot>
    </tbody>
</table>
<?php endif;?>