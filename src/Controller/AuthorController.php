<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\AuthorType;
use Symfony\Component\HttpFoundation\Request;
class AuthorController extends AbstractController
{
    #[Route('/author/add', name: 'app_addAuthor')]
    public function addAuthor(ManagerRegistry $manager,Request $req){
        $em= $manager->getManager();

        $author= new Author();

        $form = $this->createForm(AuthorType::class, $author);
      

            $form->handleRequest($req);



            if($form->isSubmitted())
       
            {
       
           $em->persist($author);
       
           $em->flush();
       
           return $this->redirectToRoute('app_getallAuthors');
       
           }
       
       
       
           return $this->render('author/formAuthor.html.twig',[
       
             'f'=>$form->createView()
       
             ]);
            }

        //$author1 -> setUsername("victor hugo");
        //$author1 -> setEmail("ch@gmail");
        // $em -> persist($author1);
        // $em-> flush();
        // return new Response('author added',200);
    

    #[Route('/author/getall', name: 'app_getallAuthors')]
    public function getallAuthor(AuthorRepository $repository)
    {
        $authors= $repository-> findAll();
        return $this->render('author/index.html.twig', [
            'authors' => $authors
        ]);  
    }
    

    #[Route('/author/update/{id}', name: 'app_updateAuthor')]
    public function updateAuthor(Request $req,ManagerRegistry $manager,Author $author,AuthorRepository $repo){
                    //$author = $repo->find($id);
                    $em= $manager->getManager();
                    $form = $this->createForm(AuthorType::class,$author);
                    $form->handleRequest($req);
                    if($form->isSubmitted())
                    {
                    $em->flush();
                    return $this->redirectToRoute('app_author_getall');
                    }
                   // $author->setName("author 1");
                    //$author->setEmail("author1@gmail.com");
            
                    return $this->render('author/formAuth.html.twig',[
                        'f'=>$form->createView()
                    ]);
                } 

    #[Route('/author/delete/{id}', name: 'app_deleteAuthor')]
    public function deleteAuthor (ManagerRegistry $manager, AuthorRepository $repository, $id) {
        $em= $manager->getManager();
       
        $authord = $repository -> find($id);
        $em -> remove($authord);

        $em -> flush();

        return $this-> redirectToRoute('app_getallAuthors'); 
    }


    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
}
