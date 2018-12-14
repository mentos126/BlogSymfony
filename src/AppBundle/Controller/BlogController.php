<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use \Datetime;

class BlogController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function HomePageAction(Request $request)
    {
        $articles = array();

        $a1 = new Article();
        $a1->title = "titre1";
        $a1->author = "L'auteur 1";
        $a1->dateCreated = new Datetime();
        $a1->dateCreatedFormated = $a1->dateCreated->format('Y-m-d H:i:s');
        $a1->image = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGTVf63Vm3XgOncMVSOy0-jSxdMT8KVJIc8WiWaevuWiPGe0Pm";
        $a1->content = "<pre>coucou je suis le content</pre>";

        $a1->comments = array();
        $c0 = new Comment();
        $c0->authorName = "coucou 0";
        $c0->authorImage = "https://c1.staticflickr.com/8/7151/6760135001_58b1c5c5f0_b.jpg";
        $c0->content = "content 0";
        $c1 = new Comment();
        $c1->authorName = "coucou 1";
        $c1->authorImage = "https://c1.staticflickr.com/8/7151/6760135001_58b1c5c5f0_b.jpg";
        $c1->content = "content 1";
        $c2 = new Comment();
        $c2->authorName = "coucou 2";
        $c2->authorImage = "https://c1.staticflickr.com/8/7151/6760135001_58b1c5c5f0_b.jpg";
        $c2->content = "content 2";
        $c3 = new Comment();
        $c3->authorName = "coucou 3";
        $c3->authorImage = "https://c1.staticflickr.com/8/7151/6760135001_58b1c5c5f0_b.jpg";
        $c3->content = "content 3";

        array_push($a1->comments, $c0);
        array_push($a1->comments, $c1);
        array_push($a1->comments, $c2);
        array_push($a1->comments, $c3);
                
        array_push($articles, $a1);
        array_push($articles, $a1);
        array_push($articles, $a1);
        array_push($articles, $a1);
        array_push($articles, $a1);
        array_push($articles, $a1);
        array_push($articles, $a1);
        array_push($articles, $a1);
        array_push($articles, $a1);
        array_push($articles, $a1);
        array_push($articles, $a1);
        array_push($articles, $a1);
        array_push($articles, $a1);

        
        // $em = $this->getDoctrine()->getManager();


        // $posts = $this->getDoctrine()
        //             ->getRepository('AppBundle:Post')
        //             ->find();



        $articlesPaginated  = $this->get('knp_paginator')->paginate($articles, $request->query->get('page', 1), 6);
               
        return $this->render('blog/homepage.html.twig', 
        [
            'user' => false,
            'articlesPaginated' => $articlesPaginated,
        ]);
    }

    /**
     * @Route("/post/{id}", name="post")
     */
    public function PostAction($id)
    {

        // get in database article with the id $id

        $article = new Article();
        $article->title = "titre1";
        $article->author = "L'auteur 1";
        $article->dateCreated = new Datetime();
        $article->dateCreatedFormated = $article->dateCreated->format('Y-m-d H:i:s');
        $article->image = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGTVf63Vm3XgOncMVSOy0-jSxdMT8KVJIc8WiWaevuWiPGe0Pm";
        $article->content = "<pre>coucou je suis le content</pre>";

        $article->comments = array();
        $c0 = new Comment();
        $c0->authorName = "coucou 0";
        $c0->authorImage = "https://c1.staticflickr.com/8/7151/6760135001_58b1c5c5f0_b.jpg";
        $c0->content = "content 0";
        $c1 = new Comment();
        $c1->authorName = "coucou 1";
        $c1->authorImage = "https://c1.staticflickr.com/8/7151/6760135001_58b1c5c5f0_b.jpg";
        $c1->content = "content 1";
        $c2 = new Comment();
        $c2->authorName = "coucou 2";
        $c2->authorImage = "https://c1.staticflickr.com/8/7151/6760135001_58b1c5c5f0_b.jpg";
        $c2->content = "content 2";
        $c3 = new Comment();
        $c3->authorName = "coucou 3";
        $c3->authorImage = "https://c1.staticflickr.com/8/7151/6760135001_58b1c5c5f0_b.jpg";
        $c3->content = "content 3";

        array_push($article->comments, $c0);
        array_push($article->comments, $c1);
        array_push($article->comments, $c2);
        array_push($article->comments, $c3);

        return $this->render('blog/post.html.twig', [
            'article'=> $article,
            'user' => true 
            ]);
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
     * @Route("/*", name="error404")
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

