<?php foreach ($contract_products as $value):?>
<option value="<?php echo $value['Product']['id'];?>"><?php echo $value['Product']['name'];?></option>
<?php endforeach; ?>


