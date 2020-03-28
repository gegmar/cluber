<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeatMap extends Model
{
    protected $fillable = ['seats', 'name', 'description', 'layout'];

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function getRowsAndColumns()
    {
        if(!$this->layout) {
            return null;
        }

        $result = [];

        $rows = json_decode($this->layout);
        $result['rows'] = count($rows);
        $result['columns'] = array_reduce($rows, function($intermediate, $row) {
            $columns = strlen($row);
            if($intermediate < $columns) {
                return $columns;
            } else {
                return $intermediate;
            }
        }, 0);
        return $result;
    }
}
