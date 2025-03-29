<?php

declare(strict_types=1);

namespace App\Application\Settings;

class Settings implements SettingsInterface
{
    public const PROJECT_ID = 'PROJECT_ID';
    public const PROJECT_URL = 'PROJECT_URL';

    private array $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return mixed
     */
    public function get(string $key = '')
    {
        return (empty($key)) ? $this->settings : $this->settings[$key];
    }

    public function getProjectId(): string
    {
        return $this->settings[self::PROJECT_ID];
    }

    public function getProjectUrl(): string {
        return $this->settings[self::PROJECT_URL];
    }
}
