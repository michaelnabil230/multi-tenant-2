<?php

namespace App\Features;

/** Additional features, like Telescope tags and tenant redirects. */
interface Feature
{
    public function bootstrap(): void;
}
