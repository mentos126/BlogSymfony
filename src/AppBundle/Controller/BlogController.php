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

class BlogController extends Controller
{
   
    /**
     * @Route("/", name="homepage")
     */
    public function IndexAction(Request $request)
    {
        $search = new PostSearch();
        $formSearch = $this->createForm(PostSearchType::class, $search);
        $formSearch->handleRequest($request);

        $posts = $this->getDoctrine()
                    ->getRepository(Post::class)
                    ->findPostOrderedDescMax50($search);

        $postsPaginated  = $this->get('knp_paginator')->paginate($posts, $request->query->get('page', 1), 6);
               
        return $this->render('blog/homepage.html.twig', 
        [
            'user' => false,
            'postsPaginated' => $postsPaginated,
            'formSearch' => $formSearch->createView(), 
        ]);
    }

    /**
     * @Route("/post/{slug}-{id}", name="post", requirements={"slug": "[a-zA-Z0-9\-]*"})
     * @return Response
     */
    public function PostAction(int $id, string $slug, Request $request)
    {
        $register = new RegisterComment();
        $formComment = $this->createForm(RegisterCommentType::class, $register);
        $formComment->handleRequest($request);

        $post = $this->getDoctrine()
                    ->getRepository(Post::class)
                    ->findOneBy(['id' => $id,]);

        if($formComment->isSubmitted() && $formComment->isValid())
        {
            $com = new Comment();
            $com->setContent($register->getMessage())
                ->setPost($post)
                ->setAuthor("Pas encore de profil");
            $em = $this->getDoctrine()->getManager();
            $em->persist($com);

            $post->addComment($com);

            $em->flush();

        }

        if($post == null || $post->getSlug() !== $slug) {
            return $this->redirectToRoute('error404', ['id' => '404',], 301);
        } else {
            return $this->render('blog/post.html.twig', [
                'user' => true,
                'post'=> $post,
                'formComment' => $formComment->createView(), 

                ]);
        }

    }


}


