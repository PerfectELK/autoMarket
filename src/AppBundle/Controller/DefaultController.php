<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CarBundle\Entity\Car;
use CarBundle\Entity\Rent;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $this->profit();
        return $this->render('main/main.html.twig', []);
    }

    /**
     * @Route("/manager")
     */
    public function managerPage(Request $request){

        $this->profit();
        return $this->render('manager/manager.html.twig');
    }
    /**
     * @Route("/getCars")
     */
    public function getCars(Request $request){
        $em = $this->getDoctrine()->getManager();
        $query = "SELECT car.id AS 'carID', car.title, car.type, car.img, car.load_capacity , car.number_of_seats, car.fuel ,rent.id AS 'rentID', rent.beging_time as 'beginUnix', rent.end_time as 'endUnix',  rent.price, rent.profit FROM `car` LEFT JOIN `rent` ON car.id = rent.car_id WHERE car.active = 1 ORDER BY car.price ASC";
        $statement = $em->getConnection()->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $readyArr = [];
        foreach ($result as $key => $item) {
            if(!empty($readyArr[$item['carID']]['item'])){
                $readyArr[$item['carID']]['rents'][] = $item;
            }else{
                $readyArr[$item['carID']]['item'] = $item;
                $readyArr[$item['carID']]['rents'][] = $item;
            }
        }
        echo json_encode(array_values($readyArr));
        die();
    }

    /**
     * @Route("/api", methods={"POST"})
     */
    public function api(Request $request){
        $doctrine = $this->getDoctrine();
        $data = $request->request->get('data');
        $jsonStringify = $request->request->get('formDataJson');
        if($jsonStringify){
            $dataJson = json_decode($jsonStringify);
        }

        if (is_array($data)) {
            $c = $data['c'];
            $m = $data['m'];

            $sString = "AppBundle\\Controller\\{$c}";
            $cObject = new $sString();
            $cObject->$m($data, $doctrine);
            die();
        }

        if($dataJson){

            $c = $dataJson->c;
            $m = $dataJson->m;

            $sString = "AppBundle\\Controller\\{$c}";
            $cObject = new $sString();
            $cObject->$m($dataJson, $doctrine);
            die();
        }

    }

    public function profit(){
        $curentTime = time();
        $query = "SELECT * FROM `rent` WHERE `end_time` < {$curentTime} AND `profit` IS NULL";
        $manager = $this->getDoctrine()->getManager();
        $statement = $manager->getConnection()->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        if(count($result)) {
            foreach ($result as $res) {
                $timeBetween = $res['end_time'] - $res['beging_time'];
                $days = round($timeBetween / 60 / 60/ 24,2);
                $hours = round($timeBetween / 60 / 60 % 24,2);
                $profit = max($res['price'] * 0.05, ($days * 300 ) + ($hours * 30));
                $query = "UPDATE `rent` SET `profit` = {$profit} WHERE `id` = {$res['id']}";
                $statement = $manager->getConnection()->prepare($query);
                $statement->execute();

            }
        }
    }


}
