<?php
if (count($blogs) > 0) {
    foreach ($blogs as $blog) {
        ?>	
        <div class="mb12">
            <h1> <?php echo $this->Html->link(ucfirst($blog ['BlogPost']['title']), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'detail', $blog ['BlogPost']['slug']), array('escape' => false)); ?></h1>
            <div class="grey13_light">
                <?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $blog['BlogPost']['created']); ?>&ndash; &nbsp;<?php echo $this->Html->link(count($blog['BlogPostComment']) . ' ' . __('projt_dtl_project_comment', true), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'detail', $blog ['BlogPost']['slug']), array('escape' => false, 'class' => 'cmnt-icon-grey')); ?>
            </div>
            <div>
                <p> <?php echo $text->truncate($blog['BlogPost']['description'], 500, array('ending' => '...', 'exact' => false, 'html' => true)); ?>
                <div class="tag"><?php echo $this->Html->link(ucfirst($blog ['BlogCategory']['category_name']), array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'category_project', $blog['BlogCategory']['slug']), array('escape' => false)); ?></div>
                </p>
            </div>
        </div>
    <?php } ?>
    <?php
    if ($this->params['isAjax']) {
        if ($current_page != $last_page) {
            echo "=================" . $this->Html->url(array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'blog/' . 'page:' . $page));
        } else {
            echo "=================";
        }
    }
} else {
    ?>

    <div class="right_box ">
        <div class="bt1px txt_italic  aligncenter"><?php __('blog_empty_msg'); ?></div>
    </div>

<?php } ?> 