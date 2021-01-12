<?php

const configName         = 'Config';
const configDatabaseName = 'Database';
const configPath         = 'mvc/application/configs';

const servicesName = "Service";
const servicesPath = "mvc/application/services/";

const controllerName       = "Controller";
const frontControllerName  = "Front";
const systemControllerName = "System";

const controllerPath       = "mvc/application/modules";
const frontControllerPath  = controllerPath . "/front/";
const systemControllerPath = controllerPath . "/system/";

const modelName = 'Model';
const modelPath = 'mvc/application/models/';

spl_autoload_register(function ( $className ) {

    $classPieces = preg_split('/(?=[A-Z])/',$className);

    if ( isset($classPieces[0]) && (string)$classPieces[0] === "" ) unset( $classPieces[0] );

    $requirePath = '';

    $firstPiece = array_shift( $classPieces );
    switch ( $firstPiece ) {

        case configName:

            $fileClassName = array_shift( $classPieces );

            switch ( $fileClassName ) {

                case configDatabaseName:

                    $fileClassName = array_shift( $classPieces );

                    $requirePath = configPath . "/" . strtolower(configDatabaseName) . "/" . $fileClassName . ".php";

                    break;

                default:
                    $requirePath = configPath . "/" . $fileClassName . ".php";
                    break;
            }

            break;

        case modelName:

            $directoryName  = !empty($classPieces[0]) ? (string)$classPieces[0] : "";
            $controllerName = !empty($classPieces[1]) ? (string)$classPieces[1] : "";

            $requirePath = modelPath . $directoryName . $controllerName . "" .".php";

            break;

        default: break;
    }

    $lastPiece  = array_pop( $classPieces );
    switch ( $lastPiece ) {
        case servicesName:
            $requirePath = servicesPath . str_replace( servicesName, '', $className ) . ".php";
            break;

        case controllerName:

            switch ( $firstPiece ) {

                case systemControllerName:

                    $fileName = str_replace( $firstPiece, "", $className );
                    $requirePath = systemControllerPath . lcfirst( $fileName ) . ".php";

                break;

                case frontControllerName:

                    $fileName = str_replace( $firstPiece, "", $className );
                    $requirePath = frontControllerPath . lcfirst( $fileName ) . ".php";

                    break;

                default:
                    $requirePath = frontControllerPath . $className . ".php";
                    break;

            }

            break;

        default: break;
    }

    if ( !empty($requirePath) ) require_once $requirePath;
});