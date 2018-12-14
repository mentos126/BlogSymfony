<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use \Datetime;

use AppBundle\Entity\Blog\Post;
use AppBundle\AppBundle;

class BlogController extends Controller
{
   
    /**
     * @Route("/", name="homepage")
     */
    public function HomePageAction(Request $request)
    {
        // pour créer temporairemment des post
        // $em = $this->getDoctrine()->getManager();
        // $post = new Post();
        // $post->setTitle('titre')
        //     ->setAuthor('Author')
        //     ->setPicture('picture')
        //     ->setComments("je <p> suis </p>")
        //     ->setContent("caca");
        // $em->persist($post);
        // $em->flush();

        $posts = $this->getDoctrine()
                    ->getRepository(Post::class)
                    ->findPostOrderedDescMax50();

        $postsPaginated  = $this->get('knp_paginator')->paginate($posts, $request->query->get('page', 1), 6);
               
        return $this->render('blog/homepage.html.twig', 
        [
            'user' => false,
            'postsPaginated' => $postsPaginated,
        ]);
    }

    /**
     * @Route("/post/{slug}-{id}", name="post", requirements={"slug": "[a-zA-Z0-9\-]*"})
     * @return Response
     */
    public function PostAction(int $id, string $slug)
    {

        $post = $this->getDoctrine()
                    ->getRepository(Post::class)
                    ->findOneBy(['id' => $id,]);

        if($post == null || $post->getSlug() !== $slug) {
            return $this->redirectToRoute('error404', ['id' => '404',], 301);
        } else {
            return $this->render('blog/post.html.twig', [
                'post'=> $post,
                'user' => true 
                ]);
        }

    }

    /**
     * @Route("/ajout", name="ajout")
     */
    public function NewAction($id)
    {
        return $this->render('blog/ajout.html.twig');
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function EditAction($id)
    {
        return $this->render('blog/edit.html.twig');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function DeleteAction($id)
    {
        return $this->render('blog/delete.html.twig');
    }


    
    /**
     * @Route("/{id}", name="error404", requirements={"id": "[a-zA-Z0-9\/\-]*"})
     */
    public function Error404Action($id)
    {
        return $this->render('error404.html.twig');
    }

}


class Article
{
    public $title;
    public $author;
    public $dateCreated;
    public $dateCreatedFormated;
    public $image;
    public $content;
    public $comments;
}

class Comment
{
    public $content;
    public $authorImage;
    public $authorName;
}

