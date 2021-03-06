<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categoria;
use AppBundle\Entity\Image;
use AppBundle\Entity\Publicacion;
use AppBundle\Form\ImageType;
use Edgar\UserBundle\Entity\User;
use Edgar\UserBundle\UserBundle;
use FOS\UserBundle\FOSUserBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class IndexController extends Controller
{
    /**
     * @Route("/", name="app_index_index")
     */
    public function indexAction(Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $publicacionRepositorio= $m->getRepository('AppBundle:Publicacion');
        $categoriaRepositorio= $m->getRepository('AppBundle:Categoria');

        $query = $publicacionRepositorio->buscarTodasLasPublicaciones();
        $categorias = $categoriaRepositorio->buscarTodasLasCategorias();
        
        $paginator = $this->get('knp_paginator');

        $publicaciones =$paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            Publicacion::PAGINATION_ITEMS,
            [
                'wrap-queries' => true,
            ]
        );

        return $this->render(':index:index.html.twig', [
            'publicaciones'  => $publicaciones,
            'categorias' => $categorias,
            'titulo'          =>'Publicaciones']);

    }

    /**
     * @Route("/upload", name="app_index_upload")
     */
    public function uploadAction(Request $request)
    {
        $p = new Image();
        $form = $this->createForm(ImageType::class, $p);

        if ($request->getMethod() == Request::METHOD_POST) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $m = $this->getDoctrine()->getManager();
                $m->persist($p);
                $m->flush();

                return $this->redirectToRoute('app_index_index');
            }
        }

        return $this->render(':index:upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
       
}
