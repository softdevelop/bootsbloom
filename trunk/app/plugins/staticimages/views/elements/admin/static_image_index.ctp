<div id="ajaxpanel">
    <?php
    echo $this->Form->create($model, array('class' => 'form-inline'));
    echo $form->hidden('operation', array('value' => ''));
    $sortKey = $paginator->sortKey();
    $sortDir = $paginator->sortDir();
    ?>
    <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
            <tr class="ui-widget-header ui-corner-all" style="height:30px;">
                <td align="left" class="padleft_15px"><?php echo $form->checkbox('chkAll', array('id' => 'chkAll', 'name' => 'chkAll', 'value' => '', 'onclick' => 'checkAll()')); ?></td>

                <td align="left"><?php echo $paginator->sort('Image', 'image_name'); ?><span <?php if ($sortKey == "Staticimage.image_name") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>

                <td align="left">Link Url </td>

                <td align="center"><?php echo $paginator->sort('Caption', 'caption'); ?><span <?php if ($sortKey == "Staticimage.caption") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>

                <td align="center">Download </td>

                <td align="center"><?php echo $paginator->sort('Date', 'created'); ?><span <?php if ($sortKey == "Staticimage.created") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
            </tr>
            <?php
            if (count($result) > 0) {
                $i = 0;
                $class = 'odd_row';
                foreach ($result as $records) {
                    $class = (($i + 1) % 2 == 0) ? 'even_row' : 'odd_row';
                    ?>
                    <tr class="<?php echo $class; ?>" id="row_<?php echo $records[$model]['id']; ?>">
                        <td width="3%" class="padleft_15px" valign="top">
                            <?php echo $form->checkbox('usersChk', array('name' => 'data[usersChk][]', 'id' => 'iId_' . $i, 'value' => $records[$model]['id']), $return = false); ?>
                        </td>
                        <td width="15%" valign="top">
                            <?php echo $this->Html->image(UPLOAD_DIR_URL . $records[$model]['image_name'] . '.' . $records[$model]['image_type'], array('width' => '80px', 'height' => '80px')); ?>
                            <div id="action_row_<?php echo $records[$model]['id']; ?>" style="visibility:hidden;" class="action_row">		<?php echo $this->Html->link('Delete', array('action' => 'admin_delete_image', $records[$model]['id']), array('title' => 'delete image', 'class' => 'vtip'), 'Are you sure you want to delete ?'); ?>
                            </div>
                        </td>
                        <td width="40%" valign="top" ><?php echo UPLOAD_DIR_URL . $records[$model]['image_name'] . '.' . $records[$model]['image_type']; ?></td>
                        <td width="15%" valign="top" align="center"><?php echo $records[$model]['caption']; ?></td>
                        <td width="15%" valign="top" align="center"> <?php echo $this->Html->link('Download', array('action' => 'admin_download_image', $records[$model]['image_name'] . '.' . $records[$model]['image_type']), array('class' => 'download_lnk', 'escape' => false)) ?></td>
                        <td width="10%" valign="top" align="center"><?php echo date('M, d Y', $records[$model]['created']); ?></td>
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
