<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('', name: 'index')]
    public function home(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(MessageRepository $repository, Request $request): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSendDate(new \DateTime('now'));
            $repository->save($message, true);

            $this->addFlash('success', 'Your message has been send!');

            return $this->redirectToRoute('home_contact', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/contact.html.twig', [
            'form' => $form,
        ]);
    }
}