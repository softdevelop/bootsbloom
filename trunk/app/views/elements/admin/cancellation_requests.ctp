<div id="ajaxpanel">
    <?php
        echo $this->Form->create($model, array('name' => 'AdminsOperateForm', 'action' => 'operate', 'id' => 'AdminsOperateForm'));
        echo $form->hidden('operation', array('value' => '', 'id' => 'AdminsOperation'));
        $sortKey = $paginator->sortKey();
        $sortDir = $paginator->sortDir();
    ?>
    <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
            <tr class="ui-widget-header ui-corner-all" style="height:30px;">
                <td align="left"><?php echo $paginator->sort('Project Title', 'title'); ?><span <?php if ($sortKey == "Project.title") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
                <td align="left"><?php echo $paginator->sort('Short Descrition', 'end_date'); ?><span <?php if ($sortKey == "Project.end_date") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>                
                <td align="left"><?php echo $paginator->sort('Owner', 'User_id'); ?><span <?php if ($sortKey == "Project.user_id") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
                <td align="left"><?php echo $paginator->sort('Category', 'category_id'); ?><span <?php if ($sortKey == "Project.category_id") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
                <td align="left"><?php echo $paginator->sort('End Date', 'created'); ?><span <?php if ($sortKey == "Project.created") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
                <td align="center"><?php echo $paginator->sort('Status', 'active'); ?><span <?php if ($sortKey == "Partner.active") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
            </tr>
            <?php
            if (count($result) > 0) {
                $i = 0;
                $class = 'odd_row';
                foreach ($result as $records) {
                    // pr($records);
                    $class = (($i + 1) % 2 == 0) ? 'even_row' : 'odd_row';
                    ?>
                    <tr class="<?php echo $class; ?>" id="row_<?php echo $records[$model]['id']; ?>">

                        <td width="30%" valign="top">
                            <?php echo $records['Project']['title']; ?>

                            <div id="action_row_<?php echo $records[$model]['id']; ?>" style="visibility:hidden;" class="action_row">
                                <?php
                                 echo $this->Html->link('Cancel Project', array('action' => 'cancel_project', $records[$model]['id'], $records['Project']['id']), array('title' => 'Cancel Peoject', 'class' => 'vtip'), 'Are you sure you want to cancel project?');
                                /*if ($records['Project']['project_end_date'] > time() || $records['Project']['active'] != 1) {
                                    echo $this->Html->link('Edit', array('plugin' => false, 'controller' => 'projects', 'action' => 'edit', $records['Project']['id']), array('title' => 'Edit Project', 'class' => 'vtip'));
                                    echo '&nbsp;|&nbsp';
                                }
                                if ($records['Project']['is_successful'] != 1) {
                                    if ($records['Project']['active'] == '2') {
                                        echo $this->Html->link('Approve', array('action' => 'change_project_status', $records['Project']['active'], $records['Project']['id']), array('title' => 'change project status to approved', 'class' => 'vtip'), 'Are you sure you want to change project status ?');
                                    } else
                                    if ($records['Project']['active'] == '1') {
                                        echo $this->Html->link('Unapprove', array('action' => 'change_project_status', $records['Project']['active'], $records['Project']['id']), array('title' => 'change project status to unapproved', 'class' => 'vtip'), 'Are you sure you want to change project status ?');
                                    } else {
                                        echo $this->Html->link('Approve', array('action' => 'change_project_status', $records['Project']['active'], $records['Project']['id']), array('title' => 'change project status to approved', 'class' => 'vtip'), 'Are you sure you want to change project status ?');
                                    }
                                    echo '&nbsp;|&nbsp;';
                                }
                                if ($records[$model]['is_successful'] == 1) {
                                    echo $this->Html->link('View Payment Info', array('plugin' => false, 'controller' => 'projects', 'action' => 'payment_info', $records['Project']['id']), array('title' => 'view payment info', 'class' => 'vtip'));
                                    echo '&nbsp;|&nbsp;';
                                }
                                ?>
                                <?php echo $this->Html->link('View Details', WEBSITE_FRONT_URL . 'projects/detail/' . $records['Project']['User']['slug'] . '/' . $records['Project']['slug'] . '?ref_by=admin', array('class' => 'vtip', 'title' => 'Project with details', 'target' => '_blank')) ?> 
                                <?php if ($records[$model]['active'] == 1) { ?>
                                    &nbsp;|&nbsp;
                                    <?php echo $this->Html->link('Backers', array('action' => 'project_backer_detail', $records['Project']['id']), array('title' => 'View the backer list of this project', 'class' => 'vtip'));
                                } ?>
                                <?php if ($records[$model]['is_recommended'] == 0) { ?>
                                    &nbsp;|&nbsp;
                                    <?php echo $this->Html->link('Set Recommended', array('action' => 'set_recommended', $records['Project']['id'], !$records['Project']['is_recommended']), array('title' => 'Set this project as Recommended', 'class' => 'vtip'), 'Are you sure you want to set this project as Recommended?');
                                } else { ?>
                                    &nbsp;|&nbsp;
                                    <?php echo $this->Html->link('Remove Recommended', array('action' => 'set_recommended', $records['Project']['id'], !$records['Project']['is_recommended']), array('title' => 'Set this project as Recommended', 'class' => 'vtip'), 'Are you sure you want to remove from Recommended?');
                                }*/ ?>
                            </div>
                        </td>
                        <td width="25%" valign="top"><?php echo ucfirst(substr($records['Project']['short_description'], 0, 80)); ?></td>
                        <td width="15%" valign="top" align="left"><?php echo $records['Project']['User']['name']; ?></td>
                        <td width="15%" valign="top" align="left"><?php echo $records['Project']['Category']['category_name']; ?></td>
                        <?php
                        if ($records['Project']['no_of_day'] != null) {
                            $date1 = date("Y-m-d", $records['Project']['created']);
                            $date = strtotime(date("Y-m-d", strtotime($date1)) . "+" . $records['Project']['no_of_day'] . "days");
                        } else {
                            $date = $records['Project']['end_date'];
                        }
                        ?>
                        <td width="12%" valign="top"><?php echo date('M, d Y', $records['Project']['project_end_date']); ?></td>
                        <td width="5%" valign="top" align="center">
                            <?php
                            if ($records['Project']['active'] == '1') {
                                echo $html->image('active.png', array('border' => '0', 'alt' => 'Active Page'));
                            } else
                            if ($records['Project']['active'] == '2') {
                                echo $html->image('inactive.png', array('border' => '0', 'alt' => 'Inactive Page'));
                            } else {
                                echo $html->image('admin/pending.png', array('border' => '0', 'alt' => 'pending Page'));
                            }
                            ?>
                        </td>
                    </tr>
                    <?php $i++;
                } ?>
                <tr>
                    <td colspan="8"><div class="ochead"></div></td>
                </tr>	
                <tr class="odd_row">
                    <td class="td-listing" colspan="8" align="right"><?php echo $this->element('admin/pagination'); ?></td>
                </tr>	
                <?php
            } else {
                ?>
                <tr class="odd_row"><td colspan="8" align="center">No record  found!</td></tr>
            <?php } ?>		   
        </table>
    </div>
    <?php echo $this->Form->end(); ?>
</div>