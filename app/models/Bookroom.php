<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Bookroom extends Model
{
    protected $table = 'book_room';
	
	const CREATED_AT = 'DATE_ADDED';
	const UPDATED_AT = 'DATE_UPDATED';
}
