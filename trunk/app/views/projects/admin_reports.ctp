<script type="text/javascript">
    $(function(){
        $("#ProjectCategoryId123").change(function(){
            document.getElementById('report_form').submit();
        });
    });
</script>

<div class="ochead" >
    <div class="floatleft" id="breadcrumb">
        Project List
    </div>

    <div class="floatright padtop_6px">
        <?php echo $this->Form->create('Project', array('action' => 'reports', 'id' => 'report_form', 'method' => 'post')); ?> 
        <div class="floatleft dgray17 pt2">Filter By: </div>
        <div class="floatleft pr10">
            <?php $this->GeneralFunctions->get_category_dropdown('Project', 'category_id', 'ProjectCategoryId', $category_id, 'ui_dropdown', '', 'onchange="this.form.submit();"'); ?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="clear"></div>
</div>
<div class="width_306 float_left" ></div>

<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
        <tr class="ui-widget-header ui-corner-all" style="height:30px;">
            <td width="30%" align="left">Successfully Funded Amount</td>
            <td width="30%" align="left">Unsuccessfully Funded Amount</td>
            <td width="30%" align="left">Live Projects Funded Amount</td>
        </tr>
        <tr>

            <td width="30%" align="left">
                $<?php echo $successfully_funded_amount; ?>								
            </td>
            <td width="30%" align="left">$<?php echo $unsuccessfully_funded_amount ?></td>
            <td width="30%" align="left">$<?php echo $running_funded_amount; ?></td>

        </tr>

    </table>
</div>
<div class="clear"></div>


<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '10')); ?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1', 'height' => '5')); ?></div>

<?php echo $this->element('projects/admin_project_report_listing'); ?>
