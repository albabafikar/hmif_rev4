<?php

namespace Jimmy\hmifOfficial\Http\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class LoginForm
 * @package Jowy\P2bj\Http\Form
 */
class LoginForm extends AbstractType
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'username',
            'text',
            [
                'constraints' => new Assert\NotBlank(),
                'attr' => ['class' => 'gui-input','placeholder' => 'Input Username'],
                'label' => false,
                'label_attr' => ['class' => 'field-label text-muted fs18 mb10']
            ]
        )->add(
            'password',
            'password',
            [
                'constraints' => new Assert\NotBlank(),
                'attr' => ['class' => 'gui-input','placeholder' => 'Input Password'],
                'label' => false,
                'label_attr' => ['class' => 'field-label text-muted fs18 mb10']
            ]
        )
            ->add(
                'login',
                'submit',
                [
                    'attr' => ['class' => 'button btn-primary mr10 pull-right']
                ]
            );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'login';
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
