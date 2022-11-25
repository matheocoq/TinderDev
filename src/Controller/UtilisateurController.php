<?php

namespace App\Controller;

use App\Entity\Ami;
use App\Entity\User;
use App\Repository\AmiRepository;
use App\Repository\LangageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\New_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/utilisateur')]
class UtilisateurController extends AbstractController
{
    #[Route('/liste', name: 'utilisateur_liste')]
    public function liste(Request $request,LangageRepository $langageRepository,UserRepository $userRepository): Response
    {
        $utilisateurs= $userRepository->findAll();
        $langages = $langageRepository->findAll();

        if($request->get("recherche")){
            $utilisateurs=$userRepository->findByRecheche($request->get("recherche"));
        }
        return $this->render('utilisateur/liste.html.twig', [
            "utilisateurs"=>$utilisateurs,
            "langages"=>$langages,
        ]);
    }

    #[Route('/ami/{id}', name: 'utilisateur_ami')]
    public function ami( AmiRepository $amiRepository,EntityManagerInterface $entityManager,User $user): JsonResponse
    {
        $utilisateur=$this->getUser();
        

        $lesAmis=$utilisateur->getAmis();
        
        $trouver=false;

        foreach ($lesAmis as $value) {
            if($value->getAmi()->getId()==$user->getId()){
                $trouver=true;
            }
        }

        if($trouver == false){
            $ami=New Ami();
            $ami->setAmi($user);
            $ami->setUtilisateur($utilisateur);
            $entityManager->persist($ami);
        }
        else{
            $ami=$amiRepository->findOneBy(['utilisateur' => $utilisateur,'ami' => $user]);
            $entityManager->remove($ami);
        }
    
        
        $entityManager->flush();

        return $this->json(['valid' => true]);
    }

   
}
