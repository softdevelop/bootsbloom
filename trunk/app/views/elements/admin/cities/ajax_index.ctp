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
                <td align="left" class="padleft_15px"><?php echo $form->checkbox('chkAll', array('id' => 'chkAll', 'name' => 'chkAll', 'value' => '', 'onclick' => 'checkAll()')); ?></td>
                <td align="left"><?php echo $paginator->sort('Name', 'name'); ?><span <?php if ($sortKey == "City.name") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
                <td align="left">Country</td>
                <td align="left"><?php echo $paginator->sort('Created', 'created'); ?><span <?php if ($sortKey == "City.created") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
            </tr>
            <?php
            if (count($results) > 0) {
                $i = 0;
                $class = 'odd_row';
                foreach ($results as $result) {

                    $class = (($i + 1) % 2 == 0) ? 'even_row' : 'odd_row';
                    ?>
                    <tr class="<?php echo $class; ?>" id="row_<?php echo $result['City']['id']; ?>">
                        <td width="5%" class="padleft_15px" valign="top">
                            <?php
                            if ($result['City']['id'] != 1) {
                                echo $form->checkbox('usersChk', array('name' => 'data[usersChk][]', 'id' => 'iId_' . $i, 'value' => $result['City']['id']), $return = false);
                            }
                            ?>
                        </td>
                        <td valign="top">
                            <?php
                            echo ucwords($result['City']['name']);
                            ?>

                            <div id="action_row_<?php echo $result['City']['id']; ?>" style="visibility:hidden;" class="action_row">
                                <?php
                                echo $html->link("Edit", array('action' => 'edit', $result['City']['id']), array('escape' => false, 'title' => 'Edit city information', 'alt' => 'Edit City', 'class' => 'vtip'));
                                ?> 
                            </div>
                        </td>
                        <td>
                            <?php echo ucwords($result['Country']['name']); ?>	
                        </td>
                        <td valign="top">
                            <?php echo date(ADMIN_DATE_FORMAT, $result['City']['created']); ?>
                        </td>

                    </tr>
                    <?php $i++;
                } ?>
                <tr>
                    <td colspan="5"><div class="ochead"></div></td>
                </tr>	
                <tr class="odd_row">
                    <td class="td-listing" colspan="4" align="right"><?php echo $this->element('admin/pagination'); ?></td>
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