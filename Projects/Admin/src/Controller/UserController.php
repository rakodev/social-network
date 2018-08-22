<?php

namespace App\Controller;

use App\Service\SocialNetworkApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user_")
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * @Route("/list/", name="list")
     * @param SocialNetworkApi $api
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, SocialNetworkApi $api)
    {
        $page = $request->query->getInt('page', 1);
        $response = $api->getUserList($page);

        return $this->render('user/list.html.twig', [
            'users' => $response['users'],
            'currentPage' => $page,
            'lastPage' => $response['pageCount'],
            'paginationPath' => 'user_list'
        ]);
    }

    /**
     * @Route("/connections/", name="connections")
     * @param Request $request
     * @param SocialNetworkApi $api
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connectionsList(Request $request, SocialNetworkApi $api)
    {
        $userId = $request->query->getInt('userId');
        $response = $api->getUserConnectionsList($userId);

        return $this->render('user/userConnectionList.html.twig', [
            'users' => $response['connections']
        ]);
    }
}
