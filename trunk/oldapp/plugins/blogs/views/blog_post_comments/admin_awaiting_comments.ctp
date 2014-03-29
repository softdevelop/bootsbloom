<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Awaiting Comments</div>
    <div class="floatright padtop_6px">
        <div class="floatleft " style="font-size:10px;"></div>
        <div class="floatleft " style="font-size:10px;">
            <?php echo $this->Html->link('Activate All', 'javascript:void(0);', array('class' => 'activate_all')); ?>
            <?php echo $this->Html->link('Inactive All', 'javascript:void(0);', array('class' => 'inactivate_all')); ?>
            <?php echo $this->Html->link('Delete All', 'javascript:void(0);', array('class' => 'delete_all')); ?>

        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info'); ?>
</div>
<div class="pagging float_right ">
    <?php echo $this->Form->create($model, array('url' => array_merge(array('plugin' => 'blogs', 'controller' => 'blog_post_comments', 'action' => 'awaiting_comments')))); ?>
    <?php echo $form->text("comment", array("class" => "status ui-widget-content ui-corner-all", 'value' => 'Comment', "onclick" => "if (this.value == 'Comment') this.value = ''", "onblur" => "if (this.value == '') this.value = 'Comment'")); ?>
    &nbsp;&nbsp;
    <?php echo $this->Form->button("Search", array('class' => 'search_lnk', 'escape' => false)); ?> &nbsp;&nbsp;
    <?php echo $this->Form->end(); ?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>
<div id="ajaxpanel">
    <?php
    echo $this->Form->create($model, array('name' => 'AdminsOperateForm', 'action' => 'operate', 'id' => 'AdminsOperateForm', "method" => "post"));
    echo $form->hidden('operation', array('value' => '', 'id' => 'AdminsOperation'));
    $sortKey = $paginator->sortKey();
    $sortDir = $paginator->sortDir();
    ?>
    <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
            <tr class="ui-widget-header ui-corner-all" style="height:30px;">

                <td align="left" class="padleft_15px" width="5%"><?php echo $form->checkbox('chkAll', array('id' => 'chkAll', 'name' => 'chkAll', 'value' => '', 'onclick' => 'checkAll()')); ?></td>	

                <td align="left" width="25%">Authour Name</td>
                <td align="left" width="30%">Comment</td>
                <td align="left" width="20%">Post Name</td>
                <td align="center" width="10%">Date</td>
                <td align="center" width="10%">Status</td>	
            </tr>
            <?php
            if (count($result) > 0) {
                $i = 0;
                $class = 'odd_row';
                foreach ($result as $records) {

                    $class = (($i + 1) % 2 == 0) ? 'even_row' : 'odd_row';
                    ?>
                    <tr class="<?php echo $class; ?>" id="row_<?php echo $records[$model]['id']; ?>">
                        <td width="5%" class="padleft_15px" valign="top">
        <?php echo $form->checkbox('usersChk', array('name' => 'data[usersChk][]', 'id' => 'iId_' . $i, 'value' => $records[$model]['id']), $return = false); ?>
                        </td>

                        <td width="25%" valign="top">
        <?php echo ucfirst($records['User']['name']); ?>
                            <div id="action_row_<?php echo $records[$model]['id']; ?>" style="visibility:hidden;" class="action_row">
                            <?php echo $this->Html->link('View ', array('plugin' => 'blogs', 'controller' => 'blog_post_comments', 'action' => 'view_comment', $records[$model]['id']), array('class' => 'vtip', 'escape' => false, 'title' => 'View ')) ?> &nbsp;|&nbsp;
                                <?php
                                if ($records[$model]['active'] == '0') {
                                    echo $this->Html->link('Active', array('action' => 'change_comment_status', $records[$model]['active'], $records[$model]['id']), array('class' => 'vtip', 'title' => 'Change Comment Status To Active', 'escape' => false));
                                } else {
                                    echo $this->Html->link('Inactive', array('action' => 'change_comment_status', $records[$model]['active'], $records[$model]['id']), array('class' => 'vtip', 'title' => 'Change Comment Status To Inactive', 'escape' => false));
                                }
                                ?>&nbsp;|&nbsp;

                                <?php echo $this->Html->link('Delete', array('action' => 'admin_delete_comment', $records[$model]['id']), array('class' => 'vtip', 'escape' => false, 'title' => 'Delete Comment')) ?>  
                            </div>
                        </td>
                        <td width="30%"valign="top"><?php echo ucfirst(substr($records[$model]['comment'], 0, 80)); ?></td>
                        <td width="20%"valign="top"><?php echo ucfirst(substr($records['BlogPost']['title'], 0, 120)); ?>	</td>
                        <td width="10%"valign="top" align="center"><?php echo date('M, d Y', $records[$model]['created']); ?>	</td>
                        <td width="10%"valign="top" align="center">
        <?php
        if ($records[$model]['active'] == '1') {
            echo $html->image('active.png', array('border' => '0', 'alt' => 'Active Page'));
        } else {
            echo $html->image('inactive.png', array('border' => '0', 'alt' => 'Inactive Page'));
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
            <?php echo $form->end(); ?>
</div>


