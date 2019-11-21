<?php

namespace App\Controller;

use App\Errors\BetslipStructureMismatch;
use App\Service\BetService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/bet", name="bet", methods={"POST","HEAD"})
     */
    public function bet(BetService $betService, Request $request)
    {
        $params = json_decode($request->getContent(),true);
        if(empty($params)) {
            return new Response(json_encode(new BetslipStructureMismatch()), 400, ['Content-Type' => 'application/json']);
        }

        if(!$betService->placeBet($params)) {
            $response = new Response(json_encode($params), 400, ['Content-Type' => 'application/json']);
        } else {
            $response = new Response(json_encode([]), 201, ['Content-Type' => 'application/json']);
        }
        return $response;
    }
}
