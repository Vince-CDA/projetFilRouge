<?php
namespace Lib;
if (isset($ajax) && $ajax == 1) {
    require_once './PHPMailer/PHPMailer.php';
    require_once './../config/configPHPMailer.php';
    }else{
        require_once './PHPMailer/PHPMailer.php';
        require_once './config/configPHPMailer.php';
    }
use PHPMailer\PHPMailer\PHPMailer;

class MailEngine
{
    //Configuration du smtp avec les données du tableau de configPHPMailer.php
    public static function CreateMail()
    { 
        global $ConfigServMail;
        global $ajax;
        if (isset($ajax) && $ajax == 1) {
            require_once './PHPMailer/PHPMailer.php';
            require_once './../config/configPHPMailer.php';
            }else{
                require_once './PHPMailer/PHPMailer.php';
                require_once './config/configPHPMailer.php';
            }
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


    public static function Send($subject, $expediteur, $destinataire, $nom, $message)
    {
        $mail = MailEngine::CreateMail();


        /* DONNEES DESTINATAIRES */
        ##########################
    $mail->setFrom($expediteur, 'No-Reply');  //adresse de l'expéditeur (pas d'accents)
    $mail->addAddress($destinataire, '');        // Adresse du destinataire (le nom est facultatif)
    $mail->addReplyTo($expediteur, $nom);     // réponse à un autre que l'expéditeur (le nom est facultatif)
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
    $mail->AltBody = $message; // ajout facultatif de texte sans balises HTML (format texte)

    $mail->send();
    }
}
