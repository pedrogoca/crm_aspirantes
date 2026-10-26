<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProgramaAcademico extends Model {
    protected $table = 'programas_academicos';
    public $timestamps = false;
    protected $primaryKey = 'id_programa';
    protected $fillable = ['nombre','modalidad','activo'];
    public function aspirantes(){return $this->hasMany(Aspirante::class,'id_programa');}
}
