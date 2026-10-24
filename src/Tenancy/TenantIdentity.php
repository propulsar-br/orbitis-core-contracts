<?php

declare(strict_types=1);

namespace Orbitis\Contracts\Tenancy;

/**
 * Identidade do tenant do request corrente, como um módulo a enxerga.
 *
 * Deliberadamente somente-leitura: módulo nunca define o tenant. Quem define
 * é o core, a partir do host — se um módulo pudesse trocar o tenant, todo o
 * isolamento do sistema cairia.
 */
interface TenantIdentity
{
    /**
     * Código estável do tenant (ex.: 'MACLER'). Null fora de tenant.
     */
    public function code(): ?string;

    public function name(): ?string;

    /**
     * Falha quando não há tenant. Use em código que toca dado de cliente —
     * operar sem escopo é pior que falhar.
     *
     * @throws \RuntimeException
     */
    public function codeOrFail(): string;
}
