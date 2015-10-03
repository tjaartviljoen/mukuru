<?php
namespace User\Service;

interface UserServiceInterface
{
    public function authenticate(String $username, String $password);

    public function releaseAuthentication(String $token);
}