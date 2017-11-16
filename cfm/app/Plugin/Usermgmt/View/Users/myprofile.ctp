<div class="x_panel">
    <div class="x_title">
        <span class="fa fa-user">&nbsp;<strong>Profile:</strong></span>
        <ul class="nav navbar-right panel_toolbox">
            <li><a href="<?php echo $this->Html->url('/dashboard/'); ?>" class="btn btn-primary"><i class="fa fa-dashboard"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <tbody>
                <?php if (!empty($user)) { ?>

                    <tr>
                        <td><strong><?php echo __('User Group'); ?></strong></td>
                        <td><?php echo h($user['UserGroup']['name']) ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Username'); ?></strong></td>
                        <td><?php echo h($user['User']['username']) ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('First Name'); ?></strong></td>
                        <td><?php echo h($user['User']['first_name']) ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Last Name'); ?></strong></td>
                        <td><?php echo h($user['User']['last_name']) ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Email'); ?></strong></td>
                        <td><?php echo h($user['User']['email']) ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Email Verified'); ?></strong></td>
                        <td><?php
                            if ($user['User']['email_verified']) {
                                echo 'Yes';
                            } else {
                                echo 'No';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Status'); ?></strong></td>
                        <td><?php
                            if ($user['User']['active']) {
                                echo 'Active';
                            } else {
                                echo 'Inactive';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Created'); ?></strong></td>
                        <td><?php echo date('d-M-Y', strtotime($user['User']['created'])) ?></td>
                    </tr>
                    <?php
                } else {
                    echo "<tr><td colspan=2><br/><br/>No Data</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


