<?php
/**
 * Created by PhpStorm.
 * User: maxchil
 * Date: 2/16/18
 * Time: 9:43 PM
 */

namespace App\Form;


use App\Entity\PastebinUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignInForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', TextType::class, array(
                'label' => 'username'
            ))
            ->add('_password', PasswordType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PastebinUser::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return null;
    }
}