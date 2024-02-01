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

class DataPatch implements DataPatchInterface
{

    private const CORE_CONFIG_TABLE_NAME = "core_config_data";

    private const CONFIG_PATH_DESIGN_SEARCH_ENGINE_ROBOTS_DEFAULT_ROBOTS = "design/search_engine_robots/default_robots";

    private const CONFIG_PATH_DESIGN_SEARCH_ENGINE_ROBOTS_DEFAULT_ROBOTS_VALUE = 'NOINDEX,NOFOLLOW';

    private const CONFIG_PATH_DESIGN_SEARCH_ENGINE_ROBOTS_CUSTOM_INSTRUCTIONS = "design/search_engine_robots/custom_instructions";

    private const CONFIG_PATH_DESIGN_SEARCH_ENGINE_ROBOTS_CUSTOM_INSTRUCTIONS_VALUE = "User-Agent: *
Disallow: /
";

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

    /** {@inheritDoc
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        $tableName = $this->moduleDataSetup->getTable(self::CORE_CONFIG_TABLE_NAME);

        $this->moduleDataSetup
            ->getConnection()
            ->insertOnDuplicate(
                $tableName,
                [
                    'path' => self::CONFIG_PATH_DESIGN_SEARCH_ENGINE_ROBOTS_DEFAULT_ROBOTS,
                    'value' => self::CONFIG_PATH_DESIGN_SEARCH_ENGINE_ROBOTS_DEFAULT_ROBOTS_VALUE
                ],
                ['value']
            );

        $this->moduleDataSetup
            ->getConnection()
            ->insertOnDuplicate(
                $tableName,
                [
                    'path' => self::CONFIG_PATH_DESIGN_SEARCH_ENGINE_ROBOTS_CUSTOM_INSTRUCTIONS,
                    'value' => self::CONFIG_PATH_DESIGN_SEARCH_ENGINE_ROBOTS_CUSTOM_INSTRUCTIONS_VALUE
                ],
                ['value']
            );

        $this->moduleDataSetup->endSetup();
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