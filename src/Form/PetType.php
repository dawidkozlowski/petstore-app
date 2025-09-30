<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', IntegerType::class, [
                'required' => true,
                'label' => 'Pet ID'
            ])
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Pet name'
            ])
            ->add('status', TextType::class, [
                'required' => true,
                'label' => 'Status (available, pending, sold)'
            ]);
    }
}
