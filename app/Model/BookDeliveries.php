<?php
namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookDeliveries extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'book_deliveries';
    protected $fillable = [
        'library_id',
        'book_id',
        'ticket_number',
        'date_extradition',
        'date_return'
    ];

    public function librarian()
    {
        return $this->belongsTo(Librarians::class, 'library_id');
    }

    public function book()
    {
        return $this->belongsTo(Books::class, 'book_id');
    }

    public function reader()
    {
        return $this->belongsTo(Readers::class, 'ticket_number');
    }
}