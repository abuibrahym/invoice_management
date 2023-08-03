<?php
namespace App\Controller;
use App\Entity\Invoice;
use App\Form\InvoiceFormType;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class InvoiceController extends AbstractController{
   
    #[Route('/', name:'app_home_page')]
    public function homePage():Response{
        return $this->render('home.html.twig',[
        ]);
    }

    #[Route('/create', name: "app_create_invoice")]
    public function createInvoice(EntityManagerInterface $entityManager, Request $request):Response{
        $form = $this->createForm(InvoiceFormType::class, null, [
            'create_new'=> true,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            // dd($request);
            // dd($form['test']->getData());
            $invoice = $form->getData();
            
            // $invoiceModel = $form->getData();
            // dd($invoiceModel);
            // $invoice = new Invoice();
            // $invoice->setInvoiceNumber($invoiceModel->invoice_number);
            // $invoice->setInvoiceName($invoiceModel->invoice_name);
            // $invoice->setPhoneNumber($invoiceModel->phone_number);
            // $invoice->setAmount($invoiceModel->amount);
            $entityManager->persist($invoice);
            $entityManager->flush();
            $this->addFlash('success', 'Invoice Created Successfully!!');
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
            public function updateInvoice(Invoice $invoice, Request $request, EntityManagerInterface $em):Response
            {
                $form = $this->createForm(InvoiceFormType::class, $invoice, 

            );

        
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                   
            // $invoiceModel = $form->getData();
            //         $invoice = new Invoice();
            //         $invoice->
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
            public function deleteInvoice(Invoice $invoice, Request $request, EntityManagerInterface $em):Response
            {
            
                $em->remove($invoice);
                $em->flush();
                $this->addFlash('success', 'Invoice Deleted Successfully!!');
    
                return $this->redirectToRoute('app_fetch_invoice', [
                    // 'id' => $invoice->getId(),
                ]);
                
        
                
            }
        

    
}