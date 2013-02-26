<?php

class Dog extends Eloquent
{
    //table name
    public static $table = 'dogs';
    
    //search filters
    public static $valid_filters = array(
        'breed_id','dog_size','dog_color','dog_gender','dog_postal'
    );
   
    //relationships
    public function breed()
    {
        return $this->belongs_to('Breed');
    }
    
    public function area()
    {
        return $this->belongs_to('Area');
    }
    
    public function user()
    {
        return $this->belongs_to('User');
    }
    
    public function pageview()
    {
        return $this->has_one('Pageview','dog_id');
    }
    
    //functionality
    public function add($data,$user,$status)
    {
        //validation
        if($status == 'F')
        {
           $dog_name_validation = 'greek_english';   
        } else {
            $dog_name_validation = 'required|greek_english';
        }
        $rules = array(
            'dog_name' => $dog_name_validation,
            'dog_date' => 'required|before:'.date('Y-m-d', strtotime(' +1 day')),
            'dog_gender' => 'not_in:-1|required',
            'dog_postal' => 'required|numeric', 
            'dog_image' => 'image|max:1000|mimes:png,jpg,jpeg,JPG,JPEG', //picture upload must be an image and must not exceed 500kb
            'breed_description' => 'max:300',
            'dog_reward' => 'min:0'
        );
        $validation = Validator::make($data, $rules);
        if( $validation->fails() ) {
            return $validation->errors;	
        }
        if($validation->passes())
        {
            //create a new dog
            $dog = new Dog();
            $dog->dog_name = ucfirst($data['dog_name']);
            $dog->dog_status = $status;
            $dog->dog_size = $data['dog_size'];
            if($data['breed_id'] == -2)
            {
                if(!empty($data['o-breed']))
                {
                    $dog->breed_description = ucfirst($data['o-breed']);
                    $dog->breed_id = -2;
                } 
            } else {
                $dog->breed_id = $data['breed_id'];
            }
            
            $dog->user_id = $user->id;
            $dog->dog_color = $data['dog_color'];
            $dog->dog_gender = $data['dog_gender'];
            if($status == 'L')
            {
                $dog->dog_reward = $data['dog_reward'];
            }
             //create dog code
            $digit6_code = mt_rand(100000, 999999);
            $dog_ = Dog::where('dog_code','=',$digit6_code)->get();
            if(empty($dog_))
            {
                $dog->dog_code = $digit6_code;
                //CREATE DOG DIRECTORY IN STORAGE FOLDER
                
                try {
                    if(!mkdir(path('base').'public/pictures/'.$digit6_code, 0777))
                    {
                        throw new Exception("cannot create dogs pictures folder.");
                    }
                }  catch (Exception $e) {
                    $status->error($e->getMessage());
                }
            }
            
       }
       
       //save dog
       if($dog->save()) {
            return $dog->id;
       } else {
           return false;
       }
    }
    
    public function edit($data,$user,$status = NULL)
    {
        if(!empty($data['dog_reward']))
        {
            $data['dog_reward'] = (float)$data['dog_reward'];
        }
        
        //validation
        $rules = array(
            'dog_name' => 'required|alpha',
            'dog_date' => 'required|before:'.date('Y-m-d', strtotime(' +1 day')),
            'dog_gender' => 'not_in:-1',
            'dog_postal' => 'required|numeric', 
            'dog_reward' => 'min:0',
            'dog_image' => 'image|max:1000|mimes:png,jpg,jpeg,JPG,JPEG', //picture upload must be an image and must not exceed 1000kb
            'breed_description' => 'max:300'
        );
        if($status != NULL && $status == 'F')
        {
            $rules['dog_name'] = 'alpha';
        }
        $validation = Validator::make($data, $rules);
        if( $validation->fails() ) {
            return $validation->errors;	
        }
        if($validation->passes())
        {
            // i am in dog object with id = $data['dog_id']
            $this->dog_name = ucfirst($data['dog_name']);
            if(!empty($data['status']) && $data['status'] == 'F')
            {
               $this->dog_status = $data['status'];
            } else {
               $this->dog_status = $data['dog_status']; 
            }
            $this->dog_size = $data['dog_size'];
            if($data['breed_id'] == -2)
            {
                if(!empty($data['o-breed']))
                {
                    $this->breed_description = ucfirst($data['o-breed']);
                    $this->breed_id = -2;
                } 
            } else {
                $this->breed_id = $data['breed_id'];
            }
            
            $this->user_id = $user->id;
            $this->dog_color = $data['dog_color'];
            $this->dog_gender = $data['dog_gender'];
            if(isset($data['dog_reward']))
            {
                 $this->dog_reward = $data['dog_reward'];
            } else {
                 $this->dog_reward = -1;
            }
            //update area
            $area = Area::find($this->area_id);
            $area->dog_postal = $data['dog_postal'];
            $area->save();
            //save dog
            if($this->save()) {
                return (int)$this->id;
            } else {
                return false;
            }
        }
    }
    
    public static function get_latest($limit = 1)
    {
        $latest = Dog::with(array('breed','area','user'))->order_by('created_at','DESC')->take($limit)->get();
        //dd($latest->get());
        return $latest;
    }
}
?>
