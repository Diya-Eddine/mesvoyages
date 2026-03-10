<?php
namespace App\Form;
use App\Entity\Visite;
use App\Entity\Environnement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use DateTime;

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ville')
            ->add('pays')
            ->add('datecreation', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
                'data' => isset($options['data']) &&
                    $options['data']->getDatecreation() != null
                    ? $options['data']->getDatecreation()
                    : new DateTime('now'),
            ])
            ->add('note', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 20
                ]
            ])
            ->add('avis')
            ->add('tempmin', null, [
                'label' => 't° min'
            ])
            ->add('tempmax', null, [
                'label' => 't° max'
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'sélection image',
                'required' => false,
            ])
            ->add('environnements', EntityType::class, [
                'class' => Environnement::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'required' => false,
                'label' => 'Environnements'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}