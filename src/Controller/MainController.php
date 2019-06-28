<?php
/**
 * Created by PhpStorm.
 * User: Альберт
 * Date: 28.06.2019
 * Time: 14:23
 */

namespace App\Controller;

use App\Entity\ProductCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MainController extends AbstractController
{

    /**
     * @IsGranted("ROLE_USER")
     * @return Response
     * @throws \Exception
     */
    public function index()
    {
        $number = random_int(0, 100);
        $user = $this->getUser();

        $productCategoryes = $this->getDoctrine()->
                                getRepository(ProductCategory::class)->findAll();

        return $this->render('main.html.twig', [
            'number' => $number,
            'user' => $user,
            'productCategoryes' =>$productCategoryes
        ]);
    }

}