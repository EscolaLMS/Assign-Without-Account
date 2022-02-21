<?php

namespace EscolaLms\AssignWithoutAccount\Listeners;

use EscolaLms\AssignWithoutAccount\Enums\UserSubmissionEnum;
use EscolaLms\AssignWithoutAccount\Repositories\Contracts\UserSubmissionRepositoryContract;
use EscolaLms\AssignWithoutAccount\Strategies\Contracts\AssignStrategy;
use EscolaLms\Auth\Events\AccountRegistered;
use EscolaLms\Core\Repositories\Criteria\Primitives\EqualCriterion;

class AccountRegisteredListener
{
    private UserSubmissionRepositoryContract $userSubmissionRepository;

    /**
     * @param UserSubmissionRepositoryContract $userSubmissionRepository
     */
    public function __construct(UserSubmissionRepositoryContract $userSubmissionRepository)
    {
        $this->userSubmissionRepository = $userSubmissionRepository;
    }

    public function handle(AccountRegistered $event)
    {
        $user = $event->user;

        $criteria = [
            new EqualCriterion('email', $user->email),
            new EqualCriterion('status', UserSubmissionEnum::ACCEPTED)
        ];

        $results = $this->userSubmissionRepository->searchByCriteria($criteria);

        foreach ($results as $result) {
            $accessUrl = $result->accessUrl;

            if (!class_exists($accessUrl->modelable_type)) {
                continue;
            }

            $strategy = $this->getStrategy($accessUrl->modelable_type);

            if (!$strategy) {
                continue;
            }

            $strategy->assign($user, $accessUrl->modelable_id);
        }
    }

    private function getStrategy(string $modelType): ?AssignStrategy
    {
        $class = class_basename($modelType);
        $strategy = 'EscolaLms\\AssignWithoutAccount\\Strategies\\' . $class . 'AssignStrategy';

        if (!class_exists($strategy)) {
            return null;
        }

        return new $strategy();
    }
}
