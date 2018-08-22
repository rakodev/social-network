<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserUser;
use App\Repository\UserRepository;
use App\Repository\UserUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * List users.
     *
     * Maximum items per request: 20.
     *
     * @Route("/lists/", name="list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listUsers(Request $request)
    {
        $page = $request->query->getInt('page', 1);
        $maxItemsPerPage = 20;
        /** @var UserRepository $repository */
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->getUsers($page, $maxItemsPerPage);
        $totalUsersCount = $repository->getTotalUsersCount();
        $pageCount = ceil($totalUsersCount/$maxItemsPerPage);
        return $this->json(
            [   'success' => true,
                'users' => $users,
                'pageCount' => $pageCount,
                'itemsPerPage' => $maxItemsPerPage,
                'totalItemCount' => $totalUsersCount
            ]
        );
    }

    /**
     * List a user connections
     *
     * @Route("/connections/", name="connections", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listUserConnection(Request $request)
    {
        $userId = $request->query->getInt('userId');

        /** @var UserUserRepository $repository */
        $repository = $this->getDoctrine()->getRepository(UserUser::class);

        $users = $repository->getUserConnections($userId);

        return $this->json(
            ['success' => true, 'connections' => $users]
        );
    }
}
