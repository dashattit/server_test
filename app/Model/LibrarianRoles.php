<?php
namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibrarianRoles extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'librarian_roles';
    protected $fillable = [
        'role_name',
        'description'
    ];

    public function librarians()
    {
        return $this->hasMany(Librarians::class, 'role_id');
    }
}