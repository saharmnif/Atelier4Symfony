<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use App\Entity\Book;
use App\Form\BookType;
use App\Form\DateBookType;
use App\Form\SearchBookType;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{

    #[Route('/book/add', name: 'app_addBook')]
    public function addBook(ManagerRegistry $manager,BookRepository $repository,Request $req) : Response {
        $em= $manager->getManager();

        $book=new Book();

        $form = $this->createForm(BookType::class, $book);
      

        $form->handleRequest($req);



        if($form->isSubmitted())
   
        {
   
       $em->persist($book);
   
       $em->flush();
   
       return $this->redirectToRoute('listbook');
   
       }
   
   
   
       return $this->render('book/formBook.html.twig',[
   
         'f'=>$form->createView()
   
         ]);
        }

        
        //$book1 -> setTitle("les miserables");
        //$book1 -> setPublicationDate("1862");
        //$book1 -> setEnabled(true);
        //$book1 -> setAuthor($author);
        //$em -> persist($book1);
        //$em-> flush();
        //return new Response('book added',200);
    

    #[Route('/book/getall', name: 'app_getallBooks')]
    public function getallStudent(BookRepository $repository)
    {

        $Books= $repository-> findAll();
        return $this->render('book/index.html.twig', [
            'books' => $Books 
        ]);  
    }

    #[Route('/book/getall2', name: 'listbook')]
    public function getallStudent2(BookRepository $repository)
    {

        $Books= $repository-> listbook();
        return $this->render('book/index.html.twig', [
            'books' => $Books 
        ]);  
    }

    #[Route('/BooksByDate', name: 'BooksBydate')]
    public function getBookByDate(BookRepository $repository,Request $req)
    {
        $form = $this->createForm(DateBookType::class);
        $form->handleRequest($req);
        
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $startDate = $data['start_date'];
            $endDate = $data['end_date'];
    
            
            $Books = $repository->getBooksByDate($startDate, $endDate);
            return $this->render('book/getBookByDate.html.twig', [
                'f' => $form->createView(),
                'books' => $Books,
            ]);
        }
        $Books= $repository-> findAll();
        return $this->render('book/getBookByDate.html.twig',[

            'f'=>$form->createView(),'books' => $Books 
      
            ]);
    }



    #[Route('/BooksSearch', name: 'Bookssearch')]
    public function searchBookByRef(BookRepository $repository,Request $req)
    {
        $form = $this->createForm(SearchBookType::class);
        $form->handleRequest($req);
        
        if ($form->isSubmitted()) {
            $id = $form->getData();
            $Books = $repository->searchBookByRef($id);
            return $this->render('book/searchBook.html.twig', [
                'f' => $form->createView(),
                'books' => $Books,
            ]);
        }$Books= $repository-> findAll();
        return $this->render('book/searchBook.html.twig',[

            'f'=>$form->createView(),'books' => $Books 
      
            ]);}

            #[Route('/book/update-category', name: 'updatebookcategory')]
        public function updatebookcategory(BookRepository $repository): Response
{
          $repository->updatebookcategory();

          return $this->redirectToRoute('app_getallBooks');
}

    #[Route('/book/update/{id}',name:'app_book_update')]
    public function updateBook(Request $req,ManagerRegistry $manager,Book $book,BookRepository $repo){
        $em= $manager->getManager();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($req);
        if($form->isSubmitted())
        {
        $em->flush();
        return $this->redirectToRoute('app_getallBooks');
        }

        return $this->render('book/formBook.html.twig',[
            'f'=>$form->createView()
        ]);
    }

    #[Route('/book/delete/{id}', name: 'app_deleteBook')]
    public function deleteBook (ManagerRegistry $manager, BookRepository $repository, $id) {
        $em= $manager->getManager();
       
        $bookd = $repository -> find($id);
        $em -> remove($bookd);

        $em -> flush();

        return $this-> redirectToRoute('app_getallBooks'); 
    }




    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
}
