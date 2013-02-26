<?php

class Area extends Eloquent
{
    //table name
    public static $table = 'areas';
    
    //relationships
    public function dogs()
    {
        return $this->has_many('Dog');
    }
    
    //functionnality
    public function add($data)
    {
        //dd($data);
         //validation
        $rules = array(
            'dog_date' => 'required',
            'dog_postal' => 'required|numeric', 
            'lat' => 'required',
            'long' => 'required',
            'area' => 'required'
        );
        $validation = Validator::make($data, $rules);
        if( $validation->fails() ) {
            return $validation->errors;	
        }
        if($validation->passes())
        {
            $area = new Area();
            $area->dog_date = $data['dog_date'];
            $area->dog_postal = $data['dog_postal'];
            $area->lat = (float)$data['lat'];
            $area->long = (float)$data['long'];
            $area->area = $data['area'];
            $area->save();
            return $area->id;
        }
    }
}
?>
