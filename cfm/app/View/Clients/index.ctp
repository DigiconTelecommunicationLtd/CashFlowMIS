<div class="x_panel">
    <div class="x_title">
        <h2>Client List:</h2>
        <ul class="nav navbar-right panel_toolbox">                      
            <li><a href="<?php echo $this->Html->url('/clients/add/'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact Person</th>
                    <th>Designation</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Added By</th>
                    <th>Added Date</th>
                    <th>Modified By</th>
                    <th>Modified Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?php echo h($client['Client']['name']); ?>&nbsp;</td>
                        <td><?php echo h($client['Client']['contact_person']); ?>&nbsp;</td>
                        <td><?php echo h($client['Client']['contact_person_designation']); ?>&nbsp;</td>
                        <td><?php echo h($client['Client']['phone']); ?>&nbsp;</td>
                        <td><?php echo h($client['Client']['email']); ?>&nbsp;</td>
                        <td><?php echo h($client['Client']['address']); ?>&nbsp;</td>
                        <td><?php echo h($client['Client']['added_by']); ?>&nbsp;</td>
                        <td><?php echo h($client['Client']['added_date']); ?>&nbsp;</td>
                        <td><?php echo h($client['Client']['modified_by']); ?>&nbsp;</td>
                        <td><?php echo ($client['Client']['modified_date']!="0000-00-00 00:00:00")?h($client['Client']['modified_date']):'N/A'; ?>&nbsp;</td>
                        <td class="actions">
                            <a href="<?php echo $this->Html->url('/clients/edit/' . $client['Client']['id']); ?>"><i class="fa fa-edit">EDIT</i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
