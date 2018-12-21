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
               
        $response =  $this->render('blog/homepage.html.twig', 
        [
            'postsPaginated' => $postsPaginated,
            'formSearch' => $formSearch->createView(), 
        ]);
        // $response->setEtag(md5($response->getContent()));
        // $response->setPublic();
        // $response->isNotModified($request);
        return $response;
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
         
            $user = $this->getUser();
            $com->setUser($user);
         
            $com->setContent($register->getMessage())
                ->setPost($post)
                ->setAuthor("Pas encore de profil");
            $em = $this->getDoctrine()->getManager();
            $em->persist($com);

            $post->addComment($com);

            $em->flush();

        }

        $isMyPost = false;
        $user = $this->getUser();
        if($user != null)
        {
            if($user == $post->getUser())
            {
                $isMyPost = true;
            }
        }

        if($post == null || $post->getSlug() !== $slug) {
            return $this->redirectToRoute('error404', ['id' => '404',], 301);
        } else {
            return $this->render('blog/post.html.twig', [
                'user' => $isMyPost,
                'post'=> $post,
                'formComment' => $formComment->createView(), 

                ]);
        }

    }


}


