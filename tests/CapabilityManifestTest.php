<?php

declare(strict_types=1);

namespace Orbitis\Contracts\Tests;

use Orbitis\Contracts\Modules\CapabilityManifest;
use Orbitis\Contracts\Modules\Tier;
use PHPUnit\Framework\TestCase;

class CapabilityManifestTest extends TestCase
{
    public function test_survives_a_round_trip(): void
    {
        $manifest = new CapabilityManifest(
            key: 'auge-legacy',
            name: 'AUGE',
            tier: Tier::Satellite,
            scopes: ['users:read'],
            slots: ['menu.main'],
            events: ['user.activated'],
            baseUrl: 'https://auge.example',
        );

        // O manifesto trafega como array (catálogo no banco, descritor de
        // app), então ida e volta não pode perder informação.
        $this->assertEquals(
            $manifest,
            CapabilityManifest::fromArray($manifest->toArray())
        );
    }

    public function test_only_satellites_require_a_base_url(): void
    {
        $this->assertTrue(Tier::Satellite->requiresBaseUrl());
        $this->assertFalse(Tier::InProcess->requiresBaseUrl());
        $this->assertFalse(Tier::Integration->requiresBaseUrl());
    }

    public function test_only_in_process_modules_ship_with_the_core(): void
    {
        $this->assertTrue(Tier::InProcess->isDeployedWithCore());

        // Esta é a razão de existir do tier: deploy independente.
        $this->assertFalse(Tier::Satellite->isDeployedWithCore());
        $this->assertFalse(Tier::Integration->isDeployedWithCore());
    }

    public function test_scope_check_reflects_what_was_declared(): void
    {
        $manifest = new CapabilityManifest(
            key: 'relatorios',
            name: 'Relatórios',
            tier: Tier::InProcess,
            scopes: ['reports:read'],
        );

        $this->assertTrue($manifest->requiresScope('reports:read'));
        $this->assertFalse($manifest->requiresScope('reports:write'));
    }
}
