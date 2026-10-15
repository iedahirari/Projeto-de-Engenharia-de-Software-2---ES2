# 🏛️ MONITORAÊ — Transparência Pública Cidadã de Mogi das Cruzes

> **Projeto Integrador da Disciplina de Engenharia de Software II (ES2)**  
> Sistema Web voltado à extração, estruturação, democratização e visualização clara dos dados públicos de agentes políticos e servidores municipais de Mogi das Cruzes.

🌐 **Site no ar:** https://iedahirari.github.io/Projeto-de-Engenharia-de-Software-2---ES2/  
🔄 **Dados atualizados automaticamente toda semana** pelos web crawlers do projeto (GitHub Actions).

---

## 📌 Sumário
- [1. 📖 Sobre o Projeto](#1--sobre-o-projeto)
- [2. 🎓 Alinhamento com Engenharia de Software II](#2--alinhamento-com-engenharia-de-software-ii)
- [3. ⚖️ Fundamentação Legal e Regras de Negócio](#3-️-fundamentação-legal-e-regras-de-negócio)
- [4. 👥 Mapeamento de Stakeholders](#4--mapeamento-de-stakeholders)
- [5. 🛡️ Premissas do Sistema](#5-️-premissas-do-sistema)
- [6. 📋 Engenharia de Requisitos](#6--engenharia-de-requisitos)
  - [6.1 Requisitos Funcionais (RF)](#61-requisitos-funcionais-rf)
  - [6.2 Requisitos Não Funcionais (RNF)](#62-requisitos-não-funcionais-rnf)
  - [6.3 Situação da Implementação](#63-situação-da-implementação)
- [7. 🔄 Casos de Uso (CDU)](#7--casos-de-uso-cdu)
- [8. 🧭 Arquitetura: como os dados chegam ao site](#8--arquitetura-como-os-dados-chegam-ao-site)
- [9. 📁 Estrutura do Repositório](#9--estrutura-do-repositório)
- [10. 🛠️ Tecnologias Utilizadas](#10-️-tecnologias-utilizadas)
- [11. 🎨 Identidade Visual](#11--identidade-visual)
- [12. ⚙️ Instruções de Instalação e Execução](#12-️-instruções-de-instalação-e-execução)
- [13. 👥 Equipe e Orientação](#13--equipe-e-orientação)
- [14. 📚 Referências Bibliográficas](#14--referências-bibliográficas)

---

## 1. 📖 Sobre o Projeto

O **MONITORAÊ** é uma plataforma concebida para aproximar a população de Mogi das Cruzes da administração pública. Embora os dados governamentais estejam disponíveis nos portais oficiais da Prefeitura, da Câmara Municipal e do Tesouro Nacional, muitas informações encontram-se dispersas em relatórios e arquivos de difícil navegação para o cidadão.

O sistema automatiza a extração desses registros por meio de rotinas de *Web Scraping/Crawling* e os apresenta em uma interface web intuitiva e transparente, com dados de vereadores, prefeito, servidores públicos, projetos de lei e um relatório de **para onde vai o dinheiro público** (saúde, educação, transporte etc.) e **quanto o Governo do Estado repassa à cidade**.

Na versão acadêmica original, os dados coletados eram armazenados em um banco MySQL (conteúdo da disciplina). Na versão publicada, os crawlers geram arquivos JSON que o próprio site lê, o que permite hospedá-lo gratuitamente no GitHub Pages e mantê-lo atualizado sem servidor nem banco de dados.

---

## 2. 🎓 Alinhamento com Engenharia de Software II

O desenvolvimento do sistema seguiu rigorosamente os pilares da disciplina de Engenharia de Software II:

- **Contexto de TI e Modelagem de Negócio:** Análise do ecossistema de transparência governamental e impacto social da tecnologia.
- **Elicitação e Análise de Necessidades:** Identificação dos problemas de acesso à informação vivenciados pelos munícipes.
- **Matriz de Requisitos e Rastreabilidade:** Mapeamento bidirecional entre visão de stakeholders (superficial) e visão de sistema (detalhada).
- **Modelagem e Especificação UML:** Elaboração de diagramas de Casos de Uso e modelagens estruturais utilizando a ferramenta Astah (`.asta`).
- **Validação por Prova de Conceito (POC):** Testes de extração estruturada de dados a partir de tabelas governamentais em formato PDF.

---

## 3. ⚖️ Fundamentação Legal e Regras de Negócio

As regras de negócio do sistema foram estruturadas com base na legislação brasileira de transparência pública:

- **Lei de Acesso à Informação (Lei Federal nº 12.527/2011):** Garante a qualquer cidadão o acesso a dados públicos sem necessidade de justificativa, estabelecendo a obrigatoriedade da transparência ativa em linguagem clara e acessível.
- **Lei da Transparência (Lei Complementar nº 131/2009):** Determina a divulgação detalhada em tempo real sobre a execução orçamentária e financeira dos entes federativos.
- **Remuneração de Agentes Públicos (Decreto nº 7.724/2012, Art. 7º):** Exige a publicidade de cargos, salários, funções de confiança, diárias, convênios, auxílios e vantagens pecuniárias dos servidores e agentes políticos.
- **Relatório Resumido da Execução Orçamentária (LRF, art. 52):** Obriga os municípios a publicar a cada bimestre quanto arrecadaram e gastaram, por área de governo. É a fonte da página de Relatórios.
- **Prazos Legais:** Informações públicas devem ter disponibilidade imediata ou resposta em até 20 dias pelos órgãos competentes.

---

## 4. 👥 Mapeamento de Stakeholders

Os envolvidos e impactados pelo projeto foram categorizados por grau de poder, interesse e influência:

### Stakeholders Internos
- **Gestores do Projeto (Stakeholders Definitivos):** Ieda de Oliveira e Thaís Ferreira (Poder Alto, Interesse Alto, Perfil Líder).
- **Colaborador / Orientador (Stakeholder Dominante):** Prof. Leandro Luque (Poder Alto, Interesse Alto, Perfil Apoiador).

### Stakeholders Externos
- **Munícipe (Stakeholder Chave / Cliente):** População de Mogi das Cruzes (Poder Baixo, Interesse Alto, Perfil Apoiador).
- **Ministério Público (Stakeholder Chave):** Fiscalização dos interesses difusos e sociais (Poder Alto, Interesse Baixo, Perfil Neutro).
- **Tribunal de Contas:** Fiscalização contábil e orçamentária da administração municipal (Poder Alto, Interesse Baixo, Perfil Neutro).
- **Poder Executivo Municipal:** Responsável pela gestão e disponibilização das bases de dados (Poder Alto, Interesse Baixo, Perfil Neutro).
- **Governo Municipal:** Órgãos da administração municipal cujos dados são processados (Poder Alto, Interesse Baixo, Perfil Desinformado).
- **Mídia (Stakeholder Adormecido):** Veículos de imprensa e comunicação regional (Poder Baixo, Interesse Baixo, Perfil Desinformado).

---

## 5. 🛡️ Premissas do Sistema

- **Combate a Fake News:** O robô de notícias busca conteúdos exclusivamente em veículos de imprensa de comprovada credibilidade (G1, Nexo, The Intercept Brasil, BuzzFeed News Brasil, BBC News Brasil, Vice Brasil).
- **Gestão de Comentários:** A moderação e identificação de comentários são gerenciadas via integração com o plugin social do Facebook, exigindo autenticação.
- **Ciclo de Atualização:** Os dados do site devem ser sincronizados com os portais oficiais em ciclos de no máximo 30 dias. Na versão publicada, os crawlers rodam automaticamente **toda semana**.
- **Fontes Oficiais:** Todo dado exibido indica a fonte pública de onde foi coletado e a data da coleta.

---

## 6. 📋 Engenharia de Requisitos

### 6.1 Requisitos Funcionais (RF)

| Código | Requisito (Visão Stakeholder) | Detalhamento de Sistema |
| :---: | :--- | :--- |
| **RF01** | O sistema deve usar um robô para buscar vereadores, prefeito e servidores públicos. | O crawler deve varrer os portais da Câmara e da Prefeitura de Mogi das Cruzes, extraindo e estruturando os registros. |
| **RF02** | O sistema deve listar os vereadores e prefeitos. | Apresentar nome, foto, partido, cargo, gastos totais, emendas, salário, comissões, benefícios, propostas, contato e histórico. |
| **RF03** | O sistema deve listar os servidores públicos. | Apresentar nome, ocupação, benefícios, recursos disponíveis e remuneração. |
| **RF04** | O sistema deve permitir comentários através do plugin do Facebook. | Permitir interação autenticada via Facebook para inserção, atualização e exclusão de opiniões nos perfis. |
| **RF05** | O sistema deve permitir a busca por vereadores e prefeitos. | Filtros por nome, cargo, partido político, volume de gastos públicos, índice de faltas, salário e projetos. |
| **RF06** | O sistema deve permitir a busca por servidores públicos. | Filtros por nome, ocupação/cargo e faixas salariais. |
| **RF07** | O sistema apresentará dashboards de gastos e projetos. | Gráficos visuais de barra, pizza e linha segmentados por período e por agente político. |
| **RF08** | O sistema deve buscar notícias sobre os políticos municipais. | Robô de busca textual vinculado ao nome do político, varrendo links de notícias públicas. |
| **RF09** | O sistema habilitará página especial para candidatos à reeleição. | Dashboard comparativo de mandato anterior, gastos, projetos aprovados e novas propostas. |
| **RF10** | O sistema deve imprimir relatórios. | Geração e impressão de relatórios gerais e individuais consolidados com filtros dinâmicos. |
| **RF11 / RF12** | O sistema deve listar as matérias jornalísticas encontradas. | Exibir título, introdução/lead e link direto da fonte oficial da notícia. |

### 6.2 Requisitos Não Funcionais (RNF)

| Categoria | Código | Requisito (Visão Stakeholder) | Especificação Técnica e Critério de Aceite |
| :--- | :---: | :--- | :--- |
| **Usabilidade** | **RNF01** | Interface agradável e moderna. | Paleta de cores harmoniosa, layout limpo e imagens de alta qualidade. |
| **Usabilidade** | **RNF02** | Navegação intuitiva. | Disposição visual clara de dados com suporte a ícones semânticos para facilitar a compreensão. |
| **Confiabilidade** | **RNF03 / RNF05** | Alta disponibilidade. | Operação 24/7 com tolerância máxima a falhas de 5%. |
| **Confiabilidade** | **RNF04** | Integridade contra Fake News. | Restrição de links de notícias a fontes jornalísticas verificadas. |
| **Desempenho** | **RNF06** | Alta performance. | Tempo de resposta inferior a 5 segundos para requisições com até 100 usuários simultâneos. |
| **Manutenibilidade** | **RNF07** | Facilidade de manutenção. | Arquitetura modular estruturada sob o paradigma de Orientação a Objetos. |

### 6.3 Situação da Implementação

| Requisito | Situação | Onde |
| :---: | :---: | :--- |
| **RF01** | ✅ Parcial | Crawlers de servidores e de finanças funcionando. O de vereadores precisa ser reescrito (o site da Câmara mudou de layout). |
| **RF02** | ✅ | Perfis do prefeito e dos 23 vereadores, com salário, votos, contato e projetos de lei. |
| **RF03 / RF06** | ✅ | [Servidores](https://iedahirari.github.io/Projeto-de-Engenharia-de-Software-2---ES2/Servidores.html): busca por nome, cargo ou RGF, ordenação e paginação. |
| **RF04** | ⏳ Não implementado | Comentários pelo Facebook. |
| **RF05** | ✅ | Busca por nome ou partido na página inicial e no perfil dos vereadores. |
| **RF07 / RF10** | ✅ | Painel na página inicial e [Relatórios](https://iedahirari.github.io/Projeto-de-Engenharia-de-Software-2---ES2/Relatorios.html): gastos por área, origem do dinheiro, repasses do Estado e evolução de 2019 até hoje. |
| **RF08 / RF11 / RF12** | 🟡 Manual | Notícias selecionadas pela equipe, com link para a fonte. Ainda sem robô de notícias. |
| **RF09** | ⏳ Não implementado | Página de candidatos à reeleição. |
| **RNF01 / RNF02** | ✅ | Identidade visual com as cores da bandeira de Mogi, modo escuro, layout para celular e acessibilidade por teclado. |
| **RNF03 / RNF06** | ✅ | Site estático no GitHub Pages: sem servidor para cair e carregamento rápido. |

---

## 7. 🔄 Casos de Uso (CDU)

O comportamento funcional do sistema foi modelado nos seguintes casos de uso principais:

```text
  [ Robô de Coleta ] ────────▶ ( CDU001: Manter Vereadores )
  [ Robô de Coleta ] ────────▶ ( CDU005: Manter Prefeito )
  [ Robô de Coleta ] ────────▶ ( CDU007: Manter Servidores Públicos )
  [ Robô de Coleta ] ────────▶ ( CDU010: Manter Notícias )

  [ Munícipe / Usuário ] ────▶ ( CDU002: Consultar Vereadores ) ──《extend》──▶ ( CDU003: Manter Comentários )
  [ Munícipe / Usuário ] ────▶ ( CDU006: Consultar Prefeito )    ──《extend》──▶ ( CDU003: Manter Comentários )
  [ Munícipe / Usuário ] ────▶ ( CDU008: Consultar Servidores Públicos )
  [ Munícipe / Usuário ] ────▶ ( CDU009: Gerar Relatórios )
  [ Munícipe / Usuário ] ────▶ ( CDU011: Consultar Notícias )

  [ Plugin Facebook ]    ────▶ ( CDU003: Manter Comentários ) & ( CDU004: Consultar Comentários )
```

---

## 8. 🧭 Arquitetura: como os dados chegam ao site

```text
 FONTES OFICIAIS                      CRAWLERS (crawler/)                       SITE (docs/)
 ─────────────────                    ──────────────────                        ────────────
 API do Tesouro Nacional  ──────────▶ financas/crawler_financas.js  ──▶ data/financas.json   ──▶ Relatórios
 (SICONFI / RREO)                     (Node.js)

 Portal da Prefeitura     ──────────▶ servidores/crawler_servidores.php ─▶ data/servidores.json ─▶ Servidores
 (folha de pagamento)                 (PHP)              └──▶ MySQL (opcional, versão acadêmica)

 Banco bdservidores.sql   ──────────▶ ferramentas/sql_para_json.py ──▶ data/vereadores.json  ──▶ Vereadores,
 (coleta de 2020)                                                       data/projetos.json       Prefeito

          ⏰ GitHub Actions roda os crawlers toda segunda-feira e faz commit só quando há dados novos.
          🌐 O GitHub Pages publica a pasta docs/ automaticamente após cada commit.
```

O site não tem back-end: as páginas são HTML + JavaScript e leem os arquivos de `docs/data/` direto no navegador. Os detalhes de cada crawler (fontes, situação e correções feitas) estão em [`crawler/README.md`](crawler/README.md).

---

## 9. 📁 Estrutura do Repositório

```text
Projeto-de-Engenharia-de-Software-2---ES2/
│
├── 📂 docs/                            # 🌐 Site publicado no GitHub Pages (só HTML, CSS, JS e dados)
│   ├── index.html                        # Página inicial: busca, vereadores, painel e notícias
│   ├── PerfilPrefeito.html               # Perfil e projetos de lei do prefeito
│   ├── PerfilVereador.html?id=N          # Perfil, busca e projetos de cada vereador
│   ├── Servidores.html                   # Consulta aos servidores (busca, ordenação, paginação)
│   ├── Relatorios.html                   # Para onde vai o dinheiro e repasses do Estado
│   ├── 📂 data/                          # Dados em JSON gerados pelos crawlers
│   ├── 📂 js/monitorae.js                # Cabeçalho, rodapé e funções compartilhadas
│   ├── 📂 css/estilo.css                 # Identidade visual (cores da bandeira de Mogi)
│   └── 📂 imgs/                          # Ícone do site e fotos do prefeito e dos vereadores
│
├── 📂 crawler/                         # 🤖 Web crawlers (ver crawler/README.md)
│   ├── 📂 financas/                      # Gastos por área e repasses do Estado (Node.js, API do Tesouro)
│   ├── 📂 servidores/                    # Folha de pagamento da Prefeitura (PHP → JSON e MySQL)
│   ├── 📂 vereadores/                    # Dados dos vereadores no site da Câmara (PHP, precisa ser reescrito)
│   ├── 📂 pdf/                           # Protótipo de extração de texto de PDFs (Node.js)
│   ├── 📂 experimentos/                  # Testes e rascunhos de raspagem
│   ├── 📂 lib/                           # Simple HTML DOM Parser
│   └── conexao.example.php               # Modelo de conexão com o MySQL
│
├── 📂 .github/workflows/               # ⏰ GitHub Actions que roda os crawlers toda semana
│
├── 📂 banco/                           # 🗄️ Banco de dados MySQL (versão acadêmica)
│   ├── bdservidores.sql                  # Esquema e dados (servidores, vereadores, projetos de lei)
│   ├── correcoes.sql                     # Correções de tipos de colunas e caminhos das fotos
│   └── bdmonitorae.sql                   # Versão anterior do banco (tb_funcionario)
│
├── 📂 app-php/                         # 🐘 Versão acadêmica em PHP + MySQL (roda no XAMPP)
│   ├── *.php                             # Páginas que consultam o banco (mesmo visual do site)
│   └── 📂 inc/                           # Layout e funções compartilhadas (conexão, escape, listas)
│
├── 📂 ferramentas/                     # 🔧 Scripts auxiliares
│   └── sql_para_json.py                  # Exporta vereadores e projetos do .sql para docs/data/
│
├── 📂 Documentacao/                    # 📑 Artefatos formais de Engenharia de Software
│   ├── Caso_de_uso_-_descrição.docx      # Especificação detalhada dos fluxos de Casos de Uso
│   ├── Requisitos(RF,RNF).xlsx           # Matriz de rastreabilidade (visão stakeholder vs. sistema)
│   ├── Versão_finalFINAL.asta            # Modelagem UML formal (Casos de Uso, Classes) via Astah
│   ├── premissa.docx                     # Premissas e restrições técnicas do projeto
│   ├── regra.docx                        # Regras de negócio e embasamento jurídico (LAI)
│   ├── requisitos.docx                   # Especificação de Requisitos de Software (SRS)
│   └── stakeholders.docx                 # Análise e mapeamento das partes interessadas
│
├── 📂 POC/                             # 🧪 Atividade prática de Prova de Conceito
├── 📂 Logo/                            # 🖼️ Logos originais do MONITORAÊ (PNG e PSD)
├── .gitignore                            # Arquivos que não vão para o Git (senhas, dependências)
└── README.md
```

---

## 10. 🛠️ Tecnologias Utilizadas

| Camada / Função | Tecnologias |
| :--- | :--- |
| **Interface do Usuário (Front-end)** | HTML5, CSS3 (design system próprio, modo escuro, responsivo), JavaScript |
| **Dados do site** | Arquivos JSON estáticos gerados pelos crawlers |
| **Web Crawlers** | Node.js (finanças), PHP (servidores e vereadores), Simple HTML DOM Parser |
| **Fontes de dados** | API do Tesouro Nacional (SICONFI/RREO), Portal da Transparência da Prefeitura, site da Câmara Municipal |
| **Hospedagem** | GitHub Pages |
| **Automação** | GitHub Actions (execução semanal dos crawlers) |
| **Banco de Dados (versão acadêmica)** | MySQL / MariaDB |
| **Engenharia e Modelagem** | Astah Community/UML, Microsoft Excel, Microsoft Word |
| **Versionamento** | Git & GitHub |

---

## 11. 🎨 Identidade Visual

As cores do site vêm da bandeira de Mogi das Cruzes:

| Cor | Hex | Uso no site |
| :--- | :---: | :--- |
| 🔵 Azul do triângulo | `#24387F` | Cor principal: cabeçalho, botões e gráficos |
| 🟡 Dourado das estrelas | `#F2C230` | Destaques, menu ativo e foco do teclado |
| ⚫⚪🔴 Faixas preta, branca e vermelha | `#1C1C1E` / `#FFFFFF` / `#D0262D` | Faixa no topo do site e alertas importantes |
| 🟢 Verde da serpente | `#2E8B3D` | Indicadores positivos ("Aprovado", "Virou lei") |

O logo é uma lupa com a estrela dourada da bandeira ([`docs/imgs/icone.svg`](docs/imgs/icone.svg)). As fontes são **Sora** (títulos) e **Inter** (textos).

---

## 12. ⚙️ Instruções de Instalação e Execução

### Ver o site na sua máquina

O site não precisa de servidor web nem de banco. Basta servir a pasta `docs/` com qualquer servidor estático:

```bash
python -m http.server 8000 --directory docs
```

Depois acesse http://localhost:8000.

### Atualização automática dos dados

Toda segunda-feira o **GitHub Actions** ([`.github/workflows/atualizar-dados.yml`](.github/workflows/atualizar-dados.yml)) roda os crawlers. Se houver dados novos, ele faz um commit em `docs/data/` e o GitHub Pages publica a nova versão do site. Para rodar na hora, use **Actions → Atualizar dados do site → Run workflow** no GitHub.

Para rodar os crawlers na sua máquina:

```bash
node crawler/financas/crawler_financas.js
```

```bash
php crawler/servidores/crawler_servidores.php
```

O primeiro precisa do Node.js 18+, e o segundo, do PHP 7.4+ (o XAMPP já vem com ele). Os detalhes, inclusive como gravar os servidores no MySQL, estão em [`crawler/README.md`](crawler/README.md).

### Versão acadêmica em PHP + MySQL (XAMPP)

1. Copie o repositório para `C:/xampp/htdocs/` e inicie o **Apache** e o **MySQL**.
2. No `http://localhost/phpmyadmin`, crie o banco `bdservidores`, importe `banco/bdservidores.sql` e depois rode `banco/correcoes.sql`.
   Para trazer os servidores atualizados para o banco, rode `php crawler/servidores/crawler_servidores.php --banco` (veja [`crawler/README.md`](crawler/README.md)).
3. Se o seu MySQL tiver senha, ajuste `app-php/conexao.php`.
4. Acesse:
   ```text
   http://localhost/Projeto-de-Engenharia-de-Software-2---ES2/app-php/index.php
   ```

---

## 13. 👥 Equipe e Orientação

- **Ieda de Oliveira** — Desenvolvimento e Engenharia de Requisitos
- **Thaís Ferreira** — Desenvolvimento e Engenharia de Requisitos
- **Bruno Stevan** — Desenvolvimento e Módulos de Web Scraping
- **Maria Beatriz** — Equipe de desenvolvimento
- **Prof. Leandro Luque** — Docente e Orientador da Disciplina

---

## 14. 📚 Referências Bibliográficas

- BRASIL. **Lei Federal nº 12.527, de 18 de novembro de 2011**. Regula o acesso a informações previsto no inciso XXXIII do art. 5º da Constituição Federal.
- BRASIL. **Lei Complementar nº 131, de 27 de maio de 2009**. Acrescenta dispositivos à Lei Complementar nº 101/2000 (Lei de Responsabilidade Fiscal) sobre transparência na gestão fiscal.
- BRASIL. **Lei Complementar nº 101, de 4 de maio de 2000** (Lei de Responsabilidade Fiscal). Art. 52: Relatório Resumido da Execução Orçamentária.
- BRASIL. **Decreto Federal nº 7.724, de 16 de maio de 2012**. Regulamenta a Lei de Acesso à Informação no âmbito do Poder Executivo federal.
- CONTROLADORIA-GERAL DA UNIÃO (CGU). **Guia Técnico de Regulamentação da Lei de Acesso à Informação em Municípios**.
- CENTRO DE LIDERANÇA PÚBLICA (CLP). **Lei de Acesso à Informação: accountability em prática**.
- TESOURO NACIONAL. **SICONFI — Sistema de Informações Contábeis e Fiscais do Setor Público Brasileiro**. Disponível em: https://siconfi.tesouro.gov.br.
