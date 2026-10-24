# orbitis/core-contracts

Interfaces e DTOs que o core do Orbitis expõe a módulos e apps. **Sem implementação, sem lógica de negócio.**

## Por que é público

Só interfaces e DTOs — nenhuma regra de negócio, nenhum dado. Quem desenvolve um app satélite precisa consultá-lo, e ser público elimina a necessidade de distribuir credencial para isso. O core do Orbitis, que tem as regras, permanece privado.

## Por que é um repositório separado

Para ter semver independente do core. Se vivesse dentro do core, cada release do core seria uma release do contrato na prática — e a promessa de compatibilidade com apps de terceiros não teria como ser cumprida.

Módulo depende deste pacote, nunca de classe concreta do core. É o que evita o acoplamento que hoje impede release independente no AUGE (105 usos de `BaseModel`, migrations de módulo alterando tabela do core).

## O que há aqui

| Contrato | Papel |
|---|---|
| `Tenancy\TenantIdentity` | Quem é o tenant do request — somente leitura: módulo nunca define tenant |
| `Modules\CapabilityManifest` | O que o módulo declara precisar; instalar para um tenant é aprovar isso |
| `Modules\Tier` | `in_process`, `satellite` ou `integration` — só o primeiro compartilha deploy com o core |
| `Events\EventBus` | Extensão por evento de domínio, em vez de herança |
| `Ui\SlotRegistry` | Módulo declara onde aparece; o core desenha. Nunca injeta HTML em view do core |

## Desenvolvimento

Em dev, o core consome este pacote via *path repository* do Composer:

```bash
composer config repositories.orbitis/core-contracts path ../core-contracts
composer require orbitis/core-contracts:@dev
```

Isso permite editar os dois juntos sem publicar versão a cada mudança — mesmo mecanismo que o AUGE já usa para `vendor/propulsar/*`.

## Regra de evolução

A partir do primeiro app de terceiro instalado, **quebrar este contrato quebra software de outra pessoa**. Mudança incompatível exige major version e janela de compatibilidade — não é higiene, é obrigação.

A superfície deve crescer conforme módulos reais pedem, não por antecipação: contrato desenhado especulativamente costuma prever a coisa errada.
