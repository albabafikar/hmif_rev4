<?php

namespace Jimmy\hmifOfficial\Http\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints as Assert;

class UserForm extends AbstractType
{
    private $username;

    private $password;

    private $createdAt;

    private $role;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'username',
            'text',[
                'constraints' => new Assert\NotBlank(),
                'label' => false,
                'attr' => [
                    'placeholder' => 'Choose Username',
                    'class' => 'form-control'
                ]
            ]
        )
            ->add(
                'password',
                'password',
                [
                    'constraints' => new Assert\NotBlank(),
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Choose Password',
                        'class' => 'form-control'
                    ]
                ]
            )->add(
                'role',
                'choice',[
                    'constraints' => new Assert\NotBlank(),
                    'choice_list' => new ChoiceList(
                        ['0','1'],['0','1']
                    ),
                    'placeholder' => 'Choose Role',
                    'empty_data' => '0',
                    'label' => false,
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )->add(
                'kirim',
                'submit',
                [
                    'label' => 'Eksekusi',
                    'attr' => [
                        'style' => 'border-bottom: 4px solid #2ecc71 !important',
                        'class' => 'btn btn-primary pull-right'
                    ]
                ]
            );
    }

    public function getName()
    {
        return 'user_form';
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

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }
}