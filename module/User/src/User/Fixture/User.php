<?php
namespace User\Fixture;

use Fixture\Service\Fixture;

class User extends Fixture
{

    /**
     * Build user fixtures.
     */
    static public function build()
    {
        parent::addStack(
            '\User\Entity\User',
            array(
                array(
                    'username'   => 'tjaart.viljoen',
                    'password'   => '12345678',
                    'firstName'  => 'Tjaart',
                    'familyName' => 'Viljoen',
                    'email'      => 'tjaartviljoen@gmail.com',
                    'mobile'     => '+27823897681',
                    'userType'   => 'Client'
                ),
                array(
                    'username'   => 'test.user',
                    'password'   => '12345678',
                    'firstName'  => 'Test',
                    'familyName' => 'User',
                    'email'      => 'email@here.com',
                    'mobile'     => '+27821234567',
                    'userType'   => 'Client'
                )
            )
        );

    }

}