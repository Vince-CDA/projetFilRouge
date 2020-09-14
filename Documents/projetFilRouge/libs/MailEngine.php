<?php
namespace Lib;

require_once './PHPMailer/src/PHPMailer.php';
require_once './config/configPHPMailer.php';
use PHPMailer\PHPMailer\PHPMailer;

class MailEngine
{
    //Configuration du smtp avec les données du tableau de configPHPMailer.php
    public static function CreateMail()
    {
        include('./config/configPHPMailer.php');
        $mail = new PHPMailer(true);
        //Config
        $mail->SMTPDebug = $ConfigServMail['SMTPDebug'];
        if ($ConfigServMail['isSMTP']) {
            $mail->isSMTP();
        }
        $mail->Host = $ConfigServMail['Host'];
        $mail->SMTPAuth = $ConfigServMail['SMTPAuth'];
        $mail->Username = $ConfigServMail['Username'];
        $mail->Password = $ConfigServMail['Password'];
        $mail->SMTPSecure = $ConfigServMail['SMTPSecure'];
        $mail->Port = $ConfigServMail['Port'];

        $mail->setFrom($ConfigServMail['From']['Address'], $ConfigServMail['From']['Name']);
        return $mail;
    }


    public static function Send($subject, $expediteur, $message)
    {
        $mail = MailEngine::CreateMail();


        /* DONNEES DESTINATAIRES */
        ##########################
    $mail->setFrom('v.mundoegea@gmail.com', 'No-Reply');  //adresse de l'expéditeur (pas d'accents)
    $mail->addAddress('v.mundoegea@gmail.com', 'Vincent Mundo');        // Adresse du destinataire (le nom est facultatif)
    // $mail->addReplyTo('moi@mon_domaine.fr', 'son nom');     // réponse à un autre que l'expéditeur (le nom est facultatif)
    // $mail->addCC('cc@example.com');            // Cc (copie) : autant d'adresse que souhaité = Cc (le nom est facultatif)
    // $mail->addBCC('bcc@example.com');          // Cci (Copie cachée) :  : autant d'adresse que souhaité = Cci (le nom est facultatif)

    /* PIECES JOINTES */
        ##########################
        // $mail->addAttachment('../dossier/fichier.zip');         // Pièces jointes en gardant le nom du fichier sur le serveur
        // $mail->addAttachment('../dossier/fichier.zip', 'nouveau_nom.zip');    // Ou : pièce jointe + nouveau nom

        /* CONTENU DE L'EMAIL*/
        ##########################
    $mail->isHTML(true);                                      // email au format HTML
    $mail->Subject = utf8_decode($subject);      // Objet du message (éviter les accents là, sauf si utf8_encode)
    $mail->Body    = $message;          // corps du message en HTML - Mettre des slashes si apostrophes
    $mail->AltBody = 'Contenu au format texte pour les clients e-mails qui ne le supportent pas'; // ajout facultatif de texte sans balises HTML (format texte)

    $mail->send();
    }
}
