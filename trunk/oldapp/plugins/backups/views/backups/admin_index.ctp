<div class="ochead" >
    <div class="floatleft" id="breadcrumb">DB Backup</div>
    <div class="floatright padtop_6px">
        <div class="floatleft " style="font-size:10px;"></div>
        <div class="floatleft " style="font-size:10px;">
            <?php echo $this->Html->link("Backup",array("action"=>"backup"),array("class"=>'add_lnk'));?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info');  ?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1','height'=>'10'));?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1','height'=>'5'));?></div>
<?php echo $this->element("admin/dbbackup_index"); ?>
