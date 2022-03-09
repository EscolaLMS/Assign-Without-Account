<?php

namespace EscolaLms\AssignWithoutAccount\Listeners;

use EscolaLms\AssignWithoutAccount\Enums\UserSubmissionStatusEnum;
use EscolaLms\AssignWithoutAccount\Repositories\Contracts\UserSubmissionRepositoryContract;
use EscolaLms\AssignWithoutAccount\Strategies\Contracts\AssignStrategy;
use EscolaLms\Auth\Events\AccountRegistered;
use EscolaLms\Cart\Contracts\Productable;
use EscolaLms\Cart\Models\Product;
use EscolaLms\Cart\Services\Contracts\ProductServiceContract;
use EscolaLms\Core\Repositories\Criteria\Primitives\EqualCriterion;

class AccountRegisteredListener
{
    private UserSubmissionRepositoryContract $userSubmissionRepository;
    private ProductServiceContract $productService;

    public function __construct(
        UserSubmissionRepositoryContract $userSubmissionRepository,
        ProductServiceContract $productService
    )
    {
        $this->userSubmissionRepository = $userSubmissionRepository;
        $this->productService = $productService;
    }

    public function handle(AccountRegistered $event)
    {
        $user = $event->user;

        $criteria = [
            new EqualCriterion('email', $user->email),
            new EqualCriterion('status', UserSubmissionStatusEnum::SENT)
        ];

        $results = $this->userSubmissionRepository->searchByCriteria($criteria);

        foreach ($results as $result) {
            $result->update(['status' => UserSubmissionStatusEnum::ACCEPTED]);
            $model = $result->morphable_type::find($result->morphable_id);

            if (!$model) {
                continue;
            }

            if ($model instanceof Product) {
                $this->productService->attachProductToUser($model, $user);
            }
            else if ($model instanceof Productable) {
                $this->productService->attachProductableToUser($model, $user);
            }
        }
    }

//    private function getStrategy(string $modelType): ?AssignStrategy
//    {
//        $class = class_basename($modelType);
//        $strategy = 'EscolaLms\\AssignWithoutAccount\\Strategies\\' . $class . 'AssignStrategy';
//
//        if (!class_exists($strategy)) {
//            return null;
//        }
//
//        return new $strategy();
//    }
}
