<?php
namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Readers extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'readers';
    protected $fillable = [
        'first_name',
        'last_name',
        'patronym',
        'address',
        'telephone'
    ];

    public function deliveries()
    {
        return $this->hasMany(BookDeliveries::class, 'ticket_number');
    }
}