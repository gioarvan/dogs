<?php class Helper
{
    public static function errors($oErrors)
    {
        $html = '';
        //if($oErrors->messages)
        //dd($oErrors);
       
        foreach($oErrors->messages as $k=>$v)
	{
            //datepicker bug! :)
            if($k == 'dog_date')
            {
                $k = 'error_dog_date';
            }
            $html .= '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">×</a><span class="error-msg" id="'.$k.'">'.$v[0].'</span></div>';
            break;
        }
	return $html;
    }
        
    public static function make_dropdown($data,$fields,$default = NULL)
    {
        $output = array();
        if(!empty($data))
        {
            //set default value
            if($default != NULL && isset($default))
            {
                $output[-1] = $default;
                $output[-2] = 'Άλλο';
            }
            foreach($data as $dt)
            {
                //convert object structure to array
                $dt_arr = get_object_vars($dt);
                //echo '<pre>';print_r($dt_arr);exit;
                $output[$dt_arr['attributes'][$fields[0]]] = $dt_arr['attributes'][$fields[1]];	
            }
        }
        //dd($output);
        return $output;
    }
    
    public static function uploadImg($imgArr,$img,$dirname)
    {
        //upload picture
        /*
        $extension = File::extension($imgArr['name']);
        $type = File::extension($imgArr['type']);
        $directory = path('storage').'pictures/'.$dirname; 
        $filename = $dirname.".".$extension;
        $upload = Input::upload($img, $directory, $filename);
        if($upload) {
            return true;
        } else {
            return false;
        }*/
        
    }
    
    public static function dir_is_empty($dir)
    {
        $dirItems = count(scandir($dir));
        if($dirItems > 2) return false;
        else return true;
    }
    
    public static function show_size($size)
    {
        $labelSize = '';
        switch($size)
        {
            case 'S':
                $labelSize = 'Small - μικρού μεγέθους';
                break;
            case 'T':
                $labelSize = 'Toy - πολύ μικρού μεγέθους';
                break;
            case 'M':
                $labelSize = 'Medium - μεσαίου μεγέθους';
                break;
            case 'L':
                $labelSize = 'Large - μεγάλου μεγέθους';
                break;
        }
        return $labelSize;
    }
    
    public static function show_color($color)
    {
        $labelColor = '';
        switch($color)
        {
            case 'B':
                $labelColor = 'Μαύρο';
                break;
            case 'BR':
                $labelColor = 'Καφέ';
                break;
            case 'G':
                $labelColor = 'Γκρι';
                break;
            case 'W':
                $labelColor = 'Άσπρο';
                break;
        }
        return $labelColor;
    }
    
     public static function show_gender($gender)
    {
        $labelGender = '';
        switch($gender)
        {
            case 'F':
                $labelGender = 'Θηλυκό';
                break;
            case 'M':
                $labelGender = 'Αρσενικό';
                break;
           
        }
        return $labelGender;
    }
  
}
?>