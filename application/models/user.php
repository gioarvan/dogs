<?php

class User extends Eloquent
{
    /**
    set table name
    **/
    public static $table = 'users';	
   
    /**
    @relationships
    **/
    public function dogs()
    {
        return $this->has_many('Dog');
    }
    
    public function edit($user,$data)
    {
       
        $rules = array(
            /*'first_name' => 'alpha',
            'last_name' => 'alpha',*/
            'username' => 'required|email|unique:users,username,'.$user->id
            /*'tel'=> 'numeric|unique:users,username,'.$user->id,
            'mobile'=> 'numeric|unique:users,username,'.$user->id*/      
	);
        //dd($data);
	$v = Validator::make($data,$rules);
	if($v->fails())
        {	
            return $v->errors;
	}
	if($v->passes())
	{
            //edit user
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->username = $data['username'];
            /*$user->tel = $data['tel'];
            $user->mobile = $data['mobile'];*/
            $result = $user->save();
            return $result;
	}
       
    }
    
    public function register($data)
    {
       
	$rules = array(
            'username' => 'required|email|unique:users',
            'password' => 'required|min:4|max:64|confirmed'
	);
        //dd($data);
	$v = Validator::make($data,$rules);
	if($v->fails())
        {	
            return $v->errors;
	}
	if($v->passes())
	{
            //dd($data);
            unset($data['password_confirmation']);
            $data['password'] = Hash::make($data['password']);        
            //register new user;
            $this->fill($data);
            $result = $this->save();
            return $result;
	}
    }
}
?>