<?php

namespace Pgvector\Hyperf;

class ConfigProvider
{
    /**
     * Register services.
     */
    public function __invoke(): array
    {
        return [
            'publish' => [
                [
                    'id' => 'migration',
                    'description' => 'The config of migration.',
                    'source' => __DIR__ . '/Migrations/2022_08_03_000000_create_vector_extension.php',
                    'destination' => BASE_PATH . '/migrations/2022_08_03_000000_create_vector_extension.php',
                ],
            ],
            'listeners' => [
                Listener\BootApplicationListener::class,
            ],
        ];
    }
}
