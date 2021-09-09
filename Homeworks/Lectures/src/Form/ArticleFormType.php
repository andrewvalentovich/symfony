<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' =>  'Укажите название статьи',
                'help'  =>  'Не используйте в названии слово "собака"'
            ])
            ->add('body')
            ->add('publishedAt', null, [
                'widget'    =>  'single_text'
            ])
        ;

        $builder->get('body')
            ->addModelTransformer(new CallbackTransformer(
               function ($bodyFormDatabase) {
                    return str_replace('**собака**', 'собака', $bodyFormDatabase);
               },
               function ($bodyFormInput) {
                    return str_replace('собака', '**собака**', $bodyFormInput);
               }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
