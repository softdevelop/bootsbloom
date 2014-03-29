<?php 
$wesite_list = explode(',', $this->data['User']['website']);
echo $this->element("front/user_profile_tabs");
echo $this->element("front/profile_projects");
