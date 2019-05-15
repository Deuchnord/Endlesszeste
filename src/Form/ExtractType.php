<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExtractType extends AbstractType
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class, [
                'required' => true,
                'label' => false,
            ])
            ->add('acceptTerms', CheckboxType::class, [
                'required' => true,
                'label' => 'chapter.form.terms',
                'label_translation_parameters' => [
                    '%termsUrl%' => $this->router->generate('help'),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'chapter.form.submit',
                'attr' => ['class' => 'submit']
            ]);
    }
}
