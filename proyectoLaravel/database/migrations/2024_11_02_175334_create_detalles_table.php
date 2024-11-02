<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detalles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('fecha_novedad');
            $table->date('fecha_reporte');
            $table->string('desc_codigo');
            $table->string('desc_cliente');
            $table->string('desc_localidad');
            $table->string('desc_puesto');
            $table->string('desc_agente');
            $table->string('desc_tipo_novedad');
            $table->string('desc_tipo_hallazgo');
            $table->string('desc_tipo_incidente');
            $table->string('desc_tipo_act_puesto');
            $table->string('desc_tipo_novedad_protemaxi');
            $table->string('desc_titulo');
            $table->string('desc_detalle');
            $table->string('desc_persona_involucrada');
            $table->string('desc_lugar_involucrado');
            $table->string('desc_comentario');
            $table->string('desc_nombre_central');
            $table->date('fecha_envio_novedad');
            $table->string('desc_estado_novedad');
            $table->string('desc_estado_aprobacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles');
    }
};
