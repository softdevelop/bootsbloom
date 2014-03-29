<?php echo $this->element('faq_project_tabs'); ?> 
<div class="tab_container">
    <div id="tab1" class="tab_content">
        <div class="ptb21">
            <div class="wrapper">
                <div class="abprolft">	
                    <?php if (!isset($faq_id)) { ?>
                        <div>
                            <?php
                            if (count($project_faqs) > 0) {
                                foreach ($project_faqs as $project_faq) {
                                    ?>
                                    <div id="blog" class="pt10">
                                        <div class="width600 height35">
                                            <span class="fl">
                                                <h1>
                                                    <?php echo ucfirst($project_faq['ProjectAskedQuestions']['question']) ?>
                                                </h1></span>
                                            <span class="clr"></span>
                                            <span class="fr pt10 grey14"><?php
                                                    if ($project_detail['User']['id'] == $this->Session->read('Auth.User.id')) {
                                                        echo $this->Html->link(__('project_view_payment_edit', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_faq', $project_detail['User']['slug'], $project_detail['Project']['slug'], $project_faq['ProjectAskedQuestions']['id']));?>
														|
														<?php //echo $this->Html->link(__('project_view_payment_delete', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_faq_delete', $project_detail['User']['slug'], $project_detail['Project']['slug'], $project_faq['ProjectAskedQuestions']['id']));
														
														 echo $html->link(__('project_view_payment_delete', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'project_faq_delete', $project_detail['User']['slug'], $project_detail['Project']['slug'], $project_faq['ProjectAskedQuestions']['id']), array('escape' => false, 'title' => 'Delete user', 'alt' => 'Delete user', 'class' => 'vtip'), sprintf(__('delete_faq_msg', true)));
                                                    }
                                                    ?></span>
                                        </div>	
                                        <div class="grey13_light"> 
                                            <span class="mt5 lh20"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $project_faq['ProjectAskedQuestions']['created']); ?></span>
                                        </div>
                                        <div>
                                            <p><?php echo ucfirst($project_faq['ProjectAskedQuestions']['answer']); ?></p>
                                        </div>

                                    </div>
                                <?php }
                            } else { ?>
                                <div class="right_box">
                                    <div class="bt1px txt_italic  aligncenter"> <?php __('faq_empty_msg'); ?> .</div>
                                </div>

                        <?php } ?>
                        </div>
                    <?php } ?>
                    <?php
                    $user_info = $this->Session->read('Auth.User');
                    if (isset($user_info) && ($project_detail['User']['slug'] == $user_info['slug'])) {
                        ?>				
                        <?php
                        if (isset($faq_id) && $faq_id != '') {

                            echo $this->Form->create($model, array('url' => array('plugin' => false, 'controller' => 'projects', 'action' => 'project_faq', $project_detail['User']['slug'], $project_detail['Project']['slug'], $faq_id)));
                        } else {

                            echo $this->Form->create($model, array('url' => array('plugin' => false, 'controller' => 'projects', 'action' => 'project_faq', $project_detail['User']['slug'], $project_detail['Project']['slug'])));
                        }
                        ?>
                        <div><?php if ($this->validationErrors) { ?>
                                <div class="error pt10"><?php echo "<ul>";
                                    foreach ($this->validationErrors['ProjectAskedQuestions'] as $error) {
                                        ?><li><?php echo $error; ?></li>
                                    <?php }
                                    echo "</ul>";
                                    ?>
                                </div>
                        <?php } ?>
                        </div>
                        <?php
                        $user_info = $this->Session->read('Auth.User');
                        if (isset($user_info) && ($project_detail['User']['slug'] == $user_info['slug'])) {
                            ?>
                            <div class="pt20">
                                <div class="greybox mb5">
                                    <div class="p10">
                                        <div class="fl grey16 width100 pt7"><?php __('cont_question'); ?><span class="mandatory_field pl5">*</span></div>
                                        <div class="fl  grey12">
                                             <?php echo $this->Form->text('ProjectAskedQuestions.question', array('class' => 'input-text600')); ?>
                                        </div>
                                        <div class="clr"></div>
                                    </div>
                                    <div class="greyboxtl"></div>
                                    <div class="greyboxtr"></div>
                                    <div class="greyboxbl"></div>
                                    <div class="greyboxbr"></div>
                                </div>
                                <div class="greybox mb5">
                                    <div class="p10">
                                        <div class="fl grey16 width100 pt7"><?php __('project_faq_answer'); ?><span class="mandatory_field pl5">*</span></div>
                                        <div class="fl grey12 width491">
                                            <?php echo $form->textarea('ProjectAskedQuestions.answer', array('class' => 'input-textarea', 'style' => 'width:478px;height:50px;')); ?>
                                        </div>
                                        <div class="clr"></div>
                                    </div>
                                    <div class="greyboxtl"></div>
                                    <div class="greyboxtr"></div>
                                    <div class="greyboxbl"></div>
                                    <div class="greyboxbr"></div>
                                </div>
                                <div class="pt5 pl120">
                                    <?php echo $this->Form->submit(__('project_edit_submit', true), array('border' => '0', 'class' => 'submit_but ie_radius fl')); ?>
                                    <div class="clr"></div>
                                </div>
                            </div>

                            <?php echo $form->end(); ?>
                        <?php }
                    } ?>
                </div>
                    <?php echo $this->element('projects/project_detail_right_panel'); ?>
                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>

<div style="display: none;" id="bio_info">
<?php echo $this->element('projects/user_bio'); ?>
</div> 

<div style="display: none;" id="widget_div">
<?php echo $this->element('projects/widget_layout'); ?>
</div> 

