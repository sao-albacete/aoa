<?php
// Informamos el título
$this->set('title_for_layout','Detalle de Cita');

/**
 * CSS
 */
$this->Html->css(array('aoa-table', 'Cita/view'), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    '/plugin/yoxview/yoxview-init',
    'https://maps.googleapis.com/maps/api/js?sensor=false',
    'https://geoxml3.googlecode.com/svn/branches/polys/geoxml3.js',
    'https://geoxml3.googlecode.com/svn/trunk/ProjectedOverlay.js',
    'Cita/view'
), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<script type="text/javascript">

var map;

function initialize() {

    var myLatlng = new google.maps.LatLng(38.70, -1.70);

    var mapOptions = {
        zoom:8,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"),
        mapOptions);

    // GeoXML para añadir eventos
    geoXmlUtm = new geoXML3.parser({
        map: map,
        singleInfoWindow: true,
        zoom: false,
        afterParse: useTheData
    });
    
    // Tratamos el archivo
    geoXmlUtm.parse('/kml/UTM_AB.kml');
    
     // GeoXML para añadir eventos
    geoXmlMunicipios = new geoXML3.parser({
        map: map,
        singleInfoWindow: true,
        zoom: false,
        afterParse: useTheData
    });
    
    // Tratamos el archivo
    geoXmlMunicipios.parse('/kml/municipios_AB.kml');
    
    // Eventos
    function kmlColor (kmlIn) {
        var kmlColor = {};
        if (kmlIn) {
            aa = kmlIn.substr(0,2);
            bb = kmlIn.substr(2,2);
            gg = kmlIn.substr(4,2);
            rr = kmlIn.substr(6,2);
            kmlColor.color = "#" + rr + gg + bb;
            kmlColor.opacity = parseInt(aa,16)/256;
        } else {
            // defaults
            kmlColor.color = randomColor();
            kmlColor.opacity = 0.45;
        }
            return kmlColor;
    }

    function randomColor(){ 
        var color="#";
        var colorNum = Math.random()*8388607.0;  // 8388607 = Math.pow(2,23)-1
        var colorStr = colorNum.toString(16);
        color += colorStr.substring(0,colorStr.indexOf('.'));
        return color;
    };


    var highlightOptions = {fillColor: "#0000ff", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};

    // Se obtienen los datos del xml (kml)
    function useTheData(doc){
        var currentBounds = map.getBounds();
        if (!currentBounds) currentBounds=new google.maps.LatLngBounds();
        
        geoXmlDoc = doc[0];
        
        for (var i = 0; i < geoXmlDoc.placemarks.length; i++) {
            
            var placemark = geoXmlDoc.placemarks[i];

            //alert(placemark.name);
            
            if (placemark.polygon) {
                
                var kmlStrokeColor = kmlColor(placemark.style.color);
                var kmlFillColor = kmlColor(placemark.style.fillcolor);
                
                var normalStyle = {
                    strokeColor: kmlStrokeColor.color,
                    strokeWeight: placemark.style.width,
                    strokeOpacity: kmlStrokeColor.opacity,
                    fillColor: kmlFillColor.color,
                    fillOpacity: kmlFillColor.opacity
                };

                placemark.polygon.normalStyle = normalStyle;

                if(placemark.name == '<?php echo $cita['Lugar']['CuadriculaUtm']['codigo'];?>') {
                    placemark.polygon.setOptions(highlightOptions); 
                }
            }
        }
    };
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

<!-- Cuerpo -->
<div>
    <fieldset>
        <legend>
        <?php echo __('Detalle de la cita: ').$cita['Cita']['id']; ?>
        &nbsp;&nbsp;
        <?php 
            echo $this->Importancia->getIconoImportancia($cita['ImportanciaCita']['id'], $cita['ImportanciaCita']['descripcion']);
            if ($cita['Especie']['Especie']['indRareza'] == 1) {
                if ($cita['Cita']['indRarezaHomologada'] == 3) {
                    echo '<span class="label label-success text-info rareza-message">Rareza homologada</span>';
                } else {
                    echo '<span class="label label-warning text-info rareza-message">Rareza pendiente de homologar</span>';
                }
            }
        ?>
        
        <span class="pull-right"><b><?php echo date_format(date_create($cita['Cita']['fechaAlta']), "d/m/Y");?></b></span>
        </legend>
        
        <?php if($usuario['observador_principal_id'] == $cita['Cita']['observador_principal_id'] || $usuario['perfil_id'] == 1) :?>
        <a href="/cita/edit/id:<?php echo $cita['Cita']['id'];?>" role="button"
            class="btn btn-mini btn-warning" data-toggle="modal"
            id="btnEditarCita"><i class="icon-plus"></i> <?php echo __("Editar cita");?></a>
        <hr>
        <?php endif;?>

        <div class="row">
            <!-- Nombres -->
            <div class="span6 contenedor_azul">
                <h3>
                <?php echo $cita['Especie']['Especie']['nombreComun']." (<em>".$cita['Especie']['Especie']['genero']." ".$cita['Especie']['Especie']['especie']." ".$cita['Especie']['Especie']['subespecie']."</em>)"; ?>
                </h3>
                <h4>
                <em>
                <?php echo $cita['Especie']['Familia']['nombre'];?>
                    ,
                    <?php echo $cita['Especie']['OrdenTaxonomico']['nombre'];?>
                </em>
                </h4>
            </div>
            <!-- Figuras de protección -->
            <div class="span6">
                <p>
                <?php echo "<span class='label ".$this->Especie->obtener_color_proteccion_lr($cita['Especie']['ProteccionLr']['codigo'])."'>".$cita['Especie']['ProteccionLr']['nombre']."</span>".__(" según el ")."<em><b>".__("Libro Rojo de las Aves de España")."</b></em>";?>
                </p>
                <p>
                <?php echo "<span class='label ".$this->Especie->obtener_color_proteccion_clm($cita['Especie']['ProteccionClm']['codigo'])."'>".$cita['Especie']['ProteccionClm']['nombre']."</span>".__(" en ")."<b>".__("Castilla - La Mancha")."</b>";?>
                </p>
                <p>
                <?php echo "<span class='label label-info'>".$cita['Especie']['EstatusCuantitativoAb']['nombre']."</span>".__(" en ")."<b>".__("Albacete")."</b>";?>
                </p>
                <p>
                <?php echo "<span class='label label-info'>".$cita['Especie']['EstatusReproductivoAb']['nombre']."</span>".__(" en ")."<b>".__("Albacete")."</b>";?>
                </p>
            </div>
        </div>
        <br>
        <div class="row">

            <!-- Datos cita -->
            <div class="span6">
                
                <table class="table table-striped table-bordered table-condensed">
                    <caption>Número de individuos</caption>
                    <thead>
                        <tr>
                            <th>Edad/Sexo</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($cita['AsoCitaClaseEdadSexo'] as $claseEdadSexo) {
                        echo "<tr>";
                        echo     "<td style='text-align: center;'>".$claseEdadSexo['clase_edad_sexo_nombre']."</td>";
                        echo     "<td style='text-align: center;'>".$claseEdadSexo['cantidad']."</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                    <tfoot>
                        <th>TOTAL</th>
                        <th><?php echo $cita['Cita']['cantidad'];?></th>
                    </tfoot>
                </table>
                
                <fieldset class="fsCustom">
                    <legend >Datos de los observadores</legend>
                    
                    <dl class="dl-horizontal">
                        <dt><?php echo __("Observador");?></dt>
                        <dd><?php echo $cita['ObservadorPrincipal']['codigo']." - ".$cita['ObservadorPrincipal']['nombre'];?></dd>
                        
                        <dt><?php echo __("Colaboradores");?></dt>
                        <dd><?php echo $this->ObservadorSecundario->mostrar_nombres_observadores($cita['observadores']);?></dd>
                        
                        <dt><?php echo __("Fuente");?></dt>
                        <dd><?php echo $cita['Fuente']['nombre'];?></dd>
                        
                        <dt><?php echo __("Estudio");?></dt>
                        <dd><?php echo $cita['Estudio']['descripcion'];?></dd>
                    </dl>
                    
                </fieldset>        
                
                <fieldset class="fsCustom" style="margin-top: 20px;">
                    <legend>Indicadores de la cita</legend>
                    
                    <dl class="dl-horizontal">
                        <dt><?php echo __("Habitat raro");?></dt>
                        <dd><?php if($cita['Cita']['indHabitatRaro'] == true){echo "<img src='/img/icons/fugue-icons-3.5.6/icons/tick.png' alt='Sí'/>";}else{echo "<img src='/img/icons/fugue-icons-3.5.6/icons/cross-script.png' alt='No'/>";}?></dd>
                        
                        <dt><?php echo __("Criando en habitat raro");?></dt>
                        <dd><?php if($cita['Cita']['indCriaHabitatRaro'] == true){echo "<img src='/img/icons/fugue-icons-3.5.6/icons/tick.png' alt='Sí'/>";}else{echo "<img src='/img/icons/fugue-icons-3.5.6/icons/cross-script.png' alt='No'/>";}?></dd>
                        
                        <dt><?php echo __("Herido, accidentado o muerto");?></dt>
                        <dd><?php if($cita['Cita']['indHerido'] == true){echo "<img src='/img/icons/fugue-icons-3.5.6/icons/tick.png' alt='Sí'/>";}else{echo "<img src='/img/icons/fugue-icons-3.5.6/icons/cross-script.png' alt='No'/>";}?></dd>
                        
                        <dt title="<?php echo __("Comportamiento o morfología curiosa");?>"><?php echo __("Comportamiento o morfología curiosa");?></dt>
                        <dd><?php if($cita['Cita']['indComportamiento'] == true){echo "<img src='/img/icons/fugue-icons-3.5.6/icons/tick.png' alt='Sí'/>";}else{echo "<img src='/img/icons/fugue-icons-3.5.6/icons/cross-script.png' alt='No'/>";}?></dd>
                    </dl>
                </fieldset>        
                
                <fieldset class="fsCustom" style="margin-top: 20px;">
                    <legend>Criterios de selección de la cita</legend>
                    
                    <dl class="dl-horizontal">
                        <dt><?php echo __("Seleccionada para el anuario");?></dt>
                        <dd><?php if($cita['Cita']['indSeleccionada'] == "1"){echo "<img src='/img/icons/fugue-icons-3.5.6/icons/tick.png' alt='Sí'/>";}else{echo "<img src='/img/icons/fugue-icons-3.5.6/icons/cross-script.png' alt='No'/>";}?></dd>

                        <dt><?php echo __("Clase de reproducción");?></dt>
                        <dd><?php echo $cita['ClaseReproduccion']['tipoCria']." - ".$cita['ClaseReproduccion']['descripcion'];?></dd>
                        
                        <dt><?php echo __("Criterio de selección");?></dt>
                        <dd><?php echo $cita['CriterioSeleccionCita']['nombre'];?></dd>
                    </dl>
                </fieldset>
            </div>

            <!-- Ubicacion -->
            <div class="span6">
                <div class="contenedor_gris row-fluid">
                    
                    <?php if($cita['Cita']['indPrivacidad'] == 1 || $usuario['observador_principal_id'] == $cita['Cita']['observador_principal_id'] || $usuario['perfil_id'] == 1) :?>
                    
                    <div class="span6">
                        <p>
                            <b>Paraje: </b>
                            <?php echo $cita['Lugar']['Lugar']['nombre'];?>
                        </p>
                        <p>
                            <b>Cuadrícula UTM: </b>
                            <?php echo $cita['Lugar']['CuadriculaUtm']['codigo'];?>
                        </p>
                    </div>
                    <div class="span6">
                        <p>
                            <b>Municipio: </b>
                            <?php echo $cita['Lugar']['Municipio']['nombre'];?>
                        </p>
                        <p>
                            <b>Comarca: </b>
                            <?php echo $cita['Lugar']['Comarca']['nombre'];?>
                        </p>
                    </div>
                    <div id="map_canvas" class="span12" style="height:400px;"></div>
                    
                    <?php else :?>
                    
                        <h5 style="text-align: left;">
                            <img src='/img/icons/fugue-icons-3.5.6/icons/exclamation-red.png' width='16' height='16' alt='alert icon' style='margin-right: 10px;'>
                            <?php echo __("Por razones de seguridad, los datos de ubicación de la cita de esta especie están ocultos.");?>
                        </h5>
                        <p style="text-align: left;"><?php echo __("No obstante, puede solicitarlos enviándonos un email a ");?><a href="mailto:anuario@sao.albacete.org">anuario@sao.albacete.org</a></p>
                    
                    <?php endif; ?>
                    
                </div>
                <fieldset class="fsCustom" style="margin-top: 20px;">
                    <legend>Observaciones</legend>
                        
                    <?php if($cita['Cita']['indPrivacidad'] == 1 || $usuario['observador_principal_id'] == $cita['Cita']['observador_principal_id'] || $usuario['perfil_id'] == 1) :?>
                        <?php echo $cita['Cita']['observaciones'];?>
                    <?php else :?>
                        <h5>
                            <img src='/img/icons/fugue-icons-3.5.6/icons/exclamation-red.png' width='16' height='16' alt='alert icon' style='margin-right: 10px;'>
                            <?php echo __("Por razones de seguridad, las observaciones de la cita de esta especie están ocultos.");?>
                        </h5>
                        <p><?php echo __("No obstante, puede solicitarlos enviándonos un email a ");?><a href="mailto:anuario@sao.albacete.org">anuario@sao.albacete.org</a></p>
                    <?php endif; ?>
                </fieldset>
            </div>
            
        </div>

        <br>
        
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#fotos"><?php echo __("Fotos");?></a></li>
        </ul>

        <!-- Fotos -->
         <div id="especie_tab_content" class="tab-content">
            <div id="fotos" class="tab-pane fade active in">
                
                <div class="row-fluid">
                    <ul class="thumbnails yoxview">
                <?php
                if(isset($cita['Fichero']) && count($cita['Fichero']) > 0) {
                    
                    foreach ($cita['Fichero'] as $foto) {
                        echo '<li class="span2">';
                        echo     '<a href="'.$foto['ruta'].$foto['nombreFisico'].'" class="thumbnail">';
                        echo $this->Html->image($foto['ruta'].$foto['nombreFisico'], array(
                                "alt"=>$foto['descripcion'],
                                "title"=>$foto['descripcion'],
                                "style"=>"max-width: 200px; max-height: 150px;"
                        )
                        );
                        echo     '</a>';
                        echo '</li>';
                    }
                    
                }
                else {
                    echo '<div class="thumbnail" style="width: 360px; height: 270px;">';
                    echo '<img src="/img/messages/AAAAAA&text=No+hay+fotos_360x270.gif" />';
                    echo '</div>';
                }
                ?>
                    </ul>
                </div>
            </div>
        </div>
    </fieldset>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>