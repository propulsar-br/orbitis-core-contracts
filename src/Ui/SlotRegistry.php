<?php

declare(strict_types=1);

namespace Orbitis\Contracts\Ui;

/**
 * Registro declarativo de pontos de extensão de interface.
 *
 * Módulo declara "quero aparecer neste slot, apontando para esta rota"; o core
 * decide como desenhar. Módulo nunca injeta HTML em view do core — é isso que
 * permite ao core mudar o layout sem quebrar módulo, e o que faz um app
 * satélite (que nem PHP compartilha) usar o mesmo mecanismo.
 */
interface SlotRegistry
{
    /**
     * @param  string  $slot  ex.: 'menu.main', 'menu.admin'
     * @param  array<string, mixed>  $attributes  rótulo, ícone, ordem, rota/URL
     */
    public function register(string $slot, string $moduleKey, array $attributes): void;

    /**
     * Itens registrados num slot, já filtrados pelo que o tenant contratou e
     * pelo que o usuário pode ver.
     *
     * @return array<int, array<string, mixed>>
     */
    public function itemsFor(string $slot): array;
}
