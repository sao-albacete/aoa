<?php 
	// Informamos el título
	$this->set('title_for_layout','Mis lugares');
	
	/**
	 * CSS
	 */
	$this->Html->css(array('datatables-bootstrap', 'Lugar/mis_lugares'), null, array('inline' => false));
	
	/**
	 * Javascript
	 */
	$this->Html->script(array('/plugin/DataTables-1.9.4/media/js/jquery.dataTables', 'datatables-bootstrap','/plugin/bootbox/bootbox.min','pleaseWaitDialog', 'Lugar/mis_lugares'), array('inline' => false));
	
	// Menu
	$this->start('menu');		
	echo $this->element('/menu');
	$this->end(); 
?>

<div>
    <fieldset>
        <legend><?php echo __('Mis lugares'); ?></legend>
        
        <a href="/lugar/add" role="button"
			class="btn btn-mini btn-warning" data-toggle="modal"
			id="btnNuevoLugar"><i class="icon-plus"></i> <?php echo __("Nuevo lugar");?></a>
			
		<hr>

		<table id="tablaLugares" class="table table-striped table-bordered table-hover table-condensed">
			<thead>
				<tr>
					<th><?php echo __("Acciones");?></th>
					<th><?php echo __("Lugar");?></th>
					<th><?php echo __("Municipio");?></th>
					<th><?php echo __("Comarca");?></th>
					<th><?php echo __("Cuadrícula UTM");?></th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach ($lugares as $lugar) {
						echo "<tr id='".$lugar["Lugar"]["id"]."'>";
						echo 	"<td style='text-align: center;'>";
						echo		"<a href='javascript: eliminarLugar(".$lugar['Lugar']['id'].", \"".$lugar['Lugar']['nombre']."\");' title='".__("Eliminar colaborador")."' title='".__("Eliminar lugar")."'><img src='/img/icons/delete.png' title='Eliminar el lugar' alt='Eliminar lugar'/></a>&nbsp;&nbsp;";
						echo		"<a href='/lugar/edit/id:".$lugar['Lugar']['id']."' title='".__("Editar lugar")."'><img src='/img/icons/edit.png' title='Editar lugar' alt='Editar lugar'/></a>&nbsp;&nbsp;";
						echo		"<a href='/lugar/view/id:".$lugar['Lugar']['id']."' title='".__("Ver detalle del lugar")."'><img src='/img/icons/search.png' title='Ver detalle del lugar' alt='Detalle lugar'/></a>";
						echo	"</td>";
						echo 	"<td><a href='/cita/index?lugarId=".$lugar["Lugar"]["id"]."'>".$lugar["Lugar"]["nombre"]."</a></td>";
						echo 	"<td><a href='/cita/index?municipioId=".$lugar["Municipio"]["id"]."'>".$lugar["Municipio"]["nombre"]."</a></td>";
						echo 	"<td><a href='/cita/index?comarcaId=".$lugar["Comarca"]["id"]."'>".$lugar["Comarca"]["nombre"]."</a></td>";
						echo 	"<td style='text-align: center;'><a href='/cita/index?cuadriculaUtmId=".$lugar["CuadriculaUtm"]["id"]."'>".$lugar["CuadriculaUtm"]["codigo"]."</a></td>";
						echo "</tr>";
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th><?php echo __("Acciones");?></th>
					<th><?php echo __("Lugar");?></th>
					<th><?php echo __("Municipio");?></th>
					<th><?php echo __("Comarca");?></th>
					<th><?php echo __("Cuadrícula UTM");?></th>
				</tr>
			</tfoot>
		</table>
	</fieldset>
</div>

<!-- Pie -->
<?php 
	$this->start('pie');		
	echo $this->element('/pie');
	$this->end(); 
?>