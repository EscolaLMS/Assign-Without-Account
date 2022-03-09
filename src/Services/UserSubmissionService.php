<?php

namespace EscolaLms\AssignWithoutAccount\Services;

use EscolaLms\AssignWithoutAccount\Dto\UserSubmissionDto;
use EscolaLms\AssignWithoutAccount\Dto\UserSubmissionSearchDto;
use EscolaLms\AssignWithoutAccount\Enums\UserSubmissionStatusEnum;
use EscolaLms\AssignWithoutAccount\Events\AssignToProduct;
use EscolaLms\AssignWithoutAccount\Events\AssignToProductable;
use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use EscolaLms\AssignWithoutAccount\Repositories\Contracts\UserSubmissionRepositoryContract;
use EscolaLms\AssignWithoutAccount\Services\Contracts\UserSubmissionServiceContract;
use EscolaLms\Cart\Contracts\Productable;
use EscolaLms\Cart\Models\Product;
use EscolaLms\Core\Dtos\PaginationDto;
use EscolaLms\Core\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserSubmissionService implements UserSubmissionServiceContract
{
    private UserSubmissionRepositoryContract $userSubmissionRepository;

    public function __construct(
        UserSubmissionRepositoryContract $userSubmissionRepository
    ) {
        $this->userSubmissionRepository = $userSubmissionRepository;
    }

    public function create(UserSubmissionDto $dto): UserSubmission
    {
        // TODO check is registered in productService productRegisterable
        $dto->setStatus(UserSubmissionStatusEnum::SENT);
        $userSubmission = $this->userSubmissionRepository->create($dto->toArray());

        $this->dispatchUserSubmissionAccepted($dto);

        return $userSubmission;
    }

    public function searchAndPaginate(UserSubmissionSearchDto $searchDto, ?PaginationDto $paginationDto): LengthAwarePaginator
    {
        return $this->userSubmissionRepository->searchAndPaginateByCriteria($searchDto, $paginationDto);
    }

    private function dispatchUserSubmissionAccepted(UserSubmissionDto $dto): void
    {
        $user = new User();
        $user->email = $dto->getEmail();
        $model = $dto->getMorphableType()::find($dto->getMorphableId()); // TODO ??? works but refactor

        if ($model instanceof Product) {
            AssignToProduct::dispatch($user, $model);
        }
        else if ($model instanceof Productable) {
            AssignToProductable::dispatch($user, $model);
        }
    }
}
