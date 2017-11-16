<div class="x_panel">
    <div class="x_title">
        <h2>Product/Category List:</h2>
        <ul class="nav navbar-right panel_toolbox">                      
            <li><a href="<?php echo $this->Html->url('/product_categories/add/'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productCategories as $productCategory): ?>
                    <tr>
                        <td><?php echo h($productCategory['ProductCategory']['name']); ?>&nbsp;</td>                       
                        <td class="actions">
                            <a href="<?php echo $this->Html->url('/product_categories/edit/' . $productCategory['ProductCategory']['id']); ?>"><i class="fa fa-edit">EDIT</i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

