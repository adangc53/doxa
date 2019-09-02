<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class UpdateType extends AbstractType{
     
    public function buildForm(FormBuilderInterface $builder,array $option){
        $builder->add('nombre',TextType::class)
            ->add('apellido',TextType::class)
            ->add('email',EmailType::class)
            ->add('password',PasswordType::class)
            ->add('role',TextType::class)
            ->add('submit',SubmitType::class);
     }
}