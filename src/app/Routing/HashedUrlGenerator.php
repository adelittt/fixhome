<?php

namespace App\Routing;

use App\Support\UrlHash;
use Illuminate\Routing\UrlGenerator;

class HashedUrlGenerator extends UrlGenerator
{
    /**
     * Automatically encode numeric `bookingId` and `teknisiId` route parameters into opaque URL hashes.
     */
    public function toRoute($route, $parameters, $absolute)
    {
        $paramNames = $route->parameterNames();
        $hashedScopes = [
            'bookingId' => 'booking',
            'teknisiId' => 'teknisi',
        ];

        $needsHash = array_intersect($paramNames, array_keys($hashedScopes));

        if (!empty($needsHash)) {
            $parameters = \Illuminate\Support\Arr::wrap($parameters);

            foreach ($paramNames as $index => $name) {
                if (!isset($hashedScopes[$name])) {
                    continue;
                }

                $scope = $hashedScopes[$name];

                if (array_key_exists($name, $parameters)) {
                    $parameters[$name] = $this->encodeIfNumeric($parameters[$name], $scope);
                } elseif (array_key_exists($index, $parameters)) {
                    $parameters[$index] = $this->encodeIfNumeric($parameters[$index], $scope);
                }
            }
        }

        return parent::toRoute($route, $parameters, $absolute);
    }

    private function encodeIfNumeric(mixed $value, string $scope): mixed
    {
        if (is_int($value) || (is_string($value) && ctype_digit($value))) {
            return UrlHash::encode($value, $scope);
        }

        if ($value instanceof \Illuminate\Database\Eloquent\Model) {
            return UrlHash::encode($value->getKey(), $scope);
        }

        return $value;
    }
}
