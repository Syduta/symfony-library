<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminAuthorsController extends AbstractController
{
    /**
     * @Route("/admin/authors",name="admin-authors")
     */

    public function authors(AuthorRepository $authorRepository){
        $authors=$authorRepository->findAll();
        return $this->render('admin/authors.html.twig',['authors'=>$authors]);
//        dd("coucou");
    }

    /**
     * @Route("/admin/author/{id}",name="admin-author")
     */

    public function author(AuthorRepository$authorRepository, $id){
        $author = $authorRepository->find($id);
        return $this->render('admin/author.html.twig',['author'=>$author]);
    }

    /**
     * @Route("/admin/authors/delete/{id}",name="admin-delete-author")
     */

    public function deleteAuthor($id,AuthorRepository $authorRepository, EntityManagerInterface $entityManager){
        $author = $authorRepository->find($id);
        if(!is_null($author)){
            $entityManager->remove($author);
            $entityManager->flush();
            $this->addFlash('success','auteur supprimé de la base de données');
            return$this->redirectToRoute('admin-authors');
        }else{
            $this->addFlash('success','auteur déjà supprimé');
            return $this->redirectToRoute('admin-authors');
        }
    }

    /**
     * @Route("/admin/authors/update/{id}",name="admin-update-author")
     */

    public function updateAuthor($id,AuthorRepository$authorRepository, EntityManagerInterface $entityManager, Request $request){
        $author = $authorRepository->find($id);
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($author);
            $entityManager->flush();
            $this->addFlash('success','auteur mis à jour');
        }
        return$this->render("admin/update-author.html.twig",['form'=>$form->createView()]);
    }

    /**
     * @Route("/admin/new-author",name="new-author")
     */

    public function newAuthor(EntityManagerInterface $entityManager, Request $request){
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($author);
            $entityManager->flush();
            $this->addFlash('success','auteur ajouté');
        }
        return $this->render("/admin/new-author.html.twig",['form'=>$form->createView()]);
//        dd("coucou");
    }

}