<?php
if ($blogs > 0) {
    $element_flag = 0;
    foreach ($blogs as $blog) {
        $element_flag++;
        if ($element_flag <= 2)
            continue;
        ?>
        <div class="pb30">
            <div class="qa_left column">
                <div>
        <?php echo $this->Html->image('front/rss-icon.png', array('alt' => '', 'width' => '109', 'height' => '85')); ?>
                </div>
                <div class="pt10 blue14"><strong>Cindy Au</strong></div>
            </div>
            <div class="qa_right column">
                <div class="blue30"><?php echo $this->Html->link(ucfirst($blog ['BlogPost']['title']), array('controller' => '', 'action' => ''), array('escape' => false)); ?></div>
                <div class="pt10">
                    <span class="documentry-grey"><?php echo date('F, d Y', $blog['BlogPost']['created']); ?></span> <?php echo $this->Html->link(count($blog['BlogPostComment']) . ' comments', array('controller' => '', 'action' => ''), array('escape' => false, 'class' => 'cmnt-icon-grey')); ?>            
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <?php
    }
} else {
   
}?>