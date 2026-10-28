# Diferenças aceitas entre o baseline (Laravel 6 / PHP 7.4) e Laravel 13 / PHP 8.4

Os snapshots foram gerados no código antigo. Só estes foram regravados, cada um com o motivo:

| Snapshot | Antes | Depois | Motivo |
|---|---|---|---|
| `ajax/admin_clippings_dt.json` | `"draw": 0` | `"draw": 1` | Artefato do teste no L6: o yajra 9 guarda o primeiro `request` num singleton, então nas requisições seguintes do mesmo teste o `draw` ficava velho. Em produção (uma requisição por processo) o `draw` sempre foi ecoado, que é o que o L13 faz. |
| `ajax/client_clippings.json`, `ajax/client_favorites.json` | — | `"disableOrdering": false` | Chave nova do yajra 13 em respostas server-side; o DataTables JS ignora. |
| `ajax/uploads.json` | `Trying to get property 'path' of non-object` | `Attempt to read property "path" on null` | Texto da mensagem de erro do próprio PHP 8 (remover arquivo inexistente). |

Normalização no helper: o `@csrf` do Blade novo adiciona `autocomplete="off"` ao input do token; o atributo é removido antes da comparação.
