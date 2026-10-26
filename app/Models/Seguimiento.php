<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Seguimiento extends Model {
    protected $table = 'seguimiento';
    public $timestamps = false;
    protected $primaryKey = 'id_seguimiento';
    protected $fillable = ['id_aspirante','id_usuario','estatus','observaciones'];
    public function aspirante(){return $this->belongsTo(Aspirante::class,'id_aspirante');}
    public function usuario(){return $this->belongsTo(User::class,'id_usuario');}
}
