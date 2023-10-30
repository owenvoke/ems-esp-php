<?php

declare(strict_types=1);

namespace OwenVoke\EMSESP\Api;

class Device extends AbstractApi
{
    public function info(string $device): array
    {
        return $this->get("/{$device}/info");
    }

    public function values(string $device): array
    {
        return $this->get("/{$device}/values");
    }

    public function commands(string $device): array
    {
        return $this->get("/{$device}/commands");
    }

    public function entities(string $device): array
    {
        return $this->get("/{$device}/entities");
    }

    public function entity(string $device, string $entity): array
    {
        return $this->get("/{$device}/{$entity}");
    }

    public function hcEntity(string $device, string $entity, string $heatingCircuit): array
    {
        return $this->get("/{$device}/{$entity}/{$heatingCircuit}");
    }

    public function update(string $device, string $entity, string $data): array
    {
        return $this->postRaw("/{$device}/{$entity}", $data);
    }

    public function hcUpdate(string $device, string $entity, string $data, string $heatingCircuit): array
    {
        return $this->postRaw("/{$device}/{$entity}/{$heatingCircuit}", $data);
    }
}
