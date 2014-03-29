<div class="wrapper grey14">
    <div class="fl pb80 greybrdrgt pt21 width68per pr50"><?php echo $review_page_content['Page']['description']; ?></div>
    <div class="fr width23per pt21 pb80">
        <div class="mt17">
            <div>
                <div class="sprite listingbxtl"></div>
                <div class="listingbxt"></div>
                <div class="sprite listingbxtr"></div>
                <div class="clr"></div>
            </div>
            <div class="listingbxmid">
                <div class="pb14">
                    <div id="review_project_image_div">
                        <?php
                        if (!empty($this->data['Project']['image'])) {
                            echo $this->Html->image('image.php?image=' . $this->data['Project']['image'] . '&height=150px&width=200px');
                        } else {
                            echo $this->Html->image('front/missing_little.png');
                        }
                        ?>
                    </div>
                </div>
                <div class="grey13 word-wrap">
                    <?php echo $this->Form->hidden('Project.old_title', array('value' => $this->data['Project']['title']));
                    echo $this->Form->hidden('Project.old_short_description', array('value' => $this->data['Project']['short_description'])); ?> 
                    <span class="blue14 block pb9" id="review_changed_project_title"><?php echo $this->data['Project']['title']; ?></span> <span class="block pb17"><?php __('frnt_by'); ?> <?php echo $this->data['User']['name']; ?></span>
                </div>
                <div class="mt29 pb10">
                    <div><?php
                    $total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($this->data['Project']['id'], $this->data['Project']['funding_goal'], $this->data['Backer']);
                    if ($total_funded_percentage > 100) {
                        $total_funded_slider_percentage = 100;
                    } else {
                        $total_funded_slider_percentage = $total_funded_percentage;
                    }
                    ?> 
                        <div class="project-pledged-wrap">
                            <div style="width: <?php echo $total_funded_slider_percentage; ?>%" class="project-pledged"></div>
                        </div>

                    </div>

                </div>
            </div>
            <div>
                <div class="sprite listingbxbl"></div>
                <div class="listingbxb"></div>
                <div class="sprite listingbxbr"></div>
                <div class="clr"></div>
            </div>
        </div>
    </div>
    <div class="clr"></div>
</div>