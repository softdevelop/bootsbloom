<div id="mainnav">
    <ul class="topnav">
        <li>
            <?php echo $this->Html->link("Dashboard", array("plugin" => "users", "controller" => "users", "action" => "dashboard"), array("class" => "top_menu_links")); ?>
        </li>

        <li>
            <?php echo $this->Html->link("Users", array("plugin" => "users", "controller" => "users", "action" => "users_dashboard"), array("class" => "top_menu_links")); ?>
            <ul class="subnav">
                <li>
                    <?php echo $this->Html->link("Site Users", array("plugin" => "users", "controller" => "users", "action" => "index"), array("class" => "top_menu_links")); ?>
                </li>
                <li>
                    <?php echo $this->Html->link("Group Privileges", array("plugin" => "group_privileges", "controller" => "group_privileges", "action" => "index"), array("class" => "top_menu_links")); ?>
                </li>
            </ul>
        </li>
        <li>
            <?php echo $this->Html->link("Projects", array("plugin" => false, "controller" => "projects", "action" => "admin_dashboard"), array("class" => "top_menu_links")); ?>
            <ul class="subnav">
                <li>
                    <?php echo $this->Html->link("Project List", array("plugin" => false, "controller" => "projects", "action" => "index"), array("class" => "top_menu_links")); ?>
                </li>
                <li>
                    <?php echo $this->Html->link("Categories", array("plugin" => "categories", "controller" => "categories", "action" => "index"), array("class" => "top_menu_links")); ?>
                </li>
                <li>
                    <?php echo $this->Html->link("Pending For Approval", array("plugin" => false, "controller" => "projects", "action" => "pending_projects"), array("class" => "top_menu_links")); ?>
                </li>
                <li>
                    <?php echo $this->Html->link("Successful Projects", array("plugin" => false, "controller" => "projects", "action" => "successful_projects"), array("class" => "top_menu_links")); ?>
                </li>
            </ul>	
        </li>
        <?php /* * ***********************blog************************* */ ?>
        <li>
            <?php echo $this->Html->link("Blogs", array("plugin" => "blogs", "controller" => "blogs", "action" => "index"), array("class" => "top_menu_links")); ?>
        </li>
        <?php /*         * *********************newsletters*********************** */ ?>
        <li><?php
            echo $this->Html->link('Newsletters', array('plugin' => 'newsletters', 'controller' => 'newsletters', 'action' => 'newsletters_dashboard'), array('class' => 'top_menu_links', 'escape' => false));
            ?> <ul class="subnav">
                <li><?php echo $this->Html->link('Templates', array('plugin' => 'newsletters', 'controller' => 'newsletters', 'action' => 'index'), array('class' => 'top_menu_links', 'escape' => false)); ?> 
                </li>
                <li> <?php echo $this->Html->link('Subscribers', array('plugin' => 'newsletters', 'controller' => 'subscribers', 'action' => 'index'), array('class' => 'top_menu_links', 'escape' => false)); ?> 
                </li>

            </ul>
        </li>
        <?php /*****************Utilites************* */ ?>
        <li>
            <?php echo $this->Html->link('Utilites', 'javascript:void(0);', array('class' => 'top_menu_links', 'escape' => false));?>
            <ul class="subnav">
                <li>
                    <?php echo $this->Html->link('Static Pages', array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index'), array('class' => 'top_menu_links', 'escape' => false)); ?>
                </li>
                <li>
                    <?php echo $this->Html->link('Curated Pages', array('plugin' => 'partners', 'controller' => 'partners', 'action' => 'index'), array('class' => 'top_menu_links', 'escape' => false)); ?>
                </li>
            </ul>
        </li>

<?php /* * ***************Help************* */ ?>
        <li>
            <?php
            echo $this->Html->link('Help', array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help_dashboard'), array('class' => 'top_menu_links', 'escape' => false));
            ?> 
            <ul class="subnav">
                <li><?php
                    echo $this->Html->link('FAQ', array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'index'), array('class' => 'top_menu_links', 'escape' => false));
                    ?> 
                </li>

                <li><?php
                    echo $this->Html->link('Best Practices', array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'index'), array('class' => 'top_menu_links', 'escape' => false));
                    ?> 
                </li>

            </ul>
        </li>	
    </ul>
  <div class="clear"></div>
</div>
