<?php

namespace EscolaLms\AssignWithoutAccount\Services;

use EscolaLms\AssignWithoutAccount\Dto\UserSubmissionDto;
use EscolaLms\AssignWithoutAccount\Dto\UserSubmissionSearchDto;
use EscolaLms\AssignWithoutAccount\Enums\UserSubmissionStatusEnum;
use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use EscolaLms\AssignWithoutAccount\Repositories\Contracts\UserSubmissionRepositoryContract;
use EscolaLms\AssignWithoutAccount\Services\Contracts\UserSubmissionServiceContract;
use EscolaLms\AssignWithoutAccount\Strategies\Contracts\AssignStrategy;
use EscolaLms\AssignWithoutAccount\Strategies\StrategyContext;
use EscolaLms\Core\Dtos\PaginationDto;
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
        $strategy = $this->getStrategy($dto->getMorphableType());
        $model = $strategy->getModelInstance($dto->getMorphableType(), $dto->getMorphableId());

        $dto->setStatus(UserSubmissionStatusEnum::SENT);
        $submission =  $this->userSubmissionRepository->create($dto->toArray());

        $strategy->dispatch($dto->getEmail(), $model);

        return $submission;
    }

    public function update(UserSubmissionDto $dto, int $id): UserSubmission
    {
        return $this->userSubmissionRepository->update($dto->toArray(), $id);
    }

    public function delete(int $id): bool
    {
        return $this->userSubmissionRepository->delete($id);
    }

    public function searchAndPaginate(UserSubmissionSearchDto $searchDto, ?PaginationDto $paginationDto): LengthAwarePaginator
    {
        return $this->userSubmissionRepository->searchAndPaginateByCriteria($searchDto, $paginationDto);
    }

    private function getStrategy(string $morphType): ?AssignStrategy
    {
        return (new StrategyContext($morphType))->getAssignStrategy();
    }
}
