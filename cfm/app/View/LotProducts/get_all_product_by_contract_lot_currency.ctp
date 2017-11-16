<option value=""></option>
<?php foreach ($products as $key => $value): ?>
<option value="<?php echo $value['cp']['id']; ?>"><?php echo $value[0]['name']; ?></option>
<?php endforeach; ?>