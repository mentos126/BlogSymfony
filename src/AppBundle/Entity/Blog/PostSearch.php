<?php

namespace AppBundle\Entity\Blog;

use Symfony\Component\Validator\Constraints as Assert;


class PostSearch {

    /**
     * @var string|null
     * @Assert\Length(min=0, max=255) 
     */
    private $partTitle;

    /**
     * @return string|null
     */
    public function getPartTitle(): ?string
    {
        return $this->partTitle;
    }

    /**
     * @param string|null $partTitle
     * @return PostSearch
     */
    public function setPartTitle(string $partTitle) : PostSearch
    {
        $this->partTitle = $partTitle;
        return $this;
    }


}