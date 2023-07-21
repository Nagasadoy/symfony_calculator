<?php

namespace App\Controller;

use App\Form\CalculatorFormType;
use App\Services\Calculator\CalculateServiceFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculatorController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(CalculatorFormType::class);
        $form->handleRequest($request);

        $result = null;
        if ($form->isSubmitted() && $form->isValid()) {

            $firstOperand = $form->get('firstOperand')->getData();
            $secondOperand = $form->get('secondOperand')->getData();
            $operation = $form->get('operation')->getData();

            try {
                $calculatorService = CalculateServiceFactory::create($operation);
                $result = $calculatorService->getResult($firstOperand, $secondOperand);
            } catch (\DomainException $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('calculator/index.html.twig', [
            'form' => $form,
            'result' => $result
        ]);
    }
}