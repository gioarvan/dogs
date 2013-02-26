<?php

class Home_Controller extends Base_Controller {

    public function get_index()
    {
        //statistics
        $stats = array();
        $stats['found'] = Dog::where('dog_status','=','F')->count();
        $stats['lost'] = Dog::where('dog_status','=','L')->count();
        $stats['users'] = User::where('id','>','0')->count();
       
        $latest = Dog::get_latest(3);
        
        if(!empty($latest))
        {
            $latest_fixed = array();
            $index = 0;
            foreach($latest as $lst)
            {
                //dd($lst);
                $latest_fixed[$index]['dog_id'] = $lst->id;
                $latest_fixed[$index]['status'] = $lst->dog_status;
                $latest_fixed[$index]['dog_name'] = $lst->dog_name;
                $latest_fixed[$index]['dog_code'] = $lst->dog_code;
                $latest_fixed[$index]['dog_views'] = $lst->dog_views;
                $latest_fixed[$index]['dog_gender'] = $lst->dog_gender;
                $latest_fixed[$index]['breed_id'] = $lst->breed_id;
                if(!empty($lst->breed->breed_name))
                {
                    $latest_fixed[$index]['breed_name'] = $lst->breed->breed_name; 
                } else {
                   $latest_fixed[$index]['breed_name'] = ''; 
                }
                $latest_fixed[$index]['breed_descr'] = $lst->breed_description;
                $latest_fixed[$index]['dog_date'] = $lst->area->dog_date;
                $latest_fixed[$index]['dog_area'] = $lst->area->area;
                $latest_fixed[$index]['img_path'] = path('base').'public/pictures/' .  $lst->dog_code;
                $latest_fixed[$index]['img'] = '';
                if($latest_fixed[$index]['img_path'])
                {
                    //check if has pictures
                    $f = Helper::dir_is_empty($latest_fixed[$index]['img_path']);
                    $img = NULL;
                    if($f == false) {
                        //i have picture inside
                        $exts = array('png','jpg','jpeg');
                        foreach($exts as $ext)
                        {
                            $filename = $latest_fixed[$index]['img_path'].'/'.$lst->dog_code.'.'.$ext;
                            if (file_exists($filename)) {
                                $latest_fixed[$index]['img'] = $lst->dog_code.'/'.$lst->dog_code.'.'.$ext;
                                break;
                            } 
                        }    
                    }
                }
                $index++;
            }
        } else {
            $latest_fixed = NULL;
        }
        //dd($latest_fixed);
        $data = array(
            'title' => 'DogFinder - Αρχική',
            'latest' => $latest_fixed,
            'stats' => $stats
        );
        return View::make('home.index',$data);
    }

}