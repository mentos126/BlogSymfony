<?php

namespace AppBundle\Entity\Blog;

class PostSearch {

    /**
     * @var string|null
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