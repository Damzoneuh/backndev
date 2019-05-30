<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createFormBuilder();
        $form->add('email', EmailType::class, [
            'attr' => [
                'class' => 'input-field validate',

            ]
        ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'class' => 'materialize-textarea validate',

                ]
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'waves-effect waves-light btn blue'
                ]
            ]);
        $getForm = $form->getForm();
        $getForm->handleRequest($request);
        if ($getForm->isSubmitted() && $getForm->isValid()){
            try {
                $data = $getForm->getData();
                $message = new \Swift_Message();
                $message->setFrom('noreply@backndev.fr');
                $message->setTo('damien@backndev.fr');
                $message->setSubject('Contact form site backndev.fr');
                $message->setBody('<body>
                <h1>Nouveau message du site Backndev.fr</h1>
                <p>sender : ' . $data['email'] . '</p>
                <p>message : ' . $data['message'] . '</p>
                </body>', 'text/html'
                );
                $mailer->send($message);
            }
            catch (\Exception $e){
                $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de votre message');
                return $this->redirectToRoute('home');
            }
            $this->addFlash('success', 'Votre message à bien été envoyé .');
            return $this->redirectToRoute('home');
        }
        return $this->render('home/contact.html.twig', ['form' => $getForm->createView()]);
    }
}
