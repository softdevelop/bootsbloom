<div id="ajaxpanel">
    <?php
    echo $this->Form->create($model, array('name' => 'AdminsOperateForm', 'action' => 'operate', 'id' => 'AdminsOperateForm'));
    echo $this->Form->hidden('operation', array('value' => '', 'id' => 'AdminsOperation'));
    $sortKey = $paginator->sortKey();
    $sortDir = $paginator->sortDir();
    ?>
    <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
            <tr class="ui-widget-header ui-corner-all" style="height:30px;">
                <td align="left"><?php echo $paginator->sort('Project Title', 'title'); ?><span <?php if ($sortKey == "Project.title") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
                <td align="left"><?php echo $paginator->sort('Current Status', 'project_end_date'); ?><span <?php if ($sortKey == "Project.end_date") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
                <td align="left"><?php echo $paginator->sort('Owner', 'User_id'); ?><span <?php if ($sortKey == "Project.user_id") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
                <td align="left"><?php echo $paginator->sort('Category', 'category_id'); ?><span <?php if ($sortKey == "Project.category_id") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
                <td align="left"><?php echo 'Total Pledge'; ?></td>
                <td align="left"><?php echo 'Total Backers'; ?></td>
                <td align="left"><?php echo $paginator->sort('Ended Date', 'created'); ?><span <?php if ($sortKey == "Project.created") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
            </tr>
            <?php
            if (count($result) > 0) {
                $i = 0;
                $class = 'odd_row';
                foreach ($result as $records) {
                    $remaining_time = $this->GeneralFunctions->get_remainig_time(time(), $records['Project']['project_end_date']);
                    $class = (($i + 1) % 2 == 0) ? 'even_row' : 'odd_row';
                    ?>
                    <tr class="<?php echo $class; ?>" id="row_<?php echo $records[$model]['id']; ?>">
                        <td width="30%" valign="top"><?php echo $records[$model]['title']; ?>
                            <div id="action_row_<?php echo $records[$model]['id']; ?>" style="visibility:hidden;" class="action_row">

                                <?php echo $this->Html->link('View Details', WEBSITE_FRONT_URL . 'projects/detail/' . $records['User']['slug'] . '/' . $records[$model]['slug'] . '?ref_by=admin', array('class' => 'vtip', 'title' => 'Project with details', 'target' => '_blank'));
                                if ($records[$model]['active'] == 1) { ?>
                                    &nbsp;|&nbsp;
                                    <?php echo $this->Html->link('Backers', array('action' => 'project_backer_detail', $records['Project']['id']), array('title' => 'View the backer list of this project', 'class' => 'vtip'));
                                } ?>
                            </div>
                        </td>
                        <td width="10%" valign="top">
                            <?php
                            if ($remaining_time > 0 && $records[$model]['active'] == 1) {
                                echo 'Running';
                            } else if ($remaining_time > 0 && $records[$model]['active'] == 0) {
                                echo 'Pending For Approval';
                            } else if ($remaining_time <= 0 && $records['Project']['is_successful'] == 1) {
                                echo 'Success fully Funded';
                            } else if ($remaining_time <= 0 && $records['Project']['is_successful'] == 0) {
                                echo "Unsuccessfull";
                            }
                            ?>
                        </td>
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
                        <td width="15%" valign="top" align="left">
                            $<?php echo $this->GeneralFunctions->get_total_pledge_amount($records['Backer']); ?>
                        </td>
                        <td width="5%" valign="top" align="left">
        <?php echo count($records['Backer']); ?>
                        </td>
                        <td width="12%" valign="top"><?php echo date('M, d Y', $records['Project']['project_end_date']); ?></td>

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
                <tr class="odd_row"><td colspan="8" align="center"><?php __('project_report_found'); ?></td></tr>
<?php } ?>		   
        </table>
    </div>
<?php echo $form->end(); ?>
</div>