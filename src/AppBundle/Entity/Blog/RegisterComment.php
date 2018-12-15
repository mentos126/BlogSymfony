<?php

namespace AppBundle\Entity\Blog;


class RegisterComment {

    /**
     * @var string|null
     */
    private $message;

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return RegisterComment
     */
    public function setMessage(string $message) : RegisterComment
    {
        $this->message = $message;
        return $this;
    }


}