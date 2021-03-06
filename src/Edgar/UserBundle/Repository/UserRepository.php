<?php
/**
 * (c) Ismael Trascastro <i.trascastro@gmail.com>
 *
 * @link        http://www.ismaeltrascastro.com
 * @copyright   Copyright (c) Ismael Trascastro. (http://www.ismaeltrascastro.com)
 * @license     MIT License - http://en.wikipedia.org/wiki/MIT_License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Edgar\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function myFindOneByUsernameOrEmail($username)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username OR u.email = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function verUsuarios($username)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ;

    }
    
    public function todosUsuarios()
    {
        return $this->createQueryBuilder('u')
            ->select('u.username', 'u.email', 'u.lastLogin', 'u.createdAt', 'u.id')
            ->from('UserBundle:User', 'user')
            ->distinct('u.username')
            ->orderBy('u.createdAt')
            ->getQuery()
            ->execute();
    }
    
    public function todosAllUsuarios()
    {
        return $this->todosUsuarios()->execute();
    }

   
   
   
    
    
}