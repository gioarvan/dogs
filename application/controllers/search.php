<?php
/*  Search Controller
 * 
 */
class Search_Controller extends Base_Controller
{
    public function post_search() 
    {
        //lost or found?
        $page = Input::get('page');
        if(empty($page))
        {
            return Redirect::to_action('home@index');
        }
        
        //get a dog model with its relationships;
        $dogs = Dog::with(array('breed','area','user'))->where('dog_status','=',$page);
        
        //get input all
        $input = Input::all();
        
        //i do not need the page
        unset($input['page']);
        
        //get Dogs model valid filters
        $valids = Dog::$valid_filters;
        
        //loop throught search filters to create SQL query
        foreach( $valids as $filter )
        {
            if ( $value = Input::get( $filter ) )
            {
                if(!empty($value) && $value != -1)
                {
                   if($filter == 'dog_postal'){
                       //find areas based on this dog_postal
                       $areas = Area::where('dog_postal','=',$value)->get();
                       if(!empty($areas)) {
                           $areas_ids = array();
                           foreach($areas as $area){
                               $areas_ids[] = $area->id;
                           }
                           $dogs->where_in('area_id',$areas_ids);
                       } else {
                           //dummy query - just ignore area_id
                           $dogs->where('area_id','=',0);
                       }
                   } else {
                        $dogs->where( $filter,'=',$value);
                   }
                }
            }
        }
        
         //get total records
        $count = $dogs->count();
        
        //get breeds
        $breeds = Breed::all();
        $breeds_select = Helper::make_dropdown($breeds,array('id','breed_name'),'Επιλέξτε ράτσα');
        
        //pagination setup
	$perPage   = Input::get('perPage', 10);
        // Pagination links setup.
        $pagination = array(
            'perPage'   => $perPage,
        );
        $dogs = $dogs->paginate( $perPage );
	$dogs->appends( $pagination )->links();
        
        switch($page)
        {
                case 'L':
                   $data = array(
                        'dogs' => $dogs,
                        'total' => $count,
                        'title' => 'Λίστα  με σκυλάκια που χάθηκαν', 
                        'pageTitle' => 'Λίστα  με σκυλάκια που χάθηκαν',
                        'breeds' => $breeds_select
                   );
                   return View::make('dogs.lost',$data);
                   break;
               case 'F':
                   $data = array(
                        'dogs' => $dogs,
                        'total' => $count,
                        'title' => 'Λίστα με σκυλάκια που βρέθηκαν', 
                        'pageTitle' => 'Λίστα με σκυλάκια που βρέθηκαν',
                        'breeds' => $breeds_select
                   );
                   return View::make('dogs.found',$data);
                   break;
        }
    }
}
?>
