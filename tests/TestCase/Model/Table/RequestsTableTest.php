<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RequestsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RequestsTable Test Case
 */
class RequestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RequestsTable
     */
    protected $Requests;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Requests',
        'app.Panels',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Requests') ? [] : ['className' => RequestsTable::class];
        $this->Requests = $this->getTableLocator()->get('Requests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Requests);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
