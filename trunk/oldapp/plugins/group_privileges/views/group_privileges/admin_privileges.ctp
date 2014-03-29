<script type="text/javascript">
    $(document).ready(function() {
        $("[id^=AdminPrivileges_]").click(function(){
            var checkFlag	=	($(this).is(':checked')) ? true : false;
            $("[id^=sub"+$(this).attr("id")+"]").each(function(index){
                $(this).attr("checked",checkFlag);
            });
        });
    });
</script>
<?php echo $this->Form->create($model, array("action" => "privileges/" . $group_id)); ?>
<div class="ochead">
    <div class="floatleft" id="breadcrumb">All Permissions</div>
    <div class="floatright padtop_6px">
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="padtop_10px">
    <div class="reg_left dgray12">
        <div id="permission_records">
            <div class="demo">
                <div id="accordion">
                    <?php
                    foreach ($module_list['Plugin'] as $plugin) {
                        // loop for controller  of plugins
                        foreach ($plugin['controllers'] as $controller) {
                            ?>
                            <h3><?php echo $controller['name']; ?></h3>
                            <div>
                                <table>
                                    <tr>
                                        <td width="100%" colspan="2">
                                            <input type="checkbox" id="AdminPrivileges_<?php echo $controller['id']; ?>" <?php if (in_array($controller['id'], $checked_modules)) { echo "checked='checked'"; } ?> value="<?php echo $controller['id']; ?>" name="data[Admin][privileges][]" /> <?php echo $controller['name']; ?>
                                        </td>
                                    </tr>
									<?php foreach ($controller['action'] as $action_id => $action) { ?>
                                        <tr>
                                            <td width="5">&nbsp;</td>
                                            <td>
                                                <table align="left" cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    <tr>
                                                        <td width="100%" >
                                                            <input type="checkbox" id="subAdminPrivileges_<?php echo $controller['id']; ?>_<?php echo $action_id; ?>" <?php if (in_array($action_id, $checked_modules)) { echo "checked='checked'"; } ?> value="<?php echo $action_id; ?>" name="data[Admin][privileges][]" /><?php echo $action; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                            <?php } ?>
                                </table>
                            </div>
    <?php
    } // end of plugin controller  loop
}
?>            </div>
            </div>
<?php echo $form->submit("Save", array("class" => "submit_button")); ?>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>
