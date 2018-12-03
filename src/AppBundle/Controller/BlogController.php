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
    public function HomePageAction()
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

        $args = "tititit";

        return $this->render('blog/homepage.html.twig', ['articles' => $articles, 'user' => true]);
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

