<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\AuthorType;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminBooksController extends AbstractController
{
    /**
     * @Route("/admin/books",name="admin-books")
     */

    public function books(BookRepository $bookRepository){
        $books = $bookRepository->findAll();
        return $this->render('admin/books.html.twig',['books'=>$books]);
//        dd("coucou");
    }

    /**
     * @Route("/admin/book/{id}",name="admin-book");
     */

    public function book($id,BookRepository $bookRepository){
        $book = $bookRepository->find($id);
        return $this->render('admin/book.html.twig',['book'=>$book]);
    }

    /**
     * @Route("/admin/books/delete/{id}",name="admin-delete-book")
     */

    public function deleteBook($id,BookRepository $bookRepository, EntityManagerInterface $entityManager){
        $book = $bookRepository->find($id);
        if(!is_null($book)){
            $entityManager->remove($book);
            $entityManager->flush();
            $this->addFlash('success','bouquin brûlé à tout jamais');
            return $this->redirectToRoute('admin-books');
        }else{
            $this->addFlash('success','autodafé déjà finit');
            return $this->redirectToRoute('admin-books');
        }
    }

    /**
     * @Route ("/admin/books/update/{id}",name="admin-update-book")
     */

    public function updateBook($id,BookRepository $bookRepository, EntityManagerInterface $entityManager, Request $request){
        $book = $bookRepository->find($id);
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('success','bouquin réécrit');
        }
        return $this->render("admin/update-book.html.twig",['form'=>$form->createView()]);
    }

    /**
     * @Route("/admin/new-book",name="admin-new-book")
     */

    public function newBook(EntityManagerInterface $entityManager, Request $request){
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('success','livre ajouté');
        }
        return $this->render("/admin/new-book.html.twig",['form'=>$form->createView()]);
//        dd("coucou");
    }
}