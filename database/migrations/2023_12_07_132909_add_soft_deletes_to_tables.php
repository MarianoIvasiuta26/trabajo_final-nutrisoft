<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actividades', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('actividades_por_tipos_de_actividades', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('actividades_prohibidas_cirugias', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('actividades_prohibidas_patologias', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('actividad_rec_por_tipo_actividades', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('adelantamiento_turnos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('administradors', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('alergias', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('alimentos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('alimentos_prohibidos_alergias', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('alimentos_prohibidos_intolerancias', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('alimentos_prohibidos_patologias', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('alimentos_recomendados_por_dietas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('alimento_por_tipo_de_dietas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('anamnesis_alimentarias', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('cirugias', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('cirugias_pacientes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('comidas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('consultas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('datos_medicos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('detalles_planes_seguimientos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('detalle_plan_alimentaciones', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('diagnosticos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('dias_atencions', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('fuente_alimentos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('grupo_alimentos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('historia_clinicas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('horarios_atencions', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('horas_atencions', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('ingredientes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('intolerancias', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('mediciones_de_pliegues_cutaneos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('nutricionistas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('nutrientes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('pacientes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('patologias', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('planes_de_seguimientos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('plan_alimentaciones', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('recetas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('registro_alimentos_consumidos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tags_diagnosticos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tipos_actividades_por_tratamientos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tipos_de_actividades', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tipos_de_dietas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tipos_de_pliegue_cutaneos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tipo_consultas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tipo_nutrientes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tratamientos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tratamiento_por_pacientes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('turnos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('turnos_temporales', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('unidades_de_tiempos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('unidades_medidas_por_comidas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('valor_analisis_clinicos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('valor_nutricionals', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actividades', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('actividades_por_tipos_de_actividades', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('actividades_prohibidas_cirugias', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('actividades_prohibidas_patologias', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('actividad_rec_por_tipo_actividades', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('adelantamiento_turnos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('administradors', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('alergias', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('alimentos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('alimentos_prohibidos_alergias', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('alimentos_prohibidos_intolerancias', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('alimentos_prohibidos_patologias', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('alimentos_recomendados_por_dietas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('alimento_por_tipo_de_dietas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('anamnesis_alimentarias', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('cirugias', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('cirugias_pacientes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('comidas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('consultas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('datos_medicos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('detalles_planes_seguimientos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('detalle_plan_alimentaciones', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('diagnosticos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('dias_atencions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('fuente_alimentos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('grupo_alimentos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('historia_clinicas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('horarios_atencions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('horas_atencions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('ingredientes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('intolerancias', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('mediciones_de_pliegues_cutaneos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('nutricionistas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('nutrientes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('patologias', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('planes_de_seguimientos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('plan_alimentaciones', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('recetas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('registro_alimentos_consumidos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tags_diagnosticos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tipos_actividades_por_tratamientos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tipos_de_actividades', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tipos_de_dietas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tipos_de_pliegue_cutaneos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tipo_consultas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tipo_nutrientes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tratamientos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tratamiento_por_pacientes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('turnos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('turnos_temporales', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('unidades_de_tiempos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('unidades_medidas_por_comidas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('valor_analisis_clinicos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('valor_nutricionals', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
