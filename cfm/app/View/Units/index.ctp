<div class="x_panel">
    <div class="x_title">
        <h2>Company/Unit List:</h2>
        <ul class="nav navbar-right panel_toolbox">                      
            <li><a href="<?php echo $this->Html->url('/units/add/'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
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
                <?php foreach ($units as $unit): ?>
                    <tr>
                        <td><?php echo h($unit['Unit']['name']); ?>&nbsp;</td>                       
                        <td class="actions">
                            <a href="<?php echo $this->Html->url('/units/edit/' . $unit['Unit']['id']); ?>"><i class="fa fa-edit">EDIT</i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
