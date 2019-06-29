<?php
/**
 * Created by PhpStorm.
 * User: Альберт
 * Date: 28.06.2019
 * Time: 19:15
 */

namespace App\Controller;


use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\ProdectType;
use App\Exception\MakeOrderException;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class OrderController extends AbstractController
{


    /**
     * @var OrderRepository
     */
    private $repository;

    public function __construct(OrderRepository $repository)
    {

        $this->repository = $repository;
    }

    /**
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function makeOrder(Request $request){

        $order = new Order();
        $order->setUserOwner($this->getUser());

        $manager = $this->getDoctrine()->getManager();

        $returnData = [
            'flag' => 'success',
            'msg'  => 'заказ создан'
        ];

        $productToSaveCount = 0;

        try{
            foreach ($request->request->all() as $uid => $count){
                if(!(is_numeric($count) && $count > 0)){
                    continue;
                }
                /**
                 * @var ProdectType $product
                 */
                $product = $this->getDoctrine()->
                getRepository(ProdectType::class)->find($uid);

                if(empty($product)){
                    throw new MakeOrderException('одного из продуктов не существует');
                }

                $orderProduct = new OrderProduct();
                $orderProduct->setCount($count)
                    ->setProductType($product)
                    ->setOrder($order);

                $productToSaveCount++;
                $order->addOrderProduct($orderProduct);
            }
            if($productToSaveCount == 0){
                throw new MakeOrderException('Заказ пустой');
            }
            $manager->persist($order);
            $manager->flush();
        }
        catch (MakeOrderException $exception){
            $returnData['flag'] = 'error';
            $returnData['msg'] = $exception->getMessage();
        }
        catch (\Exception $exception){
            $returnData['flag'] = 'error';
            $returnData['msg'] = 'возникла ошибка при сохранении заказа';
            $returnData['msg'] = $exception->getMessage();
        }

        return $this->json($returnData);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function orderList(Request $request){

        $orderBy = $request->query->get('orderBy');
        //тут я не уверен что это правильное решение
        // думал использовать dql, но тоже показалось
        // не лучшим вариантом
        $orderFieldList = [
            'createdDate',
            'count'
        ];

        $orderField = 'id';

        if(!empty($orderBy) && in_array($orderBy, $orderFieldList)){
            $orderField = $orderBy;
        }
        $orders = $this->repository->findByUserField($this->getUser(), $orderField);

        return $this->render('order list.html.twig', [
            'orders' => $orders,
        ]);
    }
}