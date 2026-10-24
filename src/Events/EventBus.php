<?php

declare(strict_types=1);

namespace Orbitis\Contracts\Events;

/**
 * Publicação e assinatura de eventos de domínio.
 *
 * É o ponto de extensão que substitui herança: módulo que quer reagir a algo
 * do core escuta um evento, em vez de estender uma classe base do core. É o
 * que evita o acoplamento que hoje trava o AUGE (105 usos de BaseModel).
 */
interface EventBus
{
    /**
     * @param  array<string, mixed>  $payload
     */
    public function publish(string $event, array $payload = []): void;

    /**
     * @param  callable(array<string, mixed>): void  $listener
     */
    public function subscribe(string $event, callable $listener): void;
}
