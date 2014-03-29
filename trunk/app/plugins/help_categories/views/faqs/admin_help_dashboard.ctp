<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Help Categories</div>
    <div class="floatright padtop_6px">
        <div class="floatleft padright_10px" style="font-size:10px;"></div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
    <tr>
        <td>
            <ul class="dblist">
                <li>
                    <?php echo $this->Html->link($this->Html->image('admin/bloomboost_school.png', array('alt' => '')) . '<br>Best<br>Practices ', array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'index'), array('escape' => false, 'title' => 'Best Practices', 'class' => 'vtip')); ?>
                </li>
                <li>
                    <?php echo $this->Html->link($this->Html->image('admin/faq.png', array('alt' => '')) . '<br>FAQ', array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'index'), array('escape' => false, 'title' => 'FAQ', 'class' => 'vtip')); ?>
                </li>
            </ul>  
            <div class="clear"></div>
        </td>
    </tr>
</table>
