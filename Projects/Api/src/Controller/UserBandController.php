<?php

namespace App\Controller;

use App\Entity\UserBand;
use App\Repository\UserBandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserBandController
 * @package App\Controller
 * @Route("/user-band", name="user_band_")
 */
class UserBandController extends AbstractController
{
    /**
     * List the possible connections available for a user in a group
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/potential-connection-user-list/", name="potential_connection_user_list")
     */
    public function index(Request $request)
    {
        $bandId = $request->query->getInt('bandId');
        $userAId = $request->query->getInt('userAId');
        /** @var UserBandRepository $repository */
        $repository = $this->getDoctrine()->getRepository(UserBand::class);

        $users = $repository->getPotentialConnectionUsers($bandId, $userAId);
        return $this->json(
            [   'success' => true,
                'users' => $users,
            ]
        );
    }
}
