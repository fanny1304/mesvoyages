<?php

namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }

    /**
     * Retourne toutes les visites triées sur un champ
     * @param type $champ
     * @param type $ordre
     * @return Visite[]
     */
    public function findAllOrderBy($champ, $ordre): array{
        return $this->createQueryBuilder('v') // permet de créer une requête de type "select"
                ->orderBy('v.'.$champ, $ordre)  // ajoute l'ordre "ORDER BY" dans la requête
                ->getQuery()    // permet d'exécuter la requête
                ->getResult();  // permet de récupérer le résultat de la requête sous forme de tableau
    }
    
    /**
     * Enregistrements dont un champ est égal à une valeur
     * ou tous les enregistrements si la valeur est vide
     * @param type $champ
     * @param type $valeur
     * @return Visite[]
     */
    public function findByEqualValue($champ, $valeur): array{
        if ($valeur==""){
            return $this->createQueryBuilder('v') // alias de la table 
                    ->orderBy('v.'.$champ, 'ASC')
                    ->getQuery()
                    ->getResult();
        }
        else{
            return $this->createQueryBuilder('v')
                    ->where('v.'.$champ.'=:valeur')
                    ->setParameter('valeur', $valeur)
                    ->orderBy('v.datecreation', 'DESC')
                    ->getQuery()
                    ->getResult();
        }
    }
    
    /**
     * Supprime une visite
     * @param Visite $visite
     * @return void
     */
    public function remove(Visite $visite): void{
        $this->getEntityManager()->remove($visite);
        $this->getEntityManager()->flush();
    }
}
