<?php

namespace App\Form;

use App\Entity\Invoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class InvoiceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   

        $data = $options['data'] ?? null;
        $isEdit = $data && $data->getInvoiceNumber();

        // dd($isEdit);
        // dd($options);
        $builder
            ->add('invoice_number', null, [
                'disabled' => $isEdit
            ])
            ->add('invoice_name')
            // ->add('address')
            ->add('phone_number')
            ->add('amount')
            // ->add('test',TextType::class, [
            //     'mapped'=>false,
            //     'required' => false
            // ])
            ;
            if($options['create_new']){
                $builder->add('test',TextType::class, [
                    'mapped'=>false,
                    'required' => false
                ]);
            }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
            // 'data_class' => InvoiceModel::class,
            'create_new' => false,
            array(
                'attr'=>array('novalidate'=>'novalidate')
            )
        ]);
    }
}
