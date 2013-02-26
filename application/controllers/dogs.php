<?php

class Dogs_Controller extends Base_Controller {

    public function get_addfound() {
        //created data for dropdown
        $breeds = Breed::all();
        $breeds_select = Helper::make_dropdown($breeds, array('id', 'breed_name'), 'Επιλέξτε ράτσα');

        $data = array(
            'title' => 'Προσθήκη νέας καταχώρησης',
            'pageTitle' => 'Προσθήκη νέας καταχώρησης',
            'breeds' => $breeds_select
        );

        return View::make('dogs.addfound', $data);
    }

    public function post_addfound() {
        //check if logged in
        if (Auth::guest()) {
            return Redirect::back()->with_input()->with('not_auth', true);
        }

        //dd(Input::file('dog_image'));
        //get logged in user
        $user = Auth::user();

        //get input
        $data = Input::all();

        $dog = new Dog();
        $result = $dog->add($data, $user, 'F');

        if (is_object($result)) {
            //validation error object
            return Redirect::to_action('dogs@addfound')->with_errors($result)->with_input();
        }
        if (!is_int($result)) {
            return Redirect::to_action('dogs@addfound')->with('error_addfound', true)->with_input();
        }

        if ($result == false) {
            return Redirect::to_action('dogs@addfound')->with('error_upload', true)->with_input();
        }

        //try to insert in areas table

        $area = new Area();
        $result_ = $area->add($data);
        if (is_object($result_)) {
            //validation error object
            return Redirect::to_action('dogs@addfound')->with_errors($result_)->with_input();
        }
        if (!is_int($result_)) {
            return Redirect::to_action('dogs@addfound')->with('error_addfound', true)->with_input();
        }

        //update dogs - set area_id
        $dog = Dog::find($result);
        $dog->area_id = $result_;
        if ($dog->save()) {
            //Upload image process
            if (empty($data['dog_image']['tmp_name'])) {
                Log::write('success', 'dog |' . $dog->dog_code . '| added');
                return Redirect::to_action('dogs@view', array($dog->id))->with('success_add', true);
            } else {
                //upload image - using resizer bundle!    
                $extension = File::extension($data['dog_image']['name']);
                $type = File::extension($data['dog_image']['type']);
                $directory = path('base') . 'public/pictures/' . $dog->dog_code;
                //dd($directory);
                $filepath = $directory . "/" . $dog->dog_code . '.' . $extension;
                // start bundle 'resizer'
                Bundle::start('resizer');
                // resize image		
                $img = Input::file('dog_image');
                //dd($img);
                $success = Resizer::open($img)
                      ->resize(300, 300, 'exact')
                      ->save($filepath, 90);
                // move uploaded file to storage/pictures
                Input::upload('dog_image', $directory, $dog->dog_code);
            }
        }
        Log::write('success', 'dog |' . $dog->dog_code . '| added');
        return Redirect::to_action('dogs@view', array($dog->id))->with('success_add', true);
    }

    public function get_addlost() {
        //created data for dropdown
        $breeds = Breed::all();
        $breeds_select = Helper::make_dropdown($breeds, array('id', 'breed_name'), 'Επιλέξτε ράτσα');

        $data = array(
            'title' => 'Προσθήκη νέας καταχώρησης',
            'pageTitle' => 'Προσθήκη νέας καταχώρησης',
            'breeds' => $breeds_select
        );

        return View::make('dogs.addlost', $data);
    }

    public function post_addlost() {
        //check if logged in
        if (Auth::guest()) {
            return Redirect::back()->with_input()->with('not_auth', true);
        }

        //dd(Input::file('dog_image'));
        //get logged in user
        $user = Auth::user();

        //get input
        $data = Input::all();

        $dog = new Dog();
        $result = $dog->add($data, $user, 'L');

        if (is_object($result)) {
            //validation error object
            return Redirect::to_action('dogs@addlost')->with_errors($result)->with_input();
        }
        if (!is_int($result)) {
            return Redirect::to_action('dogs@addlost')->with('error_addlost', true)->with_input();
        }

        if ($result == false) {
            return Redirect::to_action('dogs@addlost')->with('error_upload', true)->with_input();
        }

        //try to insert in areas table

        $area = new Area();
        $result_ = $area->add($data);
        if (is_object($result_)) {
            //validation error object
            return Redirect::to_action('dogs@addlost')->with_errors($result_)->with_input();
        }
        if (!is_int($result_)) {
            return Redirect::to_action('dogs@addlost')->with('error_addlost', true)->with_input();
        }

        //update dogs - set area_id
        $dog = Dog::find($result);
        $dog->area_id = $result_;
        if ($dog->save() == true) {

            if (empty($data['dog_image']['tmp_name'])) {
                Log::write('success', 'dog |' . $dog->dog_code . '| added');
                return Redirect::to_action('dogs@view', array($dog->id))->with('success_add', true);
            } else {
                //upload image - using resizer bundle!    
                $extension = File::extension($data['dog_image']['name']);
                $type = File::extension($data['dog_image']['type']);
                $directory = path('base') . 'public/pictures/' . $dog->dog_code;
                //dd($directory);
                $filepath = $directory . "/" . $dog->dog_code . '.' . $extension;
                // start bundle 'resizer'
                Bundle::start('resizer');
                // resize image		
                $img = Input::file('dog_image');
                //dd($img);
                $success = Resizer::open($img)
                      ->resize(300, 300, 'exact')
                      ->save($filepath, 90);
                // move uploaded file to storage/pictures
                Input::upload('dog_image', $directory, $dog->dog_code);
            }
        }
        Log::write('success', 'dog |' . $dog->dog_code . '| added');
        return Redirect::to_action('dogs@view', array($dog->id))->with('success_add', true);
    }

    public function get_lost($dogs = NULL) {
        if ($dogs == NULL) {
            //get all lost doggies
            $dogs = Dog::with(array('breed', 'area', 'user'))->where('dog_status', '=', 'L');
            $count = $dogs->count();
            $dogs->order_by('created_at', 'DESC');
        }
        //pagination setup
        $perPage = Input::get('perPage', 10);
        // Pagination links setup.
        $pagination = array(
            'perPage' => $perPage,
        );
        $dogs = $dogs->paginate($perPage);
        $dogs->appends($pagination)->links();
        //created data for dropdown
        $breeds = Breed::all();
        $breeds_select = Helper::make_dropdown($breeds, array('id', 'breed_name'), 'Επιλέξτε ράτσα');

        //lost total
        $total_lost = Dog::where('dog_status', '=', 'L')->count();

        $data = array(
            'dogs' => $dogs,
            'total' => $count,
            'title' => 'Λίστα με σκυλάκια που χάθηκαν',
            'pageTitle' => 'Λίστα με σκυλάκια που χάθηκαν',
            'breeds' => $breeds_select,
            'total' => $total_lost
        );

        return View::make('dogs.lost', $data);
    }

    public function get_found() {
        //get lost doggies
        $dogs = Dog::with(array('breed', 'area', 'user'))->where('dog_status', '=', 'F');
        $count = $dogs->count();
        $dogs->order_by('created_at', 'DESC');
        //pagination setup
        $perPage = Input::get('perPage', 10);
        // Pagination links setup.
        $pagination = array(
            'perPage' => $perPage,
        );
        $dogs = $dogs->paginate($perPage);
        $dogs->appends($pagination)->links();

        //created data for dropdown
        $breeds = Breed::all();
        $breeds_select = Helper::make_dropdown($breeds, array('id', 'breed_name'), 'Επιλέξτε ράτσα');

        //total found
        $total_found = Dog::where('dog_status', '=', 'F')->count();

        $data = array(
            'dogs' => $dogs,
            'total' => $count,
            'title' => 'Λίστα με σκυλάκια που βρέθηκαν',
            'pageTitle' => 'Λίστα με σκυλάκια που βρέθηκαν',
            'breeds' => $breeds_select,
            'total' => $total_found
        );

        return View::make('dogs.found', $data);
    }

    public function get_view($id, $page = NULL) {
        //find dog
        $dog = Dog::with(array('breed', 'area', 'user'))->where('id', '=', $id)->first();
        if (is_null($dog)) {
            return Redirect::back();
        }

        //find picture - if exists
        $img_path = path('base') . 'public/pictures/' . $dog->dog_code;
        if ($img_path) {
            //check if has pictures
            $f = Helper::dir_is_empty($img_path);
            $img = NULL;
            if ($f == false) {
                //i have picture inside
                $exts = array('png', 'jpg', 'jpeg');
                foreach ($exts as $ext) {
                    $filename = $img_path . '/' . $dog->dog_code . '.' . $ext;
                    if (file_exists($filename)) {
                        $img = $dog->dog_code . '/' . $dog->dog_code . '.' . $ext;
                        break;
                    }
                }
            }
        }
        $msg_found = false;
        $msg_finder = false;
        if ($dog->dog_status == 'F') {
            $msg_found = true;
            $msg_finder = true;
        }
        //dd($img);
        $data = array(
            'dog' => $dog,
            'img' => $img,
            'title' => 'Προβολή ' . $dog->dog_name,
            'pageTitle' => 'ID: ' . $dog->dog_code,
            'views' => $dog->dog_views,
            'msg_found' => $msg_found,
            'msg_finder' => $msg_finder
        );
      
        //add +1 view
        //get user ip
        $user_ip = Request::ip();
        //check if exists
        $ip = Pageview::where('user_ip','=',$user_ip)->where('dog_id','=',$dog->id)->first();    
        if(is_null($ip))
        {
           //add user ip
           $v = new Pageview();
           $view['user_ip'] = $user_ip;
           $view['dog_id'] = $dog->id;
           $result = $v->add($view);
        }
        
        return View::make('dogs.view', $data);
    }

    public function get_editlost($id) {
        //find user
        $user = Auth::user();
        if (!$user) {
            return Redirect::to_action('home@index');
        }
        //find dog
        $dog = Dog::find($id);
        //check if folder exists
        $img = NULL;
        if (is_dir(path('base') . 'public/pictures/' . $dog->dog_code)) {
            if ($handle = opendir(path('base') . 'public/pictures/' . $dog->dog_code)) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        $ext = substr($entry, strrpos($entry, '.') + 1);
                        if ($ext == 'png' || $ext == 'jpeg' || $ext == 'jpg') {
                            $img = $dog->dog_code . '/' . $dog->dog_code . '.' . $ext;
                        }
                    }
                }
                closedir($handle);
            }
        }
        if (!is_null($dog)) {
            //check if dog belongs to user
            if ($dog->user_id != $user->id) {
                return Redirect::to_action('dogs@lost');
            } else {
                //created data for dropdown
                $breeds = Breed::all();
                $breeds_select = Helper::make_dropdown($breeds, array('id', 'breed_name'), 'Επιλέξτε ράτσα');
                $data = array(
                    'title' => 'Επεξεργασία σκύλου',
                    'pageTitle' => 'Επεξεργασία σκύλου',
                    'dog' => $dog,
                    'breeds' => $breeds_select,
                    'img' => $img
                );
                return View::make('dogs.editlost', $data);
            }
        }
    }

    public function post_editlost() {
        //get logged in user
        $user = Auth::user();
        //get input
        $data = Input::all();
        $dog_id = $data['dog_id'];
        $dog = Dog::find($dog_id);
        $result = $dog->edit($data, $user);
        //dd($result);
        if (is_object($result)) {
            //validation error object
            return Redirect::to_action('dogs@editlost', array($dog->id))->with_errors($result)->with_input();
        }
        if (!is_int($result)) {
            return Redirect::to_action('dogs@editlost', array($dog->id))->with('error_editlost', true)->with_input();
        }

        return Redirect::to_action('dogs@editlost', array($dog->id))->with('success_editlost', true)->with_input();
    }

    public function get_editfound($id) {
        //find user
        $user = Auth::user();
        if (!$user) {
            return Redirect::to_action('home@index');
        }
        //find dog
        $dog = Dog::find($id);
        //check if folder exists
        $img = NULL;
        if (is_dir(path('base') . 'public/pictures/' . $dog->dog_code)) {
            if ($handle = opendir(path('base') . 'public/pictures/' . $dog->dog_code)) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        $ext = substr($entry, strrpos($entry, '.') + 1);
                        if ($ext == 'png' || $ext == 'jpeg' || $ext == 'jpg') {
                            $img = $dog->dog_code . '/' . $dog->dog_code . '.' . $ext;
                        }
                    }
                }
                closedir($handle);
            }
        }
        if (!is_null($dog)) {
            //check if dog belongs to user
            if ($dog->user_id != $user->id) {
                return Redirect::to_action('dogs@found');
            } else {
                //created data for dropdown
                $breeds = Breed::all();
                $breeds_select = Helper::make_dropdown($breeds, array('id', 'breed_name'), 'Επιλέξτε ράτσα');
                $data = array(
                    'title' => 'Επεξεργασία σκύλου',
                    'pageTitle' => 'Επεξεργασία σκύλου',
                    'dog' => $dog,
                    'breeds' => $breeds_select,
                    'img' => $img
                );
                return View::make('dogs.editfound', $data);
            }
        }
    }

    public function post_editfound() {
        //get logged in user
        $user = Auth::user();
        //get input
        $data = Input::all();
        $dog_id = $data['dog_id'];
        $dog = Dog::find($dog_id);
        $result = $dog->edit($data, $user, 'F');
        //dd($result);
        if (is_object($result)) {
            //validation error object
            return Redirect::to_action('dogs@editfound', array($dog->id))->with_errors($result)->with_input();
        }
        if (!is_int($result)) {
            //dd($result);
            return Redirect::to_action('dogs@editfound', array($dog->id))->with('error_editfound', true)->with_input();
        }

        return Redirect::to_action('dogs@editfound', array($dog->id))->with('success_editfound', true)->with_input();
    }

    public function get_delete($id, $page) {
        $user = Auth::user();
        $dog = Dog::where('id', '=', $id)->where('user_id', '=', $user->id)->first();
        //dd($dog);
        if (is_null($dog)) {
            return Redirect::to_action('home@index');
        }
        //delete directory
        if (is_dir(path('base') . 'public/pictures/' . $dog->dog_code)) {
            $dir = path('base') . 'public/pictures/' . $dog->dog_code;
            foreach (glob($dir . '/*') as $file) {
                if (is_dir($file))
                    rrmdir($file);
                else
                    unlink($file);
            }
            rmdir($dir);
        }
        //delete area
        $area = Area::where('id', '=', $dog->area_id);
        if (!is_null($area)) {
            if (!$area->delete()) {
                return Redirect::to_action('dogs@' . $page);
            }
            //delete dog
            if ($dog->delete()) {
                return Redirect::to_action('dogs@' . $page);
            } else {
                return Redirect::to_action('dogs@' . $page);
            }
        }
    }

}

?>
