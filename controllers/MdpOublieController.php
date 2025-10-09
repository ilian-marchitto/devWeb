<?php

namespace controllers;
require PHPMAILER_PATH . '/PHPMailer.php';
require PHPMAILER_PATH . '/Exception.php';
require PHPMAILER_PATH . '/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use models\UserModels;
use PDO;

class MdpOublieController
{
    private string $mailHost;
    private string $mailUsername;
    private string $mailPwd;
    private $connection;
    private string $pageTitle;
    private string $description;
    private string $keywords;
    private string $author;
    private array $cssFiles = [];
    public $message;
    public $head;
    

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        global $mailHost, $mailUsername, $mailPwd;
        $this->connection = $connection;
        $this->mailHost = $mailHost;
        $this->mailUsername = $mailUsername;
        $this->mailPwd = $mailPwd;

        // ─────────────── Gestion du thème ───────────────
        ToggleButtonController::handleThemeToggle();
        $styleDynamique = ToggleButtonController::getActiveStyle();

        $pageTitle = "mot de passe oublié";
        $pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Retrouvez votre mot de passe grâce à cette page.";
        $pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, mot de passe oublié";
        $pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
        $pageCss = ["seConnecter.css",  $styleDynamique];
        $this->head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);
        
        $this->handleRequest();
    }

    

    public function handleRequest()
    {
        $error = '';

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
            $email = trim($_POST['email'] ?? '');
            if (empty($email)) {
                $error = "Email requis.";
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $error = "Aucune donnée reçue.";

            }else {   
                // Message générique (toujours affiché)
                $this->message = "Si un compte existe pour cet email, tu recevras un message contenant un lien.";

                $userModel = new UserModels($this->connection);
                $userData = $userModel->findByEmail($email);
                
                

                if ($userData) {
                    // Générer token et enregistrer
                    $token = bin2hex(random_bytes(16));
                    $expires = (new \DateTime('+1 hour'))->format('Y-m-d H:i:s');
                    $userModel->saveResetToken($email, $token, $expires);

                    // Lien de réinitialisation
                    $link = BASE_URL . "/index.php?page=password_reset&token=" . urlencode($token);

                    // Envoi du mail
                    $this->sendResetMail($email, $link, $error);

                    
                }
            }
        }
    }

    private function sendResetMail(string $email, string $link, &$error): void
    {
        //PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $this->mailHost;
            $mail->SMTPAuth = true;
            $mail->Username = $this->mailUsername;
            $mail->Password = $this->mailPwd;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($this->mailUsername, 'fan2jul');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Réinitialisation de mot de passe";
            $mail->Body = "
                Bonjour,<br><br>
                Pour réinitialiser ton mot de passe, clique sur le lien suivant :<br>
                <a href=\"$link\">$link</a><br><br>
                Ce lien expire dans 1 heure.<br>
                Si tu n'as pas demandé cette opération, ignore ce message.
            ";
            $mail->send();
            
        } catch (Exception $e) {
            $error = "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
        }
    }

    public function render(): void
    {

        $vars = get_object_vars($this);
        extract($vars);

        require_once LAYOUT_PATH . '/head.php';
        include PAGES_PATH . '/mdpOublie.php';
    }
}
