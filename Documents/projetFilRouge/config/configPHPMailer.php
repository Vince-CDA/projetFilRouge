<?php
// lance les classes de PHPMailer
require_once './PHPMailer/src/PHPMailer.php';
use PHPMailer\PHPMailer\PHPMailer;

require_once './PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\SMTP;

require_once './PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\Exception;

// path du dossier PHPMailer % fichier d'envoi du mail


//Création d'un tableau de configuration PHPMailer
$ConfigServMail = array(

    'SMTPDebug' => SMTP::DEBUG_OFF, // Enable verbose debug output
    'isSMTP' => true,   // Send using SMTP
    'Host' => 'smtp.gmail.com',// Set the SMTP server to send through
    'SMTPAuth' => true,
    'Username' => 'vince.cda3@gmail.com',
    'Password' => 'cda3mund@',
    'SMTPSecure' => PHPMailer::ENCRYPTION_SMTPS, // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    'Port' => 465,    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    'From' => array('Address' => 'vince.cda3@gmail.com', 'Name' => 'Vincent Mundo'), // email and name of the site web
    'Administrator' => array('Address' => 'v.mundoegea@gmail.com', 'Name' => 'Vincent Mundo'), //  administrator (email and name) of this site web
);
