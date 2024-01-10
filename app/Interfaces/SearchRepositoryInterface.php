<?php

namespace App\Interfaces;

interface SearchRepositoryInterface
{
     public function searchRequest(object $request);
     public function searchRequestItems(object $request);
}
