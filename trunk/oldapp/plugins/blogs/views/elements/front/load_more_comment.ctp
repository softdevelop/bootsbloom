<?php
if (count($post_comment) > 0) {
    foreach ($post_comment as $comment) {
        ?>
        <div class="commenthold">
            <div class="commentimg2">

                <?php $user_array['User'] = $comment['User'];
                ?>
                <?php
                $user_image_url = $this->GeneralFunctions->get_user_profile_image_using_user_array($user_array, '30px', '39px');
                echo $this->Html->image($user_image_url, array('width' => '39', 'height' => '30'));
                ?>
            </div>
            <div class="commentrgt">
                <div class="pb5">
        <?php echo $this->Html->link($comment['User']['name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $comment['User']['slug']), array('class' => 'blue_link')); ?> 
                    <span class="grey13"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $comment['BlogPostComment']['created']); ?></span>
                </div>

                <div><?php echo ucfirst($comment['BlogPostComment']['comment']); ?></div>
            </div>
            <div class="clr"></div>
        </div>
    <?php } ?>
    <?php
    if ($this->params['isAjax']) {
        if ($current_page != $last_page) {
            echo "=================" . $this->Html->url(array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'detail/', $slug . '/' . 'page:' . $page));
        } else {
            echo "=================";
        }
    }
} else {
    ?>
    <div class="aligncenter grey16 graybg"><?php __('blog_no_comment'); ?></div>
<?php } ?>