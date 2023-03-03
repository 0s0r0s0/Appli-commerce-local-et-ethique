<?php

namespace App\DataFixtures;

use App\Entity\Association;
use App\Entity\Basket;
use App\Entity\Good;
use App\Entity\GoodsType;
use App\Entity\LabelledType;
use App\Entity\Producer;
use App\Entity\ProductionType;
use App\Entity\Profile;
use App\Entity\Rate;
use App\Entity\Role;
use App\Entity\TradeArea;
use App\Entity\Trimester;
use App\Entity\UnitType;
use App\Entity\User;
use Bezhanov\Faker\Provider\Food;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;


    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


////TODO:
////$stock->setQuantity(rand(2,20));
////
////$unit_type = $this->getReference('unit-'.$rand);
////
////if( $unit_type instanceof UnitType ) $stock->setUnitType($this->getReference('unit-'.$rand));
//

    public function load(ObjectManager $manager)
    {
        $this->loadBasket($manager);
        $this->loadTrimester($manager);
        $this->loadRole($manager);
        $this->loadTradeArea($manager);
        $this->loadLabelledType($manager);
        $this->loadUnitType($manager);
        $this->loadProductionType($manager);
        $this->loadProfile($manager);
        $this->loadUser($manager);
        $this->loadAsso($manager);
        $this->loadProducer($manager);
        $this->loadGoodsType($manager);
        $this->loadRate($manager);
        $this->loadGood($manager);

    }

    /**
     * Fonction de création d'une table avec le prix du panier et le pourcentage pour les frais de livraison
     * Le but est de modifier une seule fois ici le prix et la taxe pour le répertorié sur toute l'appli
     */
    public function loadBasket(ObjectManager $manager)
    {
        $basket = new Basket();
        $basket
            // Modifier ici le prix hebdomadaire du panier (TTC en €)
            ->setPrice(10)
            // Modifier ici le prix de la livraion (en % du TTC du panier)
            ->setDeliveryTax(5);
        $manager->persist($basket);
        $manager->flush();

    }

    /**
     * Fonction de création des trimestres en base de données
     * @throws Exception
     */
    public function loadTrimester(ObjectManager $manager)
    {
        $label = ['Trimestre 4 - 2021',
            'Trimestre 1 - 2022', 'Trimestre 2 - 2022', 'Trimestre 3 - 2022', 'Trimestre 4 - 2022',
            'Trimestre 1 - 2023', 'Trimestre 2 - 2023', 'Trimestre 3 - 2023', 'Trimestre 4 - 2023',
            'Trimestre 1 - 2024', 'Trimestre 2 - 2024', 'Trimestre 3 - 2024', 'Trimestre 4 - 2024',
            'Trimestre 1 - 2025', 'Trimestre 2 - 2025', 'Trimestre 3 - 2025', 'Trimestre 4 - 2025'
        ];
        $date_start = ['2021/10/01',
            '2022/01/01', '2022/04/01', '2022/07/01', '2022/10/01',
            '2023/01/01', '2023/04/01', '2023/07/01', '2023/10/01',
            '2024/01/01', '2024/04/01', '2024/07/01', '2024/10/01',
            '2025/01/01', '2025/04/01', '2025/07/01', '2025/10/01'
        ];
        $date_end = ['2021/12/31',
            '2022/03/31', '2022/06/30', '2022/09/30', '2022/12/31',
            '2023/03/31', '2023/06/30', '2023/09/30', '2023/12/31',
            '2024/03/31', '2024/06/30', '2024/09/30', '2024/12/31',
            '2025/03/31', '2025/06/30', '2025/09/30', '2025/12/31',
            ];

        for ($i = 0; $i < 17; $i++) {

            $trimester = new Trimester();
            $trimester
                ->setLabel($label[$i])
                ->setDateStart(new \DateTime($date_start[$i]))
                ->setDateEnd(new \DateTime($date_end[$i]));

            $manager->persist($trimester);
        }
        $manager->flush();
    }

    public function loadRole(ObjectManager $manager)
    {

        $role_names = ['ROLE_ADMIN', 'ROLE_USER', 'ROLE_PRODUCER'];
        foreach ($role_names as $kn => $name) {
            $role = new Role();
            $role->setLabel($name);
            $this->setReference('role-' . $kn, $role);
            $manager->persist($role);
        }
        $manager->flush();
    }

    public function loadTradeArea(ObjectManager $manager)
    {

        $area_names = ['Prades', 'Perpignan', 'Céret'];
        foreach ($area_names as $kn => $name) {
            $area = new TradeArea();
            $area->setLabel($name);
            $this->setReference('area-' . $kn, $area);
            $manager->persist($area);
        }
        $manager->flush();
    }

    public function loadLabelledType(ObjectManager $manager)
    {

        $label_names = ['AB', 'Agriculture Raisonnée', 'Label Rouge', 'AOP', 'IGP', 'Eco-Cert', 'Nature et Progrès', 'Spécialité Traditionnelle Garantie'];
        foreach ($label_names as $kn => $name) {
            $label = new LabelledType();
            $label->setLabel($name);
            $this->setReference('label-' . $kn, $label);
            $manager->persist($label);
        }
        $manager->flush();
    }

    public function loadUnitType(ObjectManager $manager)
    {

        $unit_names = ['article', 'Litre', 'Kg', 'Grs'];
        foreach ($unit_names as $kn => $name) {
            $unit = new UnitType();
            $unit->setLabel($name);
            $this->setReference('unit-' . $kn, $unit);
            $manager->persist($unit);
        }
        $manager->flush();
    }

    public function loadProductionType(ObjectManager $manager)
    {

        $prod_names = ['Conventionnelle', 'Raisonnée', 'Permaculture', 'Sauvage', 'Biologique', 'Industrielle'];
        foreach ($prod_names as $kn => $name) {
            $prod = new ProductionType();
            $prod->setLabel($name);
            $this->setReference('prod-' . $kn, $prod);
            $manager->persist($prod);
        }
        $manager->flush();
    }

    public function loadProfile(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i < 21; $i++) {

            $profile = new Profile();
            $profile
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPhone('06' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT))
                ->setAdress($faker->streetAddress)
                ->setCity($faker->city)
                ->setPostalCode('66' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT));
            $this->setReference('profile-' . $i, $profile);

            $manager->persist($profile);
        }
        $manager->flush();
    }

    public function loadUser(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('a@a.a')
            ->setPassword($this->encoder->encodePassword($user, 'admin'));
        $user->setProfile($this->getReference('profile-1'));
        $user->setRole($this->getReference('role-0'));
        $user->setTradeArea($this->getReference('area-0'));
        $this->setReference('user-' . 1, $user);
        $manager->persist($user);

        $faker = Factory::create('fr_FR');
        for ($i = 2; $i < 21; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setPassword($this->encoder->encodePassword($user, '12345'));
            $user->setProfile($this->getReference('profile-' . $i));
            if ($i <= 11) {
                $roleNb = 1;
            } else {
                $roleNb = 2;
            };
            $user->setRole($this->getReference('role-' . $roleNb));
            $user->setTradeArea($this->getReference('area-' . rand(0, 2)));
            $this->setReference('user-' . $i, $user);
            $manager->persist($user);
        }
        $manager->flush();
    }

    /**
     * Fonction créeant le profil de l'association
     * @param ObjectManager $manager
     */
    public function loadAsso(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $asso = new Association();
        $asso
            ->setUser($this->getReference('user-' . 1))
            ->setSiret($faker->siret)
            ->setAssoName('Association Val Llech')
            ->setAssoAdress('Mairie, Carrer Major')
            ->setAssoPostalCode('66320')
            ->setAssoCity('Espira-de-Conflent')
            ->setImage(0 . '.jpg')
            ->setPhoneNumber('0628147186')
            ->setTvaIntracom('FR' . rand(1111111111, 9999999999))
            ->setEmail('66.val.llech@gmail.com');

        $manager->persist($asso);
        $manager->flush();
    }

    public function loadProducer(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 12; $i < 21; $i++) {

            $producer = new Producer();
            $producer
                ->setFirmName($faker->company)
                ->setFirmAdress($faker->streetAddress)
                ->setFirmPostalCode('66' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT))
                ->setFirmCity($faker->city)
                ->setSiret($faker->siret)
                ->setTvaIntracom('FR' . rand(1111111111, 9999999999))
                ->setDescription($faker->text(200))
                ->setPhoneNumber($faker->serviceNumber)
                ->setImage($i - 11 . '.jpg');
            $producer->setUser($this->getReference('user-' . $i));
            $producer->setProductionType($this->getReference('prod-' . rand(0, 5)));
            $this->setReference('producer-' . $i, $producer);
            $manager->persist($producer);
        }
        $manager->flush();

    }

    public function loadGoodsType(ObjectManager $manager)
    {
        $goodType_names = ['Fruits', 'Légumes', 'Viandes', 'Plantes', 'Boissons', 'Produits laitiers', 'Pain', 'Oeufs', 'Confitures', 'Autres'];
        foreach ($goodType_names as $kn => $name) {
            $gtype = new GoodsType();
            $gtype->setLabel($name);
            $this->setReference('gtype-' . $kn, $gtype);
            $manager->persist($gtype);
        }

        $manager->flush();
    }

    public function loadRate(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ( $i=1; $i<51; $i++ )
        {
            $rate = new Rate();
            $rate->setPrice($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10));
            $rate->setUnitType($this->getReference('unit-'.rand(0,3)));
            $this->setReference('rate-'.$i, $rate);
            $manager->persist($rate);
        }
        $manager->flush();
    }

    public function loadGood(ObjectManager $manager)
    {
        $faker = Factory::create();
        $faker->addProvider(new Food($faker));

        for ( $i=1; $i<51; $i++)
        {
            $good = new Good();
            $good->setProducer($this->getReference('producer-'.rand(12,20)));
            $good->setGoodsType($this->getReference('gtype-'.rand(0,9)));
            $good->setLabelledType($this->getReference('label-'.rand(0,6)));
            $good->setRate($this->getReference('rate-'.$i));
            $good->setLabel($faker->ingredient);
            $good->setImage($faker->imageUrl($width = 64, $height = 64));
            $good->setBuyingMinimum(rand(1,5))
                ->setStock(rand(1,100));
            $this->setReference('good-'.$i, $good);
            $manager->persist($good);
        }
        $manager->flush();
    }
}
