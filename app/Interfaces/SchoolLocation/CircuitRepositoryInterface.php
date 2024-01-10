<?php

namespace App\Interfaces\SchoolLocation;

interface CircuitRepositoryInterface
{
    public function getAllCircuits();
    public function getSingleCircuit($id);
    public function addCircuit(object $request);
    public function updateCircuit(object $request, $id);
    public function deleteCircuit($id);
    public function searchCircuit($data);
}
