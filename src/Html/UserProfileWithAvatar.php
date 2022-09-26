<?php

declare(strict_types=1);

namespace Html;

use Authentication\UserAuthentication;
use Entity\User;
use Entity\UserAvatar;

class UserProfileWithAvatar extends UserProfile
{
    public const AVATAR_INPUT_NAME = 'avatar';
    /**
     * @var string
     */
    private string $formAction;

    /**
     * @param string $formAction
     */
    public function __construct(User $user, string $formAction)
    {
        parent::__construct($user);
        $this->formAction = $formAction;
    }

    public function toHtml(): string
    {
        $avatarInputName = self::AVATAR_INPUT_NAME;
        $toHtml = parent::toHtml();
        $toHtml .=
            <<<HTML
                <form enctype="multipart/form-data" action={$this->formAction} method="POST">
                    <input type="file" name="{$avatarInputName}" id="{$avatarInputName}" accept="image/png">
                    <input type="submit" value="Mettre à jour">
                </form>
                <img src="/avatar.php?userId={$this->user->getId()}" alt="Avatar de l'utilisateur"/>
            HTML
        ;

        return $toHtml;
    }

    public function updateAvatar(): bool
    {
        $returnValue = true;
        if (!isset($_FILES[self::AVATAR_INPUT_NAME])
            || $_FILES[self::AVATAR_INPUT_NAME]['error']
            || $_FILES[self::AVATAR_INPUT_NAME]['size'] == 0
            || !is_uploaded_file($_FILES[self::AVATAR_INPUT_NAME]['tmp_name'])
        ) {
            $returnValue = false;
        }

        if ($returnValue) {
            $authentication = new UserAuthentication();
            $user = $authentication->getUserFromSession();
            $userAvatar = UserAvatar::findById($user->getId());
            //$avatar = file_get_contents($_FILES[self::AVATAR_INPUT_NAME]['tmp_name']);
            $userAvatar->isValidFile($_FILES[self::AVATAR_INPUT_NAME]['tmp_name']);
            //$userAvatar->setAvatar($avatar);
            //$userAvatar->save();
        }
        return $returnValue;
    }
}
