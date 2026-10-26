<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Aspirante extends Model {
    protected $table = 'aspirantes';
    public $timestamps = false;
    protected $primaryKey = 'id_aspirante';
    protected $fillable = ['id_usuario','id_programa','nombre','apellido_paterno','apellido_materno','telefono','estatus'];
    public function usuario(){return $this->belongsTo(User::class,'id_usuario');}
    public function programa(){return $this->belongsTo(ProgramaAcademico::class,'id_programa');}
    public function documentos(){return $this->hasMany(Documento::class,'id_aspirante');}
    public function pagos(){return $this->hasMany(Pago::class,'id_aspirante');}
    public function seguimientos(){return $this->hasMany(Seguimiento::class,'id_aspirante');}
}
