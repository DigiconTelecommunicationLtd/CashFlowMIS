<!--<option value=""></option>-->
<option value="">choose a product</option>
<?php foreach ($product_categories as $key => $value): ?>
<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php endforeach; ?>