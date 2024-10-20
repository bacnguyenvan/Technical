<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;

class Item extends Model
{
    use HasFactory, ElasticquentTrait;

    protected $fillable = ['title', 'description'];
}
