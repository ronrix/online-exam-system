<?php

	
	# show errors	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	session_start();

	require_once "../dompdf/autoload.inc.php";
	require_once "../model/User.php";

	$userId = explode(":", $_SESSION['userId'])[0];

	$examId = $_GET['eid'];
	$examName = $_GET['en'];

	$takers = getTakers($examId, $userId);

	use Dompdf\Adapter\CPDF;      
	use Dompdf\Dompdf;
	use Dompdf\Exception;


	$dompdf = new Dompdf();

	$dompdf->getOptions()->setIsFontSubsettingEnabled(true);

	$html = '
<body>
<h2>'. ucwords($examName).'</h2>	
	<p>Results</p>
	<ul>
	'; 
	foreach ($takers as $a) { 
		$html.= '<li style="margin: 2px 0; border: 1px solid #222; padding: 2px; display: flex; align-items: center; justify-content: space-between;">
		<div>
			<span>'. $a['name'] . "</span>
		</div>".
		"<div>
			<span>score: ".$a['score']."</span>
		</div>".
		"</li>"; 
	} 
	$html .= '</ul></body>'; 

	$dompdf->loadHtml($html);

	$dompdf->setPaper("A4", 'landscape');

	$dompdf->render();

	$download = $dompdf->stream("file".rand(10,1000).".pdf", array("Attachment" => true));