"""Gera docs/data/vereadores.json e docs/data/projetos.json a partir de banco/bdservidores.sql.

Uso (na raiz do repositório):  python ferramentas/sql_para_json.py

Os servidores não saem daqui: docs/data/servidores.json é gerado pelo
crawler (crawler/servidores/crawler_servidores.php).
"""
import json, os, re

raiz = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
docs = os.path.join(raiz, 'docs')
sql = open(os.path.join(raiz, 'banco', 'bdservidores.sql'), encoding='utf-8').read()


def parse_values(s, i):
    """Lê as tuplas ('a', 1), (...); a partir da posição i e devolve uma lista."""
    rows, row, n = [], None, len(s)
    while i < n:
        c = s[i]
        if c == '(' and row is None:
            row = []; i += 1
        elif c == "'":
            i += 1; buf = []
            while True:
                c = s[i]
                if c == '\\':
                    nxt = s[i + 1]
                    buf.append({'n': '\n', 'r': '\r', 't': '\t', '0': ''}.get(nxt, nxt)); i += 2
                elif c == "'" and s[i + 1] == "'":
                    buf.append("'"); i += 2
                elif c == "'":
                    i += 1; break
                else:
                    buf.append(c); i += 1
            row.append(''.join(buf))
        elif c == ')' and row is not None:
            rows.append(row); row = None; i += 1
        elif c == ';' and row is None:
            return rows
        elif row is not None and (c.isdigit() or c in '-.'):
            m = re.match(r'-?[\d.]+', s[i:]); tok = m.group(0)
            row.append(float(tok) if '.' in tok else int(tok)); i += len(tok)
        elif row is not None and s.startswith('NULL', i):
            row.append(None); i += 4
        else:
            i += 1
    return rows


def table(name):
    out = []
    for m in re.finditer(r"INSERT INTO `%s` \(([^)]*)\) VALUES" % name, sql):
        cols = [c.strip(' `') for c in m.group(1).split(',')]
        out += [dict(zip(cols, r)) for r in parse_values(sql, m.end())]
    return out


def clean(v):
    if not isinstance(v, str):
        return v
    v = v.replace('</a>', '')
    return re.sub(r'\s+', ' ', v).strip()


# Nomes reais das fotos, para corrigir maiúsculas/minúsculas (o Pages diferencia)
foto_dir = os.path.join(docs, 'imgs', 'FotoVereadores')
fotos = {f.lower(): f for f in os.listdir(foto_dir)}

vereadores = []
for r in table('tb_vereadores'):
    r = {k: clean(v) for k, v in r.items()}
    arquivo = os.path.basename(r['imagem']).lower()
    vereadores.append({
        'codigo': r['codigo'], 'nome': r['NOME'], 'partido': r['Partido'],
        'atividade': r['ATIVIDADE'], 'formacao': r['FORMACAO'],
        'nascimento': r['DATANASCIMENTO'], 'estadoCivil': r['ESTADOCIVIL'],
        'votos': r['VOTOS'], 'legislatura': r['LEGISLATURA'],
        'telefone': r['TELEFONE'], 'email': r['EMAIL'], 'salario': r['SALARIO'],
        'imagem': 'imgs/FotoVereadores/' + fotos.get(arquivo, arquivo) if arquivo in fotos else 'imgs/perfil.png',
    })
vereadores.sort(key=lambda v: v['codigo'])

projetos = [{
    'codigo': r['codigo'], 'numero': clean(r['NUMERO']), 'autor': clean(r['AUTOR']),
    'assunto': clean(r['ASSUNTO']), 'anotacao': clean(r['ANOTACAO']),
} for r in table('tb_projetoslei')]

out = os.path.join(docs, 'data')
os.makedirs(out, exist_ok=True)
for nome, dados in [('vereadores', vereadores), ('projetos', projetos)]:
    with open(os.path.join(out, nome + '.json'), 'w', encoding='utf-8') as f:
        json.dump(dados, f, ensure_ascii=False, indent=1)

print(len(vereadores), 'vereadores;', len(projetos), 'projetos')
sem_foto = [v['nome'] for v in vereadores if v['imagem'] == 'imgs/perfil.png']
if sem_foto:
    print('sem foto:', sem_foto)
