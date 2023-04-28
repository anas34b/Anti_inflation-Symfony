<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\ListeArticles;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\MakerBundle\Doctrine\EntityRelation;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AjoutarticlelisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder
        //     ->add('relation',EntityType::class,[
        //         'class' => Articles::class,
        //         'multiple' => true,
        //         'choice_label' => "nom",
        // ]);

        $builder
            ->add('relation',EntityType::class,array(
                'class' => Articles::class,
                'multiple' => true,
                'choice_label' => "nom",)
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ListeArticles::class,
        ]);
    }
}
