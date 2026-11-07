<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject {
    use Notifiable;
    protected $fillable = ['name','email','password','rol'];
    protected $hidden = ['password','remember_token'];
    protected function casts(): array {return ['email_verified_at'=>'datetime','password'=>'hashed'];}
    public function aspirante(){return $this->hasOne(Aspirante::class,'id_usuario','id');}
    public function getJWTIdentifier(){return $this->getKey();}
    public function getJWTCustomClaims(): array {return [];}
    public function esPersonal(): bool {return in_array($this->rol,['ADMISIONES','ADMIN'],true);}
}
