<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Blog Dashboard</div>
    <div class="floatright padtop_6px">
        <div class="floatleft padright_10px" style="font-size:10px;"></div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
    <tr><td>
            <ul class="dblist">
                <li>
                    <?php echo $this->Html->link($this->Html->image('admin/blog_icon.png', array('alt' => '')) . '<br>Blogs', array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'index'), array('escape' => false, 'title' => 'Blogs', 'class' => 'vtip')); ?>
                </li>

                <li>
                    <?php echo $this->Html->link($this->Html->image('admin/unapprove_post.png', array('alt' => '')) . '<br>Un approve comments', array('plugin' => 'blogs', 'controller' => 'blog_post_comments', 'action' => 'awaiting_comments'), array('escape' => false, 'title' => ' Awaiting Comments', 'class' => 'vtip')); ?>
                </li>
				
				<li>
                    <?php echo $this->Html->link('Projects We Love list', array('plugin' => 'blogs', 'controller' => 'blog_fav_projects', 'action' => 'index'), array('escape' => false, 'title' => 'Projects We Love', 'class' => 'vtip')); ?>
                </li>

            </ul>
            <div class="clear"></div>
        </td></tr>
</table>
