<?php

    namespace jeyofdev\php\member\area\Entity;


    use DateTimeInterface;
    use Doctrine\ORM\Mapping as ORM;
    use jeyofdev\php\member\area\Repository\UserRepository;


    /**
     * @ORM\Entity(repositoryClass=UserRepository::class)
     * @ORM\Table(name="users")
     */
    class User {
        /**
         * @ORM\Id
         * @ORM\GeneratedValue
         * @ORM\Column(type="integer")
         */
        protected $id;



        /**
         * @ORM\Column(type="string", length=100)
         */
        protected $username;



        /**
         * @ORM\Column(type="string")
         */
        protected $email;



        /**
         * @ORM\Column(type="string")
         */
        protected $password;



        /**
         * @ORM\Column(type="string", length=60, nullable=true)
         */
        protected $confirmation_token;



        /**
         * @ORM\Column(type="datetime", nullable=true)
         */
        protected $confirmed_at;



        /**
         * @ORM\Column(type="string", length=60, nullable=true)
         */
        protected $reset_token;



        /**
         * @ORM\Column(type="datetime", nullable=true)
         */
        protected $reset_at;



        /**
         * Get the value of id
         * 
         * @return  int
         */ 
        public function getId() : int
        {
            return $this->id;
        }



        /**
         * Get the value of username
         * 
         * @return  string
         */ 
        public function getUsername() : string
        {
            return $this->username;
        }



        /**
         * Set the value of username
         *
         * @return  self
         */ 
        public function setUsername(string $username) : self
        {
            $this->username = $username;
            return $this;
        }



        /**
         * Get the value of email
         * 
         * @return  string
         */ 
        public function getEmail() : string
        {
            return $this->email;
        }



        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail(string $email) : self
        {
            $this->email = $email;
            return $this;
        }



        /**
         * Get the value of password
         * 
         * @return  string
         */ 
        public function getPassword() : string
        {
            return $this->password;
        }



        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword(string $password) : self
        {
            $this->password = password_hash($password, PASSWORD_BCRYPT);
            return $this;
        }



        /**
         * Get the value of confirmation_token
         * 
         * @return  string
         */ 
        public function getConfirmation_token() : ?string
        {
            return $this->confirmation_token;
        }



        /**
         * Set the value of confirmation_token
         *
         * @return  self
         */ 
        public function setConfirmation_token(?string $confirmation_token = null) : self
        {
            $this->confirmation_token = $confirmation_token;
            return $this;
        }



        /**
         * Get the value of confirmed_at
         * 
         * @return DateTimeInterface|null
         * 
         */ 
        public function getConfirmed_at() : ?DateTimeInterface
        {
            return $this->confirmed_at;
        }



        /**
         * Set the value of confirmed_at
         *
         * @return  self
         */ 
        public function setConfirmed_at(DateTimeInterface $confirmed_at) : self
        {
            $this->confirmed_at = $confirmed_at;
            return $this;
        }



        /**
         * Get the value of reset_token
         */ 
        public function getReset_token() : ?string
        {
            return $this->reset_token;
        }



        /**
         * Set the value of reset_token
         *
         * @return  self
         */ 
        public function setReset_token(?string $reset_token = null) : self
        {
            $this->reset_token = $reset_token;
            return $this;
        }



        /**
         * Get the value of reset_at
         * 
         * @return DateTimeInterface|null
         */ 
        public function getReset_at() : ?DateTimeInterface
        {
            return $this->reset_at;
        }



        /**
         * Set the value of reset_at
         *
         * @return  self
         */ 
        public function setReset_at(?DateTimeInterface $reset_at = null) : self
        {
            $this->reset_at = $reset_at;
            return $this;
        }
    }