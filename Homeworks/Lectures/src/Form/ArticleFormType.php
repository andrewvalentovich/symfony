<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
    }

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
            ->add('author', EntityType::class, [
                'class' =>  User::class,
                'choice_label'  =>  function (User $user) {
                    return sprintf('%s (id: %d)', $user->getFirstName(), $user->getId());
                },
                'placeholder'   =>  'Выберите автора статьи',
                'choices'   =>  $this->userRepository->findAllSortedByName()
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
