<?php

namespace App\Form;

use App\Services\Calculator\OperationsEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
            ->add('calculate', SubmitType::class, ['label' => 'Вычислить'])
            ->add('addToQueue', SubmitType::class, ['label' => 'Добавить в очередь'])
            ->add('getFromQueue', SubmitType::class, ['label' => 'Выбрать из очереди']);

//        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
//            $data = $event->getData();
//            if (array_key_exists('getFromQueue', $data)) {
//                $form = $event->getForm();
////                $form->getConfig()->get
////                $form->remove('firstOperand');
////                $form->remove('secondOperand');
////                $form->remove('operation');
//            }
//        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'validation_groups' => function (FormInterface $form) {
                if ($form->get('getFromQueue')->isClicked()) {
                    return [];
                }

                return ['Required'];
            }
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
