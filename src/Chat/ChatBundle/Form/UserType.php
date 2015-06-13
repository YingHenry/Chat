<?php

namespace Chat\ChatBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label' => 'Pseudo'
                ))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmer mot de passe'),
                'invalid_message' => 'Les mots de passe ne correspondent pas'
                ))
            ->add('save', 'submit', array(
                'label'              => 'ENREGISTRER',
                ))            
        ;
    }
   

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Chat\ChatBundle\Entity\User'
        ));
    }    


    /**
     * @return string
     */
    public function getName()
    {
        return 'chat_chatbundle_user';
    }
}
