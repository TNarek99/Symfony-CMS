<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoryController extends Controller
{
    /**
     * @Route("category/list", name="category_list")
     */
    public function listAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');
        $categories = $repository->findAll();

        $addUrl = $this->generateUrl('category_add');

        return $this->render('category/list.html.twig', array(
            "categories" => $categories,
            "addUrl" => $addUrl
        ));
    }

    /**
     * @Route("category/add", name="category_add")
     */
    public function addAction()
    {
        $category = new Category();
        $category->setTitle($_POST['title']);

        $em = $this->getDoctrine()->getManager();

        $em->persist($category);

        $em->flush();

        $listUrl = $this->generateUrl('category_list');

        return $this->redirect($listUrl);
    }

    /**
     * @Route("category/delete/{id}", requirements={"id" : "\d+"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $category = $repository->findOneById($id);

        $em->remove($category);
        $em->flush();

        $listUrl = $this->generateUrl('category_list');

        return $this->redirect($listUrl);
    }

    /**
     * @Route("category/edit/{id}", requirements={"id" : "\d+"})
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $category = $repository->findOneById($id);

        if(isset($_POST['title'])) {
            $category->setTitle($_POST['title']);
        }

        $em->persist($category);
        $em->flush();

        return $this->render('category/edit.html.twig', array(
            "category" => $category
        ));
    }
}