<?php

    namespace jeyofdev\php\member\area\Mail;


    use PHPMailer\PHPMailer\PHPMailer;


    /**
     * Manage the sending of mail
     */
    class Mail implements MailInterface
    {
        /**
         * The path of config
         * 
         * @var string
         */
        private $configPath = CONFIG_PATH;



        /**
         * @var PHPMailer
         */
        protected $mail;



        /**
         * The mail configuration parameters
         * 
         * @var array
         */
        private $mailConfig;



        public function __construct ()
        {
            $this->mail = new PHPMailer(true);

            require $this->getConfigPath() . DIRECTORY_SEPARATOR . 'mail.php';
            $this->mailConfig = $mailConfig;
        }



        /**
         * Mailer configuration
         *
         * @param boolean|null $smtpAuth  Enable SMTP authentication
         * @return self
         */
        public function config (?bool $smtpAuth = true) : self
        {
            $this->mail->isSMTP();
            $this->mail->Host       = $this->mailConfig["host"];
            $this->mail->SMTPAuth   = $smtpAuth;
            $this->mail->Username   = $this->mailConfig["username"];
            $this->mail->Password   = $this->mailConfig["password"];
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $this->mail->Port       = $this->mailConfig["port"];

            return $this;
        }



        /**
         * Set the mail header
         *
         * @param string $receiver      The receiver
         * @param string|null $fromName The name of the sender
         * @return self
         */
        public function header (string $receiver, ?string $fromName = null) : self
        {
            $this->mail->setFrom($this->mailConfig["username"], $fromName);
            $this->mail->addAddress($receiver);

            return $this;
        }



        /**
         * Set the content of the email
         *
         * @param string       $subject  The Subject of the message.
         * @param string       $body     An HTML or plain text message body.
         * @param string       $altBody  The plain-text message body.
         * @param boolean|null $isHTML   Sets message type to HTML or plain.
         * @return self
         */
        public function content (string $subject, string $body, string $altBody, ?bool $isHTML = true) : self
        {
            $this->mail->isHTML($isHTML);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->AltBody = $altBody;

            return $this;
        }


        /**
         * {@inheritDoc}
         */
        public function send () : self
        {
            $this->mail->send();

            return $this;
        }



        /**
         * {@inheritDoc}
         */
        public function getConfigPath() : string
        {
            return $this->configPath;
        }
    }

