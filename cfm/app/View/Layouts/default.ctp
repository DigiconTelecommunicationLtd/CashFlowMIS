<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Cash flow mis | <?php echo $this->fetch('title'); ?></title>
        <?php echo $this->Html->meta('favicon.ico','img/favicon.png',array('type' => 'icon')); ?>
        <!-- Bootstrap -->
        <?php echo $this->Html->css('/vendors/bootstrap/dist/css/bootstrap.min'); ?>
        <!-- Font Awesome -->
        <?php echo $this->Html->css('/vendors/font-awesome/css/font-awesome.min'); ?>
        <!-- NProgress -->
        <?php echo $this->Html->css('/vendors/nprogress/nprogress'); ?>
        <!-- iCheck -->
        <?php echo $this->Html->css('/vendors/iCheck/skins/flat/green'); ?>
         <!-- Select2 -->
       <?php echo $this->Html->css('/vendors/select2/dist/css/select2.min'); ?>
        <!-- Datatables -->
        <?php echo $this->Html->css('/vendors/datatables.net-bs/css/dataTables.bootstrap.min'); ?>
        <?php echo $this->Html->css('/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min'); ?>
        <?php echo $this->Html->css('/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min'); ?>
        <?php echo $this->Html->css('/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min'); ?>
        <?php echo $this->Html->css('/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min'); ?>
        <?php echo $this->Html->css('style'); ?>

        <!-- Custom Theme Style -->
        <?php echo $this->Html->css('/build/css/custom.min'); ?>
        <?php echo $this->fetch('css'); ?>
        <style>
                input[type=number]::-webkit-outer-spin-button,
                input[type=number]::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }

                input[type=number] {
                    -moz-appearance:textfield;
                }
        </style>
        <style>
            .table_scrol{
                display: block !important;overflow-x: auto !important;
            }
        </style>
        <script>
           function contractFormValidation() 
            {
              var errorFlag = false; 
              var contract_value_bdt=document.getElementById('contract_value_bdt').value;
              var contract_value_usd=document.getElementById('contract_value_usd').value;
              
              var contract_date=document.getElementById('contract_date').value;
              var lc_validity=document.getElementById('lc_validity').value;
              var delivery_strat_date=document.getElementById('delivery_strat_date').value;
              var contract_deadline=document.getElementById('contract_deadline').value;
               
              //advance
              var billing_percent_adv=parseInt(document.getElementById('billing_percent_adv').value);
              billing_percent_adv=(billing_percent_adv)?billing_percent_adv:0.00;
              // progressive
              var billing_percent_progressive=parseInt(document.getElementById('billing_percent_progressive').value);
              billing_percent_progressive=(billing_percent_progressive)?billing_percent_progressive:0.00;
              // first retention
              var billing_percent_first_retention=parseInt(document.getElementById('billing_percent_first_retention').value);
              billing_percent_first_retention=(billing_percent_first_retention)?billing_percent_first_retention:0.00;
              // second retention
              var billing_percent_second_retention=parseInt(document.getElementById('billing_percent_second_retention').value);
              billing_percent_second_retention=(billing_percent_second_retention)?billing_percent_second_retention:0.00;
              var total=billing_percent_adv+billing_percent_progressive+billing_percent_first_retention+billing_percent_second_retention;
               
              if(total>100)
              {
                  alert('Adv/Progressive/Retention assumption is greater than or less than 100!. Please try again.');
                  document.getElementById("billing_percent_adv").style.borderColor = "red";
                  document.getElementById("billing_percent_progressive").style.borderColor = "red"; 
                  document.getElementById("billing_percent_first_retention").style.borderColor = "red";
                  document.getElementById("billing_percent_second_retention").style.borderColor = "red"; 
                   errorFlag = true;
              }
           
              if((contract_value_bdt<=0||isNaN(contract_value_bdt))&&(contract_value_usd<=0||isNaN(contract_value_usd)))
              {
                  alert('PO Value BD/USD is required!. Please try again.');
                  document.getElementById("contract_value_bdt").style.borderColor = "red";
                  document.getElementById("contract_value_usd").style.borderColor = "red";                    
                  errorFlag = true;
              }   
              if(contract_date)
              {
                  if(!checkdate(contract_date))
                  {
                  alert("Invalid Date Format. Please correct and submit again.") 
                  document.getElementById("contract_date").style.borderColor = "red";
                  errorFlag = true;
                  }
              }
              else{
                  alert("Invalid Date Format. Please correct and submit again.") 
                  document.getElementById("contract_date").style.borderColor = "red";
                  errorFlag = true;
              }
               if(lc_validity)
              {
                  if(!checkdate(lc_validity))
                  {
                  alert("Invalid Date Format. Please correct and submit again.") 
                  document.getElementById("lc_validity").style.borderColor = "red";
                  errorFlag = true;
                  }
              }
               if(delivery_strat_date)
              {
                  if(!checkdate(delivery_strat_date))
                  {
                  alert("Invalid Date Format. Please correct and submit again.") 
                  document.getElementById("delivery_strat_date").style.borderColor = "red";
                  errorFlag = true;
                  }
              }
               if(contract_deadline)
              {
                  if(!checkdate(contract_deadline))
                   {
                  alert("Invalid Date Format. Please correct and submit again.") 
                  document.getElementById("contract_deadline").style.borderColor = "red";
                  errorFlag = true;
                  }
              }
              else{
                  alert("Invalid Date Format. Please correct and submit again.") 
                  document.getElementById("contract_deadline").style.borderColor = "red";
                  errorFlag = true;
              }
              
              return !errorFlag;
      
            }
            
       </script>
       <script type="text/javascript">

            function checkdate(input){
            var validformat=/(\d{4})-(\d{2})-(\d{2})/ //Basic check for format validity
            var returnval=false
            if (!validformat.test(input))
            return false;
            else{ //Detailed check for valid date ranges
            var monthfield=input.split("-")[1]
            var dayfield=input.split("-")[2]
            var yearfield=input.split("-")[0]
            var dayobj = new Date(yearfield, monthfield-1, dayfield)
            if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield))
            return false;
            else
            returnval=true
            }
            if (returnval==false) input.select()
            return returnval
            }

       </script>

    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <?php echo $this->element('menu'); ?>

                <!-- top navigation -->
                <?php echo $this->element('top-menu'); ?>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?php if ($this->Session->check('Message.flash')): ?> 
                            <div role="alert" class="alert alert-success alert-dismissible fade in">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                </button>
                                <strong><?php echo $this->Session->flash(); ?></strong>
                            </div> 
                        <?php endif; ?>   
                        <?php echo $this->fetch('content'); ?>
                    </div> 
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        ©2016 All Rights Reserved. CASH CYCLE MIS - Privacy and Terms
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>

        <!-- jQuery -->
        <?php echo $this->Html->script('/vendors/jquery/dist/jquery.min'); ?>
        <!-- Jeditable -->
        <?php //echo $this->Html->script('jquery.jeditable'); ?>
        <!-- Bootstrap -->
        <?php echo $this->Html->script('/vendors/bootstrap/dist/js/bootstrap.min'); ?>
         
        <!-- FastClick -->
        <?php echo $this->Html->script('/vendors/fastclick/lib/fastclick'); ?>
        <!-- NProgress -->
        <?php echo $this->Html->script('/vendors/nprogress/nprogress'); ?>
        <!-- iCheck -->
        <?php echo $this->Html->script('/vendors/iCheck/icheck.min'); ?>
        <!-- bootstrap-daterangepicker -->
        <?php echo $this->Html->script('/js/moment/moment.min'); ?>     
        <?php echo $this->Html->script('/js/datepicker/daterangepicker'); ?>
        <!-- Datatables -->
        <?php echo $this->Html->script('/vendors/datatables.net/js/jquery.dataTables.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-bs/js/dataTables.bootstrap.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-buttons/js/dataTables.buttons.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-buttons/js/buttons.flash.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-buttons/js/buttons.html5.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-buttons/js/buttons.print.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-keytable/js/dataTables.keyTable.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-responsive/js/dataTables.responsive.min'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-responsive-bs/js/responsive.bootstrap'); ?>

        <?php echo $this->Html->script('/vendors/datatables.net-scroller/js/datatables.scroller.min'); ?>

        <?php echo $this->Html->script('/vendors/jszip/dist/jszip.min'); ?>

        <?php echo $this->Html->script('/vendors/pdfmake/build/pdfmake.min'); ?>
        <?php echo $this->Html->script('/vendors/pdfmake/build/vfs_fonts'); ?>
        <!-- Switchery -->
     <?php echo $this->Html->script('/vendors/switchery/dist/switchery.min'); ?>
        <!-- Select2 -->
     <?php echo $this->Html->script('/vendors/select2/dist/js/select2.full.min'); ?>

        <!-- Custom Theme Scripts -->
        <?php echo $this->Html->script('/build/js/custom.min'); ?>
 
        <!-- Datatables -->
      <?php echo $this->Html->script('common-table'); ?>
        <!-- /Datatables -->
<?php echo $this->fetch('script'); ?>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
  $('.alert').fadeOut('slow');
}, 6000); // <-- time in milliseconds
            });
        </script>
        <!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select2_single").select2({
          placeholder: "Choose an Option",
          allowClear: true
        });
        $(".select2_group").select2({});
        $(".select2_multiple").select2({
          maximumSelectionLength: 4,
          placeholder: "Choose an Option",
          allowClear: true
        });
      });
    </script>
    <!-- /Select2 -->
     <script>
      $(document).ready(function() {
        $('#single_cal1').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal2').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_2"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('.single_cal3').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_3",
          onSelect: function ()
    {
        // The "this" keyword refers to the input (in this case: #someinput)
        this.focus();
    }
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          
        });
        $('#single_cal4').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <script type='text/javascript'>        
        //AJAX function
        function delete_product(contract_product_id,contract_id) {
            var sure=confirm('Are you sure?'); 
           if (contract_product_id && sure) {
            var form_data = {
               id:contract_product_id,
               contract_id:contract_id
            };
            $.ajax({
                url: "<?php echo $this->webroot; ?>contract_products/delete",
                type: 'POST',
                async: false,
                data: form_data,
                success: function(msg) {
                    $("#contractProductUpdate").html(msg);                  
                }
            });
           
        }
         return false;
        }        
    </script>
    <!-- delete lot product -->
     <script type='text/javascript'>        
        //AJAX function
        function delete_lot_product(lot_product_id=null,contract_no=null) {
            var sure=confirm('Are you sure?'); 
           if (lot_product_id && sure && contract_no) {
            var form_data = {
               id:lot_product_id,
               contract_no:contract_no
            };
            $.ajax({
                url: "<?php echo $this->webroot; ?>lot_products/delete",
                type: 'POST',
                async: false,
                data: form_data,
                success: function(msg) {
                    $("#lotProductUpdate").html(msg);                  
                }
            });
           
        }
         return false;
        }        
    </script>
    <!-- /delete lot product -->
    <!-- delete Procurement product -->
     <script type='text/javascript'>        
        //AJAX function
        function delete_procurement_product(id=null,contract_id=null,lot_id=null) {
            var sure=confirm('Are you sure?'); 
           if (id&&sure&&contract_id&&lot_id) {
            var form_data = {
               id:id,
               contract_id:contract_id,
               lot_id:lot_id
            };
            $.ajax({
                url: "<?php echo $this->webroot; ?>procurements/delete",
                type: 'POST',
                async: false,
                data: form_data,
                success: function(msg) {
                    $("#lotProductUpdate").html(msg);                  
                }
            });
           
        }
         return false;
        }        
    </script>
    <!-- /delete Procurement product -->
    <!-- delete Production product -->
     <script type='text/javascript'>        
        //AJAX function
        function delete_production_product(id=null,contract_id=null,lot_id=null) {
            var sure=confirm('Are you sure?'); 
           if (id&&sure&&contract_id&&lot_id) {
            var form_data = {
               id:id,
               contract_id:contract_id,
               lot_id:lot_id
            };
            $.ajax({
                url: "<?php echo $this->webroot; ?>productions/delete",
                type: 'POST',
                async: false,
                data: form_data,
                success: function(msg) {
                    $("#lotProductUpdate").html(msg);                  
                }
            });
           
        }
         return false;
        }        
    </script>
    <!-- /delete Production product -->
    <!-- delete Inspecion product -->
     <script type='text/javascript'>        
        //AJAX function
        function delete_inspection_product(id=null,contract_id=null,lot_id=null) {
            var sure=confirm('Are you sure?'); 
           if (id&&sure&&contract_id&&lot_id) {
            var form_data = {
               id:id,
               contract_id:contract_id,
               lot_id:lot_id
            };
            $.ajax({
                url: "<?php echo $this->webroot; ?>inspections/delete",
                type: 'POST',
                async: false,
                data: form_data,
                success: function(msg) {
                    $("#lotProductUpdate").html(msg);                  
                }
            });
           
        }
         return false;
        }        
    </script>
    <!-- /delete Inspection product -->
    
    <!-- delete delivery product -->
     <script type='text/javascript'>        
        //AJAX function
        function delete_delivery_product(id=null,contract_id=null,lot_id=null) {             
            var sure=confirm('Are you sure?'); 
           if (id&&sure&&contract_id&&lot_id) {
            var form_data = {
               id:id,
               contract_id:contract_id,
               lot_id:lot_id
            };
            $.ajax({
                url: "<?php echo $this->webroot; ?>deliveries/delete",
                type: 'POST',
                async: false,
                data: form_data,
                success: function(msg) {
                    $("#lotProductUpdate").html(msg);                  
                }
            });
           
        }
         return false;
        }        
    </script>
    <!-- /delete delivery product -->

    
    <script type="text/javascript">
    $(document).ready(function() {
        $("#product_id").bind('change', function() {
            $('#loading').show();
            var product_id = $("#product_id").val();
            var contract_id = $("#contract_id").val();
            var form_data = {
                contract_id:contract_id,
                product_id: product_id
            };
            $.ajax({
                url: "<?php echo $this->webroot; ?>contract_products/getContractProductInfo",
                type: 'POST',
                async: false,
                data: form_data,
                success: function(result) {
                    var data=result.split('%');
                    $('#uom').val(data[0]);
                    $('#unit_weight').val(data[1]);
                    $('#unit_price').val(data[2]);
                    $('#currency').val(data[3]);
                    $('#contract_quantity').val(data[4]);
                    $('#lot_quantity').val(data[5]);
                    $('#unit_weight_uom').val(data[6]);
                    //lot define
                     $('#reaming_quantity').val(data[4]-data[5]);
                    $('#quantity').focus();
                    $('#loading').hide();
                     
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#productCategoryId").bind('change', function() {
            $('#loading').show();
            var product_category_id = $("#productCategoryId").val();
            var contract_id = $("#contract_id").val();
            var form_data = {
                contract_id:contract_id,
                product_category_id: product_category_id
            };
            $.ajax({
                url: "<?php echo $this->webroot; ?>contract_products/getContractProductByCategory",
                type: 'POST',
                async: false,
                data: form_data,
                success: function(result) {                  
                    $("#product_id").html(result);
                    $('#loading').hide();                     
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#productCategoryId2").bind('change', function() {
            $('#loading').show();
            var product_category_id = $("#productCategoryId2").val();            
            var form_data = {                 
                product_category_id: product_category_id
            };
            $.ajax({
                url: "<?php echo $this->webroot; ?>products/product_by_category",
                type: 'POST',
                async: false,
                data: form_data,
                success: function(result) {                  
                    $("#product_id").html(result);
                    $('#loading').hide();                     
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {       
        $(".balance").keyup(function() {            
            var invoice_amount=parseInt( $("#invoice_amount").val());
           invoice_amount=(invoice_amount)?invoice_amount:0;
           
           var amount_received=parseInt( $("#amount_received").val());
           amount_received=(amount_received)?amount_received:0;
           
           var ait=parseInt( $("#ait").val());
           ait=(ait)?ait:0;
           
           var vat=parseInt( $("#vat").val());
           vat=(vat)?vat:0;
            var ld=parseInt( $("#ld").val());
           ld=(ld)?ld:0;
           var other_deduction=parseInt( $("#other_deduction").val());
           other_deduction=(other_deduction)?other_deduction:0;
           var balance=invoice_amount-(amount_received+ait+vat+ld+other_deduction);
           $("#balance").val(balance);
           
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {       
        $(".invoice_amount_receive").keyup(function() {  
            var id=$(this).attr( "id" ).split('_');
            var last=id.length;
            id=id[last-1];             
            var invoice_amount=parseInt( $("#invoice_amount_"+id).val());
            invoice_amount=(invoice_amount)?invoice_amount:0;
           
            var cheque_amount=parseInt( $("#cheque_amount_"+id).val());
            cheque_amount=(cheque_amount)?cheque_amount:0;
           
            var ait=parseInt( $("#ait_"+id).val());
            ait=(ait)?ait:0;
           
            var vat=parseInt( $("#vat_"+id).val());
            vat=(vat)?vat:0;
             var ld=parseInt( $("#ld_"+id).val());
            ld=(ld)?ld:0;
            var other_deduction=parseInt( $("#other_deduction_"+id).val());
            other_deduction=(other_deduction)?other_deduction:0;
            var balance=invoice_amount-(cheque_amount+ait+vat+ld+other_deduction);
            $("#balance_"+id).val(balance);
           
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {       
        $(".invoice_amount_receive1").keyup(function() {  
            var id=$(this).attr( "id" ).split('_');
            var last=id.length;
            id=id[last-1];             
            var invoice_amount=parseInt( $("#cheque_amount1_"+id).val());
            invoice_amount=(invoice_amount)?invoice_amount:0;
           
            var amount_received=parseInt( $("#amount_received_"+id).val());
            amount_received=(amount_received)?amount_received:0;
            
            
           
            var ait=parseInt( $("#ait1_"+id).val());
            ait=(ait)?ait:0;
           
            var vat=parseInt( $("#vat1_"+id).val());
            vat=(vat)?vat:0;
             var ld=parseInt( $("#ld1_"+id).val());
            ld=(ld)?ld:0;
            var other_deduction=parseInt( $("#other_deduction1_"+id).val());
            other_deduction=(other_deduction)?other_deduction:0;
            
            var balance=invoice_amount-(amount_received+ait+vat+ld+other_deduction);
            $("#balance1_"+id).val(balance);
           
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {       
        $(".progressive_payment").keyup(function() {            
            var unit_price=parseInt( $("#unit_price").val());
           unit_price=(unit_price)?unit_price:0;
           
           var quantity=parseInt( $("#quantity").val());
           quantity=(quantity)?quantity:0;
           
           var billing_percent=parseInt( $("#billing_percent").val());
           billing_percent=(billing_percent)?billing_percent:0;
           billing_amount=parseInt((quantity*unit_price*billing_percent)/100);
           $("#invoice_amount_temp").val(billing_amount);
           
        });
    });
</script>
<script tpye="text/javascript">              
   $(".actual_date_save").click(function(){      
       var id=$(this).attr("id" );
       var actual_date_update=$("#actual_date_update_"+id).val();
      // var actual_date_update_1=$("#actual_date_update_1_"+id).val();
       var checkDateFormat=(DatePicker_IsValidDate(actual_date_update));
       var url=$("#url").val();
       var contractID=$("#contractID").val();
       $("#message_"+id).html('Please Wait...');
       $(this).attr('disabled','disabled');
      
       if(actual_date_update&&id&&checkDateFormat){
                var form_data = {
                         id:id,
                         actual_date_update: actual_date_update,
                         contractID:contractID
                     };
                     $.ajax({
                         url: "<?php echo $this->webroot; ?>"+url,
                         type: 'POST',
                         async: false,
                         data: form_data,
                         success: function(result) {                           
                             $("#message_"+id).html(result); 
                             $(this).removeAttr('disabled');
                         }
                     });
            }else{
            alert('Wrong Date Format!.Please Try with Format(Y-m-d)');
            $("#actual_date_update_"+id).focus();
            $("#actual_date_update_"+id).css("border-color", "red");
            }
    
});
$(".actual_date_save_pli").click(function(){      
       var id=$(this).attr("id" );
       var actual_date_update=$("#actual_date_update_"+id).val();
       var actual_date_update_1=$("#actual_date_update_1_"+id).val();
       var pli_qty=$("#pli_qty_"+id).val();
      /* var pli_qty2=$("#pli_qty2_"+id).val();
       if(pli_qty2>pli_qty)
       {
         alert('Current PLI Qty is Less than Previous PLI Qty.Please Try Again');  
          $("#pli_qty_"+id).focus(); 
          $("#pli_qty_"+id).css("border-color", "red"); 
          $("#pli_qty_"+id).val(pli_qty2); 
            return false;   
       }*/
       var quantiy=$("#quantiy_"+id).val();
       
        if(parseInt(quantiy) < parseInt(pli_qty)) 
       {
          alert('Invalid PLI Qty.Please Try Again');  
          $("#pli_qty_"+id).focus(); 
          $("#pli_qty_"+id).css("border-color", "red"); 
            return false;
       }
      
       if(parseInt(pli_qty) <= 0 || isNaN(parseInt(pli_qty))) 
       {
          alert('Invalid PLI Qty.Please Try Again');  
          $("#pli_qty_"+id).focus(); 
          $("#pli_qty_"+id).css("border-color", "red"); 
            return false;
       }
       
       var rr_collection=$("#rr_collection").val();
       
       var checkDateFormat=(DatePicker_IsValidDate(actual_date_update));
       var checkDateFormat_1=(DatePicker_IsValidDate(actual_date_update_1));
       var url=$("#url").val();
       var contractID=$("#contractID").val();
       if(!checkDateFormat){
          alert('Wrong Date Format!.Please Try with Format(Y-m-d)');
            $("#actual_date_update_"+id).focus();  
            $("#actual_date_update_"+id).css("border-color", "red");
            return false;
       }
       else if(!checkDateFormat_1){
           alert('Wrong Date Format!.Please Try with Format(Y-m-d)');
            $("#actual_date_update_1_"+id).focus(); 
            $("#actual_date_update_1_"+id).css("border-color", "red");
            return false;
       }
       else if(!id){
           alert('Invalid Request.Please Try Again');
           return false;
       }
       else if(!url){
          alert('Invalid Path.Please Try Again');
           return false;  
       }
       $("#message_"+id).html('Please Wait...');
       $(this).attr('disabled','disabled');
      
       if(checkDateFormat&&checkDateFormat_1&&id){
                var form_data = {
                         id:id,
                         actual_date_update: actual_date_update,
                         contractID:contractID,
                         actual_date_update_1:actual_date_update_1,
                         rr_collection:rr_collection,
                         pli_qty:pli_qty
                     };
                     $.ajax({
                         url: "<?php echo $this->webroot; ?>"+url,
                         type: 'POST',
                         async: false,
                         data: form_data,
                         success: function(result) {                           
                             $("#message_"+id).html(result); 
                              $(this).attr('disabled',false);
                         }
                     });
            }else{
            alert('Invalid Request!.Please Try Again');
             return false;
            }
    
});
function DatePicker_IsValidDate(input) {
        var bits = input.split('-');
        var d = new Date(bits[0], bits[1] - 1, bits[2]);
        return d.getFullYear() == bits[0] && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[2]);
}

$(document).ready(function() {
    $(".numeric_number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
 </script>
 
 <script type="text/javascript">
    $(document).ready(function() {
        $(".saveChequeDate").click(function() {  
            var id = $(this).attr('id').split("_"); 
            id=id[1];
            var contractID = $("#contractID").val();
            
            var actual_payment_certificate_or_cheque_collection_date=$("#actual_payment_certificate_or_cheque_collection_date_"+id).val();            
            var forecasted_payment_collection_date = $("#forecasted_payment_collection_date_"+id).val();
            var cheque_or_payment_certification_date = $("#cheque_or_payment_certification_date_"+id).val();
            
            var cheque_amount = $("#cheque_amount_"+id).val();              
            var ait = $("#ait_"+id).val();
            var vat = $("#vat_"+id).val();
            var ld = $("#ld_"+id).val();
            var ajust_adv_amount= $("#ajust_adv_amount_"+id).val();
            var other_deduction = $("#other_deduction_"+id).val();
        if(!id){
               alert('Invalid Request');
                return false;
        } /*   
        else if(!DatePicker_IsValidDate(actual_payment_certificate_or_cheque_collection_date))
            {
                alert('Worng:Date Format.Please Trye(Y-m-d)');
                $("#actual_payment_certificate_or_cheque_collection_date").focus();
                return false;
            }*/
             else if(!DatePicker_IsValidDate(forecasted_payment_collection_date))
            {
                alert('Worng:Date Format.Please Trye(Y-m-d)');
                $("#forecasted_payment_collection_date").focus();
                return false;
            }
           /*  else if(!DatePicker_IsValidDate(cheque_or_payment_certification_date))
            {
                alert('Worng:Date Format.Please Trye(Y-m-d)');
                $("#cheque_or_payment_certification_date").focus();
                return false;
            }
             */
            var form_data = {
                id:id,
                cheque_amount:cheque_amount,
                ait:ait,
                vat:vat,
                ld:ld,
                ajust_adv_amount:ajust_adv_amount,
                other_deduction:other_deduction,
                actual_payment_certificate_or_cheque_collection_date:actual_payment_certificate_or_cheque_collection_date,
                forecasted_payment_collection_date: forecasted_payment_collection_date,
                cheque_or_payment_certification_date:cheque_or_payment_certification_date
            };
            $.ajax({
                url: "<?php echo $this->webroot; ?>collections/cheque_date/",
                type: 'POST',
                async: false,
                data: form_data,
                success: function(result) {
                    $('.bs-example-modal-lg_cheque_'+id).modal('toggle');
                    window.location.href = "<?php echo $this->webroot; ?>collections/index/"+contractID;
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".savePaymentDate").click(function() {            
            var id = $(this).attr('id').split("_"); 
            id=id[1];
             var contractID = $("#contractID").val();
             
            var payment_credited_to_bank_date=$("#payment_credited_to_bank_date_"+id).val();   
            
            var amount_received = $("#amount_received_"+id).val();
            var ait = $("#ait1_"+id).val();
            var vat = $("#vat1_"+id).val();
            var ld = $("#ld1_"+id).val();
            var ajust_adv_amount= $("#ajust_adv_amount1_"+id).val();
            var other_deduction = $("#other_deduction1_"+id).val();
            
           
        if(!id){
               alert('Invalid Request');
                return false;
        }    
        else if(!DatePicker_IsValidDate(payment_credited_to_bank_date))
            {
                alert('Worng:Date Format.Please Trye(Y-m-d)');
                $("#payment_credited_to_bank_date").focus();
                return false;
            }
            else if(!amount_received)
            {
                alert('Amount Receive Filed is Required!');
                $("#amount_received").focus();
                return false;
            }
            
            var form_data = {
                id:id,
                ait:ait,
                vat:vat,
                ld:ld,
                ajust_adv_amount:ajust_adv_amount,
                other_deduction:other_deduction,
                payment_credited_to_bank_date:payment_credited_to_bank_date,
                amount_received: amount_received
                
            };
            $.ajax({
                url: "<?php echo $this->webroot; ?>collections/bank_credit_date/",
                type: 'POST',
                async: false,
                data: form_data,
                success: function(result) {
                    $('.bs-example-modal-lg_payment_'+id).modal('toggle');                      
                    window.location.href = "<?php echo $this->webroot; ?>collections/index/"+contractID;
                }
            });
        });
    });
</script>
<!-- min and max value allow -->
<script type="text/javascript">
function minmax(value, min, max) 
{
    if(parseInt(Math.ceil(value)) < min || isNaN(value)) {
        alert('Input Qty is Less than Balance Qty');
        return ''; }
    else if(parseInt(Math.ceil(value)) > max) {
        alert('Input Qty is greater than Balance Qty');
        return ''; }
    else if(parseInt(value) <=0)
        return '';
    else return value;
}
</script>
<!-- /min and max value allow -->
<!--Delete Product -->
<script tpye="text/javascript">              
   $(".product_delete").click(function(){    
        var row=$(this).attr('id');
           row=row.split("_");
        var indent=row[0];
        var id=row[1];
        var url=row[2];
        if(!indent||!id||!url)
        {
            alert('There is a problem while executing your request?,Please try Again.');
            return false;
        }         
        if(confirm('Are you sure you want to delete?'))
        {
            var form_data = {
                        id: id
                    };
            $.ajax({
                    url:"<?php echo $this->webroot; ?>"+url+"/delete/",
                    type: 'POST',
                    async: false,
                    data: form_data,
                    success: function(msg) {
                        if(msg=="1")
                        {
                        $("tr#tr_" +id).fadeOut();
                        }
                        else{
                            alert('There is a problem while executing your request!');
                        }
                        return false;
                    }
                });
        }
       return false;
});
</script>
<script type="text/javascript">
$(document).ready(function(){
        $('form').on('submit', function () {
         $('.disabled_btn').prop('disabled', true);
         });
});
</script>

<script tpye="text/javascript">              
   $("#saveAllActualDate").click(function(){
       var id=$("#update_id").val();
       var value=$("#update_id").val().split('-');   
       var url=$("#url_all").val();
       var contract_id=$("#contractID").val();
       if(!contract_id)
       {
         alert('Invalid Contract ID');            
         return false; 
       }
       output="[";
       $.each( value, function( key, row_id ) {
       var actual_date_update=$("#actual_date_update_"+row_id).val();       
       var checkDateFormat=(DatePicker_IsValidDate(actual_date_update));    
       if(!checkDateFormat)
       {
           alert('Invalid Date Formate');
           $("#actual_date_update_"+row_id).focus();
           $("#actual_date_update_"+row_id).css("border-color","red");
           return false;
       }
      if(output!="[")
      {
          output+=",";
      }
      output+='{ "id":"'+row_id+'" , "actual_date":"'+actual_date_update+'","contract_id":"'+contract_id+'" }';
        
});
output+="]";
$(this).attr('disabled',true);
//$("#showActualDateMessage").fadeOut(); 
if(!confirm('Are you sure you want to save?'))
{
    $(this).removeAttr('disabled');
    return false;
}
$.ajax({
    url: "<?php echo $this->webroot; ?>"+url,
    type: 'POST',
    data:output,
    contentType: 'application/json; charset=utf-8',
    dataType: 'json',
    async: false,
    success: function(data) {
      if(data==1||data==2){
          $("#showActualDateMessage").fadeIn(); 
          $(this).removeAttr('saveAllActualDate',true);
      }          
    }
});
});
 </script>
 
 <script tpye="text/javascript">              
   $("#saveAllActualDatePLI").click(function(){
       var id=$("#update_id").val();
       var value=$("#update_id").val().split('-');   
        var url=$("#url_all").val();
       output="[";
       $.each( value, function( key, row_id ) {
       var pli_qty=$("#pli_qty_"+row_id).val(); 
       if(pli_qty>0)
       {
       var actual_date_update=$("#actual_date_update_"+row_id).val();       
       var checkDateFormat=(DatePicker_IsValidDate(actual_date_update));    
       if(!checkDateFormat)
       {
           alert('Invalid Date Formate');
           $("#actual_date_update_"+row_id).focus();
           $("#actual_date_update_"+row_id).css("border-color","red");
           return false;
       }
       var actual_date_update1=$("#actual_date_update_1_"+row_id).val();       
       var checkDateFormat=(DatePicker_IsValidDate(actual_date_update1));    
       if(!checkDateFormat)
       {
           alert('Invalid Date Formate');
           $("#actual_date_update_1_"+row_id).focus();
           $("#actual_date_update_1_"+row_id).css("border-color","red");
           return false;
       }
       
        var pli_qty=$("#pli_qty_"+row_id).val();
        var pli_qty_already=$("#pli_qty_already_"+row_id).val();
      
       var quantiy=$("#quantiy_"+row_id).val();
      
       var total=parseInt(pli_qty)+parseInt(pli_qty_already);
        
       
        if(quantiy < total) 
       {
          alert('1.Invalid PLI Qty.Please Try Again');  
          $("#pli_qty_"+row_id).focus(); 
          $("#pli_qty_"+row_id).css("border-color", "red"); 
            return false;
       }
      
       if(actual_date_update&&actual_date_update1&&(parseInt(pli_qty) <= 0 || isNaN(parseInt(pli_qty)))) 
       {
          alert('2.Invalid PLI Qty.Please Try Again');  
          $("#pli_qty_"+row_id).focus(); 
          $("#pli_qty_"+row_id).css("border-color", "red"); 
            return false;
       }
       
       var rr_collection=$("#rr_collection").val();

       
       
      if(output!="[")
      {
          output+=",";
      }
      output+='{ "id":"'+row_id+'" , "actual_date":"'+actual_date_update+'", "actual_date_1":"'+actual_date_update1+'", "pli_qty":"'+pli_qty+'","pli_qty_already":"'+pli_qty_already+'", "rr_collection":"'+rr_collection+'" }';
  }    
});
output+="]";
$(this).attr('disabled',true);
//$("#showActualDateMessage").fadeOut(); 
 if(!confirm('Are you sure you want to save?'))
{
    $(this).removeAttr('disabled');
    return false;
}
$.ajax({
    url: "<?php echo $this->webroot; ?>"+url,
    type: 'POST',
    data:output,
    contentType: 'application/json; charset=utf-8',
    dataType: 'json',
    async: false,
    success: function(data) {
      if(data==1||data==2){
          $(this).removeAttr('disabled',true);
          $("#showActualDateMessage").fadeIn(); 
           location.reload();
       }
    }
});
});
 </script>
 <script type="text/javascript">
    $(document).ready(function() {
        $(".balance_calculation").keyup(function() {

            var netbalance = parseInt($("#netbalance").val());
            netbalance = (netbalance) ? netbalance : 0;
             
             var other_deduction = parseInt($("#other_deduction").val());
            other_deduction = (other_deduction) ? other_deduction : 0;
            
            var ld = parseInt($("#ld").val());
            ld = (ld) ? ld : 0;
            
            var vat = parseInt($("#vat").val());
            vat = (vat) ? vat : 0;
            
            var ait = parseInt($("#ait").val());
            ait = (ait) ? ait : 0;
            
            var received_amount = parseInt($("#received_amount").val());
            received_amount = (received_amount) ? received_amount : 0;             
            var balance = netbalance - (other_deduction+ld+vat+ait+received_amount);
            $("#balance").val(balance);
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {    
        
        $(".check_net_balance").bind('change', function() {
             
            var netBalance=parseInt( $("#netBalance").val());
           netBalance=(netBalance)?netBalance:0;
           
           var amount_received=parseInt( $("#received_amount").val());
           amount_received=(amount_received)?amount_received:0;
           
           var ait=parseInt( $("#ait").val());
           ait=(ait)?ait:0;
           
           var vat=parseInt( $("#vat").val());
           vat=(vat)?vat:0;
            var ld=parseInt( $("#ld").val());
           ld=(ld)?ld:0;
           var other_deduction=parseInt( $("#other_deduction").val());
           other_deduction=(other_deduction)?other_deduction:0;
           var balance=netBalance-(amount_received+ait+vat+ld+other_deduction);
           if(balance<0){
               alert("Given amount is greater than depostion amount that client!");
               location = location
               location = location.href
           }
           
        });
    });
</script>
<script tpye="text/javascript"> 
 $(document).ready(function() {    
        $("input").attr('autocomplete', 'off');   
});
 </script>  
<!-- /Delete Product -->
    <!-- Js writeBuffer -->
<?php
if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer();
// Writes cached scripts
?>
    <?php //echo $this->element('sql_dump'); ?>
    </body>
</html>