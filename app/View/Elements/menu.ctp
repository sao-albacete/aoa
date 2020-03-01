<!-- Barra de navegación superior -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="container">

            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
            </a>

            <!-- Everything you want hidden at 940px or less, place within here -->
            <div class="nav-collapse collapse">
                <ul class="nav">
                
                    <?php 
                    
                    $out = "";
                    
                    $inicio = "dropdown";
                    $citas = "dropdown";
                    $especies = "dropdown";
                    $localizacion = "dropdown";
                    $observadores = "dropdown";
                    $acercaDe = "dropdown";
                    $ayuda = "dropdown";
                    
                    if (isset($id_opcion_seleccionada)) {
                        
                        switch ($id_opcion_seleccionada) {
                            case Constants::MENU_INICIO_ID:
                                $inicio .= " active";
                                break;
                            case Constants::MENU_CITAS_ID:
                                $citas .= " active";
                                break;
                            case Constants::MENU_ESPECIE_ID:
                                $especies .= " active";
                                break;
                            case Constants::MENU_LOCALIZACION_ID:
                                $localizacion .= " active";
                                break;
                            case Constants::MENU_OBSERVADORES_ID:
                                $observadores .= " active";
                                break;
                            case Constants::MENU_ACERCA_DE_ID:
                                $acercaDe .= " active";
                                break;
                            case Constants::MENU_AYUDA_ID:
                                $ayuda .= " active";
                                break;
                            default:
                                break;
                        }
                    }

                    ?>
                    
                    <!-- Inicio -->
                    <li class="<?=$inicio?>"><a href="/"><i class="icon-home"></i>&nbsp;&nbsp;<?=__("Inicio")?></a></li>
                    
                    <li class="divider-vertical"></li>
                    
                    <!-- Citas -->
                    <li class="<?=$citas?>">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-eye-open"></i>&nbsp;&nbsp;<?=__("Citas")?> <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                    <!-- Buscar citas -->
                    <li><a href="/cita/"><i class="icon-filter"></i>&nbsp;<?=__("Buscar citas")?></a></li>
                    <li class="divider"></li>
                    <!-- Nueva cita -->
                    <li><a href="/cita/add/"><i class="icon-plus"></i>&nbsp;<?=__("Nueva cita")?></a></li>
                    <!-- Nuevas citas múltiples -->
                    <li><a href="/cita/add_multiple/"><i class="icon-list"></i>&nbsp;<?=__("Nuevas citas múltiples")?></a></li>
                    </ul>
                    
                    <li class="divider-vertical"></li>
                    
                    <!-- Especies -->
                    <li class="<?=$especies?>">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown"><img src="/img/icons/bird.png" width="20px">&nbsp;&nbsp;<?=__("Especies")?> <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                    <!-- Lista de aves de Albacete -->
                    <li><a href="/especie/lista_ab/"><i class="icon-list"></i>&nbsp;<?=__("Lista de Aves de Albacete")?></a></li>
                    <li class="divider"></li>
                    <!-- Especies objetivo -->
                    <li><a href="/especie/especies_objetivo/"><i class="icon-flag"></i>&nbsp;<?=__("Especies objetivo")?></a></li>
                    </ul>
                    
                    <li class="divider-vertical"></li>
                    
                    <!-- Localizacion -->
                    <li class="<?=$localizacion?>">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-map-marker"></i>&nbsp;&nbsp;<?=__("Localización")?> <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                    <!-- Lugares -->
                    <li><a href="/lugar/"><i class="icon-map-marker"></i>&nbsp;<?=__("Lugares")?></a></li>
                    <li class="divider"></li>
                    <!-- Municipios -->
                    <li><a href="/municipio/"><i class="icon-globe"></i>&nbsp;<?=__("Municipios")?></a></li>
                    <!-- Comarcas -->
                    <li><a href="/comarca/"><i class="icon-globe"></i>&nbsp;<?=__("Comarcas")?></a></li>
                    <!-- Cuadriculas UTM -->
                    <li><a href="/cuadriculaUtm/"><i class="icon-globe"></i>&nbsp;<?=__("Cuadrículas UTM")?></a></li>
                    </ul>
                    
                    <li class="divider-vertical"></li>
                    
                    <!-- Observadores -->
                    <li class="<?=$observadores?>">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>&nbsp;&nbsp;<?=__("Observadores")?> <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                    <!-- Observadores -->
                    <li><a href="/observadorPrincipal/"><i class="icon-user"></i>&nbsp;<?=__("Observadores")?></a></li>
                    <li class="divider"></li>
                    <!-- Colaboradores -->
                    <li><a href="/observadorSecundario/"><i class="icon-user"></i>&nbsp;<?=__("Colaboradores")?></a></li>
                    </ul>
                    <li class="divider-vertical"></li>
                    
                    <!-- Acerca de -->
                    <li class="<?=$acercaDe?>">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-info-sign"></i>&nbsp;&nbsp;<?=__("Acerca de")?> <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                    <!-- El anuario -->
                    <li><a href="/pages/elanuario/"><?=__("El Anuario")?></a></li>
                    <!-- Metodologia -->
                    <li><a href="/metodologia/"><?=__("Metodologia")?></a></li>
                    <!-- La SAO -->
                    <li><a href="/pages/lasao/"><?=__("La SAO")?></a></li>
                    <!-- El equipo -->
                    <li><a href="/pages/elequipo/"><?=__("El Equipo")?></a></li>
                    <!-- Agradecimientos -->
                    <li><a href="/pages/agradecimientos/"><?=__("Agradecimientos")?></a></li>
                    <!-- Aviso legal -->
                    <li><a href="/pages/aviso-legal/"><?=__("Aviso legal")?></a></li>
                    <li class="divider"></li>
                    <!-- Contacto -->
                    <li><a href="/pages/contacto/"><i class="icon-envelope"></i>&nbsp;<?=__("Contacto")?></a></li>
                    </ul>
                    <li class="divider-vertical"></li>
                    
                    <!-- Ayuda -->

                </ul>
            </div>

        </div>
    </div>
</div>                        