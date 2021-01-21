<?php

namespace Source\Support;

use Exception;
use stdClass;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    /**@var PHPMailer */
    private $mail;

    /**@var stdClass */
    private $sendemail;

    /**@var Exception */
    private $error;


    /**
     * Email constructor.
     */
    public  function __construct()
    {
       $this->mail= new PHPMailer(true);
       $this->sendemail = new stdClass(); 

       $this->mail->isSMTP();
       $this->mail->isHTML();
       $this->mail->SMTPAuth = true;
       $this->mail->SMTPSecure="TLS";
       $this->mail->CharSet = "utf-8";

       $this->mail->Host = MAIL["host"];
       $this->mail->Port = MAIL["port"];
     
       
    }

    /**
     * @param string $subject
     * @param string $body
     * @param string $recipient_name
     * @param string $recipient_email
     * @param string $user
     * @param string $passwd
     * @return $this
     */
    public function addmsg(string $subject, string $body, string $recipient_name, string $recipient_email, string $user, string $passwd): Email
    {
        $this->mail->Username = $user;
        $this->mail->Password = $passwd;



        $this->sendemail->subject = $subject;
        $this->sendemail->body = $body;
        $this->sendemail->recipient_name = $recipient_name;
        $this->sendemail->recipient_email = $recipient_email;
        return $this;
    }

    /**
     * @param string $filePath
     * @param string $fileName
     * @return $this
     */
    public function attach(string $filePath, string $fileName): Email
    {
        $this->sendemail->attach[$filePath] = $fileName;
        return $this;
    }

    /**
     * @param string $from_email
     * @return bool
     */
    public function send(string $from_email): bool
    {
        try{
            $this->mail->Subject = $this->sendemail->subject;
            $this->mail->msgHTML($this->sendemail->body);
            $this->mail->addAddress($this->sendemail->recipient_email,$this->sendemail->recipient_name);
            $this->mail->setFrom($from_email);

            if(!empty($this->sendemail->attach)){
                foreach($this->sendemail->attach as $path => $name){
                    $this->mail->addAttachment($path,$name);
                }
            }

            $this->mail->send();
            return true;


        }catch (Exception $exception){
            $this->error = $exception;
            return false;
        }
    }

    /**
     * @return Exception
     */
    public function error()
    {
        return $this->error;
    }

}
?>