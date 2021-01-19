<?php

namespace App\Controller;

use DateTime;
use App\Entity\Incident;
use App\Form\IncidentType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request, EntityManagerInterface $em,
    MailerInterface $mailer): Response
    {
        $task = new Incident();
        $task->setUser($this->getUser());

        $form = $this->createForm(IncidentType::class, $task);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $em->persist($task);
            $em->flush();

            $email = (new Email())
                ->from($task->getUser()->getEmail())
                ->to('user@test.test')
                ->subject("New Incident #{$task->getId()} - {$task->getUser()->getEmail()}")
                ->html("<p>{$task->getDescription()}</p>");
                

                // simulate slow process
                sleep(8);

                $mailer->send($email);


            return $this->redirectToRoute('home');
        }
        
        
        return $this->render('home/index.html.twig', [
            'controller_name'   => 'HomeController',
            'form'              => $form->createView(),
        ]);
    }
}
