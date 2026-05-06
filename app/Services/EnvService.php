<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;


class EnvService
{
    public function set(array $data): bool
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envPath, $envContent);

        // Optional: Reload config
        Artisan::call('config:clear');
        Artisan::call('config:cache');

        return true;
    }
}
