<?php

namespace App\Controller;

use App\Service\SocialNetworkApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/band/", name="band")
     */
    public function band(Request $request, SocialNetworkApi $api)
    {
        $response = $api->getBandList();

        return $this->render('connection/band.html.twig', [
            'bands' => $response['bands'],
        ]);
    }

    /**
     * @param Request $request
     * @param SocialNetworkApi $api
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/userA/", name="user_a")
     */
    public function selectUserA(Request $request, SocialNetworkApi $api)
    {
        $bandId = $request->query->getInt('bandId');
        $response = $api->getBandUsers($bandId);
        return $this->render('connection/selectUserA.html.twig', [
            'users' => $response['users'],
            'bandId' => $bandId
        ]);
    }

    /**
     * @param Request $request
     * @param SocialNetworkApi $api
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @Route("/userB/", name="user_b")
     */
    public function selectUserB(Request $request, SocialNetworkApi $api)
    {
        $bandId = $request->query->getInt('bandId');
        $userAId = $request->query->getInt('userAId');
        $response = $api->getPotentialConnectionUsers($bandId, $userAId);
        return $this->render('connection/selectUserB.html.twig', [
            'users' => $response['users'],
            'bandId' => $bandId,
            'userAId' => $userAId
        ]);
    }

    /**
     * @param Request $request
     * @param SocialNetworkApi $api
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @Route("/connect-users/", name="connect_users")
     */
    public function connectUsers(Request $request, SocialNetworkApi $api)
    {
        $bandId = $request->query->getInt('bandId');
        $userAId = $request->query->getInt('userAId');
        $userBId = $request->query->getInt('userBId');

        $response = $api->connectUsers($bandId, $userAId, $userBId);
        if(isset($response['success']) && $response['success']) {
            $this->addFlash(
                'notice',
                'User '.$userAId.' and '.$userBId.' are now connected'
            );
        } else {
            $this->addFlash(
                'error',
                "We can't connect user ".$userAId." and ".$userBId
            );
        }

        return $this->redirectToRoute('connection_user_b', ['bandId' => $bandId, 'userAId' => $userAId]);
    }
}
