<?php echo $this->Html->script('/usermgmt/js/umupdate'); ?>
<div class="x_panel">
    <div class="x_content">
        <table  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Module List</th>
                    <th><?php echo $this->Form->input("controller", array('type' => 'select', 'div' => false, 'options' => $allControllers, 'selected' => $c, 'label' => false, 'class' => "form-control", "onchange" => "window.location='" . SITE_URL . "permissions/?c='+(this).value")) ?> </th>
                </tr>
            </thead>
            </tbody>
        </table>
        <table  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <?php if (!empty($controllers)) { ?>
                <input type="hidden" id="BASE_URL" value="<?php echo SITE_URL ?>">
                <input type="hidden" id="groups" value="<?php echo $groups ?>">
                <thead>
                    <tr>
                        <th>Module Name</th>
                        <th>Action/Permission</th>
                        <th>User Group</th>
                        <th>Operation</th>
                    </tr>
                </thead>   
                <tbody>
                    <?php
                    $k = 1;
                    foreach ($controllers as $key => $value) {
                        if (!empty($value)) {
                            for ($i = 0; $i < count($value); $i++) {
                                if (isset($value[$i])) {
                                    $action = $value[$i];
                                    echo $this->Form->create();
                                    echo $this->Form->hidden('controller', array('id' => 'controller' . $k, 'value' => $key));
                                    echo $this->Form->hidden('action', array('id' => 'action' . $k, 'value' => $action));
                                    echo "<tr>";
                                    echo "<td>" . $key . "</td>";
                                    echo "<td>" . $action . "</td>";
                                    echo "<td>";
                                    foreach ($user_groups as $user_group) {
                                        $ugname = $user_group['name'];
                                        $ugname_alias = $user_group['alias_name'];
                                        if (isset($value[$action][$ugname_alias]) && $value[$action][$ugname_alias] == 1) {
                                            $checked = true;
                                        } else {
                                            $checked = false;
                                        }
                                        echo $this->Form->input($ugname, array('id' => $ugname_alias . $k, 'type' => 'checkbox', 'checked' => $checked));
                                    }
                                    echo "</td>";
                                    echo "<td>";
                                    echo $this->Form->button('Update', array('type' => 'button', 'id' => 'mybutton123', 'name' => $k, 'onClick' => 'javascript:update_fields(' . $k . ');', 'class' => 'umbtn'));
                                    echo "<div id='updateDiv" . $k . "' align='right' class='updateDiv'>&nbsp;</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                    echo $this->Form->end();
                                    $k++;
                                }
                            }
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>  