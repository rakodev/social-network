<?php

namespace App\Controller;

use App\Entity\Band;
use App\Entity\UserBand;
use App\Repository\BandRepository;
use App\Repository\UserBandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BandController
 * @package App\Controller
 * @Route("/band", name="band_")
 */
class BandController extends AbstractController
{
    /**
     * List bands
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/list/", name="list")
     */
    public function list()
    {
        /** @var BandRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Band::class);
        $bands = $repository->list();

        return $this->json(
            [   'success' => true,
                'bands' => $bands,
            ]
        );
    }

    /**
     * List bands & users connections
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/users/", name="users")
     */
    public function users(Request $request)
    {
        $bandId = $request->query->getInt('bandId');
        /** @var UserBandRepository $repository */
        $repository = $this->getDoctrine()->getRepository(UserBand::class);

        $users = $repository->getBandUsers($bandId);
        return $this->json(
            [   'success' => true,
                'users' => $users,
            ]
        );
    }
}
