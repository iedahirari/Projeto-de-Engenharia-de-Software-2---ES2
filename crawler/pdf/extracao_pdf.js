//var para receber a dependencia do sistema de arquivos(diretorio) do pc
var path = require('path')

//filePath var para receber o caminho do pdf no sistema de arquivos(diretorio) do pc
var filePath = path.join(__dirname, 'pdf_projects/test_pdf.pdf')

//extract var para indicar qual arquivo serao excluidos
var extract = require('pdf-text-extract')

//var mysql para receber o banco de dados
var mysql = require('mysql');

//var con para receber a conexÃ£o com o banco passando os seguintes parametros: host, user, password
//(TaÃ­s deve saber)
var con = mysql.createConnection({
  host: "localhost",
  user: "admin",
  password: ""
});

//aqui vai abrir a conexao com o banco, caso tenha algum erro a var ERR NÃ‚O vai estar nula e 
//vai parar a aplicação, lançando uma exception no console/terminal
con.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
});

//aqui Ã© o metodo para extração do texto do pdf passado ao código pelo caminho lÃ¡ em cima â¤´

extract(filePath, function (err, pages) {

    //caso de algum erro na hora de ler o pdf, vai lançar a exception no console mais um vez
  if (err) {
    console.dir(err)
    return
  }

  //se não houver nenhum erro, vai printar no console as paginas convertidas para texto
  console.dir(pages)
})

//para rodar o projeto, basta ter o npm na mÃ¡quina

//assim que tiver a dependencia NPM, rodar os seguintes comandos em sequÃªncias:

// - npm init: para iniciar o node no projeto
// - npm install: para instalar as dependencias referentes aos imports usados
// - (para executar) o código: No terminal, no diretorio do projeto, rodar: node nome_arquivo.js

// para salvar a dependencia pdf-text-extract no package.json
    //sÃ³ rodar: npm install --save pdf-text-extract
    
