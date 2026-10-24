<?php

declare(strict_types=1);

namespace Orbitis\Contracts\Modules;

/**
 * Manifesto de capacidades de um módulo.
 *
 * É a peça central do contrato: declara o que o módulo precisa, e instalar o
 * módulo para um tenant é aprovar exatamente isso. Serve a três propósitos
 * que, no fim, são o mesmo mecanismo visto de ângulos diferentes:
 *
 *  - catálogo módulo×tenant (o que o cliente contratou);
 *  - descritor de instalação de app satélite;
 *  - fronteira de segurança para módulo gerado por IA no futuro.
 */
final readonly class CapabilityManifest
{
    /**
     * @param  string  $key  identificador estável do módulo
     * @param  Tier  $tier  como o módulo é executado e implantado
     * @param  array<string>  $scopes  escopos solicitados (ex.: 'orders:read')
     * @param  array<string>  $slots  slots de UI que ocupa (ex.: 'menu.main')
     * @param  array<string>  $events  eventos de domínio que escuta
     * @param  string|null  $baseUrl  obrigatório para apps satélite
     */
    public function __construct(
        public string $key,
        public string $name,
        public Tier $tier,
        public array $scopes = [],
        public array $slots = [],
        public array $events = [],
        public ?string $baseUrl = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            key: (string) $data['key'],
            name: (string) $data['name'],
            tier: Tier::from((string) $data['tier']),
            scopes: $data['scopes'] ?? [],
            slots: $data['slots'] ?? [],
            events: $data['events'] ?? [],
            baseUrl: $data['base_url'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'name' => $this->name,
            'tier' => $this->tier->value,
            'scopes' => $this->scopes,
            'slots' => $this->slots,
            'events' => $this->events,
            'base_url' => $this->baseUrl,
        ];
    }

    public function requiresScope(string $scope): bool
    {
        return in_array($scope, $this->scopes, true);
    }
}
