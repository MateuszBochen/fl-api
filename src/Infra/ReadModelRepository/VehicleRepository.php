<?php

namespace Infra\ReadModelRepository;

use Cydrickn\DDD\Common\ReadModel\AbstractReadModelIterator;
use Cydrickn\DDD\Common\ReadModel\ReadModelInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Domain\Vehicle\ReadModel\Vehicle;
use Domain\Vehicle\ReadModel\VehicleRepositoryInterface;
use Domain\Vehicle\VehicleId;
use Infra\Iterator\DBALReadModelIterator;


class VehicleRepository implements VehicleRepositoryInterface
{
    /**
     * @var Connection
     */
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(string $id): ?ReadModelInterface
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('v.*')
            ->from('vehicle', 'v')
            ->where('v.id = :id')
            ->setMaxResults(1)
            ->setParameter('id', $id);

        $result = $queryBuilder->execute()->fetch(FetchMode::ASSOCIATIVE);
        if ($result === false) {
            return null;
        }

        return Vehicle::deserialize($result);
    }

    public function findAll(): AbstractReadModelIterator
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('v.*')
            ->from('vehicle', 'v');

        return new DBALReadModelIterator(Vehicle::class, $queryBuilder->execute());
    }

    public function remove(string $id): void
    {

    }

    public function save(ReadModelInterface $readModel): void
    {
        try {
            $this->connection->beginTransaction();
            $data = $readModel->serialize();
            $this->connection->insert('vehicle', $data);
            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    public function findIdByRegistrationNumber(string $registrationNumber): ?VehicleId
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('v.id')
            ->from('vehicle', 'v')
            ->where('v.registration_number = :registrationNumber')
            ->setMaxResults(1)
            ->setParameter('registrationNumber', $registrationNumber);

        $result = $queryBuilder->execute()->fetch(FetchMode::ASSOCIATIVE);

        if ($result === false) {
            return null;
        }

        return VehicleId::fromString($result['id']);
    }
}
