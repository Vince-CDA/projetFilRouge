<?php
// lance les classes de PHPMailer
require_once './libs/PHPMailer/PHPMailer.php';
use PHPMailer\PHPMailer\PHPMailer;
require_once './libs/PHPMailer/SMTP.php';
use PHPMailer\PHPMailer\SMTP;
require_once './libs/PHPMailer/Exception.php';
use PHPMailer\PHPMailer\Exception;


// path du dossier PHPMailer % fichier d'envoi du mail


//Création d'un tableau de configuration PHPMailer
$ConfigServMail = array (

    'SMTPDebug' => SMTP::DEBUG_OFF, // Enable verbose debug output
    'isSMTP' => true,   // Send using SMTP
    'Host' => 'smtp-relay.sendinblue.com',// Set the SMTP server to send through
    'SMTPAuth' => true,
    'Username' => 'davy.blavette@2isa.com',
    'Password' => 'kn2WvLmM7bNU0BE6',
    'Username2' => 'v.mundoegea@gmail.com',   // SMTP username
    'Password2' => '@',   // SMTP password
    'SMTPSecure' => PHPMailer::ENCRYPTION_SMTPS, // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    'Port' => 465,    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    'From' => array('Address' => 'v.mundoegea@gmail.com', 'Name' => 'Vincent Mundo'), // email and name of the site web
    'Administrator' => array('Address' => 'v.mundoegea@gmail.com', 'Name' => 'Vincent Mundo'), //  administrator (email and name) of this site web
);


?>