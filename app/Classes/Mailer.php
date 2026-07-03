<?php

namespace App\Classes;

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

trait  Mailer
{
    private $mailer;
  

    public function initMailer()
    {

         // Charger les variables d'environnement une seule fois
         $dotenv = Dotenv::createImmutable(__DIR__ .THREE_PIP);
         $dotenv->load();
        $this->mailer = new PHPMailer(true);
        

        $this->configMail();
    }

    public function SendMail($to, $subject, $template, $data = [])
    {
        try {
            // Ajouter destinataire
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);

            // Sujet
            $this->mailer->Subject = $subject;

            // Charger le template
            $body = $this->renderTemplateEmail($template, $data);

            // Corps du mail
            $this->mailer->Body = $body;

            // Envoi
            return $this->mailer->send();
        } catch (Exception $e) {
            throw new \Exception("Erreur envoi email : {$this->mailer->ErrorInfo}");
        }
    }

    private function renderTemplateEmail($template, $data)
    {
        $templatePath = __DIR__ . THREE_PIP ."views/templated/emails/{$template}.php";
       
        if (!file_exists($templatePath)) {
            throw new \Exception("Template email introuvable : {$template}");
        }


        ob_start();
        extract($data);
        include $templatePath;
        return ob_get_clean();
       
    }


    private function configMail() {
        try {
            // Config SMTP
            $this->mailer->isSMTP();
            $this->mailer->UseSMTPUTF8 = true; // Support UTF-8
            $this->mailer->CharSet = 'UTF-8'; // Jeu de caractères UTF-8
            $this->mailer->SMTPAuth   = true;
            // $this->mailer->SMTPAuth   = false;
            $this->mailer->Host       = $_ENV['SMTP_HOST'];
            $this->mailer->Username   = $_ENV['SMTP_USERNAME'];
            $this->mailer->Password   = $_ENV['SMTP_PASSWORD'];
            $this->mailer->Port       = $_ENV['SMTP_PORT'];
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            // $this->mailer->SMTPSecure = $_ENV['SMTP_ENCRYPTION'];


            // Expéditeur
            $this->mailer->setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_FROM_NAME']);

            // Format HTML
            $this->mailer->isHTML(true);
        } catch (Exception $e) {
            throw new \Exception("Erreur configuration Mailer : {$e->getMessage()}");
        }
    }
}
