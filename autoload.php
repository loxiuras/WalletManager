<?php

const servicesName = "Service";
const servicesPath = "mvc/application/services/";

spl_autoload_register(function ( $className ) {

    $classPieces = preg_split('/(?=[A-Z])/',$className);

    if ( isset($classPieces[0]) && (string)$classPieces[0] === "" ) unset( $classPieces[0] );

    $requirePath = '';

    $firstPiece = array_shift( $classPieces );
    switch ( $firstPiece ) {
        default: break;
    }

    $lastPiece  = array_pop( $classPieces );
    switch ( $lastPiece ) {
        case servicesName:
            $requirePath = servicesPath . str_replace( servicesName, '', $className ) . ".php";
            break;

        default: break;
    }

    if ( !empty($requirePath) ) require_once $requirePath;
});