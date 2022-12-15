<?php

namespace App\Form;

use App\Entity\ApplicantCv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ApplicantCvUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', VichFileType::class, [
                'label' => 'CV file (only PDF allowed)',
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/pdf',
                        ],
                        'maxSize' => '10M',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApplicantCv::class,
        ]);
    }
}
