<?php

// Lancement de la session

//chemin error_log --------> xampp/xampfiles/logs/php_errors_logs

session_start();


//intilisation et affectation de l'objet PDO
$pdo = new PDO('mysql:host=localhost;dbname=boutique',
                'root',
                '',
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                )
            );

//constante qui définit la racine du projet
define('BASE', '/Boutique_PHP/');

//fonction de debug
function debug($var)
{
    echo '<pre>';
        var_dump($var);
    echo '</pre>';
}

function traitement($data)
{
    foreach($data as $marqueur => $valeur )
    {
        $data[$marqueur] = htmlspecialchars($valeur);
        // on transforme les chevrons'<>'en entité html qui neutralise les balises script ou style evnetuellement injectées
        // on parle de neutraliser les failles xss(injectés code html) et css
    }
    return $data;
}