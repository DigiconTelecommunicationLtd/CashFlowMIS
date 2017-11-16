<div class="x_panel">
    <table cellpadding="0" cellspacing="0"class="table table-striped table-bordered">
        <thead>
            <?php echo $this->Form->create('Order', array('class' => 'form-horizontal form-label-left')); ?>
            <tr>                    
                <th><label><strong>ENTRY DATE FROM:</strong></label>
                    <?php echo $this->Form->input("start_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'delivery_date', 'value' => $start_date)) ?></th>
                </th>
                <th><label><strong>ENTRY DATE TO:</strong></label>
                    <?php echo $this->Form->input("end_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'delivery_date', 'value' => $end_date)) ?></th>
                </th>   
                <th> <label><strong>CLIENT NAME:</strong></label>
                    <?php echo $this->Form->input("client_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control", 'empty' => '', 'id' => 'client_id','required'=>false)) ?></th>
                <th> <label><strong>INVOICE NO.:</strong></label>
                    <?php echo $this->Form->input("invoice_no", array("type" => "text", 'label' => false, 'div' => false, 'required'=>false, 'class' => "form-control")); ?></th>
                <th style="text-align: center;"><?php echo $this->Form->submit('SUBMIT', array('class' => 'btn btn-success')); ?><?php echo $this->Form->end(); ?></th>
            </tr>
        </thead>
    </table>
    <table cellpadding="0" cellspacing="0"class="table table-striped table-bordered" id="headerTable">
        <thead>
            <tr>                    
                <th><?php echo ('Client'); ?></th>
                <th><?php echo ('Invoice No'); ?></th>
                <th><?php echo ('Total Bill'); ?></th>
                <th><?php echo ('Discount'); ?></th>
                <th><?php echo ('Net Amount'); ?></th>
                <th><?php echo ('Received Amount'); ?></th>
                <th><?php echo ('ait'); ?></th>
                <th><?php echo ('vat'); ?></th>
                <th><?php echo ('ld'); ?></th>
                <th><?php echo ('O.D'); ?></th>
                <th><?php echo ('Balance'); ?></th>            
                <th><?php echo ('Delivery/Payment Received Date'); ?></th>
                <th><?php echo ('Added By'); ?></th>
                <th><?php echo ('Added Date'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo h($order['Order']['client_name']); ?>&nbsp;</td>
                    <td><?php echo h($order['Order']['invoice_no']); ?>&nbsp;</td>
                    <td><?php echo h($order['Order']['total_bill']); ?>&nbsp;</td>
                    <td><?php echo h($order['Order']['discount']); ?>&nbsp;</td>
                    <td><?php echo h($order['Order']['net_amount']); ?>&nbsp;</td>
                    <td><?php echo h($order['Order']['received_amount']); ?>&nbsp;</td>
                    <td><?php echo h($order['Order']['ait']); ?>&nbsp;</td>
                    <td><?php echo h($order['Order']['vat']); ?>&nbsp;</td>
                    <td><?php echo h($order['Order']['ld']); ?>&nbsp;</td>
                    <td><?php echo h($order['Order']['other_deduction']); ?>&nbsp;</td>
                    <td><?php echo h($order['Order']['balance']); ?>&nbsp;</td>               
                    <td><?php echo h($order['Order']['delivery_date']); ?>&nbsp;</td>
                    <td><?php echo h($order['Order']['added_by']); ?>&nbsp;</td>
                    <td><?php echo h($order['Order']['added_date']); ?>&nbsp;</td> 
                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $order['Order']['id'])); ?>
                        <?php echo $this->Html->link(__('Payment'), array('controller' => 'order_payments', 'action' => 'add', $order['Order']['id'])); ?>
                        <?php //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $order['Order']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $order['Order']['id']))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td  align="right" colspan="2"><strong>Total:&nbsp;</strong></td>
                <td><strong><?php echo h($order_sum[0]['total_bill']); ?>&nbsp;</strong></td>
                <td><strong><?php echo h($order_sum[0]['discount']); ?>&nbsp;</strong></td>
                <td><strong><?php echo h($order_sum[0]['net_amount']); ?>&nbsp;</strong></td>
                <td><strong><?php echo h($order_sum[0]['received_amount']); ?>&nbsp;</strong></td>
                <td><strong><?php echo h($order_sum[0]['ait']); ?>&nbsp;</strong></td>
                <td><strong><?php echo h($order_sum[0]['vat']); ?>&nbsp;</strong></td>
                <td><strong><?php echo h($order_sum[0]['ld']); ?>&nbsp;</strong></td>
                <td><strong><?php echo h($order_sum[0]['other_deduction']); ?>&nbsp;</strong></td>
                <td><strong><?php echo h($order_sum[0]['balance']); ?>&nbsp;</strong></td>               
                <td align="center"colspan="4"><iframe id="txtArea1" style="display:none"></iframe><button id="btnExport" onclick="fnExcelReport();" class="btn btn-success"> EXPORT </button></td>
            </tr>
        </tfoot>


    </table> 
</div>

<script>
    function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('headerTable'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}
</script>
<style>
    table tr td,th{
        font-weight: bold;
        text-transform: uppercase;
        font-size: 12px;
    }
</style>
