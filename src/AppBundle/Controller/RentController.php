<?php

namespace AppBundle\Controller;

use CarBundle\Entity\Rent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CarBundle\Entity\Car;

class RentController extends Controller
{

    public function getCarRents($data,$doctrine){
        $em = $doctrine->getRepository(Rent::class);
        $rents = $em->findBy(
            ['carId' => $data['params']['id'],],
            ['begingTime' => 'ASC']
        );
        $readyArr = [];
        foreach($rents as $rent){
            $readyArr[] = [
                'id' => $rent->getId(),
                'beginTime' => $rent->getBegingTime(),
                'endTime' => $rent->getEndTime(),
                'price' => $rent->getPrice(),
            ];
        }
        echo json_encode($readyArr);
    }

    public function addCarRent($data,$doctrine){
        $params = $data['params'];
        $manager = $doctrine->getManager();
        try{
            $rent = new Rent();
            $rent->setPrice($params['price']);
            $rent->setBegingTime($params['beginTime']);
            $rent->setEndTime($params['endTime']);
            $rent->setCarId($params['id']);
            $manager->persist($rent);
            $manager->flush();
            echo 1;
        }catch (\Exception $e){
            echo 0;
        }

    }

    public function ChangeCarRent($data,$doctrine){
        $params = $data['params'];
        try {
            $manager = $doctrine->getManager();
            $rent = $manager->getRepository(Rent::class)->find($params['id']);
            $rent->setPrice($params['price']);
            $rent->setBegingTime($params['beginTime']);
            $rent->setEndTime($params['endTime']);
            $manager->persist($rent);
            $manager->flush();
            echo 1;
        }catch (\Exception $e){
            echo 0;
        }
    }

    public function deleteRent($data,$doctrine){
        $params = $data['params'];
        try{
            $manager = $doctrine->getManager();
            $rent = $manager->getRepository(Rent::class)->find($params['id']);
            $manager->remove($rent);
            $manager->flush();
            echo 1;
        }catch (\Exception $e){
            echo 0;
        }
    }

    public function getRentsForTable($data,$doctrine){

        $query = "SELECT car.id AS 'carID', car.title, car.type, rent.id AS 'rentID', rent.end_time, rent.price, rent.profit FROM `car` RIGHT JOIN `rent` ON car.id = rent.car_id WHERE rent.profit IS NOT NULL ORDER BY car.id, car.type, rent.end_time ASC";
        $manager = $doctrine->getManager();
        $statement = $manager->getConnection()->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $key => $item) {
            $date = date("d.m.Y-h:i",$item['end_time']);
            $result[$key]['endFormatted'] = $date;
        }
        echo json_encode($result);
    }

}
