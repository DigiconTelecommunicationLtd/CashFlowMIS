<div class="x_panel">
    <div class="x_content"> 
        <table cellpadding="0" cellspacing="0"class="table table-striped table-bordered">
            <thead>
                <?php echo $this->Form->create('PaymentHistory', array('class' => 'form-horizontal form-label-left')); ?>
                <tr>                    
                    <th><label><strong>RECEIVED DATE FROM:</strong></label>
                        <?php echo $this->Form->input("start_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'delivery_date', 'value' => $start_date)) ?></th>
                    </th>
                    <th><label><strong>RECEIVED DATE TO:</strong></label>
                        <?php echo $this->Form->input("end_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'delivery_date', 'value' => $end_date)) ?></th>
                    </th>   
                    <th> <label><strong>CLIENT NAME:</strong></label>
                        <?php echo $this->Form->input("client_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control", 'empty' => '', 'id' => 'client_id', 'required' => false)) ?></th>
                     <th style="text-align: center;"><?php echo $this->Form->submit('SUBMIT', array('class' => 'btn btn-success')); ?><?php echo $this->Form->end(); ?></th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="x_content"> 
        <table cellpadding="0" cellspacing="0"class="table table-striped table-bordered" id="headerTable">
            <thead>
                <tr>

                    <th><?php echo $this->Paginator->sort('client_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('amount'); ?></th>
                    <th><?php echo $this->Paginator->sort('payment_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('bank'); ?></th>
                    <th><?php echo $this->Paginator->sort('branch'); ?></th>
                    <th><?php echo $this->Paginator->sort('added_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('added_date'); ?></th>                     
                </tr>
            </thead>
            <tbody>
                <?php
                $otal=0;
                foreach ($paymentHistories as $paymentHistory): ?>
                    <tr>

                        <td> <?php echo h($paymentHistory['Client']['name']); ?> &nbsp;</td>
                        <td><?php echo h($paymentHistory['PaymentHistory']['amount']);$otal+=$paymentHistory['PaymentHistory']['amount']; ?>&nbsp;</td>
                        <td><?php echo h($paymentHistory['PaymentHistory']['payment_date']); ?>&nbsp;</td>
                        <td><?php echo h($paymentHistory['PaymentHistory']['bank']); ?>&nbsp;</td>
                        <td><?php echo h($paymentHistory['PaymentHistory']['branch']); ?>&nbsp;</td>
                        <td><?php echo h($paymentHistory['PaymentHistory']['added_by']); ?>&nbsp;</td>
                        <td><?php echo h($paymentHistory['PaymentHistory']['added_date']); ?>&nbsp;</td>
                        
                    </tr>
                <?php endforeach; ?>                 
            </tbody>
             <tfoot>
            <tr>
                <td align="right"><strong>Total:&nbsp;</strong></td>                 
                <td><strong><?php echo h($otal); ?>&nbsp;</strong></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>  
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><iframe id="txtArea1" style="display:none"></iframe><button id="btnExport" onclick="fnExcelReport();" class="btn btn-success"> EXPORT </button></td>
            </tr>
        </tfoot>
        </table>
    </div>
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



