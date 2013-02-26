<?php

class Breed extends Eloquent
{
    //table name
    public static $table = 'breeds';
    
    //relationships
    public function dogs()
    {
        return $this->has_many('Dog');
    }
}
?>
