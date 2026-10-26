<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('users',function(Blueprint $t){
            $t->id();$t->string('name',150);$t->string('email',150)->unique();$t->timestamp('email_verified_at')->nullable();$t->string('password');$t->enum('rol',['ASPIRANTE','ADMISIONES','ADMIN'])->default('ASPIRANTE');$t->rememberToken();$t->timestamps();
        });
        Schema::create('programas_academicos',function(Blueprint $t){
            $t->id('id_programa');$t->string('nombre',150);$t->enum('modalidad',['ESCOLARIZADA','MIXTA','EN_LINEA']);$t->boolean('activo')->default(true);
        });
        Schema::create('aspirantes',function(Blueprint $t){
            $t->id('id_aspirante');$t->foreignId('id_usuario')->unique()->constrained('users');$t->unsignedBigInteger('id_programa');$t->foreign('id_programa')->references('id_programa')->on('programas_academicos');
            $t->string('nombre',100);$t->string('apellido_paterno',100);$t->string('apellido_materno',100)->nullable();$t->string('telefono',20)->nullable();$t->enum('estatus',['REGISTRADO','EN_REVISION','ACEPTADO','RECHAZADO'])->default('REGISTRADO');$t->dateTime('fecha_registro')->useCurrent();
            $t->index(['estatus','id_programa']);
        });
        Schema::create('documentos',function(Blueprint $t){
            $t->id('id_documento');$t->unsignedBigInteger('id_aspirante');$t->foreign('id_aspirante')->references('id_aspirante')->on('aspirantes');$t->string('tipo_documento',100);$t->string('ruta_archivo',255);$t->enum('estatus',['PENDIENTE','ACEPTADO','RECHAZADO'])->default('PENDIENTE');$t->text('observaciones')->nullable();$t->dateTime('fecha_carga')->useCurrent();
        });
        Schema::create('pagos',function(Blueprint $t){
            $t->id('id_pago');$t->unsignedBigInteger('id_aspirante');$t->foreign('id_aspirante')->references('id_aspirante')->on('aspirantes');$t->string('concepto',150);$t->decimal('monto',10,2);$t->enum('estatus',['PENDIENTE','VALIDADO','RECHAZADO'])->default('PENDIENTE');$t->dateTime('fecha_registro')->useCurrent();
        });
        Schema::create('seguimiento',function(Blueprint $t){
            $t->id('id_seguimiento');$t->unsignedBigInteger('id_aspirante');$t->foreign('id_aspirante')->references('id_aspirante')->on('aspirantes');$t->foreignId('id_usuario')->constrained('users');$t->string('estatus',50);$t->text('observaciones')->nullable();$t->dateTime('fecha')->useCurrent();
        });
    }
    public function down(): void {foreach(['seguimiento','pagos','documentos','aspirantes','programas_academicos','users'] as $table) Schema::dropIfExists($table);}
};
