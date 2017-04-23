<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Article;

class FindMonth extends EntityRepository {




    /**
     * @return Article[]
     */
    public function FindMonth($id)
    {
        return $this->createQueryBuilder('Article')
            ->Where('Article.id = :id')
            ->setParameter('id', $id)

            ->getQuery()
            ->execute();
    }


    public function FindOnly($only)
    {
        return $this->createQueryBuilder('Article')
            ->setMaxResults($only)
            ->orderBy('Article.id', 'DESC')
            ->getQuery()
            ->execute();
    }

}
