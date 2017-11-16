<div class="x_panel">
    <div class="x_content">
        <?php echo $this->Form->create('OrderPayment', array('action' => 'add', 'class' => 'form-horizontal form-label-left')); ?>
          <div class="item form-group">
              <table class="table table-striped table-bordered">
                  <tr>
                       <td>Invoice No:</td>
                       <td><?php echo $orders['Order']['invoice_no']; ?></td>
                       <td>Client Name:</td>
                       <td><?php echo $orders['Order']['client_name']; ?></td>
                       <td>Balance Amount</td>
                       <td><?php echo $clientBalance['ClientBalance']['balance']; ?></td>
                  </tr>
              </table>
        </div>
         <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Bank Name
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->hidden("invoice_no", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'required' =>true,'value'=>$orders['Order']['invoice_no'])) ?>
                <?php echo $this->Form->hidden("client_id", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'required' =>true,'value'=>$orders['Order']['client_id'])) ?>
                <?php echo $this->Form->hidden("client_name", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'required' =>true,'value'=>$orders['Order']['client_name'])) ?>
                <?php echo $this->Form->input("bank_name", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'required' =>true,'value'=>$payment_history['PaymentHistory']['bank'])) ?>
            </div>
        </div>        
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Branch Name
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("branch_name", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'required' =>true,'value'=>$payment_history['PaymentHistory']['branch'])) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Payment Type
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("payment_type", array("type" => "select", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'required' =>true,'options'=>array(''=>'Choose payment Type','Advance'=>'Advance','Final Payment'=>'Final Payment'),'style'=>'text-transform: uppercase;font-weight:bold')) ?>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Payment Received Date:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("received_date", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control single_cal3", 'required' => false, 'aria-describedby' => "inputSuccess2Status3", 'id' => 'delivery_date', 'required' => true,'style'=>'text-transform: uppercase;font-weight:bold','value'=>$payment_history['PaymentHistory']['payment_date'])) ?>
            </div>
        </div>
         <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Received Amount
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("received_amount", array("type" => "number", 'label' => false, 'div' => false,'id'=>'received_amount', 'class' => "form-control col-md-7 col-xs-12 balance_calculation check_net_balance",'required' =>true,'step'=>'any','style'=>'text-transform: uppercase;font-weight:bold','min'=>0,'onchange'=>'calculate_reaming_qty(this.value)')) ?>
            </div>
        </div> 
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">AIT
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("ait", array("type" => "number", 'label' => false, 'div' => false,'id'=>'ait', 'class' => "form-control col-md-7 col-xs-12 balance_calculation check_net_balance",'required' =>false,'step'=>'any','style'=>'text-transform: uppercase;font-weight:bold','min'=>0,'onchange'=>'calculate_reaming_qty(this.value)')) ?>
            </div>
        </div> 
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Vat
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("vat", array("type" => "number", 'label' => false, 'div' => false,'id'=>'vat', 'class' => "form-control col-md-7 col-xs-12 balance_calculation check_net_balance",'required' =>false,'step'=>'any','style'=>'text-transform: uppercase;font-weight:bold','min'=>0,'onchange'=>'calculate_reaming_qty(this.value)')) ?>
            </div>
        </div> 
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">LD
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("ld", array("type" => "number", 'label' => false, 'div' => false,'id'=>'ld', 'class' => "form-control col-md-7 col-xs-12 balance_calculation check_net_balance",'required' =>false,'step'=>'any','style'=>'text-transform: uppercase;font-weight:bold','min'=>0,'onchange'=>'calculate_reaming_qty(this.value)')) ?>
            </div>
        </div> 
        
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Other Deduction
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("other_deduction", array("type" => "number", 'label' => false,'id'=>'other_deduction', 'div' => false, 'class' => "form-control col-md-7 col-xs-12 balance_calculation check_net_balance",'required' =>false,'step'=>'any','style'=>'text-transform: uppercase;font-weight:bold','min'=>0)) ?>
            </div>
        </div> 
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Balance
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->hidden("netbalance", array("type" => "number", 'label' => false, 'div' => false,'id'=>'netbalance', 'class' => "form-control col-md-7 col-xs-12",'readOnly' =>true,'value'=>$orders['Order']['balance'])) ?>
                <?php echo $this->Form->input("balance", array("type" => "number", 'label' => false, 'div' => false,'id'=>'balance', 'class' => "form-control col-md-7 col-xs-12 balance_calculation",'readOnly' =>true,'value'=>$orders['Order']['balance'],'style'=>'text-transform: uppercase;font-weight:bold')) ?>
            </div>
        </div> 
         <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Remarks
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $this->Form->input("remarks", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'required' =>false,'style'=>'text-transform: uppercase;font-weight:bold')) ?>
            </div>
        </div>          
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3"> 
                <?php echo $this->Form->hidden("order_id", array("type" => "text", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'required' =>true,'value'=>$id)) ?>
                <?php echo $this->Form->submit('submit', array('class' => 'btn btn-success')); ?>
                 <?php echo $this->Form->hidden("netBalance", array("type" => "number", 'label' => false, 'div' => false, 'class' => "form-control col-md-7 col-xs-12",'required' =>true,'id'=>'netBalance','value'=>$clientBalance['ClientBalance']['balance'])) ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>                    
    </div>
</div>
<style>
    input[type="text"]{
        font-weight: bolder;
        text-transform: uppercase;
    } 
</style>


