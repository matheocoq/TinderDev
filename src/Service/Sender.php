<?php
namespace App\Service;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Sender 
{
   
    protected $mailer;

    public function __construct(EntityManagerInterface $entiManager,MailerInterface $mailer)
    {
       
        $this->mailer=$mailer;
    }
    
    public function envoisMessage(User $envoyeur,User $receveur,$sujet,$contenu){
        $email = (new Email())
            ->from($envoyeur->getEmail())
            ->to($receveur->getEmail())
            ->subject($sujet)
            ->html($contenu);

            $this->mailer->send($email);
        
    }

   
    
}
