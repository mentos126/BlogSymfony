<?php

namespace AppBundle\Entity\Blog;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;

/**
 * Comment
 *
 * @ORM\Table(name="blog_comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Blog\CommentRepository")
 */
class Comment
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Blog\Post", inversedBy="comments")
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="comments")
     */
    private $user;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }



    /**
     * Set post
     *
     *
     * @return Post
     */
    public function setPost(Post $post) : self
    {
        $this->post = $post;

        return $this;
    }


    /**
     * Get post
     *
     * @return Post
     */
    public function getPost() : Post
    {
        return $this->post;
    }

    /**
     * Set user
     *
     *
     * @return User
     */
    public function setUser(User $user) : self
    {
        $this->user = $user;

        return $this;
    }


    /**
     * Get user
     *
     * @return User
     */
    public function getUser() : User
    {
        return $this->user;
    }



}

