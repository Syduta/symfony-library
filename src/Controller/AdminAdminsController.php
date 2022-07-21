<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminAdminsController extends AbstractController
{
    /**
     * @Route("/admin/admins",name="admin-admins")
     */
        public function admins(UserRepository $userRepository){
            $admins = $userRepository->findAll();
            return $this->render("admin/admins.html.twig",['admins'=>$admins]);
        }

        /**
         * @Route("/admin/create",name="admin-add")
         */

        public function adminCreate(\Symfony\Component\HttpFoundation\Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $userPasswordHasher){
            //avec $user on ajoute une nouvelle entrée dans la table user
            $user = new User();
            //qui sera par défaut avec le role admin
            $user->setRoles(["ROLE_ADMIN"]);
            //on récupère le gabari du formulaire user
            $form = $this->createForm(UserType::class,$user);
            // on récupère les infos du formulaire
            $form->handleRequest($request);
            //si le formulaire est soumis et valide on récup le mot de passe on le hash
            //on le set pour la table user et l'inseère dans la bdd
            if($form->isSubmitted()&&$form->isValid()){
                $plainPassword=$form->get('password')->getData();
                $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success','admin ajouté');
                return $this->redirectToRoute("admin/home");
            }
            return $this->render("admin/new-admin.html.twig",['form'=>$form->createView()]);
        }
}