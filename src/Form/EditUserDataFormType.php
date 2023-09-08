<?php

namespace App\Form;

use App\Entity\User;
use App\Enum\BodyTypeEnum;
use App\Enum\GenderEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserDataFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('age', IntegerType::class)
            ->add('weight', NumberType::class)
            ->add('height', IntegerType::class)
            ->add('bodyType', EnumType::class, [
                'class' => BodyTypeEnum::class,
                'choice_label' => function (BodyTypeEnum $choice) {
                    return $choice->label($choice);
                },
            ])
            ->add('gender', EnumType::class, [
                'class' => GenderEnum::class,
                'choice_label' => function (GenderEnum $choice) {
                    return $choice->label($choice);
                },
            ])
            ->add('submit', SubmitType::class, [
                'row_attr' => [
                    'class' => 'd-grid gap-2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}