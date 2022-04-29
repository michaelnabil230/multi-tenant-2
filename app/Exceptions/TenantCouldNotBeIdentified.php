<?php


namespace App\Exceptions;

use Facade\IgnitionContracts\BaseSolution;
use Facade\IgnitionContracts\ProvidesSolution;
use Facade\IgnitionContracts\Solution;

class TenantCouldNotBeIdentified extends \Exception implements ProvidesSolution
{
    public function __construct($column, $value)
    {
        parent::__construct("Tenant could not be identified with $column: $value");
    }

    public function getSolution(): Solution
    {
        return BaseSolution::create('Tenant could not be identified')
            ->setSolutionDescription('Try to use the `domain` column instead of `id`.');
    }
}
