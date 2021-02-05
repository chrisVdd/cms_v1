<?php

namespace App\Form;

use App\Services\ImportHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ImportUserStep3Form
 * @package App\Form
 */
class ImportUserStep3Form extends AbstractType
{
    /**
     * @var ImportHelper
     */
    private $importHelper;

    /**
     * ImportUserStep3Form constructor.
     * @param ImportHelper $importHelper
     */
    public function __construct(ImportHelper $importHelper)
    {
        $this->importHelper = $importHelper;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $headers = $this->importHelper->getHeaders();
        $userEntityFields = $this->importHelper->getUserEntityFields();

        foreach ($userEntityFields as $userField) {
                        $builder->add($userField, ChoiceType::class,
                            [
                                'placeholder' => 'Choose a column from the excel file',
                                'choices'     => array_flip($headers),
                                'multiple'    => false,
                                'required'    => false
                            ]
                        );
                    }
    }

    /**
     * @return mixed
     */
    public function getBlockPrefix()
    {
        return 'importUserStep3';
    }
}