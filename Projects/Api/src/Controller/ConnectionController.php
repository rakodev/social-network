<?php

namespace App\Controller;

use App\Entity\UserUser;
use App\Repository\UserUserRepository;
use App\Service\ConnectionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ConnectionController
 * @package App\Controller
 * @Route("/connection", name="connection_")
 */
class ConnectionController extends AbstractController
{
    /**
     * Connect a user to another user from a same band
     *
     * @Route("/users/", name="users", methods={"POST"})
     * @param Request $request
     * @param ConnectionService $connectionService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function toUser(Request $request, ConnectionService $connectionService)
    {
        $bandId = $request->request->getInt('bandId');
        $userAId = $request->request->getInt('userAId');
        $userBId = $request->request->getInt('userBId');

        try {
            $connectionService->createConnection($bandId, $userAId, $userBId);
        } catch (Exception $exception) {
            return $this->json(
                ['success' => false, 'message' => $exception->getMessage()], 400
            );
        }

        return $this->json(
            ['success' => true]
        );
    }


}
