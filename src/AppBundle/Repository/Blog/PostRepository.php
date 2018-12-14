<?php

namespace AppBundle\Repository\Blog;

use AppBundle\Entity\Blog\PostSearch;


/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @return Post[]
     */
    public function findPostOrderedDescMax50(PostSearch $search)  : array
    {
        $query = $this->createQueryBuilder('p')
                    ->orderBy('p.published', 'DESC')
                    ->setMaxResults(50);

        if ($search->getPartTitle()) {
            $query = $query->andWhere('p.title like :val')
                        ->setParameter('val', '%' . $search->getPartTitle() . '%');
        }

        return $query->getQuery()
                    ->getResult();
    }


}
