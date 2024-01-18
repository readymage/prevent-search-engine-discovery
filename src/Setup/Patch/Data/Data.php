<?php
/**
 * Prevent Search Engine Discovery
 *
 * @copyright Scandiweb, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace ReadyMage\PreventSearchEngineDiscovery\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class Data implements DataPatchInterface
{

    private const CORE_CONFIG_TABLE_NAME = "core_config_data";

    private const CONFIG_PATH_DESIGN_SEARCH_ENGINE_ROBOTS_DEFAULT_ROBOTS = "design/search_engine_robots/default_robots";

    private const CONFIG_PATH_DESIGN_SEARCH_ENGINE_ROBOTS_DEFAULT_ROBOTS_VALUE = 'NOINDEX,NOFOLLOW';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /** {@inheritDoc}
     */
    public function apply()
    {
        $where = ['path = ?' => self::CONFIG_PATH_DESIGN_SEARCH_ENGINE_ROBOTS_DEFAULT_ROBOTS];
        $bind = ['value' => self::CONFIG_PATH_DESIGN_SEARCH_ENGINE_ROBOTS_DEFAULT_ROBOTS_VALUE];

        $this->moduleDataSetup->getConnection()->update(
            $this->moduleDataSetup->getTable(self::CORE_CONFIG_TABLE_NAME),
            $bind,
            $where
        );
    }

    /** {@inheritDoc} */
    public static function getDependencies(): array
    {
        return [];
    }

    /** {@inheritDoc} */
    public function getAliases(): array
    {
        return [];
    }
}