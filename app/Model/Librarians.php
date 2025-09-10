<?php
namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Librarians extends Model implements IdentityInterface
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'librarians';
    protected $fillable = [
        'first_name',
        'last_name',
        'patronym',
        'login',
        'password',
        'role_id',
        'avatar'
    ];

    protected $hidden = [
        'password'
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->password = md5($user->password);
            $user->save();
        });
    }

    public function findIdentity(int $id)
    {
        return self::where('id', $id)->first();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function attemptIdentity(array $credentials)
    {
        return self::where([
            'login' => $credentials['login'],
            'password' => md5($credentials['password'])
        ])->first();
    }

    public function role()
    {
        return $this->belongsTo(LibrarianRoles::class, 'role_id');
    }

    public function deliveries()
    {
        return $this->hasMany(BookDeliveries::class, 'library_id');
    }

    public function uploadAvatar(array $file): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            return null;
        }
        $fullPath = 'uploads/avatars/' . $newFileName;
        move_uploaded_file($fileTmpPath, $fullPath);
        return 'public/' . $fullPath;
    }
}