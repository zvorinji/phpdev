<?php

$file_list = array();

foreach (scandir('.') as $file){
    if(strlen($file) <= 2){
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

    $fp = fopen("results.csv", 'w');
    $header = false;
    foreach ($json as $row){
        if (empty($header)){
            $header = array_keys($row);
            fputcsv($fp, $header);
            $header = array_flip($header);
        }
        fputcsv($fp, array_merge($header, $row));
        var_dump($row);
    }
    fclose($fp);

    #echo $json[1][1];

}



extract_file($file_list[1]);



?>