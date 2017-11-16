<div class="x_panel">
    <div class="x_title">
        <span class="fa fa-user">&nbsp;<strong>List:</strong></span>
        <ul class="nav navbar-right panel_toolbox">
            <li><a href="<?php echo $this->Html->url('/addUser/'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>                     
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Group</th>
                    <th>Email Verified</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($users as $row) { 
                        echo "<tr>";                       
                        echo "<td>" . h($row['User']['first_name']) . " " . h($row['User']['last_name']) . "</td>";
                        echo "<td>" . h($row['User']['username']) . "</td>";
                        echo "<td>" . h($row['User']['email']) . "</td>";
                        echo "<td>" . h($row['UserGroup']['name']) . "</td>";
                        echo "<td>";
                        if ($row['User']['email_verified'] == 1) {
                            echo "Yes";
                        } else {
                            echo "No";
                        }
                        echo"</td>";
                        echo "<td>";
                        if ($row['User']['active'] == 1) {
                            echo "Active";
                        } else {
                            echo "Inactive";
                        }
                        echo"</td>";
                        echo "<td>" . date('d-M-Y', strtotime($row['User']['created'])) . "</td>";
                        echo "<td>";
                        echo "<span class='icon'><a href='" . $this->Html->url('/viewUser/' . $row['User'] ['id']) . "'><img src='" . SITE_URL . "usermgmt/img/view.png' border='0' alt='View' title='View'></a></span>";
                        echo "&nbsp&nbsp&nbsp" . "<span class='icon'><a href='" . $this->Html->url('/editUser/' . $row['User']['id']) . "'><img src='" . SITE_URL . "usermgmt/img/edit.png' border='0' alt='Edit' title='Edit'></a></span>";
                        echo "&nbsp&nbsp&nbsp" . "<span class='icon'><a href='" . $this->Html->url('/changeUserPassword/' . $row['User']['id']) . "'><img src='" . SITE_URL . "usermgmt/img/password.png' border='0' alt='Change Password' title='Change Password'></a></span>";
                        if ($row['User']['email_verified'] == 0) {
                            echo "<span class='icon'><a href='" . $this->Html->url('/usermgmt/users/verifyEmail/' . $row['User']['id']) . "'><img src='" . SITE_URL . "usermgmt/img/email-verify.png' border='0' alt='Verify Email' title='Verify Email'></a></span>";
                        }
                        if ($row['User']['active'] == 0) {
                            echo "<span class='icon'><a href='" . $this->Html->url('/usermgmt/users/makeActiveInactive/' . $row['User']['id'] . '/1') . "'><img src='" . SITE_URL . "usermgmt/img/dis-approve.png' border='0' alt='Make Active' title='Make Active'></a></span>";
                        } else {
                            echo "&nbsp&nbsp&nbsp" . "<span class='icon'><a href='" . $this->Html->url('/usermgmt/users/makeActiveInactive/' . $row['User']['id'] . '/0') . "'><img src='" . SITE_URL . "usermgmt/img/approve.png' border='0' alt='Make Inactive' title='Make Inactive'></a></span>";
                        }
                        if ($row['User']['id'] != 1 && $row['User']['username'] != 'Admin') {
                            echo "&nbsp&nbsp&nbsp" . $this->Form->postLink($this->Html->image(SITE_URL . 'usermgmt/img/delete.png', array("alt" => __('Delete'), "title" => __('Delete'))), array('action' => 'deleteUser', $row['User']['id']), array('escape' => false, 'confirm' => __('Are you sure you want to delete this user?')));
                        }
                        echo "</td>";
                        echo "</tr>";
                    }                  
                ?>        

            </tbody>
        </table>
    </div>
</div>

