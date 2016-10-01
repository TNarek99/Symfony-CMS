<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PostController extends Controller
{
    /**
     * @Route("/post")
     */
    public function listAction()
    {
        return $this->render('post/list.html.twig');
    }

    /**
     * @Route("/post/{id}", requirements={"id":"\d+"})
     */
    public function showAction($id)
    {
        return $this->render('post/show.html.twig', array(
            'id' => $id
        ));
    }


//    /**
//     * @Route("/post/{category}")
//     */
//    public function showCategoryAction($category)
//    {
//        return $this->render('post/showCategory.html.twig', array(
//            'category' => $category
//        ));
//    }


    /**
     * @Route("/post/generate")
     */
    public function generateAction()
    {
        $url = $this->generateUrl(
            'flan'
        );
        
        return $this->render('post/generate.html.twig', array(
           'url' => $url
        ));
    }

    /**
     * @Route("post/redirect", name="flan")
     */
    public function redirectAction()
    {
        //return $this->render('post/redirect.html.twig');
    }
}