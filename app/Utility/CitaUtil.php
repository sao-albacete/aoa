<?php

class CitaUtil {
    
    /**
     * Calcula la importancia de la cita a partir de los datos de la especie
     * 
     * @param Especie $especie
     */
    public static function calcularImportanciaCita($indRareza, $claseCriterio, $claseReproduccion) {
        
        // Por defecto, ND - No destacado
        $importancia_cita = 13;

        // R - Rareza nacional
        if ($indRareza == 1) {
            $importancia_cita = 1;
        }

        // r - Rareza local
        if ($indRareza == 2) {
            $importancia_cita = 2;
        }

        // EP - Especie protegida EN o VU
        if ($claseCriterio == 2) {
            $importancia_cita = 3;
        }

        // E - Especie muy escasa
        if ($claseCriterio == 3 || $claseCriterio == 4) {
            $importancia_cita = 4;
        }

        // R? - Rareza nacional con cría probable
        if ($indRareza == 1 && ($claseReproduccion >= 2 && $claseReproduccion <= 5)) {
            $importancia_cita = 5;
        }

        // r? - Rareza local con cría probable
        if ($indRareza == 2 && ($claseReproduccion >= 2 && $claseReproduccion <= 5)) {
            $importancia_cita = 6;
        }

        // EP? - Esp. Protegida con cría probable
        if ($claseCriterio == 2 && ($claseReproduccion >= 2 && $claseReproduccion <= 5)) {
            $importancia_cita = 7;
        }

        // E? - Especie escasa con cría probable
        if (($claseCriterio == 3 || $claseCriterio == 4) && ($claseReproduccion >= 2 && $claseReproduccion <= 5)) {
            $importancia_cita = 8;
        }

        // R¡ - Rareza nacional con cría segura
        if ($indRareza == 1 && ($claseReproduccion >= 6 && $claseReproduccion <= 10)) {
            $importancia_cita = 9;
        }

        // r¡ - Rareza local con cría segura
        if ($indRareza == 2 && ($claseReproduccion >= 6 && $claseReproduccion <= 10)) {
            $importancia_cita = 10;
        }

        // EP¡ - Esp. Protegida con cría segura
        if ($claseCriterio == 2 && ($claseReproduccion >= 6 && $claseReproduccion <= 10)) {
            $importancia_cita = 11;
        }

        // E¡ - Especie escasa con cría segura
        if (($claseCriterio == 3 || $claseCriterio == 4) && ($claseReproduccion >= 6 && $claseReproduccion <= 10)) {
            $importancia_cita = 12;
        }

        return $importancia_cita;
    }
    
    /**
     * Calcula el criterio de selección de la cita
     * 
     * @param Array $cita
     * @param Array $especie
     * @param Number $numeroCitasPorLugar
     */
    public static function calcularCriterioSeleccion($cita, $especie, $numeroCitasPorLugar) {
        
        $criterio_seleccion = 21;

        $clase_criterio = $especie['Especie']['clasificacion_criterio_esp_id'];
        $cria = $cita['clase_reproduccion_id'];
        $numero = $cita['cantidad'];
        $observaciones = StringUtil::sanear_string($cita['observaciones']);

        $indHabitatAtipico = 0;
        if (isset($cita['indHabitatRaro'])) {
            $indHabitatAtipico = $cita['indHabitatRaro'];
        }

        $indComportamientoCurioso = 0;
        if (isset($cita['indComportamiento'])) {
            $indComportamientoCurioso = $cita['indComportamiento'];
        }

        $indHerido = 0;
        if (isset($cita['indHerido'])) {
            $indHerido = $cita['indHerido'];
        }

        $fechaArray = explode("-", $cita['fechaAlta']);
        $mes = intval($fechaArray[1]);
        $dia = intval($fechaArray[2]);

        /*
         * Citas de presencia
         * De rarezas, escasas o poco conocidas en la provincia
         */
        // A1
        if($clase_criterio == 1 || $clase_criterio == 3 || $clase_criterio == 4) {
            $criterio_seleccion = 1;
        }

        /*
         * Citas de conservación
         * Todas las citas de especies incluidas en el Catálogo Regional de Especies Amenazadas, en las categorías de "En Peligro" y "Vulnerables".
         */
        // G1
        elseif ($clase_criterio == 2) {
            $criterio_seleccion = 19;
        }

        /*
         * Citas de reproducción
         * Datos de cría posible, probable y confirmada de especies que no sean abundantes.
         */
        // E1
        elseif(($clase_criterio == 3 || $clase_criterio == 4 || $clase_criterio == 5) && ($cria >= 2 && $cria <= 10)) {
            $criterio_seleccion = 14;
        }

        /*
         * Citas de abundancia
         * De especies escasas en la provincia, zona, biotopo, etc.
         */
        // D3
        elseif($clase_criterio == 9 && $numero > 4) {
            $criterio_seleccion = 13;
        }

        /*
         * Citas de fenología
         * De aves en épocas anormales para la especie.
         */
        // C1
        elseif((($clase_criterio == 6 ) && ((($mes == 12) || ($mes == 1) || ($mes == 2) || ($mes == 11 && $dia >= 15) || ($mes == 3 && $dia == 1)) || (($mes == 6) || ($mes == 5 && $dia >= 15) || ($mes == 7 && $dia <= 15))))
                || (($clase_criterio == 7 ) && (($mes == 12) || ($mes == 1) || ($mes == 2) || ($mes == 11 && $dia >= 15) || ($mes == 3 && $dia == 1)))
                || (($clase_criterio == 8 ) && (($mes >= 3 && $mes <= 9) || ($mes == 10 && $dia <= 15)))) {
            $criterio_seleccion = 5;
        }

        /*
         * Citas de fenología
         * Primeras observaciones en especies en paso migratorio prenupcial (primera observación prenupcial) o en paso posnupcial (primera observación posnupcial).
         */
        // C2
        elseif(($clase_criterio == 6) && (($mes == 2 && $dia >= 15) || ($mes == 3 && $dia <= 15) || ($mes == 8) || ($mes == 7 && $dia >= 15) || ($mes == 9 && $dia == 1))) {
            $criterio_seleccion = 6;
        }

        /*
         * Citas de fenología
         * Primeras observaciones de especies estivales. Es preciso poner cuidado en distinguir estas aves nativas de otros individuos de la misma especie que pueden pasar por la localidad de observación pero no quedarse a criar en ella.En caso de duda se anota como primera observación.
         */
        // C3
        elseif(($clase_criterio == 7) && (($mes == 2 && $dia >= 15) || ($mes == 3 && $dia <= 15))) {
            $criterio_seleccion = 7;
        }

        /*
         * Citas de fenología
         * Primeros invernantes vistos en una localidad determinada.
         */
        // C4
        elseif(($clase_criterio == 8) && (($mes == 10 && $dia >= 15) || ($mes == 11 && $dia <= 15))) {
            $criterio_seleccion = 8;
        }

        /*
         * Citas de fenología
         * De aves vistas en últimas observaciones tanto en migrantes, como en estivales e invernantes.
         */
        // C5
        elseif((($clase_criterio == 6 || $clase_criterio == 7) && ($mes == 11 && $dia <= 15))
                || (($clase_criterio == 8) && (($mes == 2 && $dia >= 15) || ($mes == 3 && $dia == 1)))) {
            $criterio_seleccion = 9;
        }

        /*
         * Citas de fenología
         * De aves vistas en migración activa o sedimentadas fuera de un hábitat típico.
         */
        // C6
        elseif(strpos($observaciones,'migracion') || strpos($observaciones,'sedimentacion') || strpos($observaciones,'activa') || strpos($observaciones,'migrando')) {
            $criterio_seleccion = 10;
        }

        /*
         * Citas de abundancia
         * De concentraciones anormales o sobresalientes de una especie, por el elevado o bajo número de aves.
         */
        // D1
        elseif ($numero > 30) {
            $criterio_seleccion = 11;
        }

        /*
         * Citas de reproducción
         * Datos de nidificación de especies abundantes, pero fuera de su hábitat típico.
         */
        // E2
        elseif (($clase_criterio == 9 || $clase_criterio == 10) && ($cria >= 2 && $cria <= 10) && $indHabitatAtipico) {
            $criterio_seleccion = 15;
        }

        /*
         * Citas de comportamiento
         * Extraños o curiosos, de cualquier ave.
         */
        // F1
        elseif (($clase_criterio == 9 || $clase_criterio == 10) && $indComportamientoCurioso) {
            $criterio_seleccion = 17;
        }

        /*
         * Citas de conservación
         * Citas de aves encontradas muertas o heridas, por cualquier causa.
         */
        // G2
        elseif ($indHerido) {
            $criterio_seleccion = 20;
        }

        /*
         * Citas de abundancia
         * De conteos en censos y jornadas de anillamiento.
         */
        // D2
        elseif (strpos($observaciones,'censo') || strpos($observaciones,'anillamiento') || strpos($observaciones,'anillado') || strpos($observaciones,'anillada')) {
            $criterio_seleccion = 12;
        }

        /*
         * Citas de distribución
         * En localidades o zonas de la geografía provincial poco prospectadas o con escasos datos.
         */
        // A2
        elseif ($numeroCitasPorLugar > 50) {
            $criterio_seleccion = 2;
        }

        return $criterio_seleccion;
    }
    
}
