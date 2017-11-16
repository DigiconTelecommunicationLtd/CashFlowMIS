<div class="x_panel">
    <div class="x_title">
        <span class="fa fa-user">&nbsp;<strong>Group List:</strong></span>
        <ul class="nav navbar-right panel_toolbox">
            <li><a href="<?php echo $this->Html->url('/addGroup/'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>                     
                    <th>Group Name</th>
                    <th>Display Name</th>
                    <th>Added Date</th>
                    <th>Modified Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($userGroups)):
                    foreach ($userGroups as $row):
                        ?>
                        <tr>
                            <td><?php echo $row['UserGroup']['name']; ?></td>
                            <td><?php echo $row['UserGroup']['alias_name']; ?></td>
                            <td><?php echo date('d-M-Y', strtotime($row['UserGroup']['created'])); ?></td>
                            <td><?php echo date('d-M-Y', strtotime($row['UserGroup']['modified'])); ?></td>
                            <td>
                                <a href="<?php echo $this->Html->url('/editGroup/' . $row['UserGroup']['id']); ?>"><span class='fa fa-edit'></span></a>&nbsp;
                                    <?php
                                    if ($row['UserGroup']['id'] != 1) {
                                        echo $this->Form->postLink($this->Html->image(SITE_URL . 'usermgmt/img/delete.png', array("alt" => __('Delete'), "title" => __('Delete'))), array('action' => 'deleteGroup', $row['UserGroup']['id']), array('escape' => false, 'confirm' => __('Are you sure you want to delete this group? Delete it your own risk')));
                                    }
                                    ?>
                            </td>                          
                        </tr>
                        <?php
                    endforeach;
                else:
                    ?>
                    <tr>
                        <td colspan="6">No Result Found!.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
