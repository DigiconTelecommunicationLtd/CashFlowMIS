<div class="x_panel">
    <div class="x_title">
        <h2>Product List:</h2>
        <ul class="nav navbar-right panel_toolbox">                      
            <li><a href="<?php echo $this->Html->url('/products/add/'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Added By</th>
                    <th>Added Date</th>
                    <th>Modified By</th>
                    <th>Modified Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product):?>
                    <tr>                        
                        <td><?php echo $product['Product']['name']; ?>&nbsp;</td>
                        <td><?php echo $product['ProductCategory']['name']; ?>&nbsp;</td>
                        <td><?php echo h($product['Product']['added_by']); ?>&nbsp;</td>
                        <td><?php echo h($product['Product']['added_date']); ?>&nbsp;</td>
                        <td><?php echo h($product['Product']['modified_by']); ?>&nbsp;</td>
                        <td><?php echo h($product['Product']['modified_date']!="0000-00-00 00:00:00")?$product['Product']['modified_date']:"N/A"; ?>&nbsp;</td>                       
                        <td class="actions">
                            <a href="<?php echo $this->Html->url('/products/edit/' . $product['Product']['id']); ?>"><i class="fa fa-edit">EDIT</i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


