<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Blog\Post;
use AppBundle\Entity\Blog\Comment;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic

        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();

    }

    /**
     * @var Collection|Post[]
     * 
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Blog\Post", mappedBy="user")
     *
     */
    private $posts;

     /**
     * @var Collection|Comment[]
     * 
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Blog\Comment", mappedBy="user")
     *
     */
    private $comments;


    /**
     * Add post
     *
     *
     * @return User
     */
    public function addPost(Post $post) : self
    {
        if(!$this->posts->contains($post))
        {
            $this->posts[] = $post;
        }

        return $this;
    }

    /**
     * Remove post
     *
     *
     * @return User
     */
    public function remmovePost(Post $post) : self
    {
        if(!$this->posts->contains($post))
        {
            $this->posts->removeElement($post);
        }

        return $this;
    }

    /**
     * Get posts
     *
     * @return Collection|Post[]
     */
    public function getPosts() 
    {
        return $this->posts;
    }

/**
     * Add Comment
     *
     *
     * @return User
     */
    public function addComment(Comment $comment) : self
    {
        if(!$this->comments->contains($comment))
        {
            $this->comments[] = $comment;
        }

        return $this;
    }

    /**
     * Remove comment
     *
     *
     * @return User
     */
    public function remmoveComment(Comment $comment) : self
    {
        if(!$this->comments->contains($comment))
        {
            $this->comments->removeElement($comment);
        }

        return $this;
    }

    /**
     * Get comments
     *
     * @return Collection|Comment[]
     */
    public function getComments() 
    {
        return $this->comments;
    }


}