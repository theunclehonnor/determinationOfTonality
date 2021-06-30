<?php


namespace App\Controller;


use App\Exception\ApiUnavailableException;
use App\Form\AnalyzeType;
use App\Model\AnalyzeDTO;
use App\Model\ModelDTO;
use App\Model\ObjectInQuestionDTO;
use App\Model\ResourceDTO;
use App\Service\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnalyzeController extends AbstractController
{
    /**
     * @Route("/analyze", name="analyze")
     */
    public function analyze(Request $request, ApiClient $apiClient): Response
    {
//        $modelsArray = $apiClient->getDistinctModel($this->getUser());
        $analyzeDto = new AnalyzeDTO();
        $analyzeDto->setResource(new ResourceDTO());
        $analyzeDto->setModel(new ModelDTO());
        $analyzeDto->setObjectInQuestion(new ObjectInQuestionDTO());

        $form = $this->createForm(AnalyzeType::class, $analyzeDto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $data = [
                    'url' => $analyzeDto->getObjectInQuestion()->getLink(),
                    'model' => [
                        'name' => $analyzeDto->getModel()->getName(),
                        'dataSet' => $analyzeDto->getModel()->getDataSet(),
                        'classificator' => $analyzeDto->getModel()->getClassificator(),
                    ]
                ];
                $method = 'parser/';
                if ('М.видео' === $analyzeDto->getResource()->getName()) {
                    $method .= 'mvideo';
                } elseif ('Продокторов | врачи' === $analyzeDto->getResource()->getName()) {
                    $method .= 'prodoctorov';
                }
                $response = $apiClient->analyze($this->getUser(), $data, $method);

                $response = $apiClient->createReport($this->getUser(), $response['id_report']);

                // flash message
                $this->addFlash('success', 'Анализ об объекте рассмотрения успешно проведен!');
                return $this->redirectToRoute('history');
            } catch (ApiUnavailableException | \Exception $e) {
                return $this->render('analyze/analyzeForm.html.twig', [
                    'form' => $form->createView(),
                    'errors' => $e->getMessage(),
                ]);
            }
        }
        return $this->render('analyze/analyzeForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}