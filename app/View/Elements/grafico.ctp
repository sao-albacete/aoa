<?php 

	require_once 'jpgraph/jpgraph.php';
	require_once 'jpgraph/jpgraph_bar.php';
	
	$ydata = array(1,2,3,4,5,6,7,8,9,10,11,12);

	// Create a graph instance
	$graph = new Graph(600,300);
	 
	// Specify what scale we want to use,
	// text = txt scale for the X-axis
	// int = integer scale for the Y-axis
	$graph->SetScale('textint');
	 
	// Setup a title for the graph
	$graph->title->Set("Titulo del grafico");
	 
	// Setup titles and X-axis labels
	$graph->xaxis->title->Set("Meses");
	$graph->xaxis->SetTickLabels(array('ENE','FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'));
	 
	// Setup Y-axis title
	$graph->yaxis->title->Set("Nº de aves");
	 
	// Create the bar plot
	$barplot=new BarPlot($data);
	 
	// Add the plot to the graph
	$graph->Add($barplot);
	 
	// Display the graph
	//$graph->Stroke();
	
	// Get the handler to prevent the library from sending the
    // image to the browser
    $gdImgHandler = $graph->Stroke(_IMG_HANDLER);

    // Stroke image to a file

    // Default is PNG so use ".png" as suffix
    $fileName = "imagefile.png";
    $graph->img->Stream($fileName);

?>