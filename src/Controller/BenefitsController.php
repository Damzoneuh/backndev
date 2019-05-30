<?php

namespace App\Controller;

use App\Entity\Benefits;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Annotation\Route;

class BenefitsController extends AbstractController
{
    /**
     * @Route("/benefits", name="benefits")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getRepository(Benefits::class);
        $find = $em->findAll();
        return $this->render('benefits/index.html.twig', array('find' => $find));
    }

    /**
     * @Route("/admin/benefits/create", name="benefits_create")
     */

    public function create(Request $request)
    {
        $benefits = new Benefits();
        $form = $this->createFormBuilder($benefits);
        $getForm = $form->getForm();

        $getForm->handleRequest($request);

        if ($getForm->isSubmitted() && $getForm->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->persist($benefits);
                $em->flush();
            }
            catch (Exception $e){
                $this->addFlash('error', 'une erreur est survenue lors de la mise en db');
                return $this->redirectToRoute('benefits');
            }

            $this->addFlash('success', 'La préstation à bien été ajoutée');
            return $this->redirectToRoute('benefits');
        }

        return $this->render('benefits/create.html.twig', array('form' => $getForm->createView()));
    }

    /**
     * @Method
     */
}
