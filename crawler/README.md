# Crawlers do MONITORAÊ

Os crawlers coletam dados públicos sobre Mogi das Cruzes e alimentam o site. O site não usa banco de dados: cada crawler grava um arquivo JSON em `docs/data/`, e as páginas leem esse arquivo direto no navegador.

```
API do Tesouro (SICONFI) ──► financas/crawler_financas.js ──► docs/data/financas.json ──┐
portal da prefeitura ─────► servidores/crawler_servidores.php ─► docs/data/servidores.json ┼─► site (GitHub Pages)
                                                         └──► MySQL (opcional, --banco)     │
                                                                                            │
GitHub Actions roda os dois toda segunda-feira e faz commit só quando há dados novos ──────┘
```

## Atualização automática (GitHub Actions)

O arquivo [`.github/workflows/atualizar-dados.yml`](../.github/workflows/atualizar-dados.yml) roda os crawlers toda segunda-feira nos servidores do GitHub. Se algum dado mudou, ele faz um commit em `docs/data/` e o GitHub Pages publica o site atualizado sozinho, sem precisar de computador ligado nem de banco de dados.

Para rodar na hora: no GitHub, abra **Actions → Atualizar dados do site → Run workflow**.

> O GitHub desativa workflows agendados de repositórios sem nenhum commit há 60 dias. Se isso acontecer, ele avisa por e-mail e basta reativar na aba Actions.

## Situação de cada crawler

| Crawler | Fonte | Situação |
| :--- | :--- | :--- |
| [`financas/crawler_financas.js`](financas/crawler_financas.js) | API do Tesouro Nacional (SICONFI), relatórios RREO da prefeitura | ✅ Funciona. Dados de 2019 até o último bimestre publicado. Alimenta a página de Relatórios. |
| [`servidores/crawler_servidores.php`](servidores/crawler_servidores.php) | API JSON `licitacao.pmmc.com.br/Transparencia/vencimentos2` | ✅ Funciona. A fonte ainda responde, mas está parada no mês de referência **Out/2020**. |
| [`vereadores/crawler_vereadores.php`](vereadores/crawler_vereadores.php) | Página `cmmc.com.br/vereadores` | ❌ Quebrado. O site da Câmara mudou de layout e não tem mais as classes que o código procura. |
| [`pdf/extracao_pdf.js`](pdf/extracao_pdf.js) | PDFs de projetos de lei | 🚧 Protótipo. Só mostra o texto do PDF no console e ainda não grava no banco. |
| [`experimentos/`](experimentos/) | Vários | Testes e rascunhos do grupo, mantidos como histórico. |

Os projetos de lei (`tb_projetoslei`) não têm crawler no repositório; os dados estão só em `banco/bdservidores.sql`.

## Como rodar o crawler de finanças

Precisa do [Node.js](https://nodejs.org/) 18 ou mais novo. Não tem dependências para instalar.

```bash
node crawler/financas/crawler_financas.js
```

Para cada ano desde 2019, o crawler pega o último relatório bimestral (RREO) publicado e junta três anexos:

- **Anexo 01:** de onde veio o dinheiro (impostos da cidade, Estado, União, FUNDEB, empréstimos);
- **Anexo 02:** para onde foi o dinheiro, por área (Saúde, Educação, Transporte…), usando a despesa *liquidada*;
- **Anexo 03:** quanto do ICMS e do IPVA o Estado repassou, mês a mês.

Ele confere se a soma das áreas bate com o total do relatório e para com erro se não bater.

## Como rodar o crawler de servidores

Precisa de PHP 7.4+ com as extensões `mbstring` e `mysqli` (o XAMPP já vem com elas).

```bash
cd crawler/servidores
php crawler_servidores.php
```

Isso atualiza `docs/data/servidores.json`. Depois é só fazer commit e push para o site no GitHub Pages mostrar os dados novos.

Para gravar também no MySQL:

1. Importe `banco/bdservidores.sql` e depois rode `banco/correcoes.sql`.
2. Copie `crawler/conexao.example.php` para `crawler/conexao.php` e coloque o usuário e a senha do seu banco.
3. Rode `php crawler_servidores.php --banco`.

### O que foi corrigido em relação à versão de 2020 (`vai_funcionar.php`)

- **Acentos:** o portal responde em ISO-8859-1 e o `iconv(... //IGNORE)` apagava as letras acentuadas ("EDUCAÇÃO" virava "EDUCAO"). Agora o texto é convertido para UTF-8.
- **Salários:** `"1.715,26"` era gravado numa coluna `DOUBLE` e virava `1.715`, perdendo os centavos. Agora vira `1715.26` numa coluna `DECIMAL`.
- **Cargos cortados:** a coluna `cargo` tinha 30 caracteres, mas há cargos com até 40.
- **SQL injection:** o `INSERT` era montado juntando textos. Agora usa uma consulta preparada.
- **Duplicação:** rodar de novo duplicava todos os servidores. Agora atualiza pelo `rgf`.
- **Erros silenciosos:** falhas de conexão ou de `INSERT` não apareciam. Agora o script para e mostra o erro.
- **Site estático:** o script gera o JSON que o GitHub Pages usa, então o site funciona sem PHP.

## Vereadores e projetos no site

`docs/data/vereadores.json` e `docs/data/projetos.json` são gerados a partir do banco exportado:

```bash
python ferramentas/sql_para_json.py
```
