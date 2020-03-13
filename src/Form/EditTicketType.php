<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditTicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           /* ->add('subject')
            ->add('priority')
            ->add('date')
            ->add('status')*/

            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Open' => 'Open',
                    'In progress' => 'In progress',
                    'no fix' => 'no fix',
                    'Closed' => 'closed',

                ],
                'mapped' => false,


            ])

            ->add('save', SubmitType::class, [
                    'attr' => ['class' => 'submit'],
            ])


       /*     ->add('user_id')
            ->add('agent_id')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
