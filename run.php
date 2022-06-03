<?php

error_reporting(E_ALL ^ E_WARNING); 


unlink("results_all.zip");
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



$file_list = array();

foreach (scandir('.') as $file){
    if(strlen($file) <= 3){
        array_push($file_list, $file);
        #echo $file."   ";

    }
	
}






function extract_file($file_name, $row_count, $file_count){



    $text = file_get_contents($file_name);
    $location_start = strpos($text, 'pre-wrap;">');
    $text = substr($text, $location_start + strlen('pre-wrap;">'));
    $location_end = strpos($text, 'web-scraper-order') + strlen('web-scraper-order') + 2;
    $scraper_order = substr(substr($text, $location_end), 0, strpos(substr($text, $location_end), '"'));

    #echo $scraper_order;

    $text = substr($text, 0, strpos($text, ']</pre>')+1);

    $json = json_decode($text, true);

    #var_dump($json);

    if($row_count > 980000){

        $file_count++;
        $row_count = 0;

    }

    $file_na = "results_all".strval($file_count).".csv";

    $fp = fopen($file_na, 'a');
    $header = false;
    foreach ($json as $row){
        if (empty($header)){
            $header = array_keys($row);
            fputcsv($fp, $header);
            $header = array_flip($header);
        }
        fputcsv($fp, array_merge($header, $row));
        #var_dump($row);
        $row_count++;
    }
    fclose($fp);

    #echo $json[1][1];

    return array($row_count, $file_count);

}

$row_count = 0;
$file_count = 1;

foreach($file_list as $ind_file){

    $return_arr = extract_file($ind_file, $row_count, $file_count);
    $row_count = $return_arr[0];
    $file_count = $return_arr[1];
    echo "ok";

}






$zip = new ZipArchive();

$DelFilePath="results_all.zip";



$j = 1;
while($j <= $file_count){

    $file_na1 = "results_all".strval($j).".csv";
    $zip->open($DelFilePath, ZIPARCHIVE::CREATE);
    $zip->addFile($file_na1, $file_na1);
    $j++;

}

// close and save archive

$zip->close(); 


$i = 1;
while($i <= $file_count){

    $file_na2 = "results_all".strval($i).".csv";
    unlink($i);
    $i++;

}




?>