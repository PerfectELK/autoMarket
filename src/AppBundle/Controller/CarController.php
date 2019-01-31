<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CarBundle\Repository\CarRepository;
use SplFileInfo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bridge\Doctrine;
use CarBundle\Entity\Car;
use CarBundle\Entity\Customer;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;


class CarController extends Controller{


    public function getAllCar($data,$doctrine){

        $car = $doctrine->getRepository(Car::class)->findAll();
        foreach ($car as $c){
            $readyArr[] = [
                'id' => $c->getId(),
                'master' => $c->getMaster(),
                'title' => $c->getTitle(),
                'price' => $c->getPrice(),
                'type' => $c->getType(),
                'fuel' => $c->getFuel(),
                'active' => $c->getActive(),
                'loadCapacity' => $c->getLoadCapacity(),
                'numberOfSeats' => $c->getNumberOfSeats(),
                'img' => $c->getImg(),
            ];
        }
        echo json_encode($readyArr);
    }

    public function putCar($data,$doctrine){

        $car = new Car();

    }

    public function addTenant($data,$doctrine){
        $params = $data['params'];
        try{
            $manager = $doctrine->getManager();

            $customer = new Customer();
            $customer->setName($params['fio']);
            $customer->setDriverNum($params['driverNum']);
            $customer->setPassport($params['passport']);
            $customer->setType('tenant');
            $customer->setPhone($params['phone']);

            $manager->persist($customer);
            $manager->flush();
            echo 1;
        }catch (\Exception $e){
            echo 0;
        }

    }

    public function addMaster($data,$doctrine){
        $params = $data['params'];
        try{
            $manager = $doctrine->getManager();

            $customer = new Customer();
            $customer->setName($params['fio']);
            $customer->setDriverNum($params['driverNum']);
            $customer->setPassport($params['passport']);
            $customer->setType('master');
            $customer->setPhone($params['phone']);

            $manager->persist($customer);
            $manager->flush();
            echo 1;
        }catch (\Exception $e){
            echo 0;
        }
    }

    public function getMasters($data,$doctrine){
        try{
            $query = $doctrine->getManager()->createQuery(
                'SELECT p 
                 FROM CarBundle\Entity\Customer p
                 WHERE p.type = :type ORDER BY p.id ASC'
            )->setParameter('type','master');
            $masters = $query->getResult();

            foreach($masters as $master){
                $readyArr[] = [
                    'id' => $master->getId(),
                    'name' => $master->getName(),
                    'phone' => $master->getPhone(),
                ];
            }
            echo json_encode($readyArr,true);

        }catch (\Exception $e){
            echo 0;
        }
    }

    public function getMaster($data, $doctrine)
    {
        try {
            $master = $doctrine->getRepository(Customer::class)->find($data['id']);

            $readyArr[] = [
                'id' => $master->getId(),
                'name' => $master->getName(),
                'phone' => $master->getPhone(),
                'passport' => $master->getPassport(),
                'driverNum' => $master->getDriverNum(),
            ];

            echo json_encode($readyArr);
        }catch (\Exception $e){
            echo 0;
        }

    }

    public function updateCustomer($data, $doctrine){
        $params = $data['params'];
        $em = $doctrine->getManager();
        $customer = $em->getRepository(Customer::class)->find($params['id']);
        if(!$customer){
            die(0);
        }
        if(trim($params['name']) != ''){
            $customer->setName($params['name']);
        }
        if(trim($params['phone']) != ''){
            $customer->setPhone($params['phone']);
        }
        if(trim($params['passport']) != ''){
            $customer->setPassport($params['passport']);
        }
        if(trim($params['driverNum']) != ''){
            $customer->setDriverNum($params['driverNum']);
        }
        try{
            $em->flush();
            echo 1;
        }catch (\Exception $e){
            echo 0;
        }


    }

    public function updateCar($data,$doctrine){
        $params = $data['params'];
        $em = $doctrine->getManager();
        $car = $em->getRepository(Car::class)->find($params['id']);
        if(!$car){
            die(0);
        }
        if(trim($params['type']) != ''){
            $car->setType($params['type']);
            if($params['type'] == 1){
                $car->setLoadCapacity($params['depOnChoose']);
                $car->setNumberOfSeats(null);
            }elseif($params['type'] == 0){
                $car->setLoadCapacity(0);
                $car->setNumberOfSeats($params['depOnChoose']);
            }
        }
        if(trim($params['model']) != ''){
            $car->setTitle($params['model']);
        }
        if(trim($params['active']) != ''){
            if($params['active'] == 'true'){
                $active = true;
            }else{
                $active = false;
            }
            $car->setActive($active);
        }
        if(trim($params['fuel']) != ''){
            $car->setFuel($params['fuel']);
        }

        try{
            $em->flush();
            echo 1;
        }catch (\Exception $e){
            echo 0;
        }

    }

    public function addCar($data,$doctrine){

        if(is_array($_FILES['img']) && count($_FILES['img'])){
                $file = $_FILES['img'];
                if($file['error'] == UPLOAD_ERR_OK){
                    if($file['type'] == "image/jpeg") {
                        $tmp = $file['tmp_name'];

                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $charactersLength = strlen($characters);
                        $randomString = '';
                        for ($i = 0; $i < 25; $i++) {
                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }
                        $extension = $this->getExtension($file['name']);
                        $name = $randomString . time() . "." . $extension;
                        $date = date("d.m.Y", time());
                        @mkdir("{$_SERVER['DOCUMENT_ROOT']}/resources/upload/{$date}");
                        move_uploaded_file($tmp, "{$_SERVER['DOCUMENT_ROOT']}/resources/upload/{$date}/$name");
                    }
                }
        }
        try {
            $manager = $doctrine->getManager();

            $car = new Car();
            $car->setPrice($data->price);
            $car->setTitle($data->name);
            $car->setType($data->type);
            $car->setFuel($data->fuel);
            $car->setActive(true);
            $car->setMaster($data->master);
            $car->setImg("/resources/upload/{$date}/{$name}");
            if ($data->type == 0) {
                $car->setNumberOfSeats($data->depOnChoose);
            } elseif ($data->type == 1) {
                $car->setLoadCapacity($data->depOnChoose);
            }
            $manager->persist($car);
            $manager->flush();
            echo 1;
        }catch (\Exception $e){
            echo 0;
        }
    }

    private function getExtension($filename) {
        return substr(strrchr($filename, '.'), 1);
    }

}