<?php

namespace App\Component\ElasticSearch\Model;

use DateTime;

abstract class AbstractModel
{
    public function toArray(): array
    {
        $array = [];

        foreach (get_object_vars($this) as $key => $value) {
            $result = $value;

            if (is_array($value)) {
                $result = [];
                foreach ($value as $item) {
                    if ($item instanceof self) {
                        $result[] = $item->toArray();
                    } else {
                        $result[] = $item;
                    }
                }
            }

            if ($value instanceof self) {
                $result = $value->toArray();
            }

            if ($value instanceof DateTime) {
                $result = $value->format('Y-m-d H:i:s');
            }

            $array[$this->format($key)] = $result;
        }

        return $array;
    }

    private function format(string $key): string
    {
        return strtolower(preg_replace('~(?<=\\w)([A-Z])~u', '_$1', $key));
    }
}
