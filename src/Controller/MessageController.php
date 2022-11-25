<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Sender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MessageController extends AbstractController
{
    #[Route('/message/{id}', name: 'app_message')]
    public function index(Request $request,User $user,MailerInterface $mailer,Sender $sender): Response
    {
        $utilisateur=$this->getUser();
        if ($request->get("submit")) {
            $sender->envoisMessage($utilisateur,$user,$request->get("sujet"),$request->get("contenu"));
        }
        return $this->render('message/index.html.twig');
    }
}
