<div class="x_panel"> 
    <div class="x_content">
        <?php echo $this->Form->create('OrderItem', array('action' => 'add', 'class' => 'form-horizontal form-label-left')); ?>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product Name:<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("product_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control col-md-7 col-xs-12", 'required' => 'required', 'tabindex' => -1, 'empty' => '', 'id' => 'product_id', 'data-placeholder' => 'Choose a Product', 'onchange' => "this.form.submit();")) ?>
            </div>
        </div>   
        <?php echo $this->Form->end(); ?>
    </div>
    <?php if ($order_products): ?>
        <div class="x_content">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr style="background-color:#2A3F54;color: white;">
                        <th>Action</th>                        
                        <th>Product</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Dis(%)</th>
                        <th>Amount</th>
                        <th>Net Amount</th>
                    </tr>
                </thead>
                <?php
                $total_amount = 0;
                $net_amount = 0;
                $total_discount = 0;
                foreach ($order_products as $order_product):
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $order_product['OrderItem']['id'])/* , array('confirm' => __('Are you sure you want to delete # %s?', $orderItem['OrderItem']['id'])) */); ?></td>
                            <td><?php echo $order_product['OrderItem']['product_name']; ?></td> 
                            <td>
                                <?php echo $this->Form->create('OrderItem', array('action' => '/edit/' . $order_product['OrderItem']['id'])); ?>
                                <?php echo $this->Form->input("unit_price", array("type" => "number", 'label' => false, 'div' => false, 'step' => 'any', 'class' => "form-control", 'required' => 'required', 'value' => h($order_product['OrderItem']['unit_price']), 'style' => 'width:80px;font-weight:bolder;','id'=>'unit_price_'.$order_product['OrderItem']['id'])) ?>
                                <?php echo $this->Form->end(); ?>
                            </td>
                            <td>
                                <?php echo $this->Form->create('OrderItem', array('action' => '/edit/' . $order_product['OrderItem']['id'])); ?>
                                <?php echo $this->Form->input("quantity", array("type" => "number", 'label' => false, 'div' => false, 'step' => 'any', 'class' => "form-control", 'required' => 'required', 'value' => h($order_product['OrderItem']['quantity']), 'style' => 'width:80px;font-weight:bolder;','id'=>'quantity_'.$order_product['OrderItem']['id'])) ?>
                                <?php echo $this->Form->end(); ?>
                            </td>
                            <td>
                                <?php echo $this->Form->create('OrderItem', array('action' => '/edit/' . $order_product['OrderItem']['id'])); ?>
                                <?php echo $this->Form->input("discount_percent", array("type" => "number", 'label' => false, 'div' => false, 'step' => 'any', 'class' => "form-control", 'required' => 'required', 'value' => h($order_product['OrderItem']['discount_percent']), 'style' => 'width:80px;font-weight:bolder;','id'=>'discount_percent_'.$order_product['OrderItem']['id'])) ?>
                                <?php echo $this->Form->end(); ?>
                            </td>
                            <td style="text-align: right"><?php
                                echo h($amount = $order_product['OrderItem']['quantity'] * $order_product['OrderItem']['unit_price']);
                                $total_amount+=$amount;
                                ?></td>                        
                            <td style="text-align: right"><?php
                                echo h($netamount = ($order_product['OrderItem']['quantity'] * $order_product['OrderItem']['unit_price']) - ($order_product['OrderItem']['quantity'] * $order_product['OrderItem']['unit_price'] * 0.01 * $order_product['OrderItem']['discount_percent']));
                                $net_amount+=$netamount;
                                ?></td>
                        </tr>
                    </tbody>                   
                <?php endforeach; ?>
                <tfoot>
                    <tr>
                        <td colspan="6" style="text-align: right;"><strong>Sub Total:</strong></td>
                        <td style="text-align: right;"><strong><?php echo $total_amount; ?></strong></td>;
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: right;"><strong>Total Discount:</strong></td>
                        <td style="text-align: right;"><strong><?php echo h($discount = $total_amount - $net_amount); ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: right;"><strong>Net Payable:</strong></td>
                        <td style="text-align: right;"><strong><?php echo $net_amount; ?></strong></td>
                    </tr> 
                </tfoot>
            </table>
            <table class="table table-striped table-bordered">
                <?php echo $this->Form->create('Order', array('action' => 'add', 'class' => 'form-horizontal form-label-left')); ?>
                <tr>
                    <th>
                        <?php echo $this->Form->hidden("total_bill", array("type" => "text", 'label' => false, 'div' => false, 'required' => 'required', 'class' => "form-control", 'value' => $total_amount)); ?>
                        <?php echo $this->Form->hidden("discount", array("type" => "text", 'label' => false, 'div' => false, 'required' => 'required', 'class' => "form-control", 'value' => $discount)); ?>
                        <?php echo $this->Form->hidden("net_amount", array("type" => "text", 'label' => false, 'div' => false, 'required' => 'required', 'class' => "form-control", 'value' => $net_amount,'id'=>'net_amount')); ?>
                        <label><strong>INVOICE<span style="color:red;">*</span>:</strong></label>
                        <?php echo $this->Form->input("invoice_no", array("type" => "text", 'label' => false, 'div' => false, 'required' => 'required', 'class' => "form-control",'value'=>$order_no,'readOnly'=>true)); ?></th>

                    <th colspan="2"> <label><strong>CLIENT<span style="color:red;">*</span>:</strong></label>
                        <?php echo $this->Form->input("client_id", array("type" => "select", 'label' => false, 'div' => false, 'class' => "select2_single form-control", 'required' => 'required', 'empty' => '', 'id' => 'client_id','onchange'=>'getBalance(this.value)')) ?></th>

                    <th> <label><strong>DELIVERY DATE<span style="color:red;">*</span>:</strong></label>
                        <?php echo $this->Form->input("delivery_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => TRUE, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'delivery_date')) ?></th>

                    <th><label><strong>ADV. AMOUNT:</strong></label>
                        <?php echo $this->Form->input("received_amount", array("type" => "number", 'label' => false,'id'=>'received_amount', 'div' => false, 'step' => 'any', 'class' => "form-control",'readOnly'=>true,'required'=>true)); ?></th>
                </tr>
                <tr>
                     <th> <label><strong>PAYMENT DATE<span style="color:red;">*</span>:</strong></label>
                        <?php echo $this->Form->input("payment_date", array("type" => "text", 'label' => false,'id'=>'payment_date', 'div' => false, 'class' => "form-control single_cal3", 'required' => true, 'aria-describedby' => "inputSuccess2Status3")) ?></th>
                    <th>
                        <label><strong>BANK:</strong></label>
                        <?php echo $this->Form->input("bank_name", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control",'style'=>'text-transform: uppercase;font-weight:bold','id'=>'bank_name','readOnly'=>true)); ?></th>
                    <th>
                        <label><strong>BRANCH:</strong></label>
                        <?php echo $this->Form->input("branch_name", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control",'style'=>'text-transform: uppercase;font-weight:bold','id'=>'branch_name','readOnly'=>true)); ?></th>
                    <th><label><strong>REMARKS:</strong></label>
                        <?php echo $this->Form->input("remarks", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control",'style'=>'text-transform: uppercase;font-weight:bold')); ?></th>
                    <th style="text-align: center;"><?php echo $this->Form->submit('SUBMIT', array('class' => 'btn btn-success')); ?><?php echo $this->Form->end(); ?></th>
                </tr>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
    function getBalance(clientID)
    {
        if(clientID)
        {
             var form_data = {
               id:clientID
            };
            $.ajax({
                url: "<?php echo $this->webroot; ?>client_balances/view",
                type: 'POST',
                async: false,
                data: form_data,
                success: function(data) {
                    data=data.split("#"); 
                    net_amount=parseInt($("#net_amount").val());     
                    net_amount=(net_amount)?net_amount:0; 
                    received_amount=parseInt(data[0]);
                    received_amount=(received_amount)?received_amount:0;
                    
                    balance=received_amount-net_amount;
                    
                    $("#received_amount").val("");
                    $("#received_amount").attr("readonly", false);
                    
                    if(balance>0)
                    {
                     $("#received_amount").attr({
                        "max" : net_amount,        
                        "min" : 0           
                     });
                     
                        $("#received_amount").val(net_amount);
                    }
                    else{
                         $("#received_amount").attr({
                        "max" : received_amount,        
                        "min" : 0           
                     });
                       $("#received_amount").val(received_amount);
                   }
                    
                    $("#payment_date").val(data[1]);
                    $("#bank_name").val(data[2]);
                    $("#branch_name").val(data[3]);
                }
            });
        }
    }
    document.getElementById("<?php echo $input_id;?>").focus();
</script>
<style>
    input[type="text"]{
        font-weight: bolder;
        text-transform: uppercase;
        
    } 
</style>
 
