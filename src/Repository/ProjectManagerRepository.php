<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProjectManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectManager>
 *
 * @method ProjectManager|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectManager|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectManager[]    findAll()
 * @method ProjectManager[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectManagerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectManager::class);
    }
}