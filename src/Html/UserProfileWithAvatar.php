<?php

declare(strict_types=1);

namespace Html;

use Authentication\UserAuthentication;
use Entity\User;
use Entity\UserAvatar;
use ImageManipulation\MyGdImage;
use ServerConfiguration\Directive;

class UserProfileWithAvatar extends UserProfile
{
    public const AVATAR_INPUT_NAME = 'avatar';
    /**
     * @var string
     */
    private string $formAction;

    private const IMAGE_TYPE = [
        'image/png' => 'png',
        'image/jpeg' => 'jpeg',
        'image/gif' => 'gif'
    ];
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
        $min = min(Directive::getUploadMaxFilesize(), UserAvatar::maxFileSize());
        $toHtml .=
            <<<HTML
                <form enctype="multipart/form-data" action={$this->formAction} method="POST">
                    <input type="file" name="{$avatarInputName}" id="{$avatarInputName}">
                    <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="{$min}">
                    <input type="submit" value="Mettre à jour">
                </form>
                <img src="/avatar.php?userId={$this->user->getId()}" alt="Avatar de l'utilisateur"/>
            HTML
        ;

        return $toHtml;
    }

    /**
     * @throws \Service\Exception\SessionException
     * @throws \Authentication\Exception\NotLoggedInException
     * @throws \Entity\Exception\EntityNotFoundException
     */
    public function updateAvatar(): bool
    {
        if (isset($_FILES[self::AVATAR_INPUT_NAME])
            && $_FILES[self::AVATAR_INPUT_NAME]['error'] === 0
            && $_FILES[self::AVATAR_INPUT_NAME]['size'] > 0
            && is_uploaded_file($_FILES[self::AVATAR_INPUT_NAME]['tmp_name'])
        ) {
            if (UserAvatar::isValidFile($_FILES[self::AVATAR_INPUT_NAME]['tmp_name'])) {
                $avatar = self::getAvatarFromImage($_FILES[self::AVATAR_INPUT_NAME]['tmp_name']);
                $userAvatar = UserAvatar::findById($this->user->getId());
                $userAvatar->setAvatar($avatar);
                $userAvatar->save();
                return true;
            }
        }
        return false;
    }

    public static function getAvatarFromImage(string $filename): string
    {
        if (array_key_exists(mime_content_type($filename), self::IMAGE_TYPE)) {
            $im1 = MyGDImage::createFromFile($filename, self::IMAGE_TYPE[mime_content_type($filename)]);
            ob_start();
            $im1->png();
            $avatar = ob_get_clean();
            return $avatar;
        }
        return file_get_contents($filename);
    }
}
