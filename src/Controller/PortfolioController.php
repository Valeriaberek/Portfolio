<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class PortfolioController extends AbstractController
{
    #[Route('/apropos', name: 'app_apropos')]
    public function apropos(): Response
    {
        return $this->render('portfolio/apropos.html.twig', [
            'controller_name' => 'PortfolioController',
        ]);
    }

    #[Route('/projets', name: 'app_projets')]
    public function projets(): Response
    {
        return $this->render('portfolio/projets.html.twig', [
            'controller_name' => 'PortfolioController',
        ]);
    }

    #[Route('/projet1', name: 'app_projet1')]
    public function projet1(): Response
    {
        return $this->render('portfolio/projet1.html.twig', [
            'controller_name' => 'PortfolioController',
        ]);
    }

    #[Route('/', name: 'app_portfolio')]
    public function index(): Response
    {
        return $this->render('portfolio/index.html.twig', [
            'controller_name' => 'PortfolioController',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
    
            $email = (new Email())
                ->from('berekpro02@gmail.com')  
                ->replyTo($data['email'])           
                ->to('berekpro02@gmail.com')         
                ->subject('Nouveau message de votre portfolio')
                ->text(
                    "Vous avez reçu un nouveau message de " . $data['name'] . ":\n\n" .
                    $data['message']
                );
    
            $mailer->send($email);
    
            $this->addFlash('success', 'Votre message a été envoyé avec succès !');
    
            return $this->redirectToRoute('app_contact');
        }
    
        return $this->render('portfolio/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
    
}
