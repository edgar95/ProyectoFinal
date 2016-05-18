<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Publicacion;
use AppBundle\Entity\Categoria;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * CategoriaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoriaRepository extends \Doctrine\ORM\EntityRepository
{
    /*
    public function añadirCategoriasSiSonNuevas(Publicacion $publicacion)
    {
        $categoriasPresentadas = $publicacion->getNuevasCategorias();
        preg_replace('/\s+/', ' ', $categoriasPresentadas);
        $categoriasV = explode(';', $categoriasPresentadas);
        foreach($categoriasV as $nombCategoria) {
            if ($nombCategoria) {
               // $categoria = $this->findOneByName($textoCategoria);
                $categoria = $this->findOneByNombre($nombCategoria);
                if (!$categoria) {
                    $nuevaCategoria = new Categoria();
                    $nuevaCategoria->setNombre($nombCategoria);
                    $publicacion->añadirCategoria($nuevaCategoria);
                } else {
                    $publicacion->añadirCategoria($categoria);
                }
            }
        }
    }



    public function añadirCategoriasSiSonNuevasAdmin(Publicacion $publicacion)
    {
        /*$categoriasPresentadas = $categorias->getNuevasCategorias();
        preg_replace('/\s+/', ' ', $categoriasPresentadas);
        $categoriasV = explode(';', $categoriasPresentadas);
        foreach($categoriasV as $nombCategoria) {
            if ($nombCategoria) {
                // $categoria = $this->findOneByName($textoCategoria);
                $categoria = $this->findOneByNombre($nombCategoria);
                if (!$categoria) {
                    $nuevaCategoria = new Categoria();
                    $nuevaCategoria->setNombre($nombCategoria);
                    $categorias->añadirCategoria($nuevaCategoria);
                } else {
                    $categorias->añadirCategoria($categoria);
                }
            }
        }*/
       /* $categoriasPresentadas = $publicacion->getNuevasCategorias();
        preg_replace('/\s+/', ' ', $categoriasPresentadas);
        $categoriasV = explode(';', $categoriasPresentadas);
        foreach($categoriasV as $nombCategoria) {
            if ($nombCategoria) {
                // $categoria = $this->findOneByName($textoCategoria);
                $categoria = $this->findOneByNombre($nombCategoria);
                if (!$categoria) {
                    $nuevaCategoria = new Categoria();
                    $nuevaCategoria->setNombre($nombCategoria);
                    $publicacion->añadirCategoria($nuevaCategoria);
                } else {
                    $publicacion->añadirCategoria($categoria);
                }
            }
        }
    }*/
    
    public function busquedaBuscarTodasLascategorias()
    {
        return $this->createQueryBuilder('categoria')
            ->addOrderBy('categoria.nombre', 'ASC')
            ->leftJoin('categoria.publicaciones', 'publicaciones')
            ->addSelect('publicaciones')
            ->getQuery()
            ;
    }

    public function buscarTodasLasCategorias()
    {
        return $this->busquedaBuscarTodasLascategorias()->execute();
    }

    public function buscarPublicacionesPorcategoriaId($id)
    {
        return $this->createQueryBuilder('categoria')
            ->leftJoin('categoria.publicaciones', 'publicaciones')
            ->andWhere('categoria.id = :id')
            ->setParameter('id', $id)
            ->addSelect('publicaciones')
            ->addOrderBy('publicaciones.createdAt', 'DESC')
            ->getQuery()
            ;
    }

   /** public function buscarPublicacionesPorcategoriaId2($id)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('p', 'categoria')
            ->from('AppBundle:Publicacion', 'p')
            ->leftJoin('p.categorias', 'categoria')
            ->andWhere('categoria.id = :id')
            ->setParameter('id', $id)
            ->addOrderBy('p.createdAt', 'DESC')
            ->getQuery()
        ;

        return $query;
    }*/

    public function getCategoriasNoUsadas()
    {
        return $this->createQueryBuilder('categoria')
            ->leftJoin('categoria.publicaciones', 'publicaciones')
            ->andWhere('categoria.publicaciones is EMPTY')
            ->getQuery()
            ->execute()
            ;
    }
    

}
