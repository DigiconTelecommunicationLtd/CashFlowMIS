

<div class="x_panel">
    <table cellpadding="0" cellspacing="0"class="table table-striped table-bordered">
        <thead>
            <?php echo $this->Form->create('OrderItem', array('class' => 'form-horizontal form-label-left')); ?>
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
                    <?php echo $this->Form->input("invoice_no", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control",'required'=>false)); ?></th>
                <th style="text-align: center;"><?php echo $this->Form->submit('SUBMIT', array('class' => 'btn btn-success')); ?><?php echo $this->Form->end(); ?></th>
            </tr>
        </thead>
    </table>
    <table id="headerTable" cellpadding="0" cellspacing="0"class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?php echo ('Invoice no'); ?></th>			 
                <th><?php echo ('Client'); ?></th>
                <th><?php echo ('Product'); ?></th>
                <th><?php echo ('Quantity'); ?></th>
                <th><?php echo ('Unit Price'); ?></th>
                <th><?php echo ('Discount(%)'); ?></th>                 
                <th><?php echo ('Net Amount'); ?></th>                
                <th><?php echo ('Added By'); ?></th>			
                <th><?php echo ('Entry Date'); ?></th>                 
            </tr>
        </thead>
        <tbody>
            <?php
            $total_quantity=0;
            $total_amount=0;
            foreach ($orderItems as $orderItem): ?>
	<tr>
		<td><?php echo h($orderItem['OrderItem']['invoice_no']); ?>&nbsp;</td>
        <td><?php echo h($orderItem['OrderItem']['client_name']); ?>&nbsp;</td>
		<td style="text-align:right"><?php echo h($orderItem['OrderItem']['product_name']); ?>&nbsp;</td>		
		<td style="text-align:right"><?php echo h($orderItem['OrderItem']['quantity']);$total_quantity+=$orderItem['OrderItem']['quantity']; ?>&nbsp;</td>
		<td style="text-align:right"><?php echo h($orderItem['OrderItem']['unit_price']); ?>&nbsp;</td>
		<td style="text-align:right"><?php echo h($orderItem['OrderItem']['discount_percent']); ?>&nbsp;</td>
		<td style="text-align:right"><?php echo h($net_amount=$orderItem['OrderItem']['unit_price']*$orderItem['OrderItem']['quantity']-($orderItem['OrderItem']['unit_price']*$orderItem['OrderItem']['quantity']*0.01*$orderItem['OrderItem']['discount_percent']));$total_amount+=$net_amount; ?>&nbsp;</td>	
		<td><?php echo h($orderItem['OrderItem']['added_by']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['added_date']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td align="right" colspan="3"><strong>Total:&nbsp;</strong></td>                 
                <td><strong><?php echo h($total_quantity); ?>&nbsp;</strong></td>
				<td>&nbsp;</strong></td>
                <td>&nbsp;</strong></td>
                <td><strong><?php echo h($total_amount); ?>&nbsp;</strong></td>
                 
                <td colspan="2" align="center"><strong><iframe id="txtArea1" style="display:none"></iframe><button id="btnExport" onclick="fnExcelReport();" class="btn btn-success"> EXPORT </button>&nbsp;</strong></td>                              
                
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