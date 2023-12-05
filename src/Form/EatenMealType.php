<?php

namespace App\Form;

use App\Entity\EatenMeal;
use App\Entity\Meal;
use App\Repository\MealRepository;
use Doctrine\ORM\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EatenMealType extends AbstractType
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('meal', EntityType::class, [
                'class' => Meal::class,
                'choice_label' => 'name',
                'query_builder' => function (MealRepository $mealRepository): QueryBuilder {
                    return $mealRepository->findPublicOrOwnQueryBuilder($this->tokenStorage->getToken()->getUser());
                },
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EatenMeal::class,
        ]);
    }
}