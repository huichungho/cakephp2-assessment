<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PanelsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PanelsTable Test Case
 */
class PanelsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PanelsTable
     */
    protected $Panels;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Panels',
        'app.Requests',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Panels') ? [] : ['className' => PanelsTable::class];
        $this->Panels = $this->getTableLocator()->get('Panels', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Panels);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
