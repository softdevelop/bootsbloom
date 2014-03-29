<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
// Router::connect('/', array('controller' => 'pages', 'action' => 'display','home'));
	

	
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	
        $Routingprefixes = Configure::read('Routing.prefixes');
	if(!empty($Routingprefixes)){
	 foreach($Routingprefixes as $Routingprefix){ 
           
			Router::connect('/'.$Routingprefix.'/help_categories/help_categories/*', array('plugin'=>'help_categories','controller' => 'help_categories', 'action' => 'index',$Routingprefix => true)); 
			
			Router::connect('/'.$Routingprefix.'/help_categories/help_dashboard/*', array('plugin'=>'help_categories','controller' => 'faqs', 'action' => 'help_dashboard',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/help_categories/add_category/*', array('plugin'=>'help_categories','controller' => 'help_categories', 'action' => 'add_category',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/help_categories/help_category_status/*', array('plugin'=>'help_categories','controller' => 'help_categories', 'action' => 'help_category_status',$Routingprefix => true));
             
			Router::connect('/'.$Routingprefix.'/help_categories/delete_catrgory/*', array('plugin'=>'help_categories','controller' => 'help_categories', 'action' => 'delete_catrgory',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/help_categories/edit_category/*', array('plugin'=>'help_categories','controller' => 'help_categories', 'action' => 'edit_category',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/help_categories/operate/*', array('plugin'=>'help_categories','controller' => 'help_categories', 'action' => 'operate',$Routingprefix => true));
			
			/****************for help post controller ****************/
			
			Router::connect('/'.$Routingprefix.'/help_posts/help_posts/*', array('plugin'=>'help_categories','controller' => 'help_posts', 'action' => 'index',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/help_posts/add_help_post/*', array('plugin'=>'help_categories','controller' => 'help_posts', 'action' => 'add_help_post',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/help_posts/edit_help_post/*', array('plugin'=>'help_categories','controller' => 'help_posts', 'action' => 'edit_help_post',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/help_posts/delete_help_post/*', array('plugin'=>'help_categories','controller' => 'help_posts', 'action' => 'delete_help_post',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/help_posts/help_post_status/*', array('plugin'=>'help_categories','controller' => 'help_posts', 'action' => 'help_post_status',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/help_posts/operate/*', array('plugin'=>'help_categories','controller' => 'help_posts', 'action' => 'operate',$Routingprefix => true));
			
			/****faq for category routing**********/
				
			
			
			Router::connect('/'.$Routingprefix.'/faqs/add_category/*', array('plugin'=>'help_categories','controller' => 'faqs', 'action' => 'add_category',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/faqs/edit_category/*', array('plugin'=>'help_categories','controller' => 'faqs', 'action' => 'edit_category',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/faqs/delete_catrgory/*', array('plugin'=>'help_categories','controller' => 'faqs', 'action' => 'delete_catrgory',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/faqs/category_status/*', array('plugin'=>'help_categories','controller' => 'faqs', 'action' => 'category_status',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/faqs/operate/*', array('plugin'=>'help_categories','controller' => 'faqs', 'action' => 'operate',$Routingprefix => true));	
			
			Router::connect('/'.$Routingprefix.'/faqs/*', array('plugin'=>'help_categories','controller' => 'faqs', 'action' => 'index',$Routingprefix => true));
			
				/**faq routing for posts**/
				
			Router::connect('/'.$Routingprefix.'/faq_posts/add_faq_post/*', array('plugin'=>'help_categories','controller' => 'faq_posts', 'action' => 'add_faq_post',$Routingprefix => true));

			Router::connect('/'.$Routingprefix.'/faq_posts/edit_faq_post/*', array('plugin'=>'help_categories','controller' => 'faq_posts', 'action' => 'edit_faq_post',$Routingprefix => true));	
			
			Router::connect('/'.$Routingprefix.'/faq_posts/delete_faq_post/*', array('plugin'=>'help_categories','controller' => 'faq_posts', 'action' => 'delete_faq_post',$Routingprefix => true));	
			
			Router::connect('/'.$Routingprefix.'/faq_posts/faq_post_status/*', array('plugin'=>'help_categories','controller' => 'faq_posts', 'action' => 'faq_post_status',$Routingprefix => true));	
				
			Router::connect('/'.$Routingprefix.'/faq_posts/operate/*', array('plugin'=>'help_categories','controller' => 'faq_posts', 'action' => 'operate',$Routingprefix => true));		
				
			Router::connect('/'.$Routingprefix.'/faq_posts/*', array('plugin'=>'help_categories','controller' => 'faq_posts', 'action' => 'index',$Routingprefix => true));	
			
			/**school routing for category **/
			
			Router::connect('/'.$Routingprefix.'/schools/add_category/*', array('plugin'=>'help_categories','controller' => 'schools', 'action' => 'add_category',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/schools/edit_category/*', array('plugin'=>'help_categories','controller' => 'schools', 'action' => 'edit_category',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/schools/category_status/*', array('plugin'=>'help_categories','controller' => 'schools', 'action' => 'category_status',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/schools/delete_catrgory/*', array('plugin'=>'help_categories','controller' => 'schools', 'action' => 'delete_catrgory',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/schools/operate/*', array('plugin'=>'help_categories','controller' => 'schools', 'action' => 'operate',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/schools/*', array('plugin'=>'help_categories','controller' => 'schools', 'action' => 'index',$Routingprefix => true));
			
			
			
			/**school routing for posty **/
			
			Router::connect('/'.$Routingprefix.'/school_posts/add_post/*', array('plugin'=>'help_categories','controller' => 'school_posts', 'action' => 'add_post',$Routingprefix => true));

			Router::connect('/'.$Routingprefix.'/school_posts/edit_post/*', array('plugin'=>'help_categories','controller' => 'school_posts', 'action' => 'edit_post',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/school_posts/delete_post/*', array('plugin'=>'help_categories','controller' => 'school_posts', 'action' => 'delete_post',$Routingprefix => true));	
			
			Router::connect('/'.$Routingprefix.'/school_posts/post_status/*', array('plugin'=>'help_categories','controller' => 'school_posts', 'action' => 'post_status',$Routingprefix => true));	
				
			Router::connect('/'.$Routingprefix.'/school_posts/add_post/*', array('plugin'=>'help_categories','controller' => 'school_posts', 'action' => 'add_post',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/school_posts/operate/*', array('plugin'=>'help_categories','controller' => 'school_posts', 'action' => 'operate',$Routingprefix => true));
			
			Router::connect('/'.$Routingprefix.'/school_posts/*', array('plugin'=>'help_categories','controller' => 'school_posts', 'action' => 'index',$Routingprefix => true));	
	 }
												/**admin pannel end here***/
			Router::connect('/help', array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help'));
			Router::connect('/design_page', array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'design_page'));
			
			Router::connect('/help/search-post/*', array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'search_post'));
			
			Router::connect('/help/help-detail/*', array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help_detail'));
			
			Router::connect('/help/post-title/*', array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'get_post_title'));
			
			Router::connect('/help/bestpractices–home', array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school_home'));
			
			Router::connect('/help/school/*', array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school'));
			
			
			
	 
	 
	}