<?php

namespace App;

class CustomObject {

    public static function hydrate(object $entity, array $data, array $fields): void {
        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $method = 'set' . str_replace(' ','',ucwords(str_replace('_',' ',$field)));
                if (method_exists($entity, $method)) {
                    $entity->$method($data[$field]);
                }
            }
        }
    }
}
?>