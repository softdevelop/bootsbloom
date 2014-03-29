<div id="ajaxpanel">
    <?php
    $group_id = $this->Session->read('Auth.admin.group_id'); 
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
                foreach ($result as $records) { //pr($records);

                    $class = (($i + 1) % 2 == 0) ? 'even_row' : 'odd_row';
                    ?>
                    <tr class="<?php echo $class; ?>" id="row_<?php echo $records[$model]['id']; ?>">

                        <td width="30%" valign="top">
                            <?php echo $records[$model]['title']; ?>

                            <div id="action_row_<?php echo $records[$model]['id']; ?>" style="visibility:hidden;" class="action_row">
                                <?php
                                if ($records[$model]['project_end_date'] > time() || $records[$model]['active'] != 1) {
                                    echo $this->Html->link('Edit', array('plugin' => false, 'controller' => 'projects', 'action' => 'edit', $records[$model]['id']), array('title' => 'Edit Project', 'class' => 'vtip'));
                                    
                                }
                                if ($records[$model]['is_successful'] != 1) {
                                    if ($records[$model]['active'] == '2'|| $records[$model]['active'] == '0' ) {
                                      echo '&nbsp;|&nbsp';  echo $this->Html->link('Approve', array('action' => 'change_project_status', $records[$model]['active'], $records[$model]['id']), array('title' => 'change project status to approved', 'class' => 'vtip'), 'Are you sure you want to change project status ?');
                                    }
                                    if ($records[$model]['active'] == '0') {
                                        echo '&nbsp;|&nbsp;';
                                        echo $this->Html->link('Unapprove', array('action' => 'change_project_status', 1, $records[$model]['id']), array('title' => 'change project status to unapproved', 'class' => 'vtip'), 'Are you sure you want to change project status ?');
                                    }
                                }
								
                                if ($records[$model]['is_successful'] == 1) {
                                    echo $this->Html->link('View Payment Info', array('plugin' => false, 'controller' => 'projects', 'action' => 'payment_info', $records[$model]['id']), array('title' => 'view payment info', 'class' => 'vtip'));
                                    echo '&nbsp;|&nbsp;';
                                }
								
								
                                ?>
                                <?php echo '&nbsp;|&nbsp'; echo $this->Html->link('View Details', WEBSITE_FRONT_URL . 'projects/detail/' . $records['User']['slug'] . '/' . $records[$model]['slug'] . '?ref_by=admin', array('class' => 'vtip', 'title' => 'Project with details', 'target' => '_blank')) ?> 
                                <?php if ($records[$model]['active'] == 1) { ?>
                                    &nbsp;|&nbsp;
                                    <?php echo $this->Html->link('Backers', array('action' => 'project_backer_detail', $records['Project']['id']), array('title' => 'View the backer list of this project', 'class' => 'vtip'));
                                } ?>
                                <?php if ($records[$model]['is_recommended'] == 0) { ?>
                                    &nbsp;|&nbsp;
                                    <?php echo $this->Html->link('Set Recommended', array('action' => 'set_recommended', $records['Project']['id'], !$records[$model]['is_recommended']), array('title' => 'Set this project as Recommended', 'class' => 'vtip'), 'Are you sure you want to set this project as Recommended?');
                                } else { ?>
                                    &nbsp;|&nbsp;
                                    <?php echo $this->Html->link('Remove Recommended', array('action' => 'set_recommended', $records['Project']['id'], !$records[$model]['is_recommended']), array('title' => 'Set this project as Recommended', 'class' => 'vtip'), 'Are you sure you want to remove from Recommended?');
                                } ?>
                                 <?php // Display Cancel Project Link for running project to Super Admin
                                            if ($group_id == 1) {
                                                if ($records[$model]['is_successful'] == 0 && $records[$model]['active'] == 1 && $records[$model]['is_cancelled'] == 0 && $records[$model]['project_end_date'] > time()) {
                                                    ?>    
                                                    &nbsp;|&nbsp;
                                                    <?php
													echo $this->Html->link('Cancel Project', array('action' => 'cancel_project', $records['Project']['id']), array('title' => 'Project cancel request', 'class' => 'vtip'), 'Are you sure you want to change project?');
                                                }
                                            }
                                ?>
                            </div>
                        </td>
                        <td width="25%" valign="top"><?php echo ucfirst(substr($records[$model]['short_description'], 0, 80)); ?></td>
                        <td width="15%" valign="top" align="left"><?php echo $records['User']['name']; ?></td>
                        <td width="15%" valign="top" align="left"><?php echo $records['Category']['category_name']; ?></td>
                        <?php
                        if ($records[$model]['no_of_day'] != null) {
                            $date1 = date("Y-m-d", $records[$model]['created']);
                            $date = strtotime(date("Y-m-d", strtotime($date1)) . "+" . $records[$model]['no_of_day'] . "days");
                        } else {
                            $date = $records[$model]['end_date'];
                        }
                        ?>
                        <td width="12%" valign="top"><?php echo date('M, d Y', $records['Project']['project_end_date']); ?></td>
                        <td width="5%" valign="top" align="center">
                            <?php
                            if ($records[$model]['active'] == '1') {
                                echo $html->image('active.png', array('border' => '0', 'alt' => 'Active Page'));
                            } else
                            if ($records[$model]['active'] == '2') {
                                echo $html->image('inactive.png', array('border' => '0', 'alt' => 'Inactive Page'));
                            } else {
                                echo $html->image('admin/pending.png', array('border' => '0', 'alt' => 'pending Page'));
                            }
                            ?></td>
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