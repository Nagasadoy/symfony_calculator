<?php

namespace App\Controller;

use App\Form\CalculatorFormType;
use App\Services\Calculator\CalculateServiceFactory;
use App\Services\RabbitMq\Calculation\CalculationConsumer;
use App\Services\RabbitMq\Calculation\CalculationProducer;
use App\Services\RabbitMq\Calculation\CalculationMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculatorController extends AbstractController
{
    public function __construct(
        private readonly CalculationProducer $producer,
        private readonly CalculationConsumer $consumer
    ) {}

    #[Route('/', name: 'app_index')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(CalculatorFormType::class);
        $form->handleRequest($request);

        $result = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $result = $this->getResult($form);
        }

        return $this->render('calculator/index.html.twig', [
            'form' => $form,
            'result' => $result
        ]);
    }

    private function getResult(FormInterface $form): ?string
    {
        $firstOperand = $form->get('firstOperand')->getData();
        $secondOperand = $form->get('secondOperand')->getData();
        $operation = $form->get('operation')->getData();

        $addToQueueSubmit = $form->get('addToQueue')->isClicked();
        $getFromQueueSubmit = $form->get('getFromQueue')->isClicked();

        if ($addToQueueSubmit) {
            try {
                $this->producer->produce(new CalculationMessage($firstOperand, $secondOperand, $operation));
                $this->addFlash('info',
                    'Выражение: "' . "$firstOperand  $operation $secondOperand" . '"отправлено в очередь'
                );
            } catch (\Throwable) {
                $this->addFlash('error', 'Произошла ошибка при отправке выражения в очередь');
            }
            return null;
        }

        if ($getFromQueueSubmit) {
            $message = $this->consumer->consume();
            if ($message === null) {
                $this->addFlash('info', 'Нет выражений в очереди');
                return null;
            }

            $firstOperand = $message->firstOperand;
            $secondOperand = $message->secondOperand;
            $operation = $message->operation;
        }

        try {
            $calculatorService = CalculateServiceFactory::create($operation);
            $result = $calculatorService->getResult($firstOperand, $secondOperand);
        } catch (\DomainException $exception) {
            $this->addFlash('error', $exception->getMessage());
            $result = null;
        }

        return $result;
    }
}