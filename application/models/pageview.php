<?php

class Pageview extends Eloquent {

    public static $table = 'views';

    public function dog() {
        return $belongs_to('Dog');
    }

    public function add($data) {

        //validation
        $rules = array(
            'user_ip' => 'required'
        );
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return $validation->errors;
        }
        if ($validation->passes()) {
           
            $this->user_ip = $data['user_ip'];
            $this->dog_id = $data['dog_id'];
            //update dogs
            $dog = Dog::find($data['dog_id']);
            if(is_null($dog))
            {
                //log
                return false;
            }
            $dog->dog_views = (int)$dog->dog_views + 1;
            if(!$dog->save() == true)
            {
                //log
                return false;
            }
          
            $result = $this->save();
            return $result;
        }
    }

}

?>
