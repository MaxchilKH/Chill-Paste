<?php
/**
 * Created by PhpStorm.
 * User: maxchil
 * Date: 2/16/18
 * Time: 10:51 PM
 */

namespace App\Form;


use App\Entity\PastebinUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'label' => 'E-mail',
                'required' => true,

            ))

            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'=> array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PastebinUser::class
        ));
    }
}