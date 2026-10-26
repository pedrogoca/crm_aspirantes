<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Documento extends Model {
    protected $table = 'documentos';
    public $timestamps = false;
    protected $primaryKey = 'id_documento';
    protected $fillable = ['id_aspirante','tipo_documento','ruta_archivo','estatus','observaciones'];
    public function aspirante(){return $this->belongsTo(Aspirante::class,'id_aspirante');}
}
