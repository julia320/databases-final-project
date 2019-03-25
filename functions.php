<?php

//connect
$mysqli = new mysqli("localhost", "TheSpookyLlamas", "TSL_jjy_2019", "TheSpookyLlamas");


//validate if data is in database

function inDb($query,$array){
    $stt = $GLOBALS['db']->prepare($query);
    $stt->execute($array);
    if($stt->rowCount()>0){
        return true;
    }else{
        return false;
    }
}
//validate if data was inserted in database

function insert($query,$array){

    $stt = $GLOBALS['db']->prepare($query);
    if($stt->execute($array)){
        return true;
    }else{
        return false;
    }
}

//obtain data from database

function fetchRows($query,$array){

    $stt = $GLOBALS['db']->prepare($query);
    $stt->execute($array);
    $rows = array();
    while($row=$stt->fetch()){
        array_push($rows,$row);
    }
    return $rows;
}
