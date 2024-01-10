<?php

namespace App\Interfaces\User;

interface ManageUserRepositoryInterface
{
    public function getAllUser();
    public function getSingleUser($id);
    public function deleteUser($id);
    public function addUser(object $request);
    public function updateUser(object $request, $id);
    public function searchUser($query);
}
