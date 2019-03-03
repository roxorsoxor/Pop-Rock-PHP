<?php

require_once '../rockdb.php';
require_once '../page_pieces/navbar_rock.php';
require_once '../page_pieces/stylesAndScripts.php';

/*
$artistsMatchSpotifyMBID_Lookup = 'artistsMatchSpotifyMBID';
$artistListenersPlaycount = 'artistListenersPlaycount';
$albumListenersPlaycount = 'albumListenersPlaycount';
$trackListenersPlaycount = 'trackListenersPlaycount';
$relatedAlbums = 'relatedAlbums';
$relatedArtists = 'relatedArtists';
$jsonFile="../data_text/Anvil_Group_03-01-19.json";

    '../data_text/AliceCooper_Combined_03-01-19.json', 
    '../data_text/AliceCooper_Combined_02-15-19.json', 
    '../data_text/AliceCooper_Combined_02-28-19.json', 
    '../data_text/JoanJett_Combined_03-01-19.json', 
    '../data_text/JoanJett_Combined_02-16-19.json', 
    '../data_text/JoanJett_Combined_02-28-19.json', 
    '../data_text/JoanJett_Combined_02-27-19.json',   
    '../data_text/Anvil_02-15-19.json',      
    '../data_text/Anvil_02-17-19.json',
    '../data_text/Anvil_02-27-19.json',
    '../data_text/Anvil_02-28-19.json',
    '../data_text/Anvil_Group_03-01-19.json',
    '../data_text/Elf_02-14-19.json', 
    '../data_text/EvilStig_02-17-19.json', 
    '../data_text/Heaven&Hell_02-14-19.json',

*/

$filenames = array (
    '../data_text/Stoney&Meatloaf_02-17-19.json',
    '../data_text/Stoney&Meatloaf_02-27-19.json',
    '../data_text/Stoney&Meatloaf_02-28-19.json',
    '../data_text/Stoney&Meatloaf_Group_03-01-19.json'
);

$x = ceil((count($filenames)));

for ($i=0; $i<$x; ++$i) {
    $jsonFile = $filenames[$i];
    $fileContents = file_get_contents($jsonFile);
    $artistData = json_decode($fileContents,true);
    
    $artistMBID = $artistData['mbid'];
    $artistName = $artistData['name'];
    
    $dataDate = $artistData['date'];
    
    $artistListeners = $artistData['stats']['listeners'];
    $artistPlaycount = $artistData['stats']['playcount'];
    
    echo $artistName . ' had ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays on ' . $dataDate . '.<br>';
    
    $insertArtistStats = "INSERT INTO artistListenersPlaycount (artistMBID, dataDate, artistListeners, artistPlaycount) VALUES('$artistMBID','$dataDate','$artistListeners', '$artistPlaycount')";
    
    $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
    
    if(!$connekt){
        echo 'Fiddlesticks! Could not connect to database.<br>';
    }
    
    $rockout = $connekt->query($insertArtistStats);
    
    if(!$rockout){
    echo 'Shickety Brickety! Could not insert stats for ' . $artistName . '.<br>';
    }
    else {
        echo ' Inserted ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays for ' . $artistName . '.<br>';
    } 
    
};

?>