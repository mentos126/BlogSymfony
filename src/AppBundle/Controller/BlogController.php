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
    public function HomePageAction(Request $request)
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
            dump($register);
            dump($formComment);
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

    /**
     * @Route("/new", name="new")
     * @return Response
     */
    public function NewAction(Request $request)
    {
        $post = new Post();
        $form =$this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $this->addFlash('succes', 'Article ajouté avec succès');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('blog/new.html.twig', [
            'form'=> $form->createView(),
            'post' => $post
        ]);
    }

    /**
     * @Route("/edit/{slug}-{id}", name="edit", requirements={"slug": "[a-zA-Z0-9\-]*"})
     */
    public function EditAction($id, string $slug, Request $request)
    {

        $post = $this->getDoctrine()
                    ->getRepository(Post::class)
                    ->findOneBy(['id' => $id,]);

        if($post == null || $post->getSlug() !== $slug) {
            return $this->redirectToRoute('error404', ['id' => '404',], 301);
        } else {
            $form =$this->createForm(PostType::class, $post);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('succes', 'Article modifié avec succès');
                return $this->redirectToRoute('homepage');
            }
            return $this->render('blog/edit.html.twig', [
                'form'=> $form->createView(),                
                'post' => $post
                ]);
        }
    }

    /**
     * @Route("/delete/{id}", name="delete", methods="DELETE")
     */
    public function DeleteAction($id, Request $request)
    {
        $post = $this->getDoctrine()
                    ->getRepository(Post::class)
                    ->findOneBy(['id' => $id,]);

        if($post == null) {
            return $this->redirectToRoute('error404', ['id' => '404',], 301);
        } else {
            if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->get('_token')))
            {
                $em = $this->getDoctrine()->getManager();
                foreach($post->getComments() as $c) {
                    $em->remove($c);
                }
                $em->remove($post);
                $em->flush();
                $this->addFlash('succes', 'Article supprimé avec succès');
                return $this->redirectToRoute('homepage');
            }
            return $this->redirectToRoute('edit', [
                'id' => $post->getId(),
            ],200);
        }

    }


    
    /**
     * @Route("/{id}", name="error404", requirements={"id": "[a-zA-Z0-9\/\-]*"})
     */
    public function Error404Action($id)
    {
        return $this->render('blog/error404.html.twig');
    }

}


