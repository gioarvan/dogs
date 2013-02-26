<?php
class Users_Controller extends Base_Controller {
	
    /*public function post_signin($page = NULL)
    {	
       
        // get POST data, attempt to authenticate based on input
	$input = array(
            'username' => Input::get('username_login'),
            'password' => Input::get('password_login')
 	);
		
	//VALIDATION
	$rules = array(
            'username' => 'required',
            'password' => 'required'
	);
		
	$v = Validator::make($input,$rules);
	if($v->fails())
	{
            return Redirect::to_action('home@index')->with_errors($v->errors);	
	}
    	if($v->passes())
	{
            //check if user exists
            $user = User::where('username','=',$input['username'])->first();
            //dd($user);
            if(is_null($user)){
                return Redirect::to_action('home@index')->with('error_not_exists',true);	
            }
            if ( Auth::attempt($input) )
            {
                //dd(Config::get('offline'));
                if(Config::get('offline') && $user->id != 1)
                {
                    return Redirect::to_action('home@index')->with('maintenance_mode',true);
                    //return Redirect::back();
		}
		//maintenance mode on/off
		//return Redirect::to_action('home@index')->with('success_signin',true);
		return Redirect::back();
            } else {
		return Redirect::to_action('home@index')->with('error_signin',true);		
            }
	}
    }*/
	
    public function get_register()
    {
        $data = array(
            'title' => 'Εγγραφή νέου χρήστη',
            'pageTitle' => 'Εγγραφή νέου χρήστη'
        );
        
        return View::make('users.register',$data);
    }
    
    
    
    public function post_register()
    {	
        // get POST data, attempt to authenticate based on input
        $data = array(
            'first_name' => ucfirst(Input::get('first_name')),
            'last_name' => ucfirst(Input::get('last_name')),
            'password' => Input::get('password'),
            'password_confirmation' => Input::get('password_confirmation'),
            'username' => Input::get('username')
            /*'tel' => Input::get('tel'),
            'mobile' => Input::get('mobile')*/
 	);
   
        //dd($data);
    	//register user
	$user = new User();
	$result = $user->register($data);
	if(is_object($result))
	{
            return Redirect::to_action('users@register')->with_errors($result)->with_input();	
	}
	else
	{
            
            if($result != false)
            {
                Log::write('success', 'user |'.Input::get('username').'| added');
		return Redirect::to_action('home@index')->with('success_register',true);	
            } 
            else
            {
                Log::write('failure', 'user |'.Input::get('username').'|');
                return Redirect::to_action('users@register')->with('error_register',true)->with_input();	
            }
	}
    }
	
    public function get_edit($id)
    {
        if(Auth::guest()){
            return Redirect::to_action('home@index');
        }
        //find user
        $user = User::find($id);
        if(is_null($user))
        {
            return Redirect::to_action('home@index');
        }
        //dd($user);
        $data = array(
            'title' => 'Επεξεργασία λογαριασμού',
            'pageTitle' => 'Επεξεργασία λογαριασμού',
            'user' => $user
        );
        
        return View::make('users.edit',$data);
    }
    
    public function post_edit()
    {
        //find user
        $user = Auth::user();
        if(is_null($user))
        {
            return Redirect::to_action('home@index');
        }
        //update data
        $data = Input::all();
        $result = $user->edit($user,$data);
        //dd($result);
        if(is_object($result))
	{
            return Redirect::to_action('users@edit',array($user->id))->with_errors($result)->with_input();	
	}
	if($result === true)
        {
            //dd($result);
            Log::write('success', 'user updated at&nbsp;' . date('m/d/Y h:i:s a', time()));
            return Redirect::to_action('users@edit',array($user->id))->with('success_edit',true);	
        } 
        else
        {
            return Redirect::to_action('users@edit',array($user->id))->with('error_edit',true)->with_input();	
        }
	
    }
    
    public function get_signout()
    {
        Auth::logout();
	return Redirect::to_action('home@index');
    }

}
?>