<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{User,ProgramaAcademico};
class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::firstOrCreate(['email'=>'admin@crm.local'],['name'=>'Administrador Demo','password'=>'CrmDemo123!','rol'=>'ADMIN']);
        foreach([['Licenciatura en Administración','ESCOLARIZADA'],['Ingeniería en Sistemas','MIXTA'],['Maestría en Educación','EN_LINEA']] as [$nombre,$modalidad]) ProgramaAcademico::firstOrCreate(['nombre'=>$nombre],['modalidad'=>$modalidad,'activo'=>true]);
    }
}
