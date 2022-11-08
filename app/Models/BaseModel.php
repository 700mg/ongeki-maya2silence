<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model {
    public function getRelationValue($key) {
        // If the key already exists in the relationships array, it just means the
        // relationship has already been loaded, so we'll just return it out of
        // here because there is no need to query within the relations twice.
        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }

        // If the "attribute" exists as a method on the model, we will just assume
        // it is a relationship and will load and return results from the query
        // and hydrate the relationship's value on the "relationships" array.
        if (
            method_exists($this, $key) ||
            (static::$relationResolvers[get_class($this)][$key] ?? null)
        ) {
            return $this->getRelationshipFromMethod($key);
        }

        $class = static::class;
        throw new \Exception("プロパティ {$key} は {$class} に存在しません。きっとスペルミスです");
    }
}
