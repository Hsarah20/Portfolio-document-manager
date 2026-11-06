<?php

namespace App\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DocumentRepository;
use App\Enum\DocumentStatus;

#[Route('/app', name: 'app_client_')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(DocumentRepository $documentRepo): Response
    {
         $client = $this->getUser()->getClient();

        return $this->render('client/dashboard.html.twig', [
            'totalDocuments'      => $documentRepo->countForClient($client),
            'documentsInProgress' => $documentRepo->countForClient($client, [DocumentStatus::PENDING, DocumentStatus::PROCESSING]),
            'documentsFailed'     => $documentRepo->countForClient($client, [DocumentStatus::FAILED]),
            'recentDocuments'     => $documentRepo->findRecentForClient($client, 5),
        ]);
    }
}