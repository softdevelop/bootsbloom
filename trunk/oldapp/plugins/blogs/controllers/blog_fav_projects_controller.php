<?php 
//
// This source code was recovered by Recover-PHP.com
//

class BlogFavProjectsController extends BlogsAppController
{
    public $name = "BlogFavProjects";
	public $uses = array( "Blogs.BlogFavProject", "Project" );
	
	
	public function beforeFilter()
    {
        parent::beforefilter();
        $this->set("model", $this->modelClass);
    }

    public function admin_index()
    {
        //$fav_projects = $this->BlogFavProject->find('all', array( 'fields' => 'Project.id', 'Project.title'));
		$fav_projects = $this->BlogFavProject->query('SELECT `Project`.`id`, `Project`.`title` FROM `blog_fav_projects` AS `BlogFavProject` LEFT JOIN `projects` AS `Project` ON (`BlogFavProject`.`project_id` = `Project`.`id`)');
		$this->set('fav_projects', $fav_projects);	
	}

    public function admin_add()
    {
		$id = isset($this->data) && isset($this->data[$this->modelClass]) && isset($this->data[$this->modelClass]['project_id']) ? 
			$this->data[$this->modelClass]['project_id'] : null;
		
		if( !is_numeric($id) )
		{
			$project = $this->Project->query('SELECT `Project`.`id` FROM `projects` AS `Project` WHERE (`Project`.`slug` = "'.$id.'")');
			if(count($project) == 0)
			{
				unset($id);
			}
			else
			{
				$id = $project[0]['Project']['id'];
			}
		}

        if( !isset($id) ) 
        {
            $this->Session->setFlash(__d("Blogs", "Please Try again.", true), "admin/error");
            $this->redirect(array( "plugin" => "blogs", "controller" => "blog_fav_projects", "action" => "index" ));
        }

		
		$this->BlogFavProject->create();		
        $this->BlogFavProject->save(array( 'project_id' => $id ) );
        $this->Session->setFlash(__d("Blogs", "Project added successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_remove($id = null)
    {
        if( !isset($id) && !is_numeric($id) ) 
        {
            $this->Session->setFlash(__d("Blogs", "Please Try again.", true), "admin/error");
            $this->redirect(array( "plugin" => "blogs", "controller" => "blog_fav_projects", "action" => "index" ));
        }

        $this->BlogFavProject->deleteAll(array( 'Project.id =' => $id ) );
        $this->Session->setFlash(__d("Blogs", "Project removed successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }


}




?>