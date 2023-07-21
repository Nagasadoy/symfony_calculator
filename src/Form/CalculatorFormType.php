<?php

namespace App\Form;

use App\Services\Calculator\OperationsEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculatorFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('firstOperand', NumberType::class, [
                'label' => 'Аргумент 1',
                'invalid_message' => 'Введите число!',
            ])
            ->add('operation', ChoiceType::class, [
                'choices' => $this->getOperationChoices(),
                'label' => 'Операция'
            ])
            ->add('secondOperand', NumberType::class, [
                'label' => 'Аругмент 2',
                'invalid_message' => 'Введите число!',
            ])
            ->add('calculate', SubmitType::class, ['label' => 'Вычислить']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }

    private function getOperationChoices(): array
    {
        $operationChoicesRaw = array_column(OperationsEnum::cases(), 'value');
        $operationChoices = [];
        foreach ($operationChoicesRaw as $choice) {
            $operationChoices[$choice] = $choice;
        }

        return $operationChoices;
    }
}
