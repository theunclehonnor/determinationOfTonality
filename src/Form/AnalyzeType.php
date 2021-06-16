<?php


namespace App\Form;


use App\Model\AnalyzeDTO;
use App\Model\ModelDTO;
use App\Model\ObjectInQuestionDTO;
use App\Model\ResourceDTO;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AnalyzeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('resource', ResourceType::class,
                    [
                        'label' => false,
                        'by_reference' => true
                    ]
                )
                    ->add('name', ChoiceType::class,
                        [
                            'label' => 'Веб-ресурс',
                            'choices' => [
                                'М.видео' => 'М.видео',
                                'Продокторов | врачи' => 'Продокторов | врачи',
                            ],
                        ]
                    )
                )
            ->add(
                $builder->create('objectInQuestion', ObjectInQuestionType::class,
                    [
                        'label' => false,
                        'by_reference' => true
                    ])
                    ->add('link', UrlType::class,
                        [
                            'label' => 'Ссылка на ресурс',
                        ]
                    )
            )
            ->add(
                $builder->create('model', ModelType::class,
                    [
                        'label' => false,
                        'by_reference' => true
                    ])
                    ->add('name', ChoiceType::class,
                        [
                            'label' => 'Модель',
                            'choices' => [
                                'BagOfWords' => 'BagOfWords',
                                'Word2Vec' => 'Word2Vec',
                            ],
                        ]
                    )
                    ->add('dataSet', ChoiceType::class,
                        [
                            'label' => 'Корпус с данными',
                            'choices' => [
                                'womenShop' => 'womenShop',
                                'twitter' => 'twitter',
                            ],
                        ]
                    )
                    ->add('classificator', ChoiceType::class,
                        [
                            'label' => 'Классификатор',
                            'choices' => [
                                'MultinomialNB' => 'MultinomialNB',
                                'RandomForest' => 'RandomForest',
                            ],
                        ]
                    )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnalyzeDTO::class,
        ]);
    }
}