<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function HomePageAction()
    {
        return $this->render('blog/homepage.html.twig');
    }

    /**
     * @Route("/post/{id}", name="post")
     */
    public function PostAction($id)
    {
        return $this->render('blog/post.html.twig', [
            'id'=> $id, 
            ]);
    }

    /**
     * @Route("", name="error404")
     */
    public function Error404Action($id)
    {
        return $this->render('error404.html.twig');
    }

}
