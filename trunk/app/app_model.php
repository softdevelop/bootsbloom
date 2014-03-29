<?php
class AppModel extends Model {

    //Validation message i18n
    function invalidate($field, $value = true) {
        parent::invalidate($field, $value);
        $this->validationErrors[$field] = __($value, true);
    }

    public function createSlug($string, $id=null) {
        $slug = Inflector::slug($string, '-');
        $slug = low($slug);
        $i = 0;
        $params = array();
        $params ['conditions'] = array();
        $params ['conditions'][$this->name . '.slug'] = $slug;
        if (!is_null($id)) {
            $params ['conditions']['not'] = array($this->name . '.id' => $id);
        }
        while (count($this->find('all', $params))) {
            if (!preg_match('/-{1}[0-9]+$/', $slug)) {
                $slug .= '-' . ++$i;
            } else {
                $slug = preg_replace('/[0-9]+$/', ++$i, $slug);
            }
            $params ['conditions'][$this->name . '.slug'] = $slug;
        }
        return $slug;
    }

    public function search_name_email($data = array()) {
        ///  pr($data); exit;
        $filter = $data['name'];
        $cond = array(
            'OR' => array(
                $this->alias . '.name LIKE' => '%' . $filter . '%',
                $this->alias . '.email LIKE' => '%' . $filter . '%',
                ));
        return $cond;
    }

    public function search_by_email($data = array()) {
        ///  pr($data); exit;
        $filter = $data['email'];
        $cond = array(
            'OR' => array(
                $this->alias . '.email LIKE' => '%' . $filter . '%',
                ));
        return $cond;
    }

    public function RandomPasswordGenerator($length = 10) {
        $pass = '';
        $randempassword = '';

        // all the chars we want to use
        $all = explode(" ", "a b c d e f g h i j k l m n o p q r s t u v w x y z "
                . "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z "
                . "0 1 2 3 4 5 6 7 8 9");

        for ($i = 0; $i < $length; $i++) {
            srand((double) microtime() * 1000000);
            $pass .= $all[rand(0, 61)];
            $arr[] = $all[rand(0, 61)];
            $randempassword .= $arr[$i];
        }
        return $randempassword;
    }
	
   /* function afterSave($created) {
        parent::afterSave($created);
        Cache::clear();
        $this->clearCache();
    }*/

}
