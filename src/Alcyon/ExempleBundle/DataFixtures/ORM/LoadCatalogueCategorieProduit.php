<?php

namespace Alcyon\ExempleBundle\DataFixtures\ORM;

use Alcyon\CoreBundle\Entity\Catalogue;
use Alcyon\CoreBundle\Entity\Categorie;
use Alcyon\CoreBundle\Entity\Media;
use Alcyon\ExempleBundle\Entity\Product;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadCatalogueCategorieProduit extends AbstractFixture  implements OrderedFixtureInterface, ContainerAwareInterface
{

     /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        return $this;
    }
    
    public function load(ObjectManager $manager)
    {

        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 60*10); // 10mn

        // Add catalogue
        $catalogue = new Catalogue();
        $catalogue->setTitle('Catalogue Boutique');
        $manager->persist($catalogue);

        $dns = $this->getReference('dns3');
        $dns->setCatalogue($catalogue);
        $manager->persist($dns);
        
        $manager->flush();

        // Init soap
        $user = 'equipe@chezmonveto.com';
        $pass = 'Vet5ervice5';
        
        ini_set("default_socket_timeout", 100);
        $params = new \stdClass();
        $client = new \SoapClient('http://ws.chezmonveto.com/?wsdl',
            array(
            'cache_wsdl' => 0,
            'soap_version' => SOAP_1_1,
            'connection_timeout' => 100)
        );

        // Load categorie
        $categories = [];
        $params->requestgetCategoriesCmv            = new \stdClass();
        $params->requestgetCategoriesCmv->vetoEmail = $user;
        $params->requestgetCategoriesCmv->password  = $pass;
        foreach ($client->getCategoriesCmv($params)->getCategoriesCmvResult->item
                as $val) {

             $data = array('id_categorie_cmv' => (int) $val->id,
                'nom' => str_replace("'", "\'", trim($val->nom)),
                'parent' => trim($val->parent),
                'path' => $val->path
            );
            

            $categorie = new Categorie();
            $categorie->setCatalogue($catalogue);
            $categorie->setTitle($data['nom']);
            if($data['parent'] >2 && isset($categories[$data['parent']]))
                $categorie->addParent($categories[$data['parent']]);
                
            $categories[(int) $val->id] = $categorie;
            $manager->persist($categorie);
            
        }
        $manager->flush();
        
        // Load produit
        $params->requestgetProducts            = new \stdClass();
        $params->requestgetProducts->vetoEmail = $user;
        $params->requestgetProducts->password  = $pass;
        $nbProduit = 0;
        foreach ($client->getProducts($params)->getProductsResult->item
                as $val) {

            $produit = new Product();
            
            // Standards Data
            $produit->setReference($val->code_cip);
            $produit->setTitle($val->designation);
            $produit->setContent(html_entity_decode($val->description));
            $produit->setShortContent(html_entity_decode($val->description_short ? $val->description_short : $val->description ));
            
            // Categories link
            foreach(explode(',',$val->cat_list) as $catId) {
                if(isset($categories[(int) $catId])) {
                    $produit->addCategorie($categories[(int) $catId]);
                }
            }
            
            // Medias link
            foreach(explode(',',$val->mediasTab) as $urlImage) {
                if(!empty($urlImage)) {
                    $image = new Media();
                    $image->setTitle($val->designation);
                    
                    // 1ere image ou pas
                    if(null === $produit->getDefaultImage()) {
                        $produit->setDefaultImage($image);
                        $countImage='';
                    } else {
                        $produit->addMedias($image);
                        $countImage = '_'.count($produit->getMedias());
                    }
                    
                    // Recuperation du fichier
                    $url = 'produit/' .$val->code_cip . $countImage . '.jpg';
                    $filePath = $this->container->getParameter('uploads_directory') . '/' .$url;
                    
                    if(!is_file($filePath)) {
                        file_put_contents($filePath, file_get_contents(str_replace(' ','%20',$urlImage)));
                    }
                    
                    // Sauvegarde des infos du fichier
                    $image->setUrl($url);
                    $image->setFolder('produit');
                    $image->setFile($val->code_cip.'.jpg');
                    
                    $manager->persist($image);
                }
            }

            $manager->persist($produit);
            
            // flush on 200 produits
            $nbProduit++;
            if(0 == $nbProduit%200) {
                $manager->flush();
            }
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }
}