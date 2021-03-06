<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200228213441 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create Table for event_store and vehicle';
    }

    public function up(Schema $schema) : void
    {
        $eventStore = $schema->createTable('event_store');
        $eventStore->addColumn('id', 'string', ['nullable' => false, 'unique' => true, 'length' => 255]);
        $eventStore->addColumn('aggregate_id', 'string', ['nullable' => false, 'length' => 255]);
        $eventStore->addColumn('aggregate_type', 'string', ['nullable' => false, 'length' => 255]);
        $eventStore->addColumn('playhead', 'integer', ['nullable' => false, 'unsigned' => true]);
        $eventStore->addColumn('payload', 'json', ['nullable' => false]);
        $eventStore->addColumn('metadata', 'json', ['nullable' => false]);
        $eventStore->addColumn('type', 'string', ['nullable' => false, 'length' => 255]);
        $eventStore->addColumn('recorded_on', 'datetime', ['nullable' => false]);
        $eventStore->setPrimaryKey(['id']);
        $eventStore->addIndex(['recorded_on']);
        $eventStore->addIndex(['type']);

        $vehicle = $schema->createTable('vehicle');
        $vehicle->addColumn('_id', 'integer', ['nullable' => false, 'autoincrement' => true]);
        $vehicle->addColumn('id', 'string', ['nullable' => false, 'unique' => true, 'length' => 255]);
        $vehicle->addColumn('registration_number', 'string', ['nullable' => false, 'length' => 255]);
        $vehicle->addColumn('brand', 'string', ['nullable' => false, 'length' => 255]);
        $vehicle->addColumn('model', 'string', ['nullable' => false, 'length' => 255]);
        $vehicle->addColumn('created_at', 'datetime', ['nullable' => false]);
        $vehicle->addColumn('last_update', 'datetime', ['nullable' => false]);
        $vehicle->setPrimaryKey(['_id']);
        $vehicle->addIndex(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('event_store');
        $schema->dropTable('vehicle');
    }
}
