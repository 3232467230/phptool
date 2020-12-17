<?php

$file = 'config.json';
$json_string = file_get_contents( $file );
global  $data;
$data = json_decode( $json_string, true );
// var_dump( $data );
//setC( 'name', '789' );

function setC( $name, $str ) {
    global $data;
    $data['config'][0][$name] = $str;
    save();
    echo '1';
}

function save() {
    global $file, $data;
    $json_strings = json_encode( $data );
    file_put_contents( $file, $json_strings );
}
?>