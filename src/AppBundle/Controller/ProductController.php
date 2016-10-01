<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends Controller
{
    /**
     * @Route("/product/list", name="product_list")
     */
    public function listAction()
    {
        $productsRepository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $products = $productsRepository->findAll();
        
        $categoriesRepository = $this->getDoctrine()->getRepository('AppBundle:Category');
        $categories = $categoriesRepository->findAll();

        $addUrl = $this->generateUrl('product_add');
        
        return $this->render('product/list.html.twig', array(
            "products" => $products,
            "categories" => $categories,
            "addUrl" => $addUrl
        ));
    }

    /**
     * @Route("/product/add", name="product_add")
     */
    public function addAction()
    {
        $product = new Product();
        $product->setName($_POST['name']);
        $product->setPrice($_POST['price']);
        $product->setDescription($_POST['description']);
        $product->setCategoryId($_POST['categoryId']);

        $em = $this->getDoctrine()->getManager();

        $em->persist($product);

        $em->flush();
        
        $listUrl = $this->generateUrl('product_list');
        
        return $this->redirect($listUrl);
    }

    /**
     * @Route("/product/delete/{id}", requirements={"id" : "\d+"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');

        $product = $repository->findOneById($id);

        $em->remove($product);
        $em->flush();

        $listUrl = $this->generateUrl('product_list');

        return $this->redirect($listUrl);
    }


    /**
     * @Route("product/edit/{id}", requirements={"id" : "\d+"})
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $productsRepository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $categoriesRepository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $product = $productsRepository->findOneById($id);
        $categories = $categoriesRepository->findAll();

        if(isset($_POST['name'])) {
            $product->setName($_POST['name']);
        }

        if(isset($_POST['price'])) {
            $product->setPrice($_POST['price']);
        }

        if(isset($_POST['description'])) {
            $product->setDescription($_POST['description']);
        }
        
        if(isset($_POST['categoryId'])) {
            $product->setCategoryId($_POST['categoryId']);
        }

        $em->persist($product);
        $em->flush();

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'categories' => $categories
        ));
    }
}