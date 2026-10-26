<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pago extends Model {
    protected $table = 'pagos';
    public $timestamps = false;
    protected $primaryKey = 'id_pago';
    protected $fillable = ['id_aspirante','concepto','monto','estatus'];
    public function aspirante(){return $this->belongsTo(Aspirante::class,'id_aspirante');}
}
