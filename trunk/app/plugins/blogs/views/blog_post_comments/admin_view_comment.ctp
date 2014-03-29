<div class="ochead" >
    <div class="floatleft" id="breadcrumb">View Comment</div>
    <div class="floatright padtop_6px">
        <div class="floatleft padright_10px" style="font-size:10px;"></div>
        <div class="floatleft padright_10px" style="font-size:10px;">
            <?php echo $this->Html->link("Back To Comments", array('plugin' => 'blogs', 'controller' => 'blog_post_comments', 'action' => 'awaiting_comments'), array("class" => 'back_lnk')); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>	
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>
<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
    <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td></tr>
        <tr class="odd_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">User Name</td>
            <td width="1%" valign="top">:</td>
            <td > <?php echo $comment_details['User']['name']; ?></td>
            <td width="30%" valign="middle"></td>
        </tr>
        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>

        <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td></tr>
        <tr class="even_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Post Title</td>
            <td width="1%" valign="top">:</td>
            <td > <?php echo $comment_details['BlogPost']['title']; ?></td>
            <td width="30%" valign="middle"></td>
        </tr>
        <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>
        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td></tr>
        <tr class="odd_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Comment</td>
            <td width="1%" valign="top">:</td>
            <td > <?php echo $comment_details[$model]['comment']; ?></td>
            <td width="30%" valign="middle"></td>
        </tr>
        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>

        <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td></tr>
        <tr class="even_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Comment on</td>
            <td width="1%" valign="top">:</td>
            <td ><?php echo date('M, d Y', $comment_details[$model]['created']); ?>	 </td>
            <td width="30%" valign="middle"></td>
        </tr>
        <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>

    </table>
</div>
