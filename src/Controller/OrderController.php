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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class OrderController extends AbstractController
{

    /**
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function makeOrder(Request $request){

        $order = new Order();
        $order->setUserOwner($this->getUser());

        $manager = $this->getDoctrine()->getManager();

        $manager->persist($order);

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
                $manager->persist($orderProduct);
            }
            if($productToSaveCount == 0){
                throw new MakeOrderException('Заказ пустой');
            }
            $manager->flush();
        }
        catch (MakeOrderException $exception){
            $returnData['flag'] = 'error';
            $returnData['msg'] = $exception->getMessage();
        }
        catch (\Exception $exception){
            $returnData['flag'] = 'error';
            $returnData['msg'] = 'возникла ошибка при сохранении заказа';
        }

        return $this->json($returnData);
    }
}