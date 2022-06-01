<?php


/*
function zipper($file){
    $zip = new ZipArchive;
    if ($zip->open($file) === TRUE) {
        $zip->extractTo('.');
        $zip->close();
        echo 'ok';
    } else {
        echo 'failed';
    }

}



zipper("pt1.zip");
zipper("pt2.zip");
zipper("pt3.zip");

*/


/*
$file_list = array();

foreach (scandir('.') as $file){
    if(strlen($file) <= 3){
        array_push($file_list, $file);
        echo $file."   ";

    }
	
}






function extract_file($file_name){



    $text = file_get_contents($file_name);
    $location_start = strpos($text, 'pre-wrap;">');
    $text = substr($text, $location_start + strlen('pre-wrap;">'));
    $location_end = strpos($text, 'web-scraper-order') + strlen('web-scraper-order') + 2;
    $scraper_order = substr(substr($text, $location_end), 0, strpos(substr($text, $location_end), '"'));

    #echo $scraper_order;

    $text = substr($text, 0, strpos($text, ']</pre>')+1);

    $json = json_decode($text, true);

    #var_dump($json);

    $fp = fopen("results_all2.csv", 'w');
    $header = false;
    foreach ($json as $row){
        if (empty($header)){
            $header = array_keys($row);
            fputcsv($fp, $header);
            $header = array_flip($header);
        }
        fputcsv($fp, array_merge($header, $row));
        #var_dump($row);
    }
    fclose($fp);

    #echo $json[1][1];

}


foreach($file_list as $ind_file){

    extract_file($ind_file);
    echo "ok";

}




*/

$zip = new ZipArchive();

$DelFilePath="results_all2.zip";


if ($zip->open($DelFilePath, ZIPARCHIVE::CREATE) != TRUE) {
        die ("Could not open archive");
}
    $zip->addFile("results_all2.csv","results_all2.csv");

// close and save archive

$zip->close(); 


?>