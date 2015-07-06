<?php
use Symfony\Component\HttpFoundation\Request;


$app->match('/service/', function (Request $request) use($app)
{
	if ($request->isMethod('POST')) {
		$file = file_get_contents('user_questions.json', FILE_USE_INCLUDE_PATH);
		$json = json_decode($file);
		
		$objekt = clone $json[0];
		
		$frage = $request->get('frage');
		$rAntwort = $request->get('rAntwort');
		$bAntwort = $request->get('bAntwort');
		$cAntwort = $request->get('cAntwort');
		$dAntwort = $request->get('dAntwort');
		$email = $request->get('email');
		
		$objekt->Kategorie = "User Defined";
		$objekt->Frage = $frage;
		$objekt->{'Antwort A'} = $rAntwort;
		$objekt->{'Antwort B'} = $bAntwort;
		$objekt->{'Antwort C'} = $cAntwort;
		$objekt->{'Antwort D'} = $dAntwort;
		$objekt->Schwierigkeit = 1;
		$objekt->{utf8_encode('�berpr�ft')} = "Nein";
		$objekt->Ersteller = utf8_encode($email);
		$objekt->FIELD11 = "";
		
		array_push($json, $objekt);
		$test2 = var_dump($json);
		$datei = fopen("test.json", 'w+');
		$string = json_encode($json, JSON_PRETTY_PRINT);
		$string = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
			return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UTF-16BE');
		}, $string);
		
			fwrite($datei, $string);
			fclose($datei);
	    return $app['templating']->render('success.html.php', array());				
	}
	else {
	    return $app['templating']->render('service.html.php', array());		
	}
});

