<?php 

	App::import('Vendor', 'jpgraph/jpgraph');
	App::import('Vendor', 'jpgraph/jpgraph_bar');
	
	try {
		
		// Create a graph instance
		$graph = new Graph(560,300);
		 
		// Specify what scale we want to use,
		// text = txt scale for the X-axis
		// int = integer scale for the Y-axis
		$graph->SetScale('textint');
		 
		// Setup a title for the graph
		$graph->title->Set($titleX);
		 
		// Setup titles and X-axis labels
		$graph->xaxis->title->Set(__("Meses"));
		$graph->xaxis->SetTickLabels(array('ENE','FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'));
		 
		// Setup Y-axis title
		$graph->yaxis->title->Set($titleY);
		 
		// Create the bar plot
		$barplot=new BarPlot($ydata_ajax);
		 
		// Add the plot to the graph
		$graph->Add($barplot);
		 
		//header("Content-type: image/png");
		// Display the graph
		//$graph->Stroke();
		
		// Get the handler to prevent the library from sending the
	    // image to the browser
	    $gdImgHandler = $graph->Stroke(_IMG_HANDLER);
	    
	    // Default is PNG so use ".png" as suffix
	    $fileName = "grafico_citas_especie_".time().".png";
	    $graph->img->Stream("img/tmp/$fileName");
	    
	    echo "<img src='/img/tmp/$fileName'></img>";
    }
    catch (Exception $e) {
    	CakeLog::error($e->getTraceAsString());
    }
    
?>
