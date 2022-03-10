<?php

namespace EscolaLms\AssignWithoutAccount\Dto;

use EscolaLms\Core\Dtos\Contracts\DtoContract;
use EscolaLms\Core\Dtos\Contracts\InstantiateFromRequest;
use Illuminate\Http\Request;

class UserSubmissionDto implements DtoContract, InstantiateFromRequest
{
    private string $email;
    private int $morphable_id;
    private string $morphable_type;
    private ?string $status;

    public function __construct(string $email, int $morphable_id, string $morphable_type, ?string $status = null)
    {
        $this->email = $email;
        $this->morphable_id = $morphable_id;
        $this->morphable_type = $morphable_type;
        $this->status = $status;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'morphable_id' => $this->morphable_id,
            'morphable_type' => $this->morphable_type,
            'status' => $this->status,
        ];
    }

    public static function instantiateFromRequest(Request $request): self
    {
        return new static(
            $request->input('email'),
            $request->input('morphable_id'),
            $request->input('morphable_type'),
            $request->input('status'),
        );
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMorphableId(): int
    {
        return $this->morphable_id;
    }

    public function getMorphableType(): string
    {
        return $this->morphable_type;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }
}
