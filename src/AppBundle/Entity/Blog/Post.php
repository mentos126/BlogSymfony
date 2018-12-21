<?php

namespace AppBundle\Entity\Blog;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Blog\Comment;
use AppBundle\Entity\User;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Post
 *
 * @ORM\Table(name="blog_post")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Blog\PostRepository")
 * @UniqueEntity("title")
 */
class Post
{

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->published = new \DateTime();
        $this->author = "default";
    }

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
     * @Assert\Length(min=5, max=255)
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    public function getSlug() : string
    {
        return (new Slugify())->slugify($this->title);
    }

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="published", type="datetime")
     */
    private $published;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255)
     */
    private $picture;

    /**
     * @var string
     *
     * @Assert\Length(min=5, max=666)
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var Collection|Comment[]
     * 
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Blog\Comment", mappedBy="post")
     *
     */
    private $comments;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="posts")
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
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Post
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
     * Set published
     *
     * @param \DateTime $published
     *
     * @return Post
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return \DateTime
     */
    public function getPublished()
    {
        return $this->published;
    }

    public function getPublishedFormated() : string
    {
        return $this->getPublished()->format('Y-m-d H:i:s');
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return Post
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Post
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
     * Add comment
     *
     *
     * @return Post
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
     * @return Post
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

