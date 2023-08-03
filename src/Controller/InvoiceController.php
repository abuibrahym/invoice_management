<?php
namespace App\Controller;
use App\Entity\Invoice;
use App\Form\InvoiceFormType;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class InvoiceController extends AbstractController{
   
    #[Route('/', name:'app_home_page')]
    public function homePage(){

        return $this->render('home.html.twig',[

        ]);

    }

    #[Route('/create', name: "app_create_invoice")]

    public function createInvoice(EntityManagerInterface $entityManager, Request $request):Response{
        $form = $this->createForm(InvoiceFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            // dd($request);
            $invoice = $form->getData();
            $entityManager->persist($invoice);
            $entityManager->flush();
            return $this->redirectToRoute('app_fetch_invoice', [
                // 'id' => $invoice->getId(),
            ]);
        }
        return $this->render('create.html.twig', [
            'invoice_form' => $form
        ]);

        }

        #[Route('/list-invoice', name: "app_fetch_invoice")]
        public function fetchInvoice(EntityManagerInterface $entityManager, InvoiceRepository $repository):Response{

            $data = $repository->findAll();
            // dd($data);
           
            return $this->render('invoice_list.html.twig', [
              'data' => $data
            ]);
    
            }

            #[Route('/update-invoice/{id}', name: "app_update_invoice")]
            public function updateInvoice(Invoice $invoice, Request $request, EntityManagerInterface $em)
            {
                $form = $this->createForm(InvoiceFormType::class, $invoice, 
            );
        
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $em->persist($invoice);
                    $em->flush();
        
                    $this->addFlash('success', 'Invoice Updated! Inaccuracies squashed!');
        
                    return $this->redirectToRoute('app_fetch_invoice', [
                        // 'id' => $invoice->getId(),
                    ]);
                }
        
                return $this->render('create.html.twig', [
                    'invoice_form' => $form->createView()
                ]);
            }

            #[Route('/delete-invoice/{id}', name: "app_delete_invoice")]
            public function deleteInvoice(Invoice $invoice, Request $request, EntityManagerInterface $em)
            {
            
                $em->remove($invoice);
                $em->flush();
                $this->addFlash('success', 'Invoice Updated! Inaccuracies squashed!');
    
                return $this->redirectToRoute('app_fetch_invoice', [
                    // 'id' => $invoice->getId(),
                ]);
                
        
                
            }
        

    
}