# 🏛️ MONITORAÊ — Transparência Pública Cidadã de Mogi das Cruzes

> **Projeto Integrador da Disciplina de Engenharia de Software II (ES2)**  
> Sistema Web voltado à extração, estruturação, democratização e visualização clara dos dados públicos de agentes políticos e servidores municipais de Mogi das Cruzes.

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
- [7. 🔄 Casos de Uso (CDU)](#7--casos-de-uso-cdu)
- [8. 📁 Estrutura do Repositório](#8--estrutura-do-repositório)
- [9. 🛠️ Tecnologias Utilizadas](#9-️-tecnologias-utilizadas)
- [10. ⚙️ Instruções de Instalação e Execução](#10-️-instruções-de-instalação-e-execução)
- [11. 👥 Equipe e Orientação](#11--equipe-e-orientação)
- [12. 📚 Referências Bibliográficas](#12--referências-bibliográficas)

---

## 1. 📖 Sobre o Projeto

O **MONITORAÊ** é uma plataforma concebida para aproximar a população de Mogi das Cruzes da administração pública. Embora os dados governamentais estejam disponíveis nos portais oficiais da Prefeitura e da Câmara Municipal, muitas informações encontram-se dispersas em relatórios e arquivos PDF de difícil navegação para o cidadão.

O sistema automatiza a extração desses registros por meio de rotinas de *Web Scraping/Crawling*, armazena as informações estruturadas em banco de dados e as apresenta em uma interface web intuitiva e transparente, contemplando dados de vereadores, prefeito, servidores e notícias verificadas.

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
- **Ciclo de Atualização:** O banco de dados do sistema deve ser sincronizado com os portais oficiais em ciclos de no máximo 30 dias.

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

## 8. 📁 Estrutura do Repositório

```text
Projeto-de-Engenharia-de-Software-2---ES2/
│
├── 📂 Documentacao/                  # Artefatos formais de Engenharia de Software
│   ├── Caso_de_uso_-_descrição.docx    # Especificação detalhada dos fluxos de Casos de Uso
│   ├── Requisitos(RF,RNF).xlsx         # Matriz de rastreabilidade (visão stakeholder vs. sistema)
│   ├── Versão_finalFINAL.asta          # Modelagem UML formal (Casos de Uso, Classes) via Astah
│   ├── premissa.docx                   # Premissas e restrições técnicas do projeto
│   ├── regra.docx                      # Regras de negócio e embasamento jurídico (LAI)
│   ├── requisitos.docx                 # Especificação de Requisitos de Software (SRS)
│   └── stakeholders.docx               # Análise e mapeamento das partes interessadas
│
├── 📂 docs/                # Código-fonte da aplicação web
│   ├── 📂 BancoDeDados/                # Scripts SQL de criação de tabelas e esquemas relacionais
│   ├── 📂 CrawlerServidores/           # Scripts de extração dos dados da folha de pagamento
│   ├── 📂 CrawlerVereadores/           # Scripts de extração dos dados da Câmara Municipal
│   ├── 📂 composer/                    # Gerenciador de dependências e autoloaders
│   ├── 📂 css/                         # Folhas de estilo da interface do usuário
│   ├── 📂 imgs/                        # Ativos gráficos e iconografia
│   ├── Guia.php                        # Seção explicativa sobre termos orçamentários ao munícipe
│   ├── PerfilPrefeito.php/.html        # Visualização de dados do Poder Executivo
│   ├── PerfilVereador.php/.html        # Visualização de dados do Poder Legislativo
│   ├── Servidores.php                  # Listagem e consulta aos servidores municipais
│   ├── conexao.php / conexao2.php      # Configurações de conexão PDO/MySQL
│   ├── index.php / index.html          # Página inicial e portal de buscas
│   └── pesquisa*.php                   # Endpoints de filtros e consultas dinâmicas
│
├── 📂 web crawler/                   # Módulos isolados de parsing de PDFs e raspagem
├── 📂 POC/                           # Atividade prática para Prova de Conceito do Web Crawler
├── 📂 Teste/                         # Scripts e planos de testes de funcionalidade
├── 📂 Logo/                          # Identidade visual da marca MONITORAÊ
├── html_scrapping.php                # Testes de scraping com Simple HTML DOM
└── simple_html_dom.php               # Biblioteca auxiliar de parsing HTML
```

---

## 9. 🛠️ Tecnologias Utilizadas

| Camada / Função | Tecnologias |
| :--- | :--- |
| **Interface do Usuário (Front-end)** | HTML5, CSS3, JavaScript |
| **Processamento e Back-end** | PHP (Orientado a Objetos), Simple HTML DOM Parser, PDF Extractor |
| **Gerenciador de Pacotes** | Composer |
| **Banco de Dados** | MySQL / MariaDB |
| **Integração de Terceiros** | Plugin Social do Facebook |
| **Engenharia e Modelagem** | Astah Community/UML, Microsoft Excel, Microsoft Word |
| **Versionamento** | Git & GitHub |

---

## 10. ⚙️ Instruções de Instalação e Execução

### Pré-requisitos
- Ambiente de desenvolvimento local com PHP >= 7.4 e MySQL (ex.: [XAMPP](https://www.apachefriends.org/), [WampServer](https://www.wampserver.com/) ou [Laragon](https://laragon.org/)).
- [Composer](https://getcomposer.org/) instalado.
- Git instalado.

### Passo a Passo

1. **Clonar o Repositório:**
   ```bash
   git clone https://github.com/iedahirari/Projeto-de-Engenharia-de-Software-2---ES2.git
   ```

2. **Mover para o Diretório do Servidor Web:**
   - No XAMPP, copie ou mova a pasta para `C:/xampp/htdocs/`.

3. **Configurar o Banco de Dados:**
   - Inicie os serviços do **Apache** e **MySQL** no painel de controle do seu servidor local.
   - Acesse `http://localhost/phpmyadmin` no seu navegador e crie uma nova base de dados.
   - Importe os arquivos `.sql` disponíveis no diretório `docs/BancoDeDados/`.
   - Ajuste as credenciais de acesso ao banco (host, usuário, senha, nome da base) em `docs/conexao.php`.

4. **Instalar Dependências:**
   ```bash
   cd docs
   composer install
   ```

5. **Executar a Coleta de Dados:**
   - Execute os scripts de raspagem em `docs/CrawlerServidores/` e `docs/CrawlerVereadores/` para popular as tabelas do banco de dados com os registros atualizados.

6. **Acessar a Aplicação:**
   - Abra o navegador e acesse:
   ```text
   http://localhost/Projeto-de-Engenharia-de-Software-2---ES2/docs/index.php
   ```

---

## 11. 👥 Equipe e Orientação

- **Ieda de Oliveira** — Desenvolvimento e Engenharia de Requisitos
- **Thaís Ferreira** — Desenvolvimento e Engenharia de Requisitos
- **Bruno** — Desenvolvimento e Módulos de Web Scraping
- **Prof. Leandro Luque** — Docente e Orientador da Disciplina

---

## 12. 📚 Referências Bibliográficas

- BRASIL. **Lei Federal nº 12.527, de 18 de novembro de 2011**. Regula o acesso a informações previsto no inciso XXXIII do art. 5º da Constituição Federal.
- BRASIL. **Lei Complementar nº 131, de 27 de maio de 2009**. Acrescenta dispositivos à Lei Complementar nº 101/2000 (Lei de Responsabilidade Fiscal) sobre transparência na gestão fiscal.
- BRASIL. **Decreto Federal nº 7.724, de 16 de maio de 2012**. Regulamenta a Lei de Acesso à Informação no âmbito do Poder Executivo federal.
- CONTROLADORIA-GERAL DA UNIÃO (CGU). **Guia Técnico de Regulamentação da Lei de Acesso à Informação em Municípios**.
- CENTRO DE LIDERANÇA PÚBLICA (CLP). **Lei de Acesso à Informação: accountability em prática**.