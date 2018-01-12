<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class UserController extends BaseAdminController
{
    /**
     * @return \FOS\UserBundle\Model\UserInterface|mixed
     */
    public function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    /**
     * @param User $user
     */
    public function persistUserEntity(User $user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
        parent::persistUserEntity($user);
    }
}
