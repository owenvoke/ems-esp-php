<?php

declare(strict_types=1);

namespace OwenVoke\EMSESP\Api;

class Custom extends AbstractApi
{
    public function info(): array
    {
        return $this->get('/custom/info');
    }
}
