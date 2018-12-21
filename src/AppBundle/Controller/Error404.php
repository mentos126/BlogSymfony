<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use \Datetime;

use AppBundle\Entity\Blog\Post;
use AppBundle\AppBundle;
use AppBundle\Form\Blog\PostType;
use AppBundle\Entity\Blog\PostSearch;
use AppBundle\Form\Blog\PostSearchType;
use AppBundle\Entity\Blog\RegisterComment;
use AppBundle\Form\Blog\RegisterCommentType;
use AppBundle\Entity\Blog\Comment;

class Error404 extends Controller
{
   
    /**
     * @Route("/{id}", name="error404", requirements={"id": "[a-zA-Z0-9\/\-]*"})
     */
    public function Error404Action($id)
    {
        return $this->render('blog/error404.html.twig');
    }


}


