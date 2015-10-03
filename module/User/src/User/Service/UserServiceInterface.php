<?php
namespace User\Service;

interface UserServiceInterface
{
    public function authenticate($username, $password);

    public function releaseAuthentication($token);
}