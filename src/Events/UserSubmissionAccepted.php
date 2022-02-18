<?php

namespace EscolaLms\AssignWithoutAccount\Events;

use EscolaLms\Core\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserSubmissionAccepted
{
    use Dispatchable, SerializesModels;

    private User $user;
    private string $url;

    /**
     * @param User $user
     * @param string $url
     */
    public function __construct(User $user, string $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
