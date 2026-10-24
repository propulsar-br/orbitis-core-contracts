<?php

declare(strict_types=1);

namespace Orbitis\Contracts\Modules;

/**
 * Como um módulo é executado e implantado.
 *
 * A distinção importa porque só um dos três compartilha o deploy do core.
 */
enum Tier: string
{
    /** PHP dentro do core. Deploy junto com o core. */
    case InProcess = 'in_process';

    /** Serviço próprio, embutido via iframe + handshake assinado. Deploy independente. */
    case Satellite = 'satellite';

    /** Sem UI: consome API e/ou recebe webhook. */
    case Integration = 'integration';

    /**
     * Satélites rodam fora do core e por isso precisam de endereço próprio e
     * segredo de handshake.
     */
    public function requiresBaseUrl(): bool
    {
        return $this === self::Satellite;
    }

    public function isDeployedWithCore(): bool
    {
        return $this === self::InProcess;
    }
}
